<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PropertyStep2DTO extends ValidatedDTO
{
    public string $title;
    public string $address;
    public string $city;
    public string $country;
    public ?string $zipcode;
    public string $description;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'zipcode' => ['nullable', 'string', 'max:20'],
            'description' => ['required', 'string'],
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
            'address' => 'string',
            'city' => 'string',
            'country' => 'string',
            'zipcode' => 'string',
            'description' => 'string',
        ];
    }
}
