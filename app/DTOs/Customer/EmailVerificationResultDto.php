<?php

namespace App\DTOs\Customer;

readonly class EmailVerificationResultDto
{
    public function __construct(
        public bool $success,
        public string $message,
        public ?string $email = null,
        public ?array $errors = null,
        public int $statusCode = 200
    ) {}

    public function toArray(): array
    {
        $result = [
            'success' => $this->success,
            'message' => $this->message,
        ];

        if ($this->email) {
            $result['email'] = $this->email;
        }

        if ($this->errors) {
            $result['errors'] = $this->errors;
        }

        return $result;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public static function success(string $message, ?string $email = null): self
    {
        return new self(
            success: true,
            message: $message,
            email: $email,
            statusCode: 200
        );
    }

    public static function error(string $message, int $statusCode = 422, ?array $errors = null): self
    {
        return new self(
            success: false,
            message: $message,
            errors: $errors,
            statusCode: $statusCode
        );
    }
}
