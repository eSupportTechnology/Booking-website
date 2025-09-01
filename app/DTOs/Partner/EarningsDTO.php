<?php

namespace App\DTOs\Partner;

class EarningsDTO
{
    public function __construct(
        public readonly float $totalEarnings,
        public readonly float $monthlyEarnings,
        public readonly float $pendingPayout,
        public readonly float $averageBooking,
        public readonly array $transactions
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            totalEarnings: $data['totalEarnings'],
            monthlyEarnings: $data['monthlyEarnings'],
            pendingPayout: $data['pendingPayout'],
            averageBooking: $data['averageBooking'],
            transactions: $data['transactions']
        );
    }
}