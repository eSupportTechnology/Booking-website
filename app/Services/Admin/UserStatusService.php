<?php

namespace App\Services\Admin;

use App\DTOs\Admin\StatusUpdateDTO;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class UserStatusService
{
    public function updateCustomerStatus(StatusUpdateDTO $dto): array
    {
        try {
            $user = User::findOrFail($dto->entityId);

            // Ensure this is a customer (not a partner)
            if ($user->partner) {
                return [
                    'success' => false,
                    'message' => 'This user is a partner, not a customer.'
                ];
            }

            $oldStatus = $user->email_verified_at ? 'active' : 'inactive';

            // Update email verification status based on the new status
            if ($dto->status === 'active') {
                $user->update([
                    'email_verified_at' => $user->email_verified_at ?? Carbon::now()
                ]);
            } else {
                $user->update([
                    'email_verified_at' => null
                ]);
            }

            Log::info('Customer status changed', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'old_status' => $oldStatus,
                'new_status' => $dto->status,
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email ?? 'Unknown'
            ]);

            return [
                'success' => true,
                'message' => "Customer status updated to {$dto->status}",
                'data' => [
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $dto->status
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to update customer status', [
                'user_id' => $dto->entityId,
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update customer status. Please try again.'
            ];
        }
    }

    public function updatePartnerStatus(StatusUpdateDTO $dto): array
    {
        try {
            $partner = Partner::findOrFail($dto->entityId);
            $user = $partner->user;
            $oldStatus = $user->email_verified_at ? 'active' : 'inactive';

            // Update email verification status based on the new status
            if ($dto->status === 'active') {
                $user->update([
                    'email_verified_at' => $user->email_verified_at ?? Carbon::now()
                ]);
            } else {
                $user->update([
                    'email_verified_at' => null
                ]);
            }

            Log::info('Partner status changed', [
                'partner_id' => $partner->id,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'old_status' => $oldStatus,
                'new_status' => $dto->status,
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email ?? 'Unknown'
            ]);

            return [
                'success' => true,
                'message' => "Partner status updated to {$dto->status}",
                'data' => [
                    'partner_id' => $partner->id,
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $dto->status
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

    public function bulkUpdateCustomerStatus(array $userIds, string $status): array
    {
        try {
            // Ensure all users are customers (not partners)
            $customers = User::whereIn('id', $userIds)
                ->whereDoesntHave('partner')
                ->get();

            if ($customers->count() !== count($userIds)) {
                return [
                    'success' => false,
                    'message' => 'Some users are not customers or do not exist.'
                ];
            }

            $updateData = [];
            if ($status === 'active') {
                $updateData['email_verified_at'] = Carbon::now();
            } else {
                $updateData['email_verified_at'] = null;
            }

            $updatedCount = User::whereIn('id', $userIds)
                ->whereDoesntHave('partner')
                ->update($updateData);

            Log::info('Bulk customer status update', [
                'user_ids' => $userIds,
                'new_status' => $status,
                'updated_count' => $updatedCount,
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => true,
                'message' => "Updated {$updatedCount} customers to {$status}",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_status' => $status
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to bulk update customer status', [
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to update customer statuses. Please try again.'
            ];
        }
    }
}
