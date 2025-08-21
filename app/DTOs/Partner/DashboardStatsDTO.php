<?php

namespace App\DTOs\Partner;

class DashboardStatsDTO
{
    public function __construct(
        public readonly int $totalProperties,
        public readonly int $activeBookings,
        public readonly float $monthlyEarnings,
        public readonly float $averageRating
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            totalProperties: $data['total_properties'] ?? 0,
            activeBookings: $data['active_bookings'] ?? 0,
            monthlyEarnings: $data['monthly_earnings'] ?? 0.0,
            averageRating: $data['average_rating'] ?? 0.0
        );
    }
}