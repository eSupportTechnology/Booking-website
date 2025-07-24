<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyPricing extends Model
{
    protected $fillable = [
        'property_id',
        'booking_type',
        'price_per_night',
        'currency',
        'discount_enabled',
        'discount_percent'
    ];

    protected $casts = [
        'discount_enabled' => 'boolean',
        'discount_percent' => 'integer',
        'price_per_night' => 'decimal:2'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
