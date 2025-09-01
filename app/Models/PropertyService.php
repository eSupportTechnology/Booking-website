<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyService extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'serve_breakfast',
        'breakfast_included',
        'breakfast_type',
        'breakfast_price',
        'parking_available',
        'parking_cost',
        'parking_cost_unit',
        'parking_reservation',
        'parking_location',
        'parking_type',
    ];

    protected $casts = [
        'breakfast_type' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
