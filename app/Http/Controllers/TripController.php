<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TripController extends Controller
{
    public function index(): View
    {
        $trips = auth()->user()->trips()->latest()->get();

        return view('trips.index', compact('trips'));
    }

    public function create(): View
    {
        return view('trips.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $trip = auth()->user()->trips()->create($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Trip berhasil dibuat.');
    }

    public function show(Trip $trip): View
    {
        $this->authorizeTrip($trip);

        $trip->load('members' , 'expenses');

        return view('trips.show', compact('trip'));
    }

    public function edit(Trip $trip): View
    {
        $this->authorizeTrip($trip);

        return view('trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip): RedirectResponse
    {
        $this->authorizeTrip($trip);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $trip->update($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Trip berhasil diperbarui.');
    }

    public function destroy(Trip $trip): RedirectResponse
    {
        $this->authorizeTrip($trip);

        $trip->delete();

        return redirect()->route('trips.index')->with('success', 'Trip berhasil dihapus.');
    }

    /**
     * Pastikan trip ini benar-benar milik user yang sedang login.
     * Kalau bukan, langsung tolak akses (403).
     */
    private function authorizeTrip(Trip $trip): void
    {
        abort_unless($trip->created_by === auth()->id(), 403);
    }
}