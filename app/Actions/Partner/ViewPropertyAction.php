<?php

namespace App\Actions\Partner;

class ViewPropertyAction
{
    public function execute(int $id): array
    {
        // Mock property data - replace with actual database query
        $properties = [
            1 => ['id' => 1, 'name' => 'Ocean View Apartment', 'type' => 'Apartment', 'location' => 'Colombo', 'status' => 'Active', 'bookings' => 8, 'description' => 'Beautiful ocean view apartment with modern amenities'],
            2 => ['id' => 2, 'name' => 'City Center Studio', 'type' => 'Apartment', 'location' => 'Kandy', 'status' => 'Active', 'bookings' => 5, 'description' => 'Cozy studio in the heart of the city'],
            3 => ['id' => 3, 'name' => 'Beach Side Flat', 'type' => 'Apartment', 'location' => 'Galle', 'status' => 'Pending', 'bookings' => 0, 'description' => 'Beachfront apartment with stunning views'],
            4 => ['id' => 4, 'name' => 'Mountain Villa', 'type' => 'Home', 'location' => 'Nuwara Eliya', 'status' => 'Active', 'bookings' => 12, 'description' => 'Luxury villa in the mountains'],
            5 => ['id' => 5, 'name' => 'Garden House', 'type' => 'Home', 'location' => 'Kandy', 'status' => 'Active', 'bookings' => 7, 'description' => 'Peaceful house with beautiful garden'],
            6 => ['id' => 6, 'name' => 'Luxury Resort', 'type' => 'Hotel', 'location' => 'Bentota', 'status' => 'Active', 'bookings' => 25, 'description' => 'Five-star luxury resort'],
            7 => ['id' => 7, 'name' => 'Tree House', 'type' => 'Alternative Place', 'location' => 'Sigiriya', 'status' => 'Active', 'bookings' => 3, 'description' => 'Unique tree house experience']
        ];

        return [
            'property' => $properties[$id] ?? null
        ];
    }
}