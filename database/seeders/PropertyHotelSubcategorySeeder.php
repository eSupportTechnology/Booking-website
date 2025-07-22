<?php

namespace Database\Seeders;

use App\Models\PropertySubcategory;
use Illuminate\Database\Seeder;

class PropertyHotelSubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            ['category_id' => 3, 'name' => 'Hotel'],
            ['category_id' => 3, 'name' => 'Guest house'],
            ['category_id' => 3, 'name' => 'Bed and breakfast'],
            ['category_id' => 3, 'name' => 'Homestay'],
            ['category_id' => 3, 'name' => 'Hostel'],
            ['category_id' => 3, 'name' => 'Aparthotel'],
            ['category_id' => 3, 'name' => 'Capsule hotel'],
            ['category_id' => 3, 'name' => 'Country house'],
            ['category_id' => 3, 'name' => 'Farm stay'],
            ['category_id' => 3, 'name' => 'Inn'],
            ['category_id' => 3, 'name' => 'Love hotel'],
            ['category_id' => 3, 'name' => 'Motel'],
            ['category_id' => 3, 'name' => 'Resort'],
            ['category_id' => 3, 'name' => 'Riad'],
            ['category_id' => 3, 'name' => 'Ryokan'],
            ['category_id' => 3, 'name' => 'Lodge'],
        ];

        foreach ($records as $record) {
            PropertySubcategory::updateOrCreate(
                [
                    'category_id' => $record['category_id'],
                    'name' => $record['name'],
                ],
                [
                    'updated_at' => now(),
                ]
            );
        }
    }
}
