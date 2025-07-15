<?php

namespace App\DTOs\Customer\Auth;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CustomerEmailRequestDTO extends ValidatedDTO
{
    public string $email;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
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
