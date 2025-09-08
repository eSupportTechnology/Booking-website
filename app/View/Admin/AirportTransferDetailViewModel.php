<?php

namespace App\View\Admin;

use App\Models\Taxi;

class AirportTransferDetailViewModel
{
    public function __construct(
        public Taxi $transfer
    ) {}

    public function toArray(): array
    {
        return [
            'transfer' => $this->transfer,
            'statistics' => $this->getStatistics(),
            'insights' => $this->getInsights()
        ];
    }

    private function getStatistics(): array
    {
        return [
            'total_passengers' => '12.5M',
            'monthly_flights' => '1,200',
            'total_airlines' => '45'
        ];
    }

    private function getInsights(): array
    {
        return [
            'unique_customers' => '150K',
            'repeat_customers' => '60%',
            'customer_rating' => '4.8',
            'customer_reviews' => '12,000'
        ];
    }
}