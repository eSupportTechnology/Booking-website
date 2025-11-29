<?php

namespace App\Services\Customer;

use App\Models\Booking;
use App\Models\Property;
use App\Models\Message;
use App\DTOs\Customer\BookingDTO;
use Illuminate\Support\Facades\Auth;

class BookingService
{
    public function createBooking(BookingDTO $bookingDTO): Booking
    {
        $booking = new Booking();
        $booking->user_id = Auth::guard('customer')->id();
        $booking->property_id = $bookingDTO->property_id;
        $booking->room_id = $bookingDTO->room_id ?? null;
        $booking->check_in = $bookingDTO->check_in;
        $booking->check_out = $bookingDTO->check_out;
        $booking->guest_count = $bookingDTO->guest_count;
        $booking->adults = $bookingDTO->adults;
        $booking->children = $bookingDTO->children;
        $booking->total_price = $bookingDTO->total_price;
        $booking->status = $bookingDTO->status;
        $booking->save();

        // Create initial message
        $property = Property::find($bookingDTO->property_id);
        if ($property && $property->user_id) {
            Message::create([
                'sender_id' => Auth::guard('customer')->id(),
                'receiver_id' => $property->user_id,
                'booking_id' => $booking->id,
                'content' => 'Hi! I just made a booking for your property. Looking forward to my stay!',
                'is_read' => false
            ]);
        }

        return $booking;
    }

    public function calculatePrice(Property $property, ?int $roomId, string $checkIn, string $checkOut, int $adults = 1, int $children = 0): array
    {
        $checkInDate = new \DateTime($checkIn);
        $checkOutDate = new \DateTime($checkOut);
        $nights = $checkInDate->diff($checkOutDate)->days;
        $userCurrency = app(\App\Services\CurrencyManager::class)->getUserCurrency();

        if ($roomId) {
            $room = \App\Models\Room::find($roomId);
            $basePrice = $room ? $room->price_per_night : ($property->pricing->price_per_night ?? 100.00);
            $baseCurrency = $room ? ($room->currency ?? 'USD') : ($property->pricing->currency ?? 'USD');
        } else {
            // Property booking (Home/Apartment) - Per person pricing
            $commissionRate = $property->commission_rate ?? 0;

            $adultPriceBase = $property->adult_price ?? 0;
            $childPriceBase = $property->child_price ?? 0;

            $adultPriceWithComm = $adultPriceBase + ($adultPriceBase * $commissionRate / 100);
            $childPriceWithComm = $childPriceBase + ($childPriceBase * $commissionRate / 100);

            $basePrice = ($adults * $adultPriceWithComm) + ($children * $childPriceWithComm);

            // Fallback to price per night if per-person prices are not set
            if ($basePrice <= 0) {
                $basePrice = $property->pricing->price_per_night ?? 100.00;
            }

            $baseCurrency = $property->currency ?? ($property->pricing->currency ?? 'USD');
        }

        $convertedPrice = app(\App\Services\CurrencyService::class)->convert($basePrice, $baseCurrency, $userCurrency);

        return [
            'total_price' => $convertedPrice * $nights,
            'currency' => $userCurrency,
            'base_currency' => $baseCurrency,
            'nights' => $nights,
            'price_per_night' => $convertedPrice
        ];
    }

    public function isRoomAvailable(Property $property, ?int $roomId, string $checkIn, string $checkOut): bool
    {
        $query = Booking::where('property_id', $property->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            });

        if ($roomId) {
            $query->where('room_id', $roomId);
        } else {
            // For properties without specific rooms, check if any booking exists
            $query->whereNull('room_id');
        }

        return !$query->exists();
    }

    public function getUserBookings(int $userId)
    {
        return Booking::where('user_id', $userId)
            ->with(['property.photos', 'property.category', 'room'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getAvailableRooms(Property $property, string $checkIn, string $checkOut): \Illuminate\Database\Eloquent\Collection
    {
        $bookedRoomIds = Booking::where('property_id', $property->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->whereNotNull('room_id')
            ->pluck('room_id')
            ->toArray();

        return $property->rooms()->whereNotIn('id', $bookedRoomIds)->with(['roomType', 'amenities'])->get();
    }
}
