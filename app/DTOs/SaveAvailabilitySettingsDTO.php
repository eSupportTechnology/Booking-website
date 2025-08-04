<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SaveAvailabilitySettingsDTO extends ValidatedDTO
{
    public $property_id;
    public $availability_mode;
    public $availability_days;
    public $allow_long_stays;
    public $max_nights;
    public $sync_tripadvisor;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'availability_mode' => ['required', 'in:continuous,18months'],
            'availability_days' => ['required', 'integer', 'in:30,90,180,365'],
            'allow_long_stays' => ['nullable', 'boolean'],
            'max_nights' => ['nullable', 'integer', 'min:31'],
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
        return [];
    }

    protected function afterValidation(): void
    {
        // Convert types manually
        $this->property_id = (int) $this->property_id;
        $this->availability_days = (int) $this->availability_days;
        $this->allow_long_stays = $this->allow_long_stays === 'true' || $this->allow_long_stays === true;
        $this->sync_tripadvisor = $this->sync_tripadvisor === 'true' || $this->sync_tripadvisor === true;
        
        if ($this->max_nights !== null) {
            $this->max_nights = (int) $this->max_nights;
            
            // Custom validation for max_nights based on allow_long_stays
            $maxAllowed = $this->allow_long_stays ? 365 : 90;
            
            if ($this->max_nights > $maxAllowed) {
                $this->addError('max_nights', "The max nights field must not be greater than {$maxAllowed}.");
            }
        }
    }
}
