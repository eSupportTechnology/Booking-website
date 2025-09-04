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
        'photo'
    ];

    // Each driver belongs to one taxi
    public function taxi()
    {
        return $this->belongsTo(Taxi::class);
    }
}
