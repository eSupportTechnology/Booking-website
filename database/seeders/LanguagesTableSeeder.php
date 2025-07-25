<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Languages;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            ['name' => 'English',],
            ['name' => 'French', ],
            ['name' => 'German',],
            ['name' => 'Hindi', ],
            
            ['name' => 'Arabic', ],
            ['name' => 'Bulgarian', ],
            ['name' => 'Catalan', ],
            ['name' => 'Chinese', ],
            ['name' => 'Croatian', ],
            ['name' => 'Czech', ],
            ['name' => 'Danish',],
            ['name' => 'Dutch', ],
        ];

        foreach ($amenities as $data) {
            Languages::updateOrCreate(
                ['name' => $data['name']],
            );
        }
    }
}
