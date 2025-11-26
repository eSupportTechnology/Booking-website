<?php

namespace App\DTOs\Customer;

class BookingDTO
{
    public function __construct(
        public int $property_id,
        public ?int $room_id,
        public string $check_in,
        public string $check_out,
        public int $guest_count,
        public int $adults,
        public int $children,
        public float $total_price,
        public string $status = 'pending',
        public float $commission_rate = 10.00
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            property_id: $request->property_id,
            room_id: $request->room_id,
            check_in: $request->check_in,
            check_out: $request->check_out,
            guest_count: $request->adults + $request->children,
            adults: $request->adults,
            children: $request->children,
            total_price: 0, // Will be calculated
        );
    }
}
