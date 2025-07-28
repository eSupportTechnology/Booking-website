<?php

namespace App\DTOs\Admin;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class RegisterDTO extends ValidatedDTO
{
    public string $name;
    public string $email;
    public string $password;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
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
