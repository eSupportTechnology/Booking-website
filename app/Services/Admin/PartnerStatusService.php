<?php

namespace App\Services\Admin;

use App\DTOs\Admin\StatusUpdateDTO;
use App\Models\Partner;
use Illuminate\Support\Facades\Log;
use Exception;

class PartnerStatusService
{
    public function updateStatus(StatusUpdateDTO $dto): array
    {
        try {
            $partner = Partner::findOrFail($dto->entityId);
            $oldStatus = $partner->status;

            // Map status values to database enum values
            $dbStatus = $this->mapStatusToDatabase($dto->status);

            $partner->update(['status' => $dbStatus]);

            Log::info('Partner status changed', [
                'partner_id' => $partner->id,
                'old_status' => $oldStatus,
                'new_status' => $dbStatus,
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email ?? 'Unknown'
            ]);

            return [
                'success' => true,
                'message' => "Partner status updated to {$dto->status}",
                'data' => [
                    'partner_id' => $partner->id,
                    'old_status' => $oldStatus,
                    'new_status' => $dbStatus
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to update partner status', [
                'partner_id' => $dto->entityId,
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update partner status. Please try again.'
            ];
        }
    }

    public function bulkUpdateStatus(array $partnerIds, string $status): array
    {
        try {
            $dbStatus = $this->mapStatusToDatabase($status);

            $updatedCount = Partner::whereIn('id', $partnerIds)
                ->update(['status' => $dbStatus]);

            Log::info('Bulk partner status update', [
                'partner_ids' => $partnerIds,
                'new_status' => $dbStatus,
                'updated_count' => $updatedCount,
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => true,
                'message' => "Updated {$updatedCount} partners to {$status}",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_status' => $dbStatus
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to bulk update partner status', [
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update partner statuses. Please try again.'
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
