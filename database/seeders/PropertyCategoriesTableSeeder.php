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
            'Homes',           // ID 1
            'Apartment',       // ID 2  
            'Hotel, B&Bs, and more',  // ID 3
            'Alternative places',     // ID 4
        ];

       // Clear existing categories to ensure correct IDs
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('property_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        foreach ($categories as $index => $category) {
            DB::table('property_categories')->insert([
                'id' => $index + 1,
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
