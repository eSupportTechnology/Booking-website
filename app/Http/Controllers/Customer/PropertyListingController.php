<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Car;
use Illuminate\Http\Request;

class PropertyListingController extends Controller
{
    public function hotelListing(Request $request)
    {
        $category = PropertyCategory::where('name', 'Hotel, B&Bs, and more')->first();
        
        $properties = Property::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['photos', 'reviews', 'category', 'pricing'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(12);

        return view('Customer.hotel-listing', compact('properties'));
    }

    public function apartmentListing(Request $request)
    {
        $category = PropertyCategory::where('name', 'Apartment')->first();
        
        $properties = Property::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['photos', 'reviews', 'category', 'pricing'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(12);

        return view('Customer.apartment-listing', compact('properties'));
    }

    public function homeListing(Request $request)
    {
        $category = PropertyCategory::where('name', 'Homes')->first();
        
        $properties = Property::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['photos', 'reviews', 'category', 'pricing'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(12);

        return view('Customer.home-listing', compact('properties'));
    }

    public function carRentalListing(Request $request)
    {
        $cars = Car::with(['carType', 'company', 'model', 'renter', 'files'])
            ->paginate(12);

        return view('Customer.car-rental-listing', compact('cars'));
    }

    public function alternativePlacesListing(Request $request)
    {
        $category = PropertyCategory::where('name', 'Alternative places')->first();
        
        $properties = Property::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['photos', 'reviews', 'category', 'pricing'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(12);

        return view('Customer.alternative-places-listing', compact('properties'));
    }

    public function singleHotel($id)
    {
        $property = Property::with([
            'files', 
            'reviews.user', 
            'hostReviews',
            'category',
            'amenities',
            'languages',
            'bedrooms',
            'additionalDetails',
            'pricing',
            'services',
            'policies',
            'hostProfile',
            'availabilitySettings',
            'facilities',
            'photos',
            'rooms'
        ])
        ->findOrFail($id);

        // Pre-calculate review data to avoid queries in view
        $guestReviews = $property->reviews;
        $hostReviews = $property->hostReviews;
        
        $guestAvgRating = $guestReviews->count() > 0 ? round($guestReviews->avg('rating'), 1) : 0;
        $hostAvgRating = $hostReviews->count() > 0 ? round($hostReviews->avg('rating'), 1) : 0;
        
        $overallRating = ($guestAvgRating > 0 || $hostAvgRating > 0) ? 
            (($guestAvgRating + $hostAvgRating) / 2) : 0;
        $overallRating = round($overallRating, 1);
        
        $ratingText = 'Average';
        if ($overallRating >= 9.0) {
            $ratingText = 'Exceptional';
        } elseif ($overallRating >= 8.0) {
            $ratingText = 'Superb';
        } elseif ($overallRating >= 7.0) {
            $ratingText = 'Very Good';
        } elseif ($overallRating >= 6.0) {
            $ratingText = 'Good';
        }
        
        $totalReviews = $guestReviews->count() + $hostReviews->count();
        
        // Mock rating data for categories (these should come from actual review data)
        $staffRating = $hostAvgRating ?: 8.5;
        $facilitiesRating = 8.2;
        $cleanlinessRating = 8.8;
        $comfortRating = 8.6;
        $valueRating = 8.0;
        $locationRating = 8.4;
        $wifiRating = 8.7;

        return view('Customer.single-hotel', compact(
            'property', 
            'guestReviews', 
            'hostReviews', 
            'guestAvgRating', 
            'hostAvgRating', 
            'overallRating', 
            'ratingText', 
            'totalReviews',
            'staffRating',
            'facilitiesRating', 
            'cleanlinessRating',
            'comfortRating',
            'valueRating',
            'locationRating',
            'wifiRating'
        ));
    }
}