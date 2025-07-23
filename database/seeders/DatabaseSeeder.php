<?php

namespace Database\Seeders;

use App\Models\User;
use BedTypeSeeder;
use Database\Seeders\BedTypeSeeder as SeedersBedTypeSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\PropertyCategoriesTableSeeder;
use Database\Seeders\PropertySubcategoriesTableSeeder;
use Database\Seeders\RoomTypeSeeder as SeedersRoomTypeSeeder;
use Faker\Provider\ar_EG\Address;
use RoomTypeSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            PropertyCategoriesTableSeeder::class,
            // PropertySubcategoriesTableSeeder::class,
            PropertySubcategorySeeder::class,
            PropertyHotelSubcategorySeeder::class,
            PropertySubtypeSeeder::class,
            AddressTypesTableSeeder::class,
            AmenitiesTableSeeder::class,
            SeedersBedTypeSeeder::class,
            SeedersRoomTypeSeeder::class,
            LanguageSeeder::class,
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
