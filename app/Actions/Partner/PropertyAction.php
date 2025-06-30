<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\PropertyDTO;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertySubcategory;
use App\Models\PropertySubtype;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PropertyAction
{

    public function registerProperty(PropertyDTO $property): Property
    {
        return Property::create($property->toArray());
    }

    public function execute(): Collection
    {
        return PropertyCategory::all()->select('name');
    }
    public function getPropertiesByCategory(int $categoryId): Collection
    {
        return PropertySubcategory::where('category_id', $categoryId)->get();
    }

    public function getPropertiesBySubcategory(int $subcategoryId): Collection
    {
        return PropertySubtype::where('subcategory_id', $subcategoryId)->get()->map(function ($subtype) {
            return [
                'id' => $subtype->id,
                'title' => $subtype->name,
                'description' => $subtype->description,
            ];
        });
    }


}
