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
        'deal_id',
        'check_in',
        'check_out',
        'guest_count',
        'total_price',
        'original_price',
        'discount_amount',
        'currency',
        'base_currency',
        'status',
        'payment_method',
        'payment_status',
        'payment_reference',
        'payment_deadline',
        'commission_rate',
        'commission_amount',
        'commission_status'
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total_price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'payment_deadline' => 'datetime',
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

    public function deal()
    {
        return $this->belongsTo(Deal::class);
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

    public function generateCommission()
    {
        if ($this->status === 'confirmed' && $this->commission_status === 'pending') {
            $commissionAmount = ($this->total_price * $this->commission_rate) / 100;
            
            CommissionInvoice::create([
                'partner_id' => $this->property->partner_id,
                'booking_id' => $this->id,
                'invoice_number' => 'INV-' . $this->id . '-' . now()->format('Ymd'),
                'amount' => $commissionAmount,
                'due_date' => now()->addDays(30),
                'status' => 'pending'
            ]);
            
            $this->update([
                'commission_amount' => $commissionAmount,
                'commission_status' => 'invoiced'
            ]);
        }
    }

    public function cancelBooking()
    {
        $this->update(['status' => 'cancelled']);
        
        // Cancel unpaid commissions
        $this->commissionInvoices()
            ->where('status', 'pending')
            ->update(['status' => 'cancelled']);
            
        $this->update(['commission_status' => 'cancelled']);
    }

    public function canBeReviewed()
    {
        return $this->status === 'confirmed' && 
               $this->check_out <= now() && 
               !$this->reviews()->exists();
    }

    public function hasReview()
    {
        return $this->reviews()->exists();
    }
}
