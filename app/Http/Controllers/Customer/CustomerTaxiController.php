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

}

