<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\RoomBed;

class Room extends Model
{
    protected $fillable = [
        'property_id',
        'room_type_id',
        'name',
        'description',
        'price_per_night',
        'size_sq_m',    
        'max_guests',
        'bathroom_count',
        'bathroom_amenities',
        'bathroom_type',
        'room_type', 
        'bed_type',
        'smoking_allowed', 
        'price_per_night', 
        'currency', 
        'discount_enabled', 
        'commission_percentage', 
        'you_earn',

    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function beds()
    {
        return $this->belongsToMany(BedType::class, 'room_beds')->withPivot('count')->withTimestamps();
    }

     public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenity', 'room_id', 'amenity_id');
    }

    public function ratePlans()
    {
        return $this->hasMany(RatePlan::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

}
