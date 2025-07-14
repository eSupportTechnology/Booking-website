<?php

namespace App\Actions\Customer;

use App\DTOs\Customer\SendOtpDto;
use App\DTOs\Customer\EmailVerificationResultDto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ResendEmailOtpAction
{
    public function __construct(
        private SendEmailOtpAction $queuedSendEmailOtpAction
    ) {}

    public function execute(string $email): EmailVerificationResultDto
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return EmailVerificationResultDto::error(
                message: 'Unauthorized access.',
                statusCode: 403
            );
        }

        $rateLimitKey = 'email_otp_rate_limit_' . $user->id . '_' . md5($email);

        // Check if user has requested OTP recently (rate limit: 1 per minute)
        if (Cache::has($rateLimitKey)) {
            return EmailVerificationResultDto::error(
                message: 'Please wait before requesting another code.',
                statusCode: 429
            );
        }

        // Set rate limit for 1 minute
        Cache::put($rateLimitKey, true, now()->addMinute());

        // Create DTO and delegate to QueuedSendEmailOtpAction
        $dto = new SendOtpDto(
            email: $email,
            userId: $user->id
        );

        return $this->queuedSendEmailOtpAction->execute($dto);
    }
}
