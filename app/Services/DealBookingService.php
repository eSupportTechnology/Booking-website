<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\Booking;
use Carbon\Carbon;

class DealBookingService
{
    public function validateDealBooking($dealId, $checkIn, $checkOut, $roomId = null)
    {
        $deal = Deal::with(['dealDates', 'property', 'room'])->find($dealId);
        
        if (!$deal || $deal->status !== 'active' || now()->lt($deal->start_date) || now()->gt($deal->end_date)) {
            return ['valid' => false, 'message' => 'Deal is not available'];
        }

        // Check if deal applies to the selected room
        if ($deal->applicable_to === 'room') {
            if (!$roomId || $deal->room_id !== $roomId) {
                return ['valid' => false, 'message' => 'This deal is only valid for specific room: ' . $deal->room->name];
            }
        }

        // Check date restrictions
        if ($deal->dealDates->count() > 0) {
            $checkInDate = Carbon::parse($checkIn);
            $checkOutDate = Carbon::parse($checkOut);
            
            // Check if all booking dates are within deal dates
            $currentDate = $checkInDate->copy();
            while ($currentDate->lt($checkOutDate)) {
                if (!$deal->isAvailableOnDate($currentDate)) {
                    return [
                        'valid' => false, 
                        'message' => 'Deal is not available for selected dates. Available dates: ' . 
                                   $deal->dealDates->pluck('available_date')->map(fn($d) => $d->format('M d'))->join(', ')
                    ];
                }
                $currentDate->addDay();
            }
        }

        return ['valid' => true, 'deal' => $deal];
    }

    public function applyDealDiscount($deal, $originalPrice)
    {
        $discount = $deal->calculateDiscount($originalPrice);
        $finalPrice = max(0, $originalPrice - $discount);
        
        return [
            'original_price' => $originalPrice,
            'discount_amount' => $discount,
            'final_price' => $finalPrice,
            'deal_type' => $deal->deal_type,
            'deal_title' => $deal->title
        ];
    }

    public function getAvailableDealsForProperty($propertyId, $checkIn, $checkOut, $roomId = null)
    {
        $query = Deal::active()
                    ->where('property_id', $propertyId)
                    ->with(['dealDates', 'room']);

        if ($roomId) {
            $query->where(function($q) use ($roomId) {
                $q->where('applicable_to', 'property')
                  ->orWhere(function($qq) use ($roomId) {
                      $qq->where('applicable_to', 'room')
                         ->where('room_id', $roomId);
                  });
            });
        } else {
            $query->where('applicable_to', 'property');
        }

        $deals = $query->get();
        
        return $deals->filter(function($deal) use ($checkIn, $checkOut) {
            $validation = $this->validateDealBooking($deal->id, $checkIn, $checkOut);
            return $validation['valid'];
        });
    }
}