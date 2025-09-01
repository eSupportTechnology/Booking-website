<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserStatusController extends Controller
{
    /**
     * Update customer status
     */
    public function updateCustomerStatus(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive'])]
        ]);

        try {
            // Ensure this is a customer (not a partner)
            if ($user->partner) {
                return response()->json([
                    'success' => false,
                    'message' => 'This user is a partner, not a customer.'
                ], 400);
            }

            $oldStatus = $user->email_verified_at ? 'active' : 'inactive';
            $newStatus = $request->status;

            // Update email verification status based on the new status
            if ($newStatus === 'active') {
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
                'new_status' => $newStatus,
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email ?? 'Unknown'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Customer status updated to {$newStatus}",
                'data' => [
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update customer status', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update customer status. Please try again.'
            ], 500);
        }
    }

    /**
     * Update partner status
     */
    public function updatePartnerStatus(Request $request, Partner $partner): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive'])]
        ]);

        try {
            $user = $partner->user;
            $oldStatus = $user->email_verified_at ? 'active' : 'inactive';
            $newStatus = $request->status;

            // Update email verification status based on the new status
            if ($newStatus === 'active') {
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
                'new_status' => $newStatus,
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email ?? 'Unknown'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Partner status updated to {$newStatus}",
                'data' => [
                    'partner_id' => $partner->id,
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update partner status', [
                'partner_id' => $partner->id,
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update partner status. Please try again.'
            ], 500);
        }
    }

    /**
     * Bulk update customer statuses
     */
    public function bulkUpdateCustomerStatus(Request $request): JsonResponse
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'status' => ['required', Rule::in(['active', 'inactive'])]
        ]);

        try {
            $userIds = $request->user_ids;
            $newStatus = $request->status;

            // Ensure all users are customers (not partners)
            $customers = User::whereIn('id', $userIds)
                ->whereDoesntHave('partner')
                ->get();

            if ($customers->count() !== count($userIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some users are not customers or do not exist.'
                ], 400);
            }

            $updateData = [];
            if ($newStatus === 'active') {
                $updateData['email_verified_at'] = Carbon::now();
            } else {
                $updateData['email_verified_at'] = null;
            }

            $updatedCount = User::whereIn('id', $userIds)
                ->whereDoesntHave('partner')
                ->update($updateData);

            Log::info('Bulk customer status update', [
                'user_ids' => $userIds,
                'new_status' => $newStatus,
                'updated_count' => $updatedCount,
                'admin_id' => auth('admin')->id()
            ]);

            return response()->json([
                'success' => true,
                'message' => "Updated {$updatedCount} customers to {$newStatus}",
                'data' => [
                    'updated_count' => $updatedCount,
                    'new_status' => $newStatus
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to bulk update customer status', [
                'error' => $e->getMessage(),
                'admin_id' => auth('admin')->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update customer statuses. Please try again.'
            ], 500);
        }
    }
}
