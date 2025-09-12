<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Taxi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdateAirportTransferStatusController extends Controller
{
    public function __invoke(Request $request, Taxi $transfer): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['Scheduled', 'Completed', 'Cancelled'])]
        ]);

        try {
            $oldStatus = $transfer->status;
            $transfer->status = $request->status;
            $transfer->save();

            return response()->json([
                'success' => true,
                'message' => "Transfer status updated to {$request->status}",
                'data' => [
                    'transfer_id' => $transfer->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update transfer status. Please try again.'
            ], 500);
        }
    }
}