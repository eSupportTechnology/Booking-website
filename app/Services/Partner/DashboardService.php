<?php

namespace App\Services\Partner;

use App\DTOs\Partner\DashboardStatsDTO;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getDashboardStats(): DashboardStatsDTO
    {
        $partnerId = Auth::id();
        
        // Mock data - replace with actual database queries
        return DashboardStatsDTO::fromArray([
            'total_properties' => 5,
            'active_bookings' => 12,
            'monthly_earnings' => 2450.0,
            'average_rating' => 4.8
        ]);
    }

    public function getRecentBookings(): array
    {
        // Mock data - replace with actual database queries
        return [
            [
                'id' => 'BK10234',
                'guest_name' => 'Sarah Johnson',
                'property_name' => 'Ocean View Apartment',
                'check_in' => '2025-07-20',
                'status' => 'Confirmed',
                'earnings' => 180
            ]
        ];
    }

    public function getChartData(): array
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'earnings' => [1200, 1800, 1500, 2200, 1900, 2400, 2450],
            'bookings' => [8, 12, 10, 15, 13, 16, 12]
        ];
    }
}