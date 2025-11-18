<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'car_renter_id','car_type_id','company_id','model_id','brand','seats','nearest_city','with_driver',
        'driver_name','driver_phone','driver_age','driver_experience','driver_nic',
        'driver_license_front','driver_license_back',
        'transmission','mileage_type','fuel_type','car_front', 'car_back', 'car_inside','price_per_day','price_per_km','currency','deposit','status','approval_status','rejection_reason'
    ];

    protected $casts = [
        'status' => 'string'
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
    public function brand()
    {
        return $this->belongsTo(CarBrand::class); // ✅ FIXED
    }
    public function reservations()
    {
        return $this->hasMany(CarReservation::class);
    }

    public function renter()
    {
        return $this->belongsTo(CarRenter::class, 'car_renter_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'car_id');
    }

    public function mainImage()
    {
        return $this->hasOne(File::class, 'car_id')->where('file_type', 'image');
    }
}
