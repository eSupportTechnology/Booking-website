<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAdditionalDetail extends Model
{
    protected $fillable = [
        'property_id', 'guests', 'bathrooms', 'allow_children', 'offer_cribs', 'apartment_size', 'apartment_unit'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
