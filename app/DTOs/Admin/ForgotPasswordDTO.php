<?php

namespace App\DTOs\Admin;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ForgotPasswordDTO extends ValidatedDTO
{
    public string $username;

    protected function rules(): array
    {
        return [
            'username' => 'required|string|exists:admins,username'
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
