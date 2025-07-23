<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            'English',
            'French',
            'German',
            'Hindi',
            'Arabic',
            'Bulgarian',
            'Catalan',
            'Chinese',
            'Croatian',
            'Czech',
            'Danish',
            'Dutch',
            'Spanish',
            'Italian',
            'Portuguese',
            'Russian',
            'Japanese',
            'Korean',
            'Thai',
            'Vietnamese',
            'Turkish',
            'Greek',
            'Hebrew',
            'Polish',
            'Swedish',
            'Norwegian',
            'Finnish',
            'Hungarian',
            'Romanian',
            'Ukrainian',
            'Indonesian',
            'Malay',
            'Tagalog',
            'Swahili',
            'Urdu',
            'Bengali',
            'Tamil',
            'Telugu',
            'Marathi',
            'Gujarati',
            'Punjabi',
            'Kannada',
            'Malayalam',
            'Sinhala',
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(['name' => $language]);
        }
    }
}
