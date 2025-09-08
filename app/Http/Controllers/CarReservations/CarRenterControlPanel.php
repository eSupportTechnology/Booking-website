<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car; // ✅ Import Car model

class CarRenterControlPanel extends Controller
{
    public function index()
    {
        $carRenter = Auth::guard('car_renter')->user();

        return view('car_rentals.carrenters_control_panel', compact('carRenter'));
    }
    
    public function myCars()
    {
        $user = Auth::guard('car_renter')->user();

        // fetch only cars that belong to this car renter
        $cars = Car::with(['carType', 'company', 'model'])
            ->where('car_renter_id', $user->id)
            ->get();

        return view('car_rentals.car_rentals', compact('cars'));
    }
}
