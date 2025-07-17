<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'ownership_type',
        'property_id',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function individuals()
    {
        return $this->hasMany(Individual::class);
    }

    public function businessEntities()
    {
        return $this->hasMany(BusinessEntity::class);
    }
} 