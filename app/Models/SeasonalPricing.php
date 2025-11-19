<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeasonalPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'season_name',
        'start_date',
        'end_date',
        'adult_price',
        'child_price',
        'commission_rate',
        'total_price_with_commission',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'adult_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'total_price_with_commission' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function calculateTotalPrice()
    {
        $basePrice = $this->adult_price + ($this->child_price ?? 0);
        $commissionAmount = $basePrice * ($this->commission_rate / 100);
        return $basePrice + $commissionAmount;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
    }
}