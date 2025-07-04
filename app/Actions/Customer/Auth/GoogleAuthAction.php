<?php

namespace App\Actions\Customer\Auth;

use App\DTOs\Customer\Auth\GoogleAuthDTO;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleAuthAction
{
    public function execute(GoogleAuthDTO $dto): array
    {
        Log::info("Google Auth process started for: {$dto->email}");

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

            // If user is entirely new
            if (!$user) {
                $randomPassword = Str::random();

                $user = User::create([
                    'name' => $dto->name,
                    'email' => $dto->email,
                    'email_verified_at' => now(),
                    'password' => Hash::make($randomPassword),
                ]);

                if (!$user) {
                    Log::error("User creation returned null.");
                    throw new \Exception("Failed to create user.");
                }

                Log::debug("User created: ", $user->toArray());

                $user->assignRole('customer');
                $isNewUser = true;

                Log::info("New user created via Google Auth: {$dto->email}");
            }

            // Login the user
            Auth::login($user, true);

            // Dispatch welcome email if new
            if ($isNewUser) {
                SendWelcomeEmailJob::dispatch($dto->email, $dto->name);
            }

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
            Log::error("Google Auth failed for {$dto->email}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Authentication failed',
                'error' => $e->getMessage(),
            ];
        }
    }
}
