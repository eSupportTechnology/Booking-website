<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PartnerLoginPasswordDTO extends ValidatedDTO
{
    public string $password;
    public string $email;

    protected function rules(): array
    {
        return [
            'password' => ['required', 'string'],
            'email' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password is required.',
            'email.required' => 'Email is required.',
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
} 