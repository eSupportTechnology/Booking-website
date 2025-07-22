<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class AccommodationDetailsDTO extends ValidatedDTO
{
    public int $property_id;
    public string $ownership_type;
    public ?array $business_entity = null; // ['business_name', 'trading_name', 'address', 'zip_code', 'city', 'country']
    public ?array $individuals = null; // array of ['first_name', 'last_name', 'date_of_birth', 'alt_names' => []]

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'integer', 'exists:properties,id'],
            'ownership_type' => ['required', 'in:individual,business_entity'],
            'business_entity' => ['nullable', 'array'],
            'business_entity.business_name' => ['required_if:ownership_type,business_entity', 'string', 'max:255'],
            'business_entity.trading_name' => ['nullable', 'string', 'max:255'],
            'business_entity.address' => ['required_if:ownership_type,business_entity', 'string'],
            'business_entity.zip_code' => ['required_if:ownership_type,business_entity', 'string', 'max:20'],
            'business_entity.city' => ['required_if:ownership_type,business_entity', 'string', 'max:255'],
            'business_entity.country' => ['required_if:ownership_type,business_entity', 'string', 'max:255'],
            'individuals' => ['nullable', 'array'],
            'individuals.*.first_name' => ['required_with:individuals', 'string', 'max:255'],
            'individuals.*.last_name' => ['required_with:individuals', 'string', 'max:255'],
            'individuals.*.date_of_birth' => ['required_with:individuals', 'date'],
            'individuals.*.alt_names' => ['nullable', 'array'],
            'individuals.*.alt_names.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'business_entity' => null,
            'individuals' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            // 'property_id' => 'integer',
            // 'business_entity' => 'array',
            // 'individuals' => 'array',
        ];
    }
} 