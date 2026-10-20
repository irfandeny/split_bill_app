<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Services\TripBalanceService;
use Illuminate\Http\JsonResponse;

class TripBalanceController extends Controller
{
    public function __construct(protected TripBalanceService $balanceService) {}

    public function summary(Trip $trip): JsonResponse
    {
        $summary = $this->balanceService->summarizeTrip($trip);

        return response()->json([
            'trip' => $trip->name,
            'summary' => $summary,
        ]);
    }
}