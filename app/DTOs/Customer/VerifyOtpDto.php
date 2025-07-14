<?php

namespace App\DTOs\Customer;

readonly class VerifyOtpDto
{
    public function __construct(
        public string $email,
        public string $otp,
        public int $userId
    ) {}
}
