<?php

namespace App\DTOs\CarRenters;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CarRenterLoginPasswordDTO extends ValidatedDTO
{
    public string $password;

    protected function rules(): array
    {
        return [
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password is required.',
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
