<?php

// app/DTOs/RegisterPasswordDTO.php

namespace App\DTOs\Partner;

class RegisterPasswordDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password'),
        );
    }
}
