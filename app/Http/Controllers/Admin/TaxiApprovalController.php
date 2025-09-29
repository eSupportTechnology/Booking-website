<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Taxi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaxiApprovalController extends Controller
{
    public function approve(Request $request, Taxi $taxi): JsonResponse
    {
        try {
            $taxi->update([
                'approval_status' => 'approved',
                'status' => 'Active',
                'rejection_reason' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Taxi approved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve taxi'
            ], 500);
        }
    }

    public function reject(Request $request, Taxi $taxi): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            $taxi->update([
                'approval_status' => 'rejected',
                'status' => 'Inactive',
                'rejection_reason' => $request->reason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Taxi rejected successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject taxi'
            ], 500);
        }
    }
}