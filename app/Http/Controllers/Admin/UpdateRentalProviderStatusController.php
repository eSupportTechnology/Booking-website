<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarRenter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdateRentalProviderStatusController extends Controller
{
    public function __invoke(Request $request, CarRenter $provider): JsonResponse
    {
        $admin = auth('admin')->user();
        if (!$admin || (!method_exists($admin, 'isSuperAdmin') || (!$admin->isSuperAdmin() && !$admin->can('edit_rental_providers')))) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden'
            ], 403);
        }
        $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])]
        ]);

        try {
            $user = $provider->user ?? null;
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rental provider has no associated user account.'
                ], 400);
            }

            $oldStatus = $provider->status ?? ($user->email_verified_at ? 'active' : 'pending');

            $dbStatus = match($request->status) {
                'active' => 'active',
                'inactive' => 'suspended',
                'pending' => 'pending',
                default => 'pending'
            };

            $provider->status = $dbStatus;

            switch($request->status) {
                case 'active':
                    $user->email_verified_at = $user->email_verified_at ?? now();
                    break;
                case 'inactive':
                    $user->email_verified_at = null;
                    break;
                case 'pending':
                    // leave as-is
                    break;
            }

            $user->save();
            $provider->save();

            return response()->json([
                'success' => true,
                'message' => "Rental provider status updated to {$request->status}",
                'data' => [
                    'provider_id' => $provider->id,
                    'user_id' => $user->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update rental provider status. Please try again.'
            ], 500);
        }
    }
}
