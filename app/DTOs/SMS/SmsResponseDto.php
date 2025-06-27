<?php

namespace App\DTOs\SMS;

class SmsResponseDto
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message,
        public readonly ?array $data = null,
        public readonly ?string $errorCode = null,
        public readonly ?array $rawResponse = null
    ) {}

    public static function success(array $data, string $message = 'SMS sent successfully'): self
    {
        return new self(
            success: true,
            message: $message,
            data: $data
        );
    }

    public static function failure(string $message, ?string $errorCode = null, ?array $rawResponse = null): self
    {
        return new self(
            success: false,
            message: $message,
            errorCode: $errorCode,
            rawResponse: $rawResponse
        );
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->data,
            'error_code' => $this->errorCode,
            'raw_response' => $this->rawResponse,
        ];
    }
}
