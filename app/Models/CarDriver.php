<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDriver extends Model
{
    protected $fillable = [
        'car_id',
        'name',
        'phone',
        'age',
        'experience',
        'nic',
    ];

    // A driver belongs to a car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
