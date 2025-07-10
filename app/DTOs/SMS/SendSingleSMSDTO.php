<?php

namespace App\DTOs\SMS;

class SendSingleSMSDTO
{
    public string $to;
    public string $message;

    public function __construct(array $data)
    {
        $this->to = $data['to'];
        $this->message = $data['message'];
    }

    public static function fromRequest(array $data): self
    {
        return new self($data);
    }
}
