<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Traveler extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function details()
    {
        return $this->hasOne(TravelersDetails::class, 'traveler_id');
    }
}
