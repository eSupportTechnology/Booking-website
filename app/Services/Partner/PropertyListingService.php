<?php

namespace App\Services\Partner;

use App\DTOs\Partner\PropertyListingsDTO;
use Illuminate\Support\Facades\Auth;

class PropertyListingService
{
    public function getPropertyCounts(): PropertyListingsDTO
    {
        $partnerId = Auth::id();
        
        // Mock data - replace with actual database queries
        return PropertyListingsDTO::fromArray([
            'apartments' => 3,
            'homes' => 2,
            'hotels' => 1,
            'alternative_places' => 1
        ]);
    }

    public function getApartments(?string $search = null): array
    {
        $apartments = [
            ['id' => 1, 'name' => 'Ocean View Apartment', 'location' => 'Colombo', 'status' => 'Active', 'bookings' => 8],
            ['id' => 2, 'name' => 'City Center Studio', 'location' => 'Kandy', 'status' => 'Active', 'bookings' => 5],
            ['id' => 3, 'name' => 'Beach Side Flat', 'location' => 'Galle', 'status' => 'Pending', 'bookings' => 0]
        ];
        
        if ($search) {
            return array_filter($apartments, fn($apt) => 
                stripos($apt['name'], $search) !== false || 
                stripos($apt['location'], $search) !== false
            );
        }
        
        return $apartments;
    }

    public function getHomes(?string $search = null): array
    {
        $homes = [
            ['id' => 4, 'name' => 'Mountain Villa', 'location' => 'Nuwara Eliya', 'status' => 'Active', 'bookings' => 12],
            ['id' => 5, 'name' => 'Garden House', 'location' => 'Kandy', 'status' => 'Active', 'bookings' => 7]
        ];
        
        if ($search) {
            return array_filter($homes, fn($home) => 
                stripos($home['name'], $search) !== false || 
                stripos($home['location'], $search) !== false
            );
        }
        
        return $homes;
    }

    public function getHotels(?string $search = null): array
    {
        $hotels = [
            ['id' => 6, 'name' => 'Luxury Resort', 'location' => 'Bentota', 'status' => 'Active', 'bookings' => 25]
        ];
        
        if ($search) {
            return array_filter($hotels, fn($hotel) => 
                stripos($hotel['name'], $search) !== false || 
                stripos($hotel['location'], $search) !== false
            );
        }
        
        return $hotels;
    }

    public function getAlternativePlaces(?string $search = null): array
    {
        $places = [
            ['id' => 7, 'name' => 'Tree House', 'location' => 'Sigiriya', 'status' => 'Active', 'bookings' => 3]
        ];
        
        if ($search) {
            return array_filter($places, fn($place) => 
                stripos($place['name'], $search) !== false || 
                stripos($place['location'], $search) !== false
            );
        }
        
        return $places;
    }
}