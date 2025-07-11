<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\DTOs\SMS\SendSingleSMSDTO;
use App\Actions\SMS\SendSingleSMSAction;
use App\Jobs\SendOTPJob;
use Illuminate\Support\Facades\Log;

class OTPService
{
    protected SendSingleSMSAction $smsAction;

    public function __construct(SendSingleSMSAction $smsAction)
    {
        $this->smsAction = $smsAction;
    }

    public function send(string $phone): bool
{
    $otp = rand(100000, 999999);
    $normalizedPhone = $this->normalizePhoneNumber($phone);
    $localPhone = $this->formatPhoneForQuickSend($normalizedPhone);

    if (!$localPhone) {
        Log::error('Invalid phone number format', ['phone' => $phone, 'normalized' => $normalizedPhone]);
        return false;
    }

    $cacheKey = 'otp_' . $normalizedPhone;
    Cache::put($cacheKey, $otp, now()->addMinutes(5));

    Log::info('Sending OTP via queue', [
        'original_phone' => $phone,
        'normalized_phone' => $normalizedPhone,
        'formatted_phone' => $localPhone,
        'otp' => $otp,
        'cache_key' => $cacheKey
    ]);

    $dto = new SendSingleSMSDTO([
        'to' => $localPhone,
        'message' => "Your OTP is: {$otp}"
    ]);

    try {
        // Dispatch to queue instead of direct execution
        SendOTPJob::dispatch($dto);
        return true;
    } catch (\Exception $e) {
        Log::error('OTP Queue Dispatch Exception', ['message' => $e->getMessage()]);
        return false;
    }
}

    public function verify(string $phone, string $otp): bool
{
    $normalizedPhone = $this->normalizePhoneNumber($phone);
    $cacheKey = 'otp_' . $normalizedPhone;

    // Check multiple possible cache key variations
    $possibleKeys = [
        'otp_' . $normalizedPhone,
        'otp_' . $phone,
        'otp_' . preg_replace('/[^0-9]/', '', $phone),
        'otp_' . preg_replace('/[^0-9]/', '', ltrim($phone, '+'))
    ];

    $cachedOtp = Cache::get($cacheKey);

    Log::info('OTP Verification Debug Analysis', [
        'original_phone' => $phone,
        'normalized_phone' => $normalizedPhone,
        'primary_cache_key' => $cacheKey,
        'provided_otp' => $otp,
        'cached_otp' => $cachedOtp,
        'cache_exists' => Cache::has($cacheKey),
        'all_cache_keys' => array_map(function($key) {
            return [
                'key' => $key,
                'value' => Cache::get($key),
                'exists' => Cache::has($key)
            ];
        }, $possibleKeys)
    ]);

    $isValid = $cachedOtp && $cachedOtp == $otp;

    if ($isValid) {
        Cache::forget($cacheKey);
        Log::info('OTP verified successfully and cleared from cache', ['cache_key' => $cacheKey]);
    } else {
        Log::warning('OTP verification failed', [
            'cache_key' => $cacheKey,
            'provided_otp' => $otp,
            'cached_otp' => $cachedOtp
        ]);
    }

    return $isValid;
}

    private function normalizePhoneNumber(string $phone): string
    {
        // Remove any non-digit characters and leading +
        $phone = preg_replace('/[^0-9]/', '', ltrim($phone, '+'));

        Log::info('Normalizing phone number', [
            'input' => $phone,
            'output' => $phone
        ]);

        return $phone;
    }

    private function formatPhoneForQuickSend(string $phone): ?string
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Handle Sri Lankan numbers with country code (94)
        if (strlen($phone) === 11 && str_starts_with($phone, '94')) {
            // Convert 947XXXXXXXX to 07XXXXXXXX
            return '0' . substr($phone, 2);
        }

        // Handle numbers that already start with 07
        if (strlen($phone) === 10 && str_starts_with($phone, '07')) {
            return $phone;
        }

        // Handle 7XXXXXXXX format (missing leading 0)
        if (strlen($phone) === 9 && str_starts_with($phone, '7')) {
            return '0' . $phone;
        }

        // Invalid format
        return null;
    }
}
