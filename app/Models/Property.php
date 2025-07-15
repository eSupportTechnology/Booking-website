<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'subtype_id',
        'address_type_id',
        'title',
        'description',
        'address',
        'city',
        'country',
        'zipcode',
        'latitude',
        'longitude',
        'status'
    ];
    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity');
    }
}
