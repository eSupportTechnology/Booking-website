<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_id',
        'booking_id',
        'amount',
        'payout_status',
        'payout_method',
        'transaction_reference',
        'payout_date'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payout_date' => 'datetime'
    ];

    /**
     * Get the host that owns the payout.
     */
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    /**
     * Get the booking associated with the payout.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
