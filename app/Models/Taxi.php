<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    protected $fillable = [
        'car_renter_id', 'taxi_type_id', 'number_plate',
        'color', 'passenger_capacity', 'luggage_capacity', 'status', 'front_image',   
        'back_image',    
        'inside_image',  
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function type()
    {
        return $this->belongsTo(TaxiType::class, 'taxi_type_id');
    }

     public function drivers()
    {
        return $this->hasMany(Driver::class); // One-to-many now
    }

    public function fare()
    {
        return $this->hasOne(Fare::class);
    }

    public function renter()
    {
        return $this->belongsTo(CarRenter::class, 'car_renter_id');
    }
}
