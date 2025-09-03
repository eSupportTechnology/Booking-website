<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\Admin\StatusUpdateDTO;
use App\Services\Admin\UserStatusService;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdatePartnerStatusController extends Controller
{
    public function __construct(
        private UserStatusService $userStatusService
    ) {}

    public function __invoke(Request $request, Partner $partner): JsonResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])]
        ]);

        try {
            $user = $partner->user;
            $oldStatus = $partner->status;

            // Update partner status
            $partner->status = $request->status === 'inactive' ? 'suspended' : $request->status;

            // Update user email verification status based on partner status
            switch($request->status) {
                case 'active':
                    $user->email_verified_at = $user->email_verified_at ?? now();
                    break;
                case 'inactive':
                    $user->email_verified_at = null;
                    break;
                case 'pending':
                    $user->email_verified_at = now();
                    break;
            }

            $user->save();
            $partner->save();

            return response()->json([
                'success' => true,
                'message' => "Partner status updated to {$request->status}",
                'data' => [
                    'partner_id' => $partner->id,
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update partner status. ' . $e->getMessage()
            ], 500);
        }
    }
}
