<?php

namespace App\Actions\Customer;

use App\DTOs\Customer\VerifyOtpDto;
use App\DTOs\Customer\EmailVerificationResultDto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class VerifyEmailOtpAction
{
    public function execute(VerifyOtpDto $dto): EmailVerificationResultDto
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return EmailVerificationResultDto::error(
                message: 'Unauthorized access.',
                statusCode: 403
            );
        }

        // Check OTP from cache
        $cacheKey = 'email_otp_' . $user->id . '_' . md5($dto->email);
        $storedOtp = Cache::get($cacheKey);

        if (!$storedOtp) {
            return EmailVerificationResultDto::error(
                message: 'Verification code has expired. Please request a new code.',
                statusCode: 422
            );
        }

        if ($storedOtp !== $dto->otp) {
            return EmailVerificationResultDto::error(
                message: 'Invalid verification code. Please try again.',
                statusCode: 422
            );
        }

        // OTP is valid, update user's email
        try {
            $user->email = $dto->email;
            $user->email_verified_at = now();
            $user->save();

            // Clear the OTP from cache
            Cache::forget($cacheKey);

            return EmailVerificationResultDto::success(
                message: 'Email verified and updated successfully.',
                email: $dto->email
            );

        } catch (\Exception $e) {
            return EmailVerificationResultDto::error(
                message: 'Failed to update email. Please try again.',
                statusCode: 500
            );
        }
    }
}
