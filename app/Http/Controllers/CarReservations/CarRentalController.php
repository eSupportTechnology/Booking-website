<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\Company;
use App\Models\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CarRentalController extends Controller
{
    public function index()
    {
        Log::info('Car Rental Index accessed');

        $car_types  = CarType::all();
        $car_models = CarModel::all();
        $car_brands = CarBrand::all();
        $companies  = Company::all();

        return view('car_rentals.carrentals-addcar', compact('car_types', 'car_models', 'car_brands', 'companies'));
    }

    public function registerStep(Request $request)
    {
        $user = Auth::guard('car_renter')->user(); // logged-in car renter
        $step = $request->input('step');
        $carData = $request->input('car');

        try {
            // Step 1: Basic car info + optional driver
       // Step 1: Basic car info + optional driver
if ($step == 1) {
    $validated = $request->validate([
        'car.car_type_id' => 'required|integer|exists:car_types,id',
        'car.company_id'  => 'required|integer|exists:companies,id',
        'car.brand'       => 'required|integer|exists:car_brands,id',
        'car.model_id'    => 'required|integer|exists:car_models,id',
        'car.seats'       => 'required|integer|min:2|max:20',
        'car.with_driver' => 'required|in:yes,no',
        'car.driver_name'       => 'nullable|required_if:car.with_driver,yes|string|max:255',
        'car.driver_phone'      => 'nullable|required_if:car.with_driver,yes|string|max:20',
        'car.driver_age'        => 'nullable|required_if:car.with_driver,yes|integer|min:18|max:80',
        'car.driver_experience' => 'nullable|required_if:car.with_driver,yes|integer|min:0|max:60',
        'car.driver_nic'        => 'nullable|required_if:car.with_driver,yes|string|unique:cars,driver_nic,' . ($request->car_id ?? 'NULL'),
        'driver_license_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'driver_license_back'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Handle file uploads
    $frontPath = null;
    $backPath  = null;

    if ($request->hasFile('driver_license_front')) {
        $frontPath = $request->file('driver_license_front')->store('driver_licenses', 'public');
    }

    if ($request->hasFile('driver_license_back')) {
        $backPath = $request->file('driver_license_back')->store('driver_licenses', 'public');
    }

    if ($request->filled('car_id')) {
        // Update existing car
        $car = Car::where('id', $request->car_id)->where('car_renter_id', $user->id)->firstOrFail();

        $car->update([
            'car_type_id' => $validated['car']['car_type_id'],
            'company_id'  => $validated['car']['company_id'],
            'model_id'    => $validated['car']['model_id'],
            'seats'       => $validated['car']['seats'],
            'with_driver' => $validated['car']['with_driver'],
            'driver_name' => $validated['car']['driver_name'] ?? null,
            'driver_phone'=> $validated['car']['driver_phone'] ?? null,
            'driver_age'  => $validated['car']['driver_age'] ?? null,
            'driver_experience' => $validated['car']['driver_experience'] ?? null,
            'driver_nic' => $validated['car']['driver_nic'] ?? null,
            'driver_license_front' => $frontPath ?? $car->driver_license_front,
            'driver_license_back'  => $backPath ?? $car->driver_license_back,
        ]);
    } else {
        // Create new car
        $car = Car::create([
            'car_type_id'   => $validated['car']['car_type_id'],
            'company_id'    => $validated['car']['company_id'],
            'model_id'      => $validated['car']['model_id'],
            'car_renter_id' => $user->id,
            'seats'         => $validated['car']['seats'],
            'with_driver'   => $validated['car']['with_driver'],
            'driver_name'   => $validated['car']['driver_name'] ?? null,
            'driver_phone'  => $validated['car']['driver_phone'] ?? null,
            'driver_age'    => $validated['car']['driver_age'] ?? null,
            'driver_experience' => $validated['car']['driver_experience'] ?? null,
            'driver_nic'    => $validated['car']['driver_nic'] ?? null,
            'driver_license_front' => $frontPath,
            'driver_license_back'  => $backPath,
            'price_per_day' => 0,
            'deposit'       => 0,
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => $request->filled('car_id') ? 'Step 1 updated successfully' : 'Step 1 saved successfully',
        'car_id' => $car->id
    ]);
}


            // Step 2: Specifications
            if ($step == 2) {
                $validated = $request->validate([
                    'car.transmission' => ['required', Rule::in(['manual', 'automatic'])],
                    'car.mileage_type' => ['required', Rule::in(['unlimited', 'limited'])],
                    'car.fuel_type'    => ['required', Rule::in(['petrol', 'diesel', 'electric', 'hybrid'])],
                ]);

                $car = Car::find($request->input('car_id'));

if (!$car) {
    return response()->json([
        'success' => false,
        'message' => 'Car not found'
    ], 404);
}

$car->update([
    'transmission' => $validated['car']['transmission'],
    'mileage_type' => $validated['car']['mileage_type'],
    'fuel_type'    => $validated['car']['fuel_type'],
]);

return response()->json([
    'success' => true,
    'message' => 'Step 2 saved successfully',
    'car_id' => $car->id
]);

            }

            // Step 3: Image
    // Step 3: Image
if ($step == 3) {
    $validated = $request->validate([
        'car_id'    => 'required|exists:cars,id',
        'car_front' => 'required|file|mimes:jpg,jpeg,png|max:8192',
        'car_back'  => 'required|file|mimes:jpg,jpeg,png|max:8192',
        'car_inside'=> 'required|file|mimes:jpg,jpeg,png|max:8192',
    ]);

    $car = Car::findOrFail($validated['car_id']);

    if ($request->hasFile('car_front')) {
        $frontPath = $request->file('car_front')->store('cars', 'public');
        $car->car_front = $frontPath;   // <-- use the DB column name from migration
    }

    if ($request->hasFile('car_back')) {
        $backPath = $request->file('car_back')->store('cars', 'public');
        $car->car_back = $backPath;
    }

    if ($request->hasFile('car_inside')) {
        $insidePath = $request->file('car_inside')->store('cars', 'public');
        $car->car_inside = $insidePath;
    }

    $car->save();

    return response()->json([
        'success' => true,
        'message' => 'Step 3 images uploaded successfully',
        'car_id'  => $car->id
    ]);
}


if ($step == 4) {
    $validated = $request->validate([
        'car_id'      => 'required|exists:cars,id',
        'pricingType' => 'required|in:perDay,perKm',
        'pricePerDay' => 'required_if:pricingType,perDay|nullable|numeric|min:0',
        'pricePerKm'  => 'required_if:pricingType,perKm|nullable|numeric|min:0',
        'deposit'     => 'nullable|numeric|min:0',
    ]);

    $car = Car::findOrFail($validated['car_id']);

    if ($validated['pricingType'] === 'perDay') {
        $car->price_per_day = $validated['pricePerDay'];
        $car->price_per_km = null;
    } else {
        $car->price_per_km = $validated['pricePerKm'];
        $car->price_per_day = null;
    }
    $car->deposit = $validated['deposit'] ?? 0;
    $car->save();

    return response()->json([
        'success' => true,
        'message' => 'Car pricing saved successfully',
        'car_id'  => $car->id
    ]);
}


            return response()->json([
                'success' => false,
                'message' => 'Invalid step'
            ]);
        } catch (\Exception $e) {
            Log::error('Car Registration Error: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
