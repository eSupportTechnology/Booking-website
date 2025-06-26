<?php

namespace App\DTOs\Auth;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class GoogleAuthDTO extends ValidatedDTO
{
    public string $email;
    public string $name;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'name' => 'Customer User',
        ];
    }

    protected function casts(): array
    {
        return [
            // 'email' => 'string',
            // 'name' => 'string',
        ];
    }

    public static function fromGoogleUser($googleUser): self
    {
        return new self([
            'email' => $googleUser->getEmail(),
            'name' => $googleUser->getName(),
        ]);
    }
}
