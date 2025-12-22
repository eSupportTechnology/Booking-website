<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarReview extends Model
{
    protected $table = 'reviews'; 
    protected $fillable = [
        'reservation_id',
        'user_id',
        'rating',
        'comment',
        'reply',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'booking_id');
    }
}
