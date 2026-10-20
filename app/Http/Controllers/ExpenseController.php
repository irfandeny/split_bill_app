<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class ExpenseController extends Controller
{
    public function create(Trip $trip): View
    {
        $this->authorizeTrip($trip);

        $trip->load('members');

        return view('expenses.create', compact('trip'));
    }

    public function edit(Trip $trip, Expense $expense): View
    {
        $this->authorizeTrip($trip);
        abort_unless($expense->trip_id === $trip->id, 404);
        $trip->load('members');
        $expense->load('payers', 'participants');

        return view('expenses.create', compact('trip', 'expense'));
    }

    public function store(Request $request, Trip $trip): RedirectResponse
    {
        return $this->saveExpense($request, $trip);
    }

    public function update(Request $request, Trip $trip, Expense $expense): RedirectResponse
    {
        $this->authorizeTrip($trip);
        abort_unless($expense->trip_id === $trip->id, 404);

        return $this->saveExpense($request, $trip, $expense);
    }

    private function saveExpense(Request $request, Trip $trip, ?Expense $expense = null): RedirectResponse
    {
        $this->authorizeTrip($trip);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0.01',
            'split_method' => 'required|in:equal,custom_amount,percentage',
            'expense_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'payers' => 'required|array|min:1',
            'payers.*.trip_member_id' => ['required', 'integer', 'distinct', Rule::exists('trip_members', 'id')->where('trip_id', $trip->id)],
            'payers.*.amount_paid' => 'required|numeric|min:0.01',
            'participants' => 'required|array|min:1',
            'participants.*.trip_member_id' => ['required', 'integer', 'distinct', Rule::exists('trip_members', 'id')->where('trip_id', $trip->id)],
            'participants.*.share_amount' => 'nullable|numeric|min:0',
            'participants.*.share_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $totalAmount = (float) $validated['total_amount'];

        // Validasi total payer harus pas dengan total_amount
        $totalPaid = collect($validated['payers'])->sum(fn ($p) => (float) $p['amount_paid']);
        if (abs($totalPaid - $totalAmount) > 0.01) {
            throw ValidationException::withMessages([
                'payers' => 'Total nominal yang dibayar payer harus sama dengan total expense (Rp' . number_format($totalAmount, 0, ',', '.') . ').',
            ]);
        }

        // Hitung share_amount tiap participant sesuai split_method
        $participantsData = $this->calculateShares(
            $validated['split_method'],
            $totalAmount,
            $validated['participants']
        );

        // Validasi total share harus pas dengan total_amount
        $totalShare = collect($participantsData)->sum('share_amount');
        if (abs($totalShare - $totalAmount) > 0.01) {
            throw ValidationException::withMessages([
                'participants' => 'Total porsi participant harus sama dengan total expense (Rp' . number_format($totalAmount, 0, ',', '.') . ').',
            ]);
        }

        $editing = $expense !== null;
        DB::transaction(function () use ($trip, $expense, $validated, $totalAmount, $participantsData) {
            $attributes = [
                'title' => $validated['title'],
                'total_amount' => $totalAmount,
                'split_method' => $validated['split_method'],
                'expense_date' => $validated['expense_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ];

            if ($expense) {
                $expense = $trip->expenses()->whereKey($expense->id)->lockForUpdate()->firstOrFail();
                $expense->update($attributes);
                $expense->payers()->delete();
                $expense->participants()->delete();
            } else {
                $expense = $trip->expenses()->create($attributes);
            }

            foreach ($validated['payers'] as $payer) {
                $expense->payers()->create([
                    'trip_member_id' => $payer['trip_member_id'],
                    'amount_paid' => $payer['amount_paid'],
                ]);
            }
            foreach ($participantsData as $participant) {
                $expense->participants()->create($participant);
            }
        });

        return redirect()->route('trips.show', $trip)->with('success',
            $editing ? 'Expense berhasil diperbarui.' : 'Expense berhasil ditambahkan.');
    }

    public function destroy(Trip $trip, \App\Models\Expense $expense): RedirectResponse
    {
        $this->authorizeTrip($trip);

        abort_unless($expense->trip_id === $trip->id, 404);

        $expense->delete();

        return redirect()->route('trips.show', $trip)->with('success', 'Expense berhasil dihapus.');
    }

    /**
     * Hitung share_amount tiap participant berdasarkan split_method.
     */
    private function calculateShares(string $splitMethod, float $totalAmount, array $participants): array
    {
        $count = count($participants);

        return match ($splitMethod) {
            'equal' => array_map(fn ($p) => [
                'trip_member_id' => $p['trip_member_id'],
                'share_amount' => round($totalAmount / $count, 2),
                'share_percentage' => null,
            ], $participants),

            'custom_amount' => array_map(fn ($p) => [
                'trip_member_id' => $p['trip_member_id'],
                'share_amount' => (float) ($p['share_amount'] ?? 0),
                'share_percentage' => null,
            ], $participants),

            'percentage' => array_map(fn ($p) => [
                'trip_member_id' => $p['trip_member_id'],
                'share_amount' => round($totalAmount * ((float) ($p['share_percentage'] ?? 0) / 100), 2),
                'share_percentage' => (float) ($p['share_percentage'] ?? 0),
            ], $participants),

            default => [],
        };
    }

    private function authorizeTrip(Trip $trip): void
    {
        abort_unless($trip->created_by === auth()->id(), 403);
    }
}