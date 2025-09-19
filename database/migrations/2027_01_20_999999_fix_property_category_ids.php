<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Fix property category IDs to ensure correct mapping
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear and reset property categories with correct IDs
        DB::table('property_categories')->truncate();
        
        $categories = [
            ['id' => 1, 'name' => 'Homes'],
            ['id' => 2, 'name' => 'Apartment'],
            ['id' => 3, 'name' => 'Hotel, B&Bs, and more'],
            ['id' => 4, 'name' => 'Alternative places'],
        ];
        
        foreach ($categories as $category) {
            DB::table('property_categories')->insert([
                'id' => $category['id'],
                'name' => $category['name'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        // Revert if needed
    }
};