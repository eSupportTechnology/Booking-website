<?php

namespace App\Services\Partner;

use App\DTOs\Partner\PropertyStatsDTO;
use Illuminate\Support\Facades\Auth;

class PropertyService
{
    public function getPropertyStats(): PropertyStatsDTO
    {
        $partnerId = Auth::id();
        
        return PropertyStatsDTO::fromArray([
            'total_properties' => 5,
            'active_properties' => 4,
            'pending_approval' => 1,
            'inactive_properties' => 0
        ]);
    }

    public function getProperties(): array
    {
        return [
            [
                'name' => 'Ocean View Apartment',
                'type' => 'Apartment',
                'location' => 'Colombo',
                'status' => 'Active',
                'bookings' => 8
            ]
        ];
    }

    public function getBookings(): array
    {
        return [
            [
                'id' => 'BK10234',
                'guest' => 'Sarah Johnson',
                'property' => 'Ocean View Apartment',
                'check_in' => '2025-07-20',
                'check_out' => '2025-07-25',
                'status' => 'Confirmed',
                'amount' => 900
            ]
        ];
    }
}