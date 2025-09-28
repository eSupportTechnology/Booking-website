<?php

namespace App\Http\Controllers\Customer;
use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerCarRentalController extends Controller
{
     public function index()
{
    // Paginate only active cars
    $activeCars = Car::where('status', 'Active')
        ->with('carType', 'company', 'brand','model')
        ->paginate(8); // show 8 cars per page

    return view('Customer.car-rentals-listing', compact('activeCars'));
}

public function showLatestCars(){
    // Get latest 10 active cars
    $latestActiveCars = Car::where('status', 'Active')
        ->with('carType', 'company', 'brand','model')
        ->latest() // order by created_at descending
        ->take(10) // limit to 10 cars
        ->get();

    return view('frontend.car-rentals', compact('latestActiveCars'));
}



}
