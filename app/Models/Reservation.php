<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'reservations';

    protected $fillable = [
        'car_id',
        'user_id',
        'start_date',
        'end_date',
        'pickup_location',
        'dropoff_location',
        'pickup_datetime',
        'dropoff_datetime',
        'total_price',
        'status',
        'payment_status',
        'notes',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
    
     public function messages()
    {
        return $this->hasMany(Message::class, 'booking_id');
    }

}
