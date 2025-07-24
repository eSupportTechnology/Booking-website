<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SavePolicyDTO extends ValidatedDTO
{
    public bool $smoking_allowed;
    public bool $parties_allowed;
    public string $pets_allowed;
    public string $pets_fees;
    public string $check_in_from;
    public string $check_in_until;
    public string $check_out_from;
    public string $check_out_until;
    public string $cancellation_policy;

    public function rules(): array
    {
        return [
            'smoking_allowed' => ['required', 'boolean'],
            'parties_allowed' => ['required', 'boolean'],
            'pets_allowed' => ['required', 'string'],
            'pets_fees' => [ 'string'],
            'check_in_from' => ['required'],
            'check_in_until' => ['required'],
            'check_out_from' => ['required'],
            'check_out_until' => ['required'],
            'cancellation_policy' => [ 'in:flexible,moderate,strict'],
        ];
    }

    protected function casts(): array
    {
        return [
           
        ];
    }

    protected function defaults(): array
    {
        return [];
    }
}
