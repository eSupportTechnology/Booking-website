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
use App\DTOs\Partner\UploadPropertyPhotosDTO;
use App\Services\FileUploadService;
use App\DTOs\Partner\SaveAmenitiesDTO;
use App\DTOs\Partner\SavePolicyDTO;

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
    public function getAmenities(): Collection
    {
        return \App\Models\Amenity::all()->map(function ($amenity) {
            return [
                'id' => $amenity->id,
                'name' => $amenity->name,
            ];
        });
    }

    public function getRoomTypes(): Collection
    {
        return \App\Models\RoomType::all()->map(function ($roomType) {
            return [
                'id' => $roomType->id,
                'name' => $roomType->name,
            ];
        });
    }

    public function getBedTypes(): Collection
    {
        return \App\Models\BedType::all()->map(function ($bedType) {
            return [
                'id' => $bedType->id,
                'name' => $bedType->name,
            ];
        });
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
        Log::info('PropertyStep2DTO received:', (array) $dto);
        $property->update(array_filter([
            'title' => $dto->title,
            'address' => $dto->address,
            'apartment' => $dto->apartment,
            'city' => $dto->city,
            'country' => $dto->country,
            'zipcode' => $dto->zipcode,
            'description' => $dto->description,
            'subtype_id' => $dto->subtype_id,
            'address_type_id' => $dto->address_type_id,
            'channel_manager' => $dto->channel_manager,
        ], fn($value) => !is_null($value)));

        // Save bedrooms if provided
        Log::info('Bedrooms array in DTO:', ['bedrooms' => $dto->bedrooms]);
        if (!empty($dto->bedrooms)) {
            $property->bedrooms()->delete();
            foreach ($dto->bedrooms as $bedroom) {
                Log::info('Creating bedroom:', $bedroom);
                $property->bedrooms()->create($bedroom);
            }
        }

        $property->additionalDetails()->updateOrCreate(
            [],
            [
                'guests' => $dto->guests,
                'bathrooms' => $dto->bathrooms,
                'allow_children' => $dto->allow_children,
                'offer_cribs' => $dto->offer_cribs,
                'apartment_size' => $dto->apartment_size,
                'apartment_unit' => $dto->apartment_unit,
            ]
        );

        Log::info('Amenities array in DTO:', ['amenities' => $dto->amenities]);
        if (!empty($dto->amenities)) {
            $property->amenities()->sync($dto->amenities);
            Log::info('Amenities synced to property', ['property_id' => $property->id, 'amenity_ids' => $dto->amenities]);
        } else {
            Log::info('No amenities to sync for property', ['property_id' => $property->id]);
        }

        return $property;
    }

    public function updatePropertyPartial(Property $property, array $data, ?array $bedrooms = null)
    {
        $fields = [
            'title',
            'address',
            'apartment',
            'country',
            'city',
            'zipcode',
            'channel_manager',
            'description',
        ];
        $property->update(array_intersect_key($data, array_flip($fields)));

        // Handle bedrooms data
        if ($bedrooms !== null && is_array($bedrooms)) {
            Log::info('Processing bedrooms data:', ['bedrooms' => $bedrooms]);
            $property->bedrooms()->delete();
            foreach ($bedrooms as $bedroom) {
                Log::info('Creating bedroom:', $bedroom);
                $property->bedrooms()->create($bedroom);
            }
        }
        return $property->fresh();
    }

    public function getGroupedAmenities()
    {
        return \App\Models\Amenity::all()->groupBy('category');
    }

    public function syncAmenities(Property $property, array $amenityIds)
    {
        $property->amenities()->sync($amenityIds);
    }

    public function uploadPhotos(UploadPropertyPhotosDTO $dto, FileUploadService $fileUploadService): void
    {
        $property_type = Property::find($dto->property_id)?->subtype_id ?? 'Property';

        foreach ($dto->photos as $photo) {
            $fileUploadService->uploadAndSave(
                file: $photo,
                fileType: 'image',
                propertyType: PropertySubtype::find($property_type)?->name ?? 'Property',
                propertyId: $dto->property_id,
                directory: 'property_photos'
            );
        }
    }

    public function saveAmenities(Property $property, SaveAmenitiesDTO $dto): void
    {
        $property->amenities()->sync($dto->amenities);
    }


    public function savePolicy(Property $property, SavePolicyDTO $dto): void
    {
        $property->policies()->updateOrCreate(
            ['property_id' => $property->id],
            $dto->toArray()
        );
    }

}
