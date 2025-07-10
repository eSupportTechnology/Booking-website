<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\DTOs\SMS\SendSingleSMSDTO;
use App\Actions\SMS\SendSingleSMSAction;

class OTPService
{
    protected SendSingleSMSAction $smsSender;

    public function __construct(SendSingleSMSAction $smsSender)
    {
        $this->smsSender = $smsSender;
    }

    public function send(string $phone): bool
    {
        $otp = rand(100000, 999999);

        // Cache OTP for 5 minutes
        Cache::put('otp_' . $phone, $otp, now()->addMinutes(5));

        // Send SMS using existing DTO + Action
        $dto = new SendSingleSMSDTO([
            'to' => $phone,
            'message' => "Your OTP is: {$otp}"
        ]);

        $response = $this->smsSender->execute($dto);

        return isset($response['status']) && $response['status'] === 'SENT';
    }

    public function verify(string $phone, string $otp): bool
    {
        $cached = Cache::get('otp_' . $phone);

        return $cached && $cached == $otp;
    }
}

