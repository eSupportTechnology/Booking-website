<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyPricing extends Model
{
    protected $table = 'property_pricing';
    
    protected $fillable = [
        'property_id',
        'adult_price',
        'children_price', 
        'commission_rate',
        'season_start',
        'season_end',
        'is_default'
    ];

    protected $casts = [
        'adult_price' => 'decimal:2',
        'children_price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'season_start' => 'date',
        'season_end' => 'date',
        'is_default' => 'boolean'
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}