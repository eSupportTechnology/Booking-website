<?php

namespace App\Services\Partner;

use App\Models\Property;
use App\DTOs\Partner\HomeEditDTO;
use Illuminate\Support\Facades\Storage;

class HomeEditService
{
    public function updateBasicDetails(Property $property, HomeEditDTO $dto): Property
    {
        $property->update(array_filter([
            'title' => $dto->title,
            'description' => $dto->description,
            'address' => $dto->address,
            'city' => $dto->city,
            'country' => $dto->country,
            'zipcode' => $dto->zipcode,
            'category_id' => $dto->category_id,
        ]));

        return $property->fresh();
    }

    public function updateAmenities(Property $property, array $data): void
    {
        // Sync amenities
        if (isset($data['amenities'])) {
            $property->amenities()->sync($data['amenities']);
        }
        
        // Handle facilities
        if (isset($data['facilities'])) {
            $property->facilities()->delete();
            foreach ($data['facilities'] as $facility) {
                if (!empty($facility)) {
                    $property->facilities()->create(['facility_name' => $facility]);
                }
            }
        }
    }

    public function updatePhotos(Property $property, array $photos, ?string $mainPhoto = null): void
    {
        // Handle new photo uploads
        foreach ($photos as $photo) {
            $path = $photo->store('property_photos', 'public');
            $property->files()->create([
                'file_type' => 'image',
                'path' => $path,
                'property_type' => $property->category->name ?? 'Property',
                'property_id' => $property->id
            ]);
        }
    }

    public function deletePhoto(Property $property, int $photoId): void
    {
        $photo = $property->files()->where('file_type', 'image')->find($photoId);
        if ($photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }
    }

    public function updateServices(Property $property, array $services): void
    {
        $property->services()->updateOrCreate(
            ['property_id' => $property->id],
            $services
        );
    }

    public function updateLanguages(Property $property, array $languages): void
    {
        $property->languages()->sync($languages);
    }

    public function updateHouseRules(Property $property, array $rules): void
    {
        $property->policies()->updateOrCreate(
            ['property_id' => $property->id],
            $rules
        );
    }

    public function updateHostProfile(Property $property, array $profile): void
    {
        $property->hostProfile()->updateOrCreate(
            ['property_id' => $property->id],
            $profile
        );
    }

    public function updatePaymentSettings(Property $property, array $settings): void
    {
        $property->update([
            'payment_method' => $settings['payment_method'] ?? null,
            'invoicing_info' => json_encode($settings['invoicing'] ?? [])
        ]);
    }

    public function updateRooms(Property $property, array $data): void
    {
        // Update additional details (guests, bathrooms, etc.)
        $property->additionalDetails()->updateOrCreate(
            ['property_id' => $property->id],
            [
                'guests' => $data['guests'] ?? null,
                'bathrooms' => $data['bathrooms'] ?? null,
                'allow_children' => $data['allow_children'] ?? null,
                'offer_cribs' => $data['offer_cribs'] ?? null,
                'apartment_size' => $data['apartment_size'] ?? null,
                'apartment_unit' => $data['apartment_unit'] ?? null,
            ]
        );
    }

    public function updateVerification(Property $property, array $verification): void
    {
        $property->partnerVerification()->updateOrCreate(
            ['property_id' => $property->id],
            $verification
        );
    }
}