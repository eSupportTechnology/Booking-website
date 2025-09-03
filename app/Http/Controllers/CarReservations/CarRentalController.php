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
            if ($step == 1) {
                $validated = $request->validate([
                    'car.car_type_id' => 'required|integer|exists:car_types,id',
                    'car.company_id'  => 'required|integer|exists:companies,id',
                    'car.brand'       => 'required|integer|exists:car_brands,id',
                    'car.model_id'    => 'required|integer|exists:car_models,id',
                    'car.seats'       => 'required|integer|min:2|max:20',
                    'car.with_driver' => 'required|in:yes,no',
                    'car.driver_name' => 'required_if:car.with_driver,yes|string|max:255',
                    'car.driver_phone'=> 'required_if:car.with_driver,yes|string|max:20',
                    'car.driver_age'  => 'required_if:car.with_driver,yes|integer|min:18|max:80',
                    'car.driver_experience' => 'nullable|integer|min:0|max:60',
                    'car.driver_nic' => 'nullable|string|unique:cars,driver_nic',
                ]);

                $car = Car::create([
                    'car_type_id' => $validated['car']['car_type_id'],
                    'company_id'  => $validated['car']['company_id'],
                    'model_id'    => $validated['car']['model_id'],
                    'car_renter_id' => $user->id,
                    'seats'       => $validated['car']['seats'],
                    'with_driver' => $validated['car']['with_driver'],
                    'driver_name' => $validated['car']['driver_name'] ?? null,
                    'driver_phone'=> $validated['car']['driver_phone'] ?? null,
                    'driver_age'  => $validated['car']['driver_age'] ?? null,
                    'driver_experience' => $validated['car']['driver_experience'] ?? null,
                    'driver_nic' => $validated['car']['driver_nic'] ?? null,
                    'price_per_day' => 0,
                    'deposit' => 0,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Step 1 saved successfully',
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

                $car = Car::findOrFail($request->input('car_id'));
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
            if ($step == 3) {
                $validated = $request->validate([
                    'selectedImage' => 'required|string',
                    'car_id' => 'required|exists:cars,id'
                ]);

                File::create([
                    'file_type' => 'image',
                    'path' => 'images/' . $validated['selectedImage'] . '.jpg',
                    'property_type' => 'car',
                    'car_id' => $validated['car_id'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Demo image saved successfully',
                    'car_id' => $validated['car_id']
                ]);
            }

            // Step 4: Pricing
            if ($step == 4) {
                $validated = $request->validate([
                    'car_id' => 'required|exists:cars,id',
                    'pricingType' => 'required|in:perDay,perKm',
                    'pricePerDay' => 'nullable|numeric|min:0',
                    'pricePerKm'  => 'nullable|numeric|min:0',
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
                    'car_id' => $car->id
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
