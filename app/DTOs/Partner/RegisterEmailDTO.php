<?php

// app/DTOs/RegisterEmailDTO.php

namespace App\DTOs\Partner;

class RegisterEmailDTO
{
    public function __construct(
        public string $email
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            email: $request->input('email'),
        );
    }
}
