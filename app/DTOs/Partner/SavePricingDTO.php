<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class SavePricingDTO extends ValidatedDTO
{
    public int $property_id;
    public string $booking_type;
    public ?float $price_per_night;
    public ?string $currency;
    public bool $discount_enabled;
    public ?int $discount_percent;

    protected function rules(): array
    {
        return [
            'property_id' => ['required', 'exists:properties,id'],
            'booking_type' => ['required', 'in:instant,request'],
            'price_per_night' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'in:usd,eur,gbp'],
            'discount_enabled' => ['required', 'boolean'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'price_per_night' => null,
            'currency' => 'usd',
            'discount_enabled' => false,
            'discount_percent' => null,
        ];
    }

    protected function casts(): array
    {
        return [
            // 'property_id' => 'integer',
            // 'price_per_night' => 'float',
            // 'discount_enabled' => 'boolean',
            // 'discount_percent' => 'integer',
        ];
    }
} 