<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveAvailabilitySettingsDTO extends ValidatedDTO
{
    public int $property_id;
    public string $availability_mode;
    public int $availability_days;
    public ?bool $allow_long_stays;
    public ?int $max_nights;
    public bool $sync_tripadvisor;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'availability_mode' => ['required', 'in:continuous,18months'],
            'availability_days' => ['required', 'integer', 'in:30,90,180,365'],
            'allow_long_stays' => ['nullable', 'boolean'],
            'max_nights' => ['nullable', 'integer', 'min:31', 'max:90'],
            'sync_tripadvisor' => ['required', 'boolean'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'sync_tripadvisor' => false,
            'allow_long_stays' => null,
            'max_nights' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            // 'property_id' => 'integer',
            // 'availability_days' => 'integer',
            // 'allow_long_stays' => 'boolean',
            // 'max_nights' => 'integer',
            // 'sync_tripadvisor' => 'boolean',
        ];
    }
}
