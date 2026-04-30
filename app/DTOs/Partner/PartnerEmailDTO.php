<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;
use App\Models\User;

class PartnerEmailDTO extends ValidatedDTO
{
    public string $email;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [];
    }

    /**
     * Additional validation after DTO creation.
     */
    protected function after(\Illuminate\Validation\Validator $validator): void
    {
        // Partner check is now handled in the controller to allow redirect to login
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