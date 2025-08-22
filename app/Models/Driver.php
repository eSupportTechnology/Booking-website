<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'contact_number', 'email', 'license_number', 'photo'];
    public function taxis()
    {
        return $this->belongsToMany(Taxi::class, 'taxi_driver')->withTimestamps()->withPivot(['assigned_at', 'released_at']);
    }
}
