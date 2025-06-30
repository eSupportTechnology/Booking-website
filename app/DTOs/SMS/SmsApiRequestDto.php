<?php

namespace App\DTOs\SMS;

class SmsApiRequestDto
{
    public function __construct(
        public readonly string $senderID,
        public readonly string $to,
        public readonly string $msg
    ) {}

    public function toArray(): array
    {
        return [
            'senderID' => $this->senderID,
            'to' => $this->to,
            'msg' => $this->msg,
        ];
    }

    public function toGetParameters(): array
    {
        return [
            'FUN' => 'SEND_SINGLE',
            'with_get' => 'true',
            'senderID' => $this->senderID,
            'msg' => $this->msg,
            'to' => $this->to,
        ];
    }
}
