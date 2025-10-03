<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxiBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pickup_location',
        'dropoff_location',
        'pickup_datetime',
        'return_datetime',
        'distance_km',
        'fare_lkr',
        'name',
        'address',
        'email',
        'phone1',
        'phone2',
    ];

    /**
     * Relationship: A booking belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
