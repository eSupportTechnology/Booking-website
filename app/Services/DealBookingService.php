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

        if (!$deal || $deal->status !== 'active') {
            return ['valid' => false, 'message' => 'Deal is not available'];
        }

        // Fix: Check if booking dates overlap with deal period instead of checking now()
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);

        if ($checkInDate->gt($deal->end_date) || $checkOutDate->lt($deal->start_date)) {
            return ['valid' => false, 'message' => 'Deal is not valid for the selected dates'];
        }

        // Check if deal applies to the selected room
        if ($deal->applicable_to === 'room') {
            if (!$roomId || $deal->room_id !== $roomId) {
                return ['valid' => false, 'message' => 'This deal is only valid for specific room: ' . $deal->room->name];
            }
        }

        // Check date restrictions
        if ($deal->dealDates->count() > 0) {
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

    public function applyDealDiscount($deal, $originalPrice, $checkIn, $checkOut, $adults = null, $children = null, $property = null)
    {
        $checkInDate = Carbon::parse($checkIn);
        $checkOutDate = Carbon::parse($checkOut);
        $nights = $checkInDate->diffInDays($checkOutDate);
        $pricePerNight = $originalPrice / max(1, $nights);

        // Adult/Child pricing breakdown (for apartments, homes, alternative places)
        $hasAdultChildPricing = $property && $adults !== null && $children !== null &&
            ($property->adult_price > 0 || $property->child_price > 0);

        $adultPricePerNight = 0;
        $childPricePerNight = 0;

        if ($hasAdultChildPricing) {
            $commissionRate = $property->commission_rate ?? 0;
            $adultPriceBase = $property->adult_price ?? 0;
            $childPriceBase = $property->child_price ?? 0;

            $adultPriceWithComm = $adultPriceBase + ($adultPriceBase * $commissionRate / 100);
            $childPriceWithComm = $childPriceBase + ($childPriceBase * $commissionRate / 100);

            $adultPricePerNight = $adults * $adultPriceWithComm;
            $childPricePerNight = $children * $childPriceWithComm;
        }

        $totalDiscount = 0;
        $adultDiscount = 0;
        $childDiscount = 0;
        $currentDate = $checkInDate->copy();
        $dealNights = 0;

        while ($currentDate->lt($checkOutDate)) {
            if ($deal->isAvailableOnDate($currentDate)) {
                $dealNights++;
                // Calculate discount for this night (Percentage only)
                $nightDiscount = $pricePerNight * ($deal->discount_percentage / 100);
                $totalDiscount += $nightDiscount;

                // Break down adult/child discounts proportionally
                if ($hasAdultChildPricing && $pricePerNight > 0) {
                    $adultDiscount += ($adultPricePerNight / $pricePerNight) * $nightDiscount;
                    $childDiscount += ($childPricePerNight / $pricePerNight) * $nightDiscount;
                }
            }
            $currentDate->addDay();
        }

        $finalPrice = max(0, $originalPrice - $totalDiscount);

        $result = [
            'original_price' => $originalPrice,
            'discount_amount' => $totalDiscount,
            'final_price' => $finalPrice,
            'deal_type' => $deal->deal_type,
            'deal_title' => $deal->title,
            'deal_nights' => $dealNights
        ];

        // Add adult/child breakdown if applicable
        if ($hasAdultChildPricing) {
            $result['adult_price_before_deal'] = $adultPricePerNight * $nights;
            $result['child_price_before_deal'] = $childPricePerNight * $nights;
            $result['adult_discount'] = $adultDiscount;
            $result['child_discount'] = $childDiscount;
            $result['adult_price_after_deal'] = max(0, ($adultPricePerNight * $nights) - $adultDiscount);
            $result['child_price_after_deal'] = max(0, ($childPricePerNight * $nights) - $childDiscount);
        }

        return $result;
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
