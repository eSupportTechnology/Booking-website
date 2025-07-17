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
            ['name' => 'Private bathroom',],
            ['name' => 'Sea views', ],
            ['name' => 'Family rooms',],
            ['name' => 'Airport shuttle', ],
            ['name' => 'Spa and wellness center', ],

            ['name' => 'Air conditioning', ],
            ['name' => 'Heating', ],
            ['name' => 'Free WiFi', ],
            ['name' => 'Electric vehicle charging station', ],

            ['name' => 'Kitchen', ],
            ['name' => 'Microwave',],
            ['name' => 'Washing machine', ],

            ['name' => 'Flat-screen TV', ],
            ['name' => 'Swimming Pool',],
            ['name' => 'Hot tub', ],
            ['name' => 'Minibar', ],
            ['name' => 'Sauna', ],

            ['name' => 'Balcony',],
            ['name' => 'Garden view', ],
            ['name' => 'Terrace', ],
            ['name' => 'View',],
        ];

        foreach ($amenities as $data) {
            Amenity::updateOrCreate(
                ['name' => $data['name']],
            );
        }
    }
}
