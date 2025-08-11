<?php

namespace App\Services\Partner;

use App\DTOs\Partner\PropertyListingsDTO;
use App\Models\Property;
use App\Models\PropertyCategory;
use Illuminate\Support\Facades\Auth;

class PropertyListingService
{
    public function getPropertyCounts(): PropertyListingsDTO
    {
        $partnerId = Auth::id();
        
        $apartmentCategory = PropertyCategory::where('name', 'Apartment')->first();
        $homeCategory = PropertyCategory::where('name', 'Home')->first();
        $hotelCategory = PropertyCategory::where('name', 'Hotel')->first();
        $alternativeCategory = PropertyCategory::where('name', 'Alternative Place')->first();
        
        return PropertyListingsDTO::fromArray([
            'apartments' => Property::where('user_id', $partnerId)
                ->where('category_id', $apartmentCategory?->id)
                ->count(),
            'homes' => Property::where('user_id', $partnerId)
                ->where('category_id', $homeCategory?->id)
                ->count(),
            'hotels' => Property::where('user_id', $partnerId)
                ->where('category_id', $hotelCategory?->id)
                ->count(),
            'alternative_places' => Property::where('user_id', $partnerId)
                ->where('category_id', $alternativeCategory?->id)
                ->count()
        ]);
    }

    public function getApartments(?string $search = null): array
    {
        $partnerId = Auth::id();
        $apartmentCategory = PropertyCategory::where('name', 'Apartment')->first();
        
        $query = Property::where('user_id', $partnerId)
            ->where('category_id', $apartmentCategory?->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        return $query->get()->toArray();
    }

    public function getHomes(?string $search = null): array
    {
        $partnerId = Auth::id();
        $homeCategory = PropertyCategory::where('name', 'Home')->first();
        
        $query = Property::where('user_id', $partnerId)
            ->where('category_id', $homeCategory?->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        return $query->get()->toArray();
    }

    public function getHotels(?string $search = null): array
    {
        $partnerId = Auth::id();
        $hotelCategory = PropertyCategory::where('name', 'Hotel')->first();
        
        $query = Property::where('user_id', $partnerId)
            ->where('category_id', $hotelCategory?->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        return $query->get()->toArray();
    }

    public function getAlternativePlaces(?string $search = null): array
    {
        $partnerId = Auth::id();
        $alternativeCategory = PropertyCategory::where('name', 'Alternative Place')->first();
        
        $query = Property::where('user_id', $partnerId)
            ->where('category_id', $alternativeCategory?->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        return $query->get()->toArray();
    }
}