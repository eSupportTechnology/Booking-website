<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveHouseRulesDTO extends ValidatedDTO
{
    public $smoking_allowed;
    public $children_allowed;
    public $parties_allowed;
    public ?string $pets_allowed;
    public ?string $pets_fees;
    public ?string $check_in_from;
    public ?string $check_in_until;
    public ?string $check_out_from;
    public ?string $check_out_until;

    protected function rules(): array
    {
        return [
            'smoking_allowed' => ['nullable'],
            'children_allowed' => ['nullable'],
            'parties_allowed' => ['nullable'],
            'pets_allowed' => ['nullable', 'string', 'in:yes,upon_request,no'],
            'pets_fees' => ['nullable', 'string', 'in:free,charges'],
            'check_in_from' => ['nullable', 'string'],
            'check_in_until' => ['nullable', 'string'],
            'check_out_from' => ['nullable', 'string'],
            'check_out_until' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'smoking_allowed.boolean' => 'The smoking allowed field must be a boolean value.',
            'children_allowed.boolean' => 'The children allowed field must be a boolean value.',
            'parties_allowed.boolean' => 'The parties allowed field must be a boolean value.',
        ];
    }

    protected function casts(): array
    {
        return [];
    }

    protected function defaults(): array
    {
        return [
            'smoking_allowed' => false,
            'children_allowed' => true,
            'parties_allowed' => false,
            'pets_allowed' => 'no',
            'pets_fees' => null,
            'check_in_from' => '15:00',
            'check_in_until' => '18:00',
            'check_out_from' => '08:00',
            'check_out_until' => '11:00',
        ];
    }




} 