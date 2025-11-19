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
        $homeCategory = PropertyCategory::where('name', 'Homes')->first();
        $hotelCategory = PropertyCategory::where('name', 'Hotel, B&Bs, and more')->first();
        $alternativeCategory = PropertyCategory::where('name', 'Alternative places')->first();
        
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

    public function getApartments(?string $search = null, ?string $status = null): array
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
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $properties = $query->with('files')->get();
        
        return $properties->map(function($property) {
            $propertyArray = $property->toArray();
            $propertyArray['image'] = $property->files->first()?->path ?? null;
            $propertyArray['adult_price_usd'] = app(\App\Services\CurrencyService::class)->convert($property->adult_price ?? 0, $property->currency ?? 'LKR', 'USD');
            $propertyArray['child_price_usd'] = app(\App\Services\CurrencyService::class)->convert($property->child_price ?? 0, $property->currency ?? 'LKR', 'USD');
            return $propertyArray;
        })->toArray();
    }

    public function getHomes(?string $search = null, ?string $status = null): array
    {
        $partnerId = Auth::id();
        $homeCategory = PropertyCategory::where('name', 'Homes')->first();
        
        $query = Property::where('user_id', $partnerId)
            ->where('category_id', $homeCategory?->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $properties = $query->with('files')->get();
        
        return $properties->map(function($property) {
            $propertyArray = $property->toArray();
            $propertyArray['image'] = $property->files->first()?->path ?? null;
            $propertyArray['adult_price_usd'] = app(\App\Services\CurrencyService::class)->convert($property->adult_price ?? 0, $property->currency ?? 'LKR', 'USD');
            $propertyArray['child_price_usd'] = app(\App\Services\CurrencyService::class)->convert($property->child_price ?? 0, $property->currency ?? 'LKR', 'USD');
            return $propertyArray;
        })->toArray();
    }

    public function getHotels(?string $search = null, ?string $status = null): array
    {
        $partnerId = Auth::id();
        $hotelCategory = PropertyCategory::where('name', 'Hotel, B&Bs, and more')->first();
        
        $query = Property::where('user_id', $partnerId)
            ->where('category_id', $hotelCategory?->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $properties = $query->with(['files', 'rooms'])->get();
        
        return $properties->map(function($property) {
            $propertyArray = $property->toArray();
            $propertyArray['image'] = $property->files->first()?->path ?? null;
            $currencyService = app(\App\Services\CurrencyService::class);
            $roomCurrency = $property->rooms->first()?->currency ?? $property->currency ?? 'LKR';
            $propertyArray['min_price_usd'] = $currencyService->convert($property->rooms->min('price_per_night') ?? 0, $roomCurrency, 'USD');
            $propertyArray['max_price_usd'] = $currencyService->convert($property->rooms->max('price_per_night') ?? 0, $roomCurrency, 'USD');
            return $propertyArray;
        })->toArray();
    }

    public function getAlternativePlaces(?string $search = null, ?string $status = null): array
    {
        $partnerId = Auth::id();
        $alternativeCategory = PropertyCategory::where('name', 'Alternative places')->first();
        
        $query = Property::where('user_id', $partnerId)
            ->where('category_id', $alternativeCategory?->id);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $properties = $query->with('files')->get();
        
        return $properties->map(function($property) {
            $propertyArray = $property->toArray();
            $propertyArray['image'] = $property->files->first()?->path ?? null;
            $propertyArray['adult_price_usd'] = app(\App\Services\CurrencyService::class)->convert($property->adult_price ?? 0, $property->currency ?? 'LKR', 'USD');
            $propertyArray['child_price_usd'] = app(\App\Services\CurrencyService::class)->convert($property->child_price ?? 0, $property->currency ?? 'LKR', 'USD');
            return $propertyArray;
        })->toArray();
    }
}