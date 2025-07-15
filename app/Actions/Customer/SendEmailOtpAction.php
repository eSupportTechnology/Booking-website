<?php

namespace App\Actions\Customer;

use App\DTOs\Customer\SendOtpDto;
use App\DTOs\Customer\EmailVerificationResultDto;
use App\Jobs\SendEmailOtpJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendEmailOtpAction
{
    public function execute(SendOtpDto $dto): EmailVerificationResultDto
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return EmailVerificationResultDto::error(
                message: 'Unauthorized access.',
                statusCode: 403
            );
        }

        // Check if email is already in use by another user
        $existingUser = User::where('email', $dto->email)
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingUser) {
            return EmailVerificationResultDto::error(
                message: 'This email address is already registered with another account.',
                statusCode: 422
            );
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in cache for 10 minutes
        $cacheKey = 'email_otp_' . $user->id . '_' . md5($dto->email);
        Cache::put($cacheKey, $otp, now()->addMinutes(10));

        // Dispatch email job to queue
        try {
            SendEmailOtpJob::dispatch($dto->email, $otp);

            Log::info('Email OTP job dispatched', [
                'user_id' => $user->id,
                'email' => $dto->email,
                'cache_key' => $cacheKey
            ]);

            return EmailVerificationResultDto::success(
                message: 'Verification code is being sent to your email address.',
                email: $dto->email
            );

        } catch (\Exception $e) {
            Log::error('Failed to dispatch email OTP job', [
                'user_id' => $user->id,
                'email' => $dto->email,
                'error' => $e->getMessage()
            ]);

            return EmailVerificationResultDto::error(
                message: 'Failed to queue verification code. Please try again.',
                statusCode: 500
            );
        }
    }
}
