<?php

namespace App\Actions\Customer\Auth;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class VerifyOtpAction
{
    public function execute(string $otp, string $email): bool
    {
        $cachedOtp = Cache::get("customer_otp_{$email}");

        if ($cachedOtp && $cachedOtp == $otp) {
            // OTP matched
            Cache::forget("customer_otp_{$email}");
            Session::forget('customer_email');
            Session::put('customer_verified', true);
            Session::put('customer_verified_email', $email);
            return true;
        }

        return false;
    }
}
