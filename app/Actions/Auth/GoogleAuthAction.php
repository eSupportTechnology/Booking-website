<?php

namespace App\Actions\Auth;

use App\DTOs\Auth\GoogleAuthDTO;
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
            $user = User::where('email', $dto->email)->first();
            $isNewUser = false;

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
                }
                Log::debug("User created: ", $user->toArray());

                $isNewUser = true;
                Log::info("New user created via Google Auth: {$dto->email}");
            }

            Auth::login($user, true);

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
