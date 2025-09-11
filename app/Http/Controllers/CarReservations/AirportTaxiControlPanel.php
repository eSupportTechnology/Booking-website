<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Taxi; // ✅ Import Car model

class AirportTaxiControlPanel extends Controller
{
    public function index()
    {
        $carRenter = Auth::guard('car_renter')->user();

        return view('car_rentals.carrenters_control_panel', compact('carRenter'));
    }
    
    public function myTaxi()
    {
        $user = Auth::guard('car_renter')->user();

        

        // fetch only cars that belong to this car renter
        $taxi = Taxi::with(['type', 'drivers', 'fare'])
            ->where('car_renter_id', $user->id)
            ->get();

        return view('airport_taxis.taxis', compact('taxi'));
    }

    public function destroy($id)
{
    $user = Auth::guard('car_renter')->user();

    // Find taxi that belongs to this renter
    $taxi = Taxi::where('car_renter_id', $user->id)->findOrFail($id);

    // Delete the taxi
    $taxi->delete();

    // Redirect back with success message
    return redirect()->route('taxi.listing')->with('success', 'Taxi deleted successfully.');
}

public function show($id)
{
    $user = Auth::guard('car_renter')->user();

    // Fetch taxi that belongs to this renter
    $taxi = Taxi::with(['type', 'drivers', 'fare'])
        ->where('car_renter_id', $user->id)
        ->findOrFail($id);

    return view('airport_taxis.show_taxi', compact('taxi'));
}


}
