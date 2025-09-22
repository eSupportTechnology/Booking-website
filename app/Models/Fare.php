<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fare extends Model
{
    protected $fillable = ['taxi_id',  'price_per_km',
    'price_per_day', 'base_fare', 'price', 'airport_fee', 'luggage_fee'];
    public function taxi()
    {
        return $this->belongsTo(Taxi::class);
    }
}
