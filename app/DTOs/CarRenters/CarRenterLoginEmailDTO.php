<?php

namespace App\DTOs\CarRenters;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class CarRenterLoginEmailDTO extends ValidatedDTO
{
    public string $email;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:car_renters,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'No account found with this email. Please register first.',
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
