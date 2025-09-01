<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PartnerVerificationDTO extends ValidatedDTO
{
    public  $property_id;
    public string $type;
    public ?string $full_name;
    public ?string $national_id;
    public ?string $company_name;
    public ?string $registration_number;
    public ?string $trading_name;
    public ?string $address;
    public ?string $zip_code;
    public ?string $country;
    public ?array $owners;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'type' => ['required', 'in:individual,business'],
            'full_name' => ['nullable', 'string'],
            'national_id' => ['nullable', 'string'],
            'company_name' => ['nullable', 'string'],
            'registration_number' => ['nullable', 'string'],
            'trading_name' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'zip_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'owners' => ['nullable', 'array'],
            'owners.*.first_name' => ['nullable', 'string'],
            'owners.*.last_name' => ['nullable', 'string'],
            'owners.*.dob' => ['nullable', 'date_format:Y-m-d'],
        ];
    }
    protected function casts(): array
    {
        return [];
    }
    protected function defaults(): array
    {
        return [
            'full_name' => null,
            'national_id' => null,
            'company_name' => null,
            'registration_number' => null,
            'trading_name' => null,
            'address' => null,
            'zip_code' => null,
            'city' => null,
            'country' => null,
            'owners' => null
        ];
    }
}
