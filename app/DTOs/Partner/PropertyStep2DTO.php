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
    public ?string $channel_manager;
    public ?array $bedrooms = null;
    public ?int $guests = null;
    public ?int $bathrooms = null;
    public ?string $allow_children = null;
    public ?string $offer_cribs = null;
    public ?int $apartment_size = null;
    public ?string $apartment_unit = null;
    public ?array $amenities = null;




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
            'channel_manager' => ['nullable', 'string'],
            'bedrooms' => ['nullable', 'array'],
            'guests' => ['nullable', 'integer'],
            'bathrooms' => ['nullable', 'integer'],
            'allow_children' => ['nullable', 'string'],
            'offer_cribs' => ['nullable', 'string'],
            'apartment_size' => ['nullable', 'integer'],
            'apartment_unit' => ['nullable', 'string'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],
        ];
    }


    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            // 'title' => 'string',
            // 'address' => 'string',
            // 'city' => 'string',
            // 'country' => 'string',
            // 'zipcode' => 'string',
            // 'description' => 'string',
            // 'apartment' => 'string',
        ];
    }
}
