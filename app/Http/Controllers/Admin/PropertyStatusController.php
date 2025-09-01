<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PropertyStatusController extends Controller
{
    /**
     * Update property status
     */
    public function updateStatus(Request $request, Property $property): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'active', 'suspended', 'completed'])]
        ]);

        try {
            $oldStatus = $property->status;
            $newStatus = $request->status;

            $property->update([
                'status' => $newStatus
            ]);

            // Log the status change (optional)
            Log::info('Property status changed', [
                'property_id' => $property->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email ?? 'Unknown'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Property status updated to {$newStatus}",
                'data' => [
                    'property_id' => $property->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update property status', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update property status. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk update property statuses
     */
    public function bulkUpdateStatus(Request $request): JsonResponse
    {
        $request->validate([
            'property_ids' => 'required|array',
            'property_ids.*' => 'exists:properties,id',
            'status' => ['required', Rule::in(['pending', 'active', 'suspended', 'completed'])]
        ]);

        try {
            $propertyIds = $request->property_ids;
            $newStatus = $request->status;

            $updatedCount = Property::whereIn('id', $propertyIds)
                ->update(['status' => $newStatus]);

            Log::info('Bulk property status update', [
                'property_ids' => $propertyIds,
                'new_status' => $newStatus,
                'updated_count' => $updatedCount,
                'admin_id' => auth('admin')->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "Updated {$updatedCount} properties to {$newStatus}",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to bulk update property status', [
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update property statuses. Please try again.'
            ], 500);
        }
    }
}
