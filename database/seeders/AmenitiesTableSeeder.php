<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            // Highlights
            ['name' => 'Private bathroom', 'category' => 'Highlights'],
            ['name' => 'Sea views', 'category' => 'Highlights'],
            ['name' => 'Family rooms', 'category' => 'Highlights'],
            ['name' => 'Airport shuttle', 'category' => 'Highlights'],
            ['name' => 'Spa and wellness center', 'category' => 'Highlights'],

            // General
            ['name' => 'Air conditioning', 'category' => 'General'],
            ['name' => 'Heating', 'category' => 'General'],
            ['name' => 'Free WiFi', 'category' => 'General'],
            ['name' => 'Electric vehicle charging station', 'category' => 'General'],

            // Cooking and cleaning
            ['name' => 'Kitchen', 'category' => 'Cooking and cleaning'],
            ['name' => 'Microwave', 'category' => 'Cooking and cleaning'],
            ['name' => 'Washing machine', 'category' => 'Cooking and cleaning'],

            // Entertainment
            ['name' => 'Flat-screen TV', 'category' => 'Entertainment'],
            ['name' => 'Swimming Pool', 'category' => 'Entertainment'],
            ['name' => 'Hot tub', 'category' => 'Entertainment'],
            ['name' => 'Minibar', 'category' => 'Entertainment'],
            ['name' => 'Sauna', 'category' => 'Entertainment'],

            // Outside and view
            ['name' => 'Balcony', 'category' => 'Outside and view'],
            ['name' => 'Garden view', 'category' => 'Outside and view'],
            ['name' => 'Terrace', 'category' => 'Outside and view'],
            ['name' => 'View', 'category' => 'Outside and view'],
        ];

        foreach ($amenities as $data) {
            Amenity::updateOrCreate(
                ['name' => $data['name']],
                ['category' => $data['category']]
            );
        }
    }
}
