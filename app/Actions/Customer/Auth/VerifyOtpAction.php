<?php

namespace App\Actions\Customer\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class VerifyOtpAction
{
    public function execute(string $otp, string $email): bool
    {
        $cachedOtp = Cache::get("customer_otp_{$email}");

        if (!$cachedOtp || $cachedOtp != $otp) {
            return false;
        }

        $user = User::withTrashed()->where('email', $email)->first();

        if ($user && $user->trashed()) {
            Log::warning("Soft-deleted user attempted OTP verification: {$email}");

            // OPTION 1: Force re-registration
            // return false;

            // OPTION 2: Auto-restore (Uncomment below if allowed)
            $user->restore();
            Log::info("Soft-deleted user restored via OTP: {$email}");
        }

        // OTP matched
        Cache::forget("customer_otp_{$email}");
        Session::forget('customer_email');
        Session::put('customer_verified', true);
        Session::put('customer_verified_email', $email);

        return true;
    }
}
