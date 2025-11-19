<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    public function run()
    {
        $amenities = [
            // Basic amenities
            ['name' => 'WiFi', 'category' => 'basic'],
            ['name' => 'Air conditioning', 'category' => 'basic'],
            ['name' => 'Heating', 'category' => 'basic'],
            ['name' => 'Kitchen', 'category' => 'basic'],
            ['name' => 'Washing machine', 'category' => 'basic'],
            ['name' => 'TV', 'category' => 'basic'],
            ['name' => 'Parking', 'category' => 'basic'],
            
            // Safety amenities
            ['name' => 'Smoke detector', 'category' => 'safety'],
            ['name' => 'Carbon monoxide detector', 'category' => 'safety'],
            ['name' => 'Fire extinguisher', 'category' => 'safety'],
            ['name' => 'First aid kit', 'category' => 'safety'],
            
            // Entertainment
            ['name' => 'Pool', 'category' => 'entertainment'],
            ['name' => 'Hot tub', 'category' => 'entertainment'],
            ['name' => 'Gym', 'category' => 'entertainment'],
            ['name' => 'Game room', 'category' => 'entertainment'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(['name' => $amenity['name']], $amenity);
        }
    }
}