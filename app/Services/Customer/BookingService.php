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

    public function calculatePrice(Property $property, ?int $roomId, string $checkIn, string $checkOut, int $guestCount): array
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
            $basePrice = $property->pricing->price_per_night ?? 100.00;
            $baseCurrency = $property->pricing->currency ?? 'USD';
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
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
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
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->whereNotNull('room_id')
            ->pluck('room_id')
            ->toArray();

        return $property->rooms()->whereNotIn('id', $bookedRoomIds)->with(['roomType', 'amenities'])->get();
    }
}