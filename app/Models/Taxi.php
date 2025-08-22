<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxi extends Model
{
    protected $fillable = ['taxi_type_id', 'number_plate', 'color', 'passenger_capacity', 'luggage_capacity'];
    public function type()
    {
        return $this->belongsTo(TaxiType::class, 'taxi_type_id');
    }
    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'taxi_driver')->withTimestamps()->withPivot(['assigned_at', 'released_at']);
    }
    public function fare()
    {
        return $this->hasOne(Fare::class);
    }
}
