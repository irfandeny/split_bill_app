<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\TripMember;
use Illuminate\Support\Collection;

class TripBalanceService
{
    /**
     * Hitung ringkasan saldo (Total Tanggungan, Total Kontribusi, Sisa)
     * untuk SEMUA member dalam satu trip.
     *
     * @return Collection<int, array{
     *     trip_member_id: int,
     *     name: string,
     *     total_responsibility: float,
     *     total_contribution: float,
     *     remaining: float
     * }>
     */
    public function summarizeTrip(Trip $trip): Collection
    {
        $trip->load([
            'members',
            'expenses.participants',
            'expenses.payers',
            'settlements',
        ]);

        return $trip->members->map(function (TripMember $member) use ($trip) {
            return [
                'trip_member_id' => $member->id,
                'name' => $member->name,
                'total_responsibility' => $this->totalResponsibility($trip, $member),
                'total_contribution' => $this->totalContribution($trip, $member),
                'remaining' => $this->remaining($trip, $member),
            ];
        });
    }

    /**
     * LEDGER 1 — Total Tanggungan (fixed).
     * Dijumlahkan dari share_amount di semua expense yang diikuti member ini.
     * Angka ini TIDAK dipengaruhi settlement sama sekali.
     */
    public function totalResponsibility(Trip $trip, TripMember $member): float
    {
        return (float) $trip->expenses
            ->flatMap(fn ($expense) => $expense->participants)
            ->where('trip_member_id', $member->id)
            ->sum(fn ($participant) => (float) $participant->share_amount);
    }

    /**
     * LEDGER 2 — Total Kontribusi (dinamis).
     * = (nominal yang dia bayarkan langsung sebagai payer di expense)
     * + (settlement yang DIA BAYARKAN ke orang lain)
     *
     * Settlement yang DITERIMA member ini TIDAK dihitung sebagai kontribusi dia,
     * karena itu bukan dia membayar tanggungan siapa pun, melainkan menerima uang.
     */
    public function totalContribution(Trip $trip, TripMember $member): float
    {
        $fromExpenses = $trip->expenses
            ->flatMap(fn ($expense) => $expense->payers)
            ->where('trip_member_id', $member->id)
            ->sum(fn ($payer) => (float) $payer->amount_paid);

        $fromSettlementsSent = $trip->settlements
            ->where('from_trip_member_id', $member->id)
            ->sum(fn ($settlement) => (float) $settlement->amount);

        return (float) ($fromExpenses + $fromSettlementsSent);
    }

    /**
     * Total settlement yang DITERIMA member ini dari orang lain.
     * Dipakai untuk mengurangi "Sisa yang Harus Dibayar", BUKAN menambah kontribusi.
     */
    public function totalSettlementsReceived(Trip $trip, TripMember $member): float
    {
        return (float) $trip->settlements
            ->where('to_trip_member_id', $member->id)
            ->sum(fn ($settlement) => (float) $settlement->amount);
    }

    /**
     * Angka turunan — Sisa yang Harus Dibayar/Diterima.
     *
     * Sisa = Total Tanggungan
     *        − Total Kontribusi (bayar expense + settlement yang dia bayarkan)
     *        − Total settlement yang dia TERIMA
     *
     * Positif  = masih punya utang ke grup.
     * Negatif  = sudah bayar lebih dari tanggungannya (nombok / berhak menerima).
     */
    public function remaining(Trip $trip, TripMember $member): float
    {
        $responsibility = $this->totalResponsibility($trip, $member);
        $contribution = $this->totalContribution($trip, $member);
        $received = $this->totalSettlementsReceived($trip, $member);

        return round($responsibility - $contribution + $received, 2);
    }
}