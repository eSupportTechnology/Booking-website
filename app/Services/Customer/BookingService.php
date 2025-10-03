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

    public function calculatePrice(Property $property, string $checkIn, string $checkOut, int $guestCount): float
    {
        $checkInDate = new \DateTime($checkIn);
        $checkOutDate = new \DateTime($checkOut);
        $nights = $checkInDate->diff($checkOutDate)->days;
        
        $basePrice = $property->pricing->base_price ?? 100.00;
        
        return $basePrice * $nights;
    }

    public function isPropertyAvailable(Property $property, string $checkIn, string $checkOut): bool
    {
        $conflictingBookings = Booking::where('property_id', $property->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();

        return !$conflictingBookings;
    }

    public function getUserBookings(int $userId)
    {
        return Booking::where('user_id', $userId)
            ->with(['property.photos', 'property.category'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}