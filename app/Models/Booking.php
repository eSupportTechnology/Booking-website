<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'room_id',
        'check_in',
        'check_out',
        'guest_count',
        'total_price',
        'status'
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function commissionInvoices()
    {
        return $this->hasMany(CommissionInvoice::class, 'booking_id');
    }

    public function cancelBooking()
    {
        $this->update(['status' => 'cancelled']);
        
        // Cancel any unpaid commission invoices for this booking
        $this->commissionInvoices()
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);
    }
}
