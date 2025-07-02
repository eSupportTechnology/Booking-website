<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyAmenity extends Model
{
    use HasFactory;
    protected $fillable = ['property_id', 'amenity_id'];
    public $timestamps = false;
}
