<?php

namespace App\DTOs\Auth;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class AppleAuthDTO extends ValidatedDTO
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
        return [];
    }

    protected function casts(): array
    {
        return [];
    }

    public static function fromSocialUser($appleUser): self
    {
        $name = $appleUser->getName() ?: $appleUser->getEmail();

        return new self([
            'email' => $appleUser->getEmail(),
            'name' => $name,
        ]);
    }
}
