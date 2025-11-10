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
            'currency' => ['nullable', 'in:USD,EUR,GBP,LKR'],
            'discount_enabled' => ['nullable', 'boolean'],
            'discount_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }

    protected function defaults(): array
    {
        return [
            'price_per_night' => null,
            'currency' => 'USD',
            'discount_enabled' => false,
            'discount_percent' => 0,
        ];
    }

    protected function casts(): array
    {
        return [
            // Casts handled manually in controller
        ];
    }
} 