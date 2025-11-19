<?php

namespace App\DTOs\Partner;

use WendellAdriel\ValidatedDTO\ValidatedDTO;
use WendellAdriel\ValidatedDTO\Casting\FloatCast;

class EnhancedPricingDTO extends ValidatedDTO
{
    public ?float $adult_price;
    public ?float $child_price;
    public ?float $commission_rate;
    public ?int $property_id;
    
    protected function rules(): array
    {
        return [
            'adult_price' => ['required', 'numeric', 'min:0'],
            'child_price' => ['nullable', 'numeric', 'min:0'],
            'commission_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'property_id' => ['required', 'integer', 'exists:properties,id'],
        ];
    }
    
    protected function casts(): array
    {
        return [
            'adult_price' => new FloatCast(),
            'child_price' => new FloatCast(),
            'commission_rate' => new FloatCast(),
        ];
    }
    
    public function calculateTotalPrice(): float
    {
        $basePrice = $this->adult_price + ($this->child_price ?? 0);
        $commissionAmount = $basePrice * ($this->commission_rate / 100);
        return $basePrice + $commissionAmount;
    }
    
    public function getCommissionAmount(): float
    {
        $basePrice = $this->adult_price + ($this->child_price ?? 0);
        return $basePrice * ($this->commission_rate / 100);
    }
}