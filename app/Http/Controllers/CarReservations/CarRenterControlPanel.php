<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use App\Models\Company;
use App\Models\CarBrand;
use App\Models\CarModel;
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

public function edit(Car $car)
    {
        $car_types = CarType::all();
        $companies = Company::all();
        $car_brands = CarBrand::all();
        $car_models = CarModel::all();

        return view('car_rentals.car_edit', compact('car', 'car_types', 'companies', 'car_brands', 'car_models'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'car_type_id' => 'required',
            'company_id' => 'required',
            'brand' => 'required',
            'model_id' => 'required',
            'seats' => 'required|integer|min:2|max:20',
            'transmission' => 'required',
            'mileage_type' => 'required',
            'fuel_type' => 'required',
            'pricingType' => 'required',
        ]);

        $car->update($request->all());

        return redirect()->route('cars.edit', $car->id)
                         ->with('success', 'Car details updated successfully.');
    }
}

