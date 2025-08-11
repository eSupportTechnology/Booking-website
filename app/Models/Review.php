<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'booking_id', 
        'property_id', 
        'user_id', 
        'rating', 
        'comment',
        'staff_rating',
        'facilities_rating', 
        'cleanliness_rating',
        'comfort_rating',
        'value_rating',
        'location_rating',
        'wifi_rating'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traveler()
    {
        return $this->belongsTo(Traveler::class, 'user_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
