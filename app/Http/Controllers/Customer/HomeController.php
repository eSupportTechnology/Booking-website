<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache data for 30 minutes to improve performance
        $cacheMinutes = 30;

        // 1. Trending Cities with property counts and images
        $trendingCities = Cache::remember('home_trending_cities', $cacheMinutes * 60, function () {
            return DB::table('properties')
                ->select('city', DB::raw('COUNT(*) as property_count'))
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->where('status', 'active')
                ->groupBy('city')
                ->orderByDesc('property_count')
                ->limit(5)
                ->get()
                ->map(function ($city) {
                    // Get a property image from this city
                    $photo = DB::table('properties')
                        ->join('property_photos', 'properties.id', '=', 'property_photos.property_id')
                        ->where('properties.city', $city->city)
                        ->where('properties.status', 'active')
                        ->select('property_photos.path')
                        ->first();

                    return [
                        'city' => $city->city,
                        'property_count' => $city->property_count,
                        'image' => $photo ? asset('storage/' . $photo->path) : asset('images/default-city.jpg'),
                    ];
                });
        });

        // 2. Destinations by category (City, Beach, etc.) with property counts
        $destinations = Cache::remember('home_destinations', $cacheMinutes * 60, function () {
            return DB::table('properties')
                ->select('city', DB::raw('COUNT(*) as property_count'))
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->where('status', 'active')
                ->groupBy('city')
                ->orderByDesc('property_count')
                ->limit(8)
                ->get()
                ->map(function ($city) {
                    $photo = DB::table('properties')
                        ->join('property_photos', 'properties.id', '=', 'property_photos.property_id')
                        ->where('properties.city', $city->city)
                        ->where('properties.status', 'active')
                        ->select('property_photos.path')
                        ->first();

                    return [
                        'name' => $city->city,
                        'properties' => number_format($city->property_count),
                        'image' => $photo ? asset('storage/' . $photo->path) : asset('images/default-city.jpg'),
                    ];
                });
        });

        // 3. Featured Properties (Top unique properties)
        $featuredProperties = Cache::remember('home_featured_properties', $cacheMinutes * 60, function () {
            return Property::with(['photos', 'rooms'])
                ->where('status', 'active')
                ->whereHas('photos')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(function ($property) {
                    $avgRating = Review::where('property_id', $property->id)->avg('rating') ?? 0;
                    $reviewCount = Review::where('property_id', $property->id)->count();
                    $minPrice = $property->rooms->min('price') ?? $property->adult_price ?? 0;

                    return [
                        'id' => $property->id,
                        'title' => $property->title,
                        'city' => $property->city,
                        'country' => $property->country ?? 'Sri Lanka',
                        'image' => $property->photos->first() ? asset('storage/' . $property->photos->first()->path) : asset('images/default-property.jpg'),
                        'rating' => round($avgRating, 1),
                        'rating_text' => $this->getRatingText($avgRating),
                        'review_count' => $reviewCount,
                        'price' => $minPrice,
                        'currency' => $property->currency ?? 'LKR',
                    ];
                });
        });

        // 4. Homes (Holiday Homes - category based)
        $homes = Cache::remember('home_holiday_homes', $cacheMinutes * 60, function () {
            return Property::with(['photos', 'rooms'])
                ->where('status', 'active')
                ->whereHas('photos')
                ->whereHas('category', function ($q) {
                    $q->whereIn('name', ['Home', 'Homes', 'Holiday Home', 'Villa', 'Apartment']);
                })
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(function ($property) {
                    $avgRating = Review::where('property_id', $property->id)->avg('rating') ?? 0;
                    $reviewCount = Review::where('property_id', $property->id)->count();
                    $minPrice = $property->rooms->min('price') ?? $property->adult_price ?? 0;

                    return [
                        'id' => $property->id,
                        'title' => $property->title,
                        'city' => $property->city,
                        'country' => $property->country ?? 'Sri Lanka',
                        'image' => $property->photos->first() ? asset('storage/' . $property->photos->first()->path) : asset('images/default-property.jpg'),
                        'rating' => round($avgRating, 1),
                        'rating_text' => $this->getRatingText($avgRating),
                        'review_count' => $reviewCount,
                        'price' => $minPrice,
                        'currency' => $property->currency ?? 'LKR',
                    ];
                });
        });

        // 5. Property Types with counts
        $propertyTypes = Cache::remember('home_property_types', $cacheMinutes * 60, function () {
            return PropertyCategory::withCount(['properties' => function ($q) {
                    $q->where('status', 'active');
                }])
                ->orderByDesc('properties_count')
                ->limit(4)
                ->get()
                ->map(function ($category) {
                    return [
                        'name' => $category->name,
                        'count' => $category->properties_count,
                        'image' => $category->image ? asset('storage/' . $category->image) : asset('images/' . strtolower($category->name) . '.jpg'),
                        'route' => $this->getCategoryRoute($category->name),
                    ];
                });
        });

        // 6. All cities for "Popular with travelers" section
        $cities = Cache::remember('home_all_cities', $cacheMinutes * 60, function () {
            return DB::table('properties')
                ->select('city', DB::raw('COUNT(*) as property_count'))
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->where('status', 'active')
                ->groupBy('city')
                ->orderByDesc('property_count')
                ->limit(20)
                ->get()
                ->map(function ($city) {
                    return [
                        'city' => $city->city,
                        'count' => $city->property_count,
                    ];
                });
        });

        return view('Customer.home', compact(
            'trendingCities',
            'destinations',
            'featuredProperties',
            'homes',
            'propertyTypes',
            'cities'
        ));
    }

    private function getRatingText($rating): string
    {
        if ($rating >= 9) return 'Exceptional';
        if ($rating >= 8) return 'Excellent';
        if ($rating >= 7) return 'Very Good';
        if ($rating >= 6) return 'Good';
        if ($rating >= 5) return 'Pleasant';
        return 'Review score';
    }

    private function getCategoryRoute($categoryName): string
    {
        $routes = [
            'Hotel' => 'hotel-listing',
            'Hotels' => 'hotel-listing',
            'Apartment' => 'apartment-listing',
            'Apartments' => 'apartment-listing',
            'Home' => 'home-listing',
            'Homes' => 'home-listing',
            'Villa' => 'alternative-places-listing',
            'Villas' => 'alternative-places-listing',
        ];

        return $routes[$categoryName] ?? 'hotel-listing';
    }

    // Legacy method - keeping for backwards compatibility
    public function popularCities()
    {
        return $this->index();
    }
}
