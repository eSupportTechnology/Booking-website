<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Taxi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdateTaxiStatusController extends Controller
{
    public function __invoke(Request $request, Taxi $taxi): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['Active', 'Inactive', 'On Trip'])]
        ]);

        try {
            $oldStatus = $taxi->status;
            $taxi->status = $request->status;
            $taxi->save();

            return response()->json([
                'success' => true,
                'message' => "Taxi status updated to {$request->status}",
                'data' => [
                    'taxi_id' => $taxi->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update taxi status. Please try again.'
            ], 500);
        }
    }
}