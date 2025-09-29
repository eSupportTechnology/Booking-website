<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarApprovalController extends Controller
{
    public function approve(Request $request, Car $car): JsonResponse
    {
        try {
            $car->update([
                'approval_status' => 'approved',
                'status' => 'Active',
                'rejection_reason' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Car approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve car'
            ], 500);
        }
    }

    public function reject(Request $request, Car $car): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            $car->update([
                'approval_status' => 'rejected',
                'status' => 'Inactive',
                'rejection_reason' => $request->reason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Car rejected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject car'
            ], 500);
        }
    }
}