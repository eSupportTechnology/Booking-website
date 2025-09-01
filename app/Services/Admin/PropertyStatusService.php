<?php

namespace App\Services\Admin;

use App\DTOs\Admin\StatusUpdateDTO;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Exception;

class PropertyStatusService
{
    public function updateStatus(StatusUpdateDTO $dto): array
    {
        try {
            $property = Property::findOrFail($dto->entityId);
            $oldStatus = $property->status;

            // Map status values to database enum values
            $dbStatus = $this->mapStatusToDatabase($dto->status);

            $property->update(['status' => $dbStatus]);

            Log::info('Property status changed', [
                'property_id' => $property->id,
                'old_status' => $oldStatus,
                'new_status' => $dbStatus,
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email ?? 'Unknown'
            ]);

            return [
                'success' => true,
                'message' => "Property status updated to {$dto->status}",
                'data' => [
                    'property_id' => $property->id,
                    'old_status' => $oldStatus,
                    'new_status' => $dbStatus
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to update property status', [
                'property_id' => $dto->entityId,
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update property status. Please try again.'
            ];
        }
    }

    public function bulkUpdateStatus(array $propertyIds, string $status): array
    {
        try {
            $dbStatus = $this->mapStatusToDatabase($status);

            $updatedCount = Property::whereIn('id', $propertyIds)
                ->update(['status' => $dbStatus]);

            Log::info('Bulk property status update', [
                'property_ids' => $propertyIds,
                'new_status' => $dbStatus,
                'updated_count' => $updatedCount,
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => true,
                'message' => "Updated {$updatedCount} properties to {$status}",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_status' => $dbStatus
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to bulk update property status', [
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update property statuses. Please try again.'
            ];
        }
    }

    private function mapStatusToDatabase(string $status): string
    {
        return match($status) {
            'active' => 'active',
            'inactive' => 'suspended',
            'pending' => 'pending',
            default => 'pending'
        };
    }
}
