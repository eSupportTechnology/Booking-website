<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
      protected $fillable = [
        'car_renter_id','car_type_id','company_id','model_id','brand','seats','with_driver',
        'driver_name','driver_phone','driver_age','driver_experience','driver_nic',
        'transmission','mileage_type','fuel_type','image','price_per_day','price_per_km'
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
     public function renter()
    {
        return $this->belongsTo(CarRenter::class, 'car_renter_id');
    }
// App\Models\Car.php
public function files()
{
    return $this->hasMany(File::class, 'car_id');
}

public function image()
{
    return $this->hasOne(File::class, 'car_id')->where('file_type', 'image');
}


}
