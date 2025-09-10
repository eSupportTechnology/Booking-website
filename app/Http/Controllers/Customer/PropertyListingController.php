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
            ->with(['photos', 'reviews', 'category'])
            ->paginate(12);

        return view('Customer.hotel-listing', compact('properties'));
    }

    public function apartmentListing(Request $request)
    {
        $category = PropertyCategory::where('name', 'Apartment')->first();
        
        $properties = Property::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['photos', 'reviews', 'category'])
            ->paginate(12);

        return view('Customer.apartment-listing', compact('properties'));
    }

    public function homeListing(Request $request)
    {
        $category = PropertyCategory::where('name', 'Homes')->first();
        
        $properties = Property::where('category_id', $category->id)
            ->where('status', 'active')
            ->with(['photos', 'reviews', 'category'])
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
            ->with(['photos', 'reviews', 'category'])
            ->paginate(12);

        return view('Customer.alternative-places-listing', compact('properties'));
    }
}