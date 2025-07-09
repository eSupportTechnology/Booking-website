<?php

namespace App\Actions\Partner;

use App\DTOs\Partner\PropertyDTO;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\PropertySubcategory;
use App\Models\PropertySubtype;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\DTOs\Partner\PropertyStep1DTO;
use App\DTOs\Partner\PropertyStep2DTO;
use Illuminate\Support\Facades\Log;

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
                'desc' => $subtype->description,
            ];
        });
    }

    public function createPropertyStep1(PropertyStep1DTO $dto)
    {
        return \App\Models\Property::create($dto->toArray());
    }

    public function updatePropertyStep2(Property $property, PropertyStep2DTO $dto)
    {
        Log::info("DTO ;", [$dto]);
        $property->update(array_filter([
            'title' => $dto->title,
            'address' => $dto->address,
            'city' => $dto->city,
            'country' => $dto->country,
            'zipcode' => $dto->zipcode,
            'description' => $dto->description,
            'subtype_id' => $dto->subtype_id,
        ], fn($value) => !is_null($value)));

        return $property;
    }
}
