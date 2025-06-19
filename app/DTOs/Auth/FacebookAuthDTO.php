<?php

namespace App\DTOs\Auth;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class FacebookAuthDTO extends ValidatedDTO
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

    public static function fromSocialUser($facebookUser): self
    {
        return new self([
            'email' => $facebookUser->getEmail(),
            'name' => $facebookUser->getName(),
        ]);
    }
}
