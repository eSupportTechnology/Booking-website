<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAdditionalDetail extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'property_id',
        'guests',
        'bedrooms',
        'bathrooms',
        'allow_children',
        'offer_cribs',
        'apartment_size',
        'apartment_unit',
        'breakfast',
        'parking',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
