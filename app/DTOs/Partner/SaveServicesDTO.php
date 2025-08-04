<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveServicesDTO extends ValidatedDTO
{
    public ?bool $serve_breakfast;
    public ?string $breakfast_included;
    public ?array $breakfast_type;
    public ?string $breakfast_price;
    public ?string $parking_available;
    public ?string $parking_cost;
    public ?string $parking_reservation;
    public ?string $parking_location;
    public ?string $parking_type;

    protected function rules(): array
    {
        return [
            'serve_breakfast' => ['nullable'],
            'breakfast_included' => ['nullable', 'string', 'in:included,extra'],
            'breakfast_type' => ['nullable', 'array'],
            'breakfast_type.*' => ['string'],
            'breakfast_price' => ['nullable', 'string'],
            'parking_available' => ['nullable', 'string', 'in:free,paid,no'],
            'parking_cost' => ['nullable', 'string'],
            'parking_reservation' => ['nullable', 'string', 'in:yes,no,not_needed'],
            'parking_location' => ['nullable', 'string', 'in:on_site,off_site'],
            'parking_type' => ['nullable', 'string', 'in:private,public'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'serve_breakfast' => false,
            'breakfast_included' => null,
            'breakfast_type' => [],
            'breakfast_price' => null,
            'parking_available' => 'no',
            'parking_cost' => null,
            'parking_reservation' => null,
            'parking_location' => null,
            'parking_type' => null,
        ];
    }

        protected function casts(): array
    {
        return [
            // 'serve_breakfast' => 'boolean',
            // 'breakfast_type' => 'array',
            // 'breakfast_price' => 'string',
        ];
    }
} 