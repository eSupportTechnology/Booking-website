<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxiTypeCommission extends Model
{
    protected $fillable = [
        'car_renter_id',
        'taxi_type_id',
        'commission_rate'
    ];
}
