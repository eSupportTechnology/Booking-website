<?php

namespace App\View\Customer;

use App\Models\Property;
use App\Models\Booking;

class BookingViewModel
{
    public function __construct(
        private Property $property
    ) {}

    public function getPropertyData(): array
    {
        return [
            'id' => $this->property->id,
            'title' => $this->property->title,
            'description' => $this->property->description,
            'address' => $this->property->address,
            'city' => $this->property->city,
            'category' => $this->property->category->name,
            'photos' => $this->property->photos->map(fn($photo) => [
                'path' => $photo->file_path,
                'alt' => $this->property->title
            ]),
            'amenities' => $this->property->amenities->map(fn($amenity) => [
                'name' => $amenity->name,
                'category' => $amenity->category
            ]),
            'rooms' => $this->property->rooms->map(fn($room) => [
                'id' => $room->id,
                'name' => $room->name,
                'amenities' => $room->amenities->pluck('name')
            ]),
            'pricing' => [
                'price_per_night' => $this->property->pricing->price_per_night   ?? 5000,
                'currency' => 'LKR'
            ]
        ];
    }

    public function getBookingFormData(): array
    {
        return [
            'property_id' => $this->property->id,
            'min_date' => now()->addDay()->format('Y-m-d'),
            'max_date' => now()->addYear()->format('Y-m-d'),
            'guest_options' => range(1, 10),
            'room_options' => $this->property->rooms->map(fn($room) => [
                'id' => $room->id,
                'name' => $room->name
            ])
        ];
    }

    public static function formatBookingForDisplay(Booking $booking): array
    {
        return [
            'id' => $booking->id,
            'property' => [
                'title' => $booking->property->title,
                'address' => $booking->property->address,
                'city' => $booking->property->city,
                'category' => $booking->property->category->name,
                'image' => $booking->property->photos->first()?->file_path
            ],
            'dates' => [
                'check_in' => $booking->check_in->format('M d, Y'),
                'check_out' => $booking->check_out->format('M d, Y'),
                'nights' => $booking->check_in->diffInDays($booking->check_out)
            ],
            'guests' => $booking->guest_count,
            'room' => $booking->room?->name,
            'total_price' => number_format($booking->total_price),
            'status' => $booking->status,
            'status_color' => match($booking->status) {
                'confirmed' => 'green',
                'pending' => 'yellow',
                'cancelled' => 'red',
                default => 'gray'
            }
        ];
    }
}
