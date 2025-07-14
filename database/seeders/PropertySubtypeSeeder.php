<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySubtypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('property_subtypes')->insert([
            ['subcategory_id' => 1, 'name' => ' Villa', 'created_at' => now(), 'updated_at' => now()],
            ['subcategory_id' => 1, 'name' => 'Chalet', 'created_at' => now(), 'updated_at' => now()],            
            ['subcategory_id' => 1, 'name' => 'Apartment', 'created_at' => now(), 'updated_at' => now()],            
            ['subcategory_id' => 1, 'name' => 'Holiday Home', 'created_at' => now(), 'updated_at' => now()],            
            ['subcategory_id' => 1, 'name' => 'Apart Hotel', 'created_at' => now(), 'updated_at' => now()],            
            ['subcategory_id' => 1, 'name' => 'Holiday Park', 'created_at' => now(), 'updated_at' => now()],            

        ]);
    }
}
