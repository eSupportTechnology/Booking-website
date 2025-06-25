<?php

namespace App\Actions\Customer\Auth;

use App\DTOs\Customer\Auth\CustomerEmailRequestDTO;
use App\Jobs\SendCustomerOtpJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendCustomerOtpAction
{
    public function execute(CustomerEmailRequestDTO $dto): void
    {
        Log::info("Starting OTP process for: {$dto->email}");

        $otp = random_int(100000, 999999);
        Log::info("Generated OTP: {$otp}");

        Cache::put("customer_otp_{$dto->email}", $otp, now()->addMinutes(1));
        Log::info("OTP cached successfully");

        try {
            SendCustomerOtpJob::dispatch($dto->email, $otp);
            Log::info("OTP email job dispatched for: {$dto->email}");
        } catch (\Throwable $e) {
            Log::error("OTP job dispatch failed for {$dto->email}: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }
}
