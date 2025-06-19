<?php

// app/DTOs/RegisterContactDTO.php

namespace App\DTOs\Partner;

class RegisterContactDTO
{
    public function __construct(
        public string $email, // to identify existing record
        public string $first_name,
        public string $last_name,
        public string $contact_number,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            email: $request->input('email'),
            first_name: $request->input('first_name'),
            last_name: $request->input('last_name'),
            contact_number: $request->input('contact_number'),
        );
    }
}
