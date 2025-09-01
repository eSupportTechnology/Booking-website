<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Amenity extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category'];
    public $timestamps = false;

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_amenity', 'amenity_id', 'property_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_amenity', 'amenity_id', 'room_id');
    }
}
