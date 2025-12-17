<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleTypeCommission extends Model
{
    protected $fillable = [
        'car_renter_id',
        'vehicle_type_id',
        'commission_rate'
    ];

    public function vehicleType()
    {
        return $this->belongsTo(CarType::class, 'vehicle_type_id');
    }

    public function carRenter()
    {
        return $this->belongsTo(CarRenter::class, 'car_renter_id');
    }
}
