<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\AppleAuthDTO;
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
            // Check if user exists by email or Apple ID
            $user = User::where('email', $dto->email)
                       ->first();
            $isNewUser = false;

            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $dto->name,
                    'email' => $dto->email,
                    'email_verified_at' => now(),
                    'password' => null,
                ]);
                $isNewUser = true;
                Log::info("New user created via Apple Auth: {$dto->email}");
            } else {
                // Update existing user with Apple data
                $updateData = [];

                if (!$user->email_verified_at) {
                    $updateData['email_verified_at'] = now();
                }

                if (!empty($updateData)) {
                    $user->update($updateData);
                    Log::info("Existing user updated with Apple data: {$dto->email}");
                }
            }

            // Authenticate the user
            Auth::guard('customer')->login($user, true);

            // Queue welcome email job only for new users
            if ($isNewUser) {
                SendWelcomeEmailJob::dispatch($dto->email, $dto->name);
            }

            Log::info("Apple Auth successful for: {$dto->email}");

            return [
                'success' => true,
                'message' => $isNewUser ? 'Registration successful' : 'Login successful',
                'user_data' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'is_new_user' => $isNewUser,
                ]
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
