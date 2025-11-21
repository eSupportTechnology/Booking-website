<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SavePricingDTO extends ValidatedDTO
{
    public int $property_id;

    // New fields for home creation (properties table)
    public ?float $adult_price;
    public ?float $child_price;

    // Old fields for other property creation flows
    public ?string $booking_type;
    public ?float $price_per_night;
    public ?bool $discount_enabled;
    public ?int $discount_percent;

    public ?string $currency;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],

            // New fields (for home creation)
            'adult_price' => ['nullable', 'numeric', 'min:0'],
            'child_price' => ['nullable', 'numeric', 'min:0'],

            // Old fields (for other property creation)
            'booking_type' => ['nullable', 'in:instant,request'],
            'price_per_night' => ['nullable', 'numeric', 'min:0'],
            'discount_enabled' => ['nullable', 'boolean'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],

            // Common field
            'currency' => ['nullable', 'in:USD,EUR,GBP,LKR'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'child_price' => 0,
            'price_per_night' => null,
            'currency' => 'USD',
            'discount_enabled' => false,
            'discount_percent' => 0,
        ];
    }

    protected function casts(): array
    {
        return [
            'property_id' => 'integer',
            'adult_price' => 'float',
            'child_price' => 'float',
            'price_per_night' => 'float',
        ];
    }
}
