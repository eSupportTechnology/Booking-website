<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class PropertyAdditionalDetailsDTO extends ValidatedDTO
{
    public ?int $guests = null;
    public ?int $bathrooms = null;
    public ?string $allow_children = null;
    public ?string $offer_cribs = null;
    public ?int $apartment_size = null;
    public ?string $apartment_unit = null;
    public ?string $breakfast = null;
    public ?string $parking = null;

    public function rules(): array
    {
        return [
            'guests' => ['nullable', 'integer'],
            'bathrooms' => ['nullable', 'integer'],
            'allow_children' => ['nullable', 'string'],
            'offer_cribs' => ['nullable', 'string'],
            'apartment_size' => ['nullable', 'integer'],
            'apartment_unit' => ['nullable', 'string'],
            'breakfast' => ['nullable', 'string', 'in:yes,no'],
            'parking' => ['nullable', 'string', 'in:free,paid,no'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            // 'guests' => 'integer',
            // 'bathrooms' => 'integer',
            // 'apartment_size' => 'integer',
        ];
    }
}
