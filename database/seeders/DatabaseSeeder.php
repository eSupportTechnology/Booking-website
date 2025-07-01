<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\PropertyCategoriesTableSeeder;
use Database\Seeders\PropertySubcategoriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PropertyCategoriesTableSeeder::class,
            PropertySubcategoriesTableSeeder::class,
        ]);

        // Create a test user
        // $user = User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // // Assign 'customer' role to the user
        // $user->assignRole('customer');
    }
}
