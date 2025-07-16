<?php

namespace App\DTOs\Customer;

readonly class SendOtpDto
{
    public function __construct(
        public string $email,
        public int $userId
    ) {}
}
