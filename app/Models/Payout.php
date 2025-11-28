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

    /**
     * Get the partner/host that will receive this payout
     */
    public function partner()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    /**
     * Mark payout as processing
     */
    public function markAsProcessing(): void
    {
        $this->update(['payout_status' => 'processing']);
    }

    /**
     * Mark payout as completed
     */
    public function markAsCompleted(string $transactionRef): void
    {
        $this->update([
            'payout_status' => 'completed',
            'payout_date' => now(),
            'transaction_reference' => $transactionRef
        ]);
    }

    /**
     * Mark payout as failed
     */
    public function markAsFailed(string $reason = null): void
    {
        $this->update([
            'payout_status' => 'failed',
            'transaction_reference' => $reason
        ]);
    }

    /**
     * Check if payout can be processed
     */
    public function canBeProcessed(): bool
    {
        return $this->payout_status === 'pending' && $this->booking && $this->booking->payment_status === 'completed';
    }
}
