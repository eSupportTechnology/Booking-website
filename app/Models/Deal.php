<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount_percentage',
        'original_price',
        'discounted_price',
        'fixed_discount_amount',
        'special_offer_text',
        'applicable_to',
        'start_date',
        'end_date',
        'property_id',
        'room_id',
        'partner_id',
        'status',
        'deal_type',
        'currency'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'original_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'fixed_discount_amount' => 'decimal:2',
        'discount_percentage' => 'integer',
        'currency' => 'string'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function dealDates()
    {
        return $this->hasMany(DealDate::class);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('deal_type', $type);
    }

    public function calculateDiscount($basePrice)
    {
        switch ($this->deal_type) {
            case 'percentage':
                return $basePrice * ($this->discount_percentage / 100);
            case 'fixed':
                return $this->fixed_discount_amount;
            case 'special':
                return $basePrice - $this->discounted_price;
            default:
                return 0;
        }
    }

    public function getDiscountDisplayAttribute()
    {
        switch ($this->deal_type) {
            case 'percentage':
                return $this->discount_percentage . '% OFF';
            case 'fixed':
                return '$' . $this->fixed_discount_amount . ' OFF';
            case 'special':
                return $this->special_offer_text;
            default:
                return 'Special Deal';
        }
    }

    public function isAvailableOnDate($date)
    {
        // Use loaded collection instead of query to avoid N+1 problem
        if ($this->dealDates->count() === 0) {
            return $date >= $this->start_date && $date <= $this->end_date;
        }
        
        return $this->dealDates->where('available_date', $date)->isNotEmpty();
    }
}