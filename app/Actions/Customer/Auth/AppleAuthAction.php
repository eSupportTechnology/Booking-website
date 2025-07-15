<?php

namespace App\Actions\Customer\Auth;

use App\DTOs\Customer\Auth\AppleAuthDTO;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppleAuthAction
{
    public function execute(AppleAuthDTO $dto): array
    {
        Log::info("Apple Auth process started for: {$dto->email}");

        try {
            $isNewUser = false;

            // Check for user, including soft-deleted
            $user = User::withTrashed()->where('email', $dto->email)->first();

            // If user is soft-deleted, restore and update
            if ($user && $user->trashed()) {
                $user->restore();

                $user->update([
                    'name' => $dto->name,
                    'email_verified_at' => now(),
                ]);

                Log::info("Restored soft-deleted user via Google Auth: {$dto->email}");
            }

            if (!$user) {
                $user = User::create([
                    'name' => $dto->name,
                    'email' => $dto->email,
                    'email_verified_at' => now(),
                    'password' => null,
                ]);
                $isNewUser = true;
                Log::info("New user created via Apple Auth: {$dto->email}");

                // ✅ Assign the 'customer' role
                if ($user && !$user->hasRole('customer')) {
                    $user->assignRole('customer');
                    Log::info("Role 'customer' assigned to Apple-auth user: {$dto->email}");
                }
            } else {
                // Update existing user
                $updateData = [];

                if (!$user->email_verified_at) {
                    $updateData['email_verified_at'] = now();
                }

                if (!empty($updateData)) {
                    $user->update($updateData);
                    Log::info("Existing user updated with Apple data: {$dto->email}");
                }

                // ✅ Ensure role exists
                if (!$user->hasRole('customer')) {
                    $user->assignRole('customer');
                    Log::info("Role 'customer' assigned to existing Apple user: {$dto->email}");
                }
            }

            // Authenticate
            Auth::guard('customer')->login($user, true);

            // Send welcome email
            if ($isNewUser) {
                SendWelcomeEmailJob::dispatch($dto->email, $dto->name);
            }

            return [
                'success' => true,
                'message' => $isNewUser ? 'Registration successful' : 'Login successful',
                'user_data' => $user, // Return actual user model
            ];

        } catch (\Throwable $e) {
            Log::error("Apple Auth failed for {$dto->email}: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());

            return [
                'success' => false,
                'message' => 'Authentication failed',
                'error' => $e->getMessage()
            ];
        }
    }
}
