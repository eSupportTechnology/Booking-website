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

        return view('car_rentals.renter-types', compact('carRenter'));
    }
    
    public function myCars()
    {
        $user = Auth::guard('car_renter')->user();

        // fetch only cars that belong to this car renter
        $cars = Car::with(['carType', 'company', 'model'])
            ->where('car_renter_id', $user->id)
            ->get();

        return view('car_rentals.my_car_rentals', compact('cars'));
    }

    public function show($id)
    {
        $user = Auth::guard('car_renter')->user();

        // Fetch the car that belongs to this car renter
        $car = Car::with(['carType', 'company', 'model'])
            ->where('car_renter_id', $user->id)
            ->findOrFail($id);

        return view('car_rentals.show_car', compact('car'));
    }

    public function destroy($id)
{
    $user = Auth::guard('car_renter')->user();

    // Find car that belongs to this renter
    $car = Car::where('car_renter_id', $user->id)->findOrFail($id);

    // Delete the car
    $car->delete();

    // Redirect back with success message
    return redirect()->route('car_rentals-listing')->with('success', 'Car deleted successfully.');
}

}

