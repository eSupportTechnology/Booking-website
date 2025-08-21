<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car_Reservation extends Model
{
    protected $fillable = [
        'car_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'total_price'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
