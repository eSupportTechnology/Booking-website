<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    protected $fillable = ['taxi_id', 'fare_type', 'base_fare', 'price', 'airport_fee', 'luggage_fee'];
    public function taxi()
    {
        return $this->belongsTo(Taxi::class);
    }
}
