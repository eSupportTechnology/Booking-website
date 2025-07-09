<?php

namespace App\Services;

use App\Actions\SMS\SendSmsViaPostAction;
use App\Actions\SMS\SendSmsViaGetAction;
use App\DTOs\SMS\SendSmsRequestDto;
use App\DTOs\SMS\SmsResponseDto;

class QuickSendSmsService
{
    public function __construct(
        private readonly SendSmsViaPostAction $sendSmsViaPostAction,
        private readonly SendSmsViaGetAction $sendSmsViaGetAction
    ) {}

    public function sendSingleSms(SendSmsRequestDto $request): SmsResponseDto
    {
        return $this->sendSmsViaPostAction->execute($request);
    }

    public function sendSingleSmsViaGet(SendSmsRequestDto $request): SmsResponseDto
    {
        return $this->sendSmsViaGetAction->execute($request);
    }
}
