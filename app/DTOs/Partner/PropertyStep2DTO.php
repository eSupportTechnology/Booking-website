<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PropertyStep2DTO extends ValidatedDTO
{

    public ?string $title;
    public ?string $address;
    public ?string $city;
    public ?string $country;
    public ?string $zipcode;
    public ?string $description;
    public ?int $subtype_id;
    public ?string $apartment;
    public ?int $address_type_id = null; 




    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'zipcode' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'subtype_id' => ['nullable', 'integer', 'exists:property_subtypes,id'],
            'apartment' => ['nullable', 'string', 'max:255'],
            'address_type_id' => ['nullable', 'integer', 'exists:address_types,id'],
        ];
    }


    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'title' => 'string',
            // 'address' => 'string',
            // 'city' => 'string',
            // 'country' => 'string',
            // 'zipcode' => 'string',
            'description' => 'string',
            // 'apartment' => 'string',
        ];
    }
}
