<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'serve_breakfast',
        'breakfast_included',
        'breakfast_type',
        'parking_available',
        'parking_cost',
        'parking_cost_unit',
        'parking_reservation',
        'parking_location',
        'parking_type',
        'breakfast_price'
    ];

    protected $casts = [
        'breakfast_type' => 'array',
        'serve_breakfast' => 'boolean',
        'parking_cost' => 'decimal:2',
        'breakfast_price' => 'decimal:2'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}