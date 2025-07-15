<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySubtypeSeeder extends Seeder
{
    public function run(): void
    {
        $subtypes = [
            ['subcategory_id' => 3, 'name' => 'Villa'],
            ['subcategory_id' => 3, 'name' => 'Chalet'],
            ['subcategory_id' => 3, 'name' => 'Apartment'],
            ['subcategory_id' => 3, 'name' => 'Holiday Home'],
            ['subcategory_id' => 3, 'name' => 'Apart Hotel'],
            ['subcategory_id' => 3, 'name' => 'Holiday Park'],
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
