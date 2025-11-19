<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertyCategory;

class PropertyCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Apartment', 'description' => 'Furnished apartments for short-term stays'],
            ['name' => 'Homes', 'description' => 'Private homes and houses'],
            ['name' => 'Hotel, B&Bs, and more', 'description' => 'Hotels, bed & breakfasts, and similar accommodations'],
            ['name' => 'Alternative places', 'description' => 'Unique stays like treehouses, boats, and more']
        ];

        foreach ($categories as $category) {
            PropertyCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}