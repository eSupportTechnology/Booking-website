<?php

namespace App\DTOs\Admin;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ForgotPasswordDTO extends ValidatedDTO
{
    public string $email;

    protected function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email'
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
