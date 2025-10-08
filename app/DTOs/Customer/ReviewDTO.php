<?php

namespace App\DTOs\Customer;

use Illuminate\Http\Request;

class ReviewDTO
{
    public function __construct(
        public int $booking_id,
        public int $property_id,
        public int $user_id,
        public int $rating,
        public ?string $comment = null,
        public ?float $staff_rating = null,
        public ?float $facilities_rating = null,
        public ?float $cleanliness_rating = null,
        public ?float $comfort_rating = null,
        public ?float $value_rating = null,
        public ?float $location_rating = null,
        public ?float $wifi_rating = null,
    ) {}

    public static function fromRequest(Request $request, int $booking_id, int $property_id, int $user_id): self
    {
        return new self(
            booking_id: $booking_id,
            property_id: $property_id,
            user_id: $user_id,
            rating: $request->integer('rating'),
            comment: $request->string('comment')->toString(),
            staff_rating: $request->float('staff_rating'),
            facilities_rating: $request->float('facilities_rating'),
            cleanliness_rating: $request->float('cleanliness_rating'),
            comfort_rating: $request->float('comfort_rating'),
            value_rating: $request->float('value_rating'),
            location_rating: $request->float('location_rating'),
            wifi_rating: $request->float('wifi_rating'),
        );
    }

    public function toArray(): array
    {
        return [
            'booking_id' => $this->booking_id,
            'property_id' => $this->property_id,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'staff_rating' => $this->staff_rating,
            'facilities_rating' => $this->facilities_rating,
            'cleanliness_rating' => $this->cleanliness_rating,
            'comfort_rating' => $this->comfort_rating,
            'value_rating' => $this->value_rating,
            'location_rating' => $this->location_rating,
            'wifi_rating' => $this->wifi_rating,
        ];
    }
}