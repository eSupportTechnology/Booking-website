<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyBedroom extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id', 'room_type', 'name', 'twin', 'full', 'queen', 'king', 'bunk', 'sofa', 'futon'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
} 