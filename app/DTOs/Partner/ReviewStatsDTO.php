<?php

namespace App\DTOs\Partner;

class ReviewStatsDTO
{
    public function __construct(
        public readonly float $averageRating,
        public readonly int $totalReviews,
        public readonly int $monthlyReviews,
        public readonly int $responseRate
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            averageRating: $data['average_rating'],
            totalReviews: $data['total_reviews'],
            monthlyReviews: $data['monthly_reviews'],
            responseRate: $data['response_rate']
        );
    }
}