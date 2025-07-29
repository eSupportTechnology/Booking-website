<?php

namespace App\DTOs\Admin;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class LoginDTO extends ValidatedDTO
{
    public string $username;
    public string $password;
    public ?bool $remember;

    protected function rules(): array
    {
        return [
            'username' => 'required|string|exists:admins,username',
            'password' => 'required|min:6',
            'remember' => 'nullable|boolean'
        ];
    }

    protected function defaults(): array
    {
        return [
            'remember' => false
        ];
    }

    protected function casts(): array
    {
        return [
            'remember' => fn($key, $value) => (bool) $value
        ];
    }
}
