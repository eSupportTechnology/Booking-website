<?php

namespace App\View\Admin;

use App\Models\Taxi;

class TaxiDetailViewModel
{
    public function __construct(
        public Taxi $taxi
    ) {}

    public function toArray(): array
    {
        return [
            'taxi' => $this->taxi,
            'driver' => $this->taxi->drivers->first(),
            'statistics' => $this->getStatistics(),
            'performance' => $this->getPerformanceData()
        ];
    }

    private function getStatistics(): array
    {
        return [
            'total_bookings' => 180,
            'completed_trips' => 170,
            'canceled_trips' => 5,
            'ongoing_trips' => 5,
            'peak_booking_time' => 'Evening',
            'top_pickup_locations' => ['Colombo', 'Kandy', 'Negombo']
        ];
    }

    private function getPerformanceData(): array
    {
        return [
            'total_revenue' => 120000,
            'monthly_revenue' => 30000,
            'total_trips' => 145,
            'customers_served' => 95,
            'average_fare' => 1200,
            'total_distance' => 4500
        ];
    }
}