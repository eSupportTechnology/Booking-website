<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            // Homes (category 1)
            ['category_id' => 1, 'name' => 'Entire Place'],
            ['category_id' => 1, 'name' => 'Private Room'],
            // Alternative places (category 4)
            ['category_id' => 4, 'name' => 'Boat'],
            ['category_id' => 4, 'name' => 'Campsite'],
            ['category_id' => 4, 'name' => 'Luxury Tent'],
            ['category_id' => 4, 'name' => 'Treehouse'],
        ];

        foreach ($subcategories as $subcategory) {
            DB::table('property_subcategories')->updateOrInsert(
                ['category_id' => $subcategory['category_id'], 'name' => $subcategory['name']],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
