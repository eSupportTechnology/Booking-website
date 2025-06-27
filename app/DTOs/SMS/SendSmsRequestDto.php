<?php

namespace App\DTOs\SMS;

class SendSmsRequestDto
{
    public function __construct(
        public readonly string $phoneNumber,
        public readonly string $message,
        public readonly ?string $senderId = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            phoneNumber: $data['phone_number'] ?? '',
            message: $data['message'] ?? '',
            senderId: $data['sender_id'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'phone_number' => $this->phoneNumber,
            'message' => $this->message,
            'sender_id' => $this->senderId,
        ];
    }
}
