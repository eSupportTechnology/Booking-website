<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'taxi_id',
        'name',
        'contact_number',
        'email',
        'license_number',
        'photo',
        'driver_license_front',
        'driver_license_back',
        'tourism_license_front',
        'tourism_license_back'
    ];

    // Each driver belongs to one taxi
    public function taxi()
    {
        return $this->belongsTo(Taxi::class);
    }
}
