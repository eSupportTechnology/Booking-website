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
}
