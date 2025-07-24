<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Apartment',
            'Homes',
            'Hotel, B&Bs, and more',
            'Alternative places',
        ];

        foreach ($categories as $category) {
            DB::table('property_categories')->updateOrInsert(
                ['name' => $category],
                ['name' => $category] // or add more fields like 'updated_at' if needed
            );
        }
    }
}
