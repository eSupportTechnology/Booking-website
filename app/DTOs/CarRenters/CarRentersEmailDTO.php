<?php

namespace App\DTOs\CarRenters;
use App\Models\CarRenter;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CarRentersEmailDTO extends ValidatedDTO
{
    public string $email;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:car_renters,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'An account with this email already exists. Please sign in instead.',
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
