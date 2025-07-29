<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySubtypeSeeder extends Seeder
{
    public function run(): void
    {
        $subtypes = [
            ['subcategory_id' => 1, 'name' => 'Villa'],
            ['subcategory_id' => 1, 'name' => 'Chalet'],
            ['subcategory_id' => 1, 'name' => 'Apartment'],
            ['subcategory_id' => 1, 'name' => 'Holiday Home'],
            ['subcategory_id' => 1, 'name' => 'Apart Hotel'],
            ['subcategory_id' => 1, 'name' => 'Holiday Park'],
            ['subcategory_id' => 2, 'name' => 'Guest house'],
            ['subcategory_id' => 2, 'name' => 'Bed and breakfast'],
            ['subcategory_id' => 2, 'name' => 'Homestay'],
            ['subcategory_id' => 2, 'name' => 'Country house '],
            ['subcategory_id' => 2, 'name' => 'Apart Hotel'],
            ['subcategory_id' => 2, 'name' => 'Farm stay'],
        ];

        foreach ($subtypes as $subtype) {
            DB::table('property_subtypes')->updateOrInsert(
                [
                    'subcategory_id' => $subtype['subcategory_id'],
                    'name' => $subtype['name'],
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
