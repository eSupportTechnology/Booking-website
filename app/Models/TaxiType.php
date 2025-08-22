<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxiType extends Model
{
    protected $fillable = ['name', 'description', 'passenger_capacity', 'luggage_capacity'];
    public function taxis()
    {
        return $this->hasMany(Taxi::class);
    }
}
