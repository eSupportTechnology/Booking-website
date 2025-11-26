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

            // Check if at least one booking date is within deal dates
            $currentDate = $checkInDate->copy();
            $hasValidDate = false;

            while ($currentDate->lt($checkOutDate)) {
                if ($deal->isAvailableOnDate($currentDate)) {
                    $hasValidDate = true;
                    break;
                }
                $currentDate->addDay();
            }

            if (!$hasValidDate) {
                return [
                    'valid' => false,
                    'message' => 'Deal is not available for any of the selected dates.'
                ];
            }
        }

        return ['valid' => true, 'deal' => $deal];
    }

    public function applyDealDiscount($deal, $originalPrice, $checkIn, $checkOut)
    {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        $nights = $checkInDate->diffInDays($checkOutDate);
        $pricePerNight = $originalPrice / max(1, $nights);

        $totalDiscount = 0;
        $currentDate = $checkInDate->copy();

        while ($currentDate->lt($checkOutDate)) {
            if ($deal->isAvailableOnDate($currentDate)) {
                // Calculate discount for this night
                if ($deal->deal_type === 'percentage') {
                    $totalDiscount += $pricePerNight * ($deal->discount_percentage / 100);
                } elseif ($deal->deal_type === 'fixed') {
                    $totalDiscount += $deal->fixed_discount_amount;
                } elseif ($deal->deal_type === 'special') {
                    // Special offer logic (assuming it replaces the price)
                    $totalDiscount += $pricePerNight - $deal->discounted_price;
                }
            }
            $currentDate->addDay();
        }

        $finalPrice = max(0, $originalPrice - $totalDiscount);

        return [
            'original_price' => $originalPrice,
            'discount_amount' => $totalDiscount,
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
            $query->where(function ($q) use ($roomId) {
                $q->where('applicable_to', 'property')
                    ->orWhere(function ($qq) use ($roomId) {
                        $qq->where('applicable_to', 'room')
                            ->where('room_id', $roomId);
                    });
            });
        } else {
            $query->where('applicable_to', 'property');
        }

        $deals = $query->get();

        return $deals->filter(function ($deal) use ($checkIn, $checkOut) {
            $validation = $this->validateDealBooking($deal->id, $checkIn, $checkOut);
            return $validation['valid'];
        });
    }
}
