<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PropertySubcategory;
use App\Models\PropertySubtype;
use App\Models\Language;
use App\Models\PropertyCategory;

class PropertyEnhancedDataSeeder extends Seeder
{
    public function run()
    {
        // Create languages
        $languages = [
            ['name' => 'English', 'code' => 'en'],
            ['name' => 'Spanish', 'code' => 'es'],
            ['name' => 'French', 'code' => 'fr'],
            ['name' => 'German', 'code' => 'de'],
            ['name' => 'Italian', 'code' => 'it'],
            ['name' => 'Portuguese', 'code' => 'pt'],
            ['name' => 'Chinese', 'code' => 'zh'],
            ['name' => 'Japanese', 'code' => 'ja'],
            ['name' => 'Arabic', 'code' => 'ar'],
            ['name' => 'Russian', 'code' => 'ru']
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(['code' => $language['code']], $language);
        }

        // Get or create categories
        $apartmentCategory = PropertyCategory::firstOrCreate(['name' => 'Apartment']);
        $hotelCategory = PropertyCategory::firstOrCreate(['name' => 'Hotel']);
        $homeCategory = PropertyCategory::firstOrCreate(['name' => 'Home']);

        // Create subcategories for Apartments
        $apartmentSubcategories = [
            ['name' => 'Studio Apartment', 'category_id' => $apartmentCategory->id],
            ['name' => '1 Bedroom Apartment', 'category_id' => $apartmentCategory->id],
            ['name' => '2 Bedroom Apartment', 'category_id' => $apartmentCategory->id],
            ['name' => '3+ Bedroom Apartment', 'category_id' => $apartmentCategory->id],
            ['name' => 'Penthouse', 'category_id' => $apartmentCategory->id],
            ['name' => 'Loft', 'category_id' => $apartmentCategory->id]
        ];

        foreach ($apartmentSubcategories as $subcategory) {
            PropertySubcategory::firstOrCreate(
                ['name' => $subcategory['name'], 'category_id' => $subcategory['category_id']]
            );
        }

        // Create subcategories for Hotels
        $hotelSubcategories = [
            ['name' => 'Boutique Hotel', 'category_id' => $hotelCategory->id],
            ['name' => 'Business Hotel', 'category_id' => $hotelCategory->id],
            ['name' => 'Resort Hotel', 'category_id' => $hotelCategory->id],
            ['name' => 'Budget Hotel', 'category_id' => $hotelCategory->id],
            ['name' => 'Luxury Hotel', 'category_id' => $hotelCategory->id]
        ];

        foreach ($hotelSubcategories as $subcategory) {
            PropertySubcategory::firstOrCreate(
                ['name' => $subcategory['name'], 'category_id' => $subcategory['category_id']]
            );
        }

        // Create subcategories for Homes
        $homeSubcategories = [
            ['name' => 'Entire House', 'category_id' => $homeCategory->id],
            ['name' => 'Villa', 'category_id' => $homeCategory->id],
            ['name' => 'Cottage', 'category_id' => $homeCategory->id],
            ['name' => 'Townhouse', 'category_id' => $homeCategory->id],
            ['name' => 'Cabin', 'category_id' => $homeCategory->id]
        ];

        foreach ($homeSubcategories as $subcategory) {
            PropertySubcategory::firstOrCreate(
                ['name' => $subcategory['name'], 'category_id' => $subcategory['category_id']]
            );
        }

        // Create subtypes for some subcategories
        $studioSubcategory = PropertySubcategory::where('name', 'Studio Apartment')->first();
        if ($studioSubcategory) {
            $studioSubtypes = [
                ['name' => 'Modern Studio', 'subcategory_id' => $studioSubcategory->id],
                ['name' => 'Classic Studio', 'subcategory_id' => $studioSubcategory->id],
                ['name' => 'Luxury Studio', 'subcategory_id' => $studioSubcategory->id]
            ];

            foreach ($studioSubtypes as $subtype) {
                PropertySubtype::firstOrCreate(
                    ['name' => $subtype['name'], 'subcategory_id' => $subtype['subcategory_id']]
                );
            }
        }

        $villaSubcategory = PropertySubcategory::where('name', 'Villa')->first();
        if ($villaSubcategory) {
            $villaSubtypes = [
                ['name' => 'Beach Villa', 'subcategory_id' => $villaSubcategory->id],
                ['name' => 'Mountain Villa', 'subcategory_id' => $villaSubcategory->id],
                ['name' => 'City Villa', 'subcategory_id' => $villaSubcategory->id],
                ['name' => 'Private Pool Villa', 'subcategory_id' => $villaSubcategory->id]
            ];

            foreach ($villaSubtypes as $subtype) {
                PropertySubtype::firstOrCreate(
                    ['name' => $subtype['name'], 'subcategory_id' => $subtype['subcategory_id']]
                );
            }
        }
    }
}