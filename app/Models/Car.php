<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'car_type_id',
        'company_id',
        'model_id',
        'seats',
        'transmission',
        'mileage_type',
        'pay_timing',
        'fuel_type',
        'price_per_day',
        'deposit'
    ];

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function reservations()
    {
        return $this->hasMany(Car_Reservation::class);
    }
}
