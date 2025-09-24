<?php

namespace App\Http\Controllers\Customer;



use App\Http\Controllers\Controller;
use App\Models\Taxi;

class CustomerTaxiController extends Controller
{
   public function index()
{
    // Paginate only active taxis
    $activeTaxis = Taxi::where('status', 'Active')
        ->with('type', 'drivers', 'fare')
        ->paginate(8); // show 8 taxis per page

    return view('customer.airport-taxi-listing', compact('activeTaxis'));
}

public function showLatestTaxis(){
    // Get latest 10 active taxis
    $latestActiveTaxis = Taxi::where('status', 'Active')
        ->with('type', 'drivers', 'fare')
        ->latest() // order by created_at descending
        ->take(10) // limit to 10 taxis
        ->get();

    return view('frontend.airport-taxi', compact('latestActiveTaxis'));
}

public function show($id)
{
    // Find taxi by id (only active ones)
    $taxi = Taxi::where('status', 'Active')
        ->with('type', 'drivers', 'fare')
        ->findOrFail($id);

    return view('Customer.single-airport-taxi', compact('taxi'));
}

}

