<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TripMemberController extends Controller
{
    public function store(Request $request, Trip $trip): RedirectResponse
    {
        $this->authorizeTrip($trip);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $trip->members()->create($validated);

        return redirect()->route('trips.show', $trip)->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function destroy(Trip $trip, \App\Models\TripMember $member): RedirectResponse
    {
        $this->authorizeTrip($trip);

        abort_unless($member->trip_id === $trip->id, 404);

        $member->delete();

        return redirect()->route('trips.show', $trip)->with('success', 'Anggota berhasil dihapus.');
    }

    private function authorizeTrip(Trip $trip): void
    {
        abort_unless($trip->created_by === auth()->id(), 403);
    }
}