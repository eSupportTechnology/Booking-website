<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class RegisterPartnerDTO extends ValidatedDTO
{
    public string $name;
    public string $email;
    public string $password;
    public ?string $first_name;
    public ?string $last_name;
    public ?string $contact_number;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:20'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'first_name' => '',
            'last_name' => '',
            'contact_number' => '',
        ];
    }

    protected function casts(): array
    {
        return [];
    }
}
// This DTO is used for registering a partner, ensuring that all necessary fields are validated and cast correctly.