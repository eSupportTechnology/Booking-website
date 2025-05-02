<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelersDetails extends Model
{
    protected $table = 'travelers_details';
    protected $fillable = [
        'traveler_id',
        'display_name',
        'phone',
        'dob',
        'nationality',
        'gender',
        'passport_details',
        'address',
        'profile_picture',
    ];

    public function traveler()
    {
        return $this->belongsTo(Traveler::class);
    }
}
