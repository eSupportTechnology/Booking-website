<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxiBooking extends Model
{
    use HasFactory;

    protected $table = 'taxi_bookings';

    protected $fillable = [
        'booking_id',
        'user_id',
        'taxi_id',
        'driver_id',

        // Trip Info
        'pickup_location',
        'dropoff_location',
        'pickup_datetime',
        'return_datetime',
        'distance',

        // Fare Breakdown
        'base_fare',
        'distance_fare',
        'service_fee',
        'total_amount',

        // Customer Info
        'name',
        'address',
        'email',
        'phone1',
        'phone2',

        // Payment
        'payment_method',
        'payment_status',

        // Booking status
        'status',
    ];

    /**
     * Relationship: A booking belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: booking belongs to taxi.
     */
    public function taxi()
    {
        return $this->belongsTo(Taxi::class, 'taxi_id');
    }

    /**
     * Relationship: booking belongs to driver.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function bookings()
{
    return $this->hasMany(TaxiBooking::class, 'taxi_id');
}

}
