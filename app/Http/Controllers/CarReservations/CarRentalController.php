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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CarRentalController extends Controller
{

    public function index()
    {
        Log::info('Car Rental Index accessed');
        // Fetch all cars with their types, companies, and models
        $car_types = CarType::all();
        $car_models = CarModel::all();
        $car_brands = CarBrand::all();
        $companies = Company::all();
        return view('car_rentals.carrentals-addcar', compact('car_types', 'car_models', 'car_brands', 'companies'));
    }
    public function registerStep(Request $request)
    {
        Log::info('Car registration step data: ', $request->all());
        try {
            $step = $request->input('step');
            $carData = $request->input('car');

            if ($step == 1) {
                $validated = $request->validate([
                    'car.car_type_id' => 'required|string',
                    'car.company_id' => 'required|string',
                    'car.brand' => 'required|string',
                    'car.model_id' => 'required|string',
                    'car.seats' => 'required|integer|min:2|max:20',
                ]);

                // You can save partial progress in session or draft DB table
                session(['car_registration' => $carData]);

                $car = Car::create([
                    'car_type_id' => $validated['car']['car_type_id'],
                    'company_id' => $validated['car']['company_id'],
                    'model_id' => $validated['car']['model_id'],
                    'seats' => $validated['car']['seats'],
                    'price_per_day' => $validated['car']['price_per_day'] ?? 0,
                    'deposit' => $validated['car']['deposit'] ?? 0,
                    // 'transmission' => $validated['car']['transmission'], // Uncomment and fix if needed
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Step 1 saved successfully',
                    'car' => $car['id']
                ]);
            } else if ($step == 2) {

                $validated = $request->validate([
                    'car.transmission' => ['required', Rule::in(['manual', 'automatic'])],
                    'car.mileage_type' => ['required', Rule::in(['unlimited', 'limited'])],
                    'car.fuel_type'    => ['required', Rule::in(['petrol', 'diesel', 'electric', 'hybrid'])],
                ]);


                // Update the car with the additional details
                $car = Car::find($request->input('car_id'));
                if (!$car) {
                    return response()->json(['error' => 'Car not found'], 404);
                }
                $car->update([
                    'transmission' => $validated['car']['transmission'],
                    'mileage_type' => $validated['car']['mileage_type'],
                    'fuel_type' => $validated['car']['fuel_type'],

                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Step 2 saved successfully'
                ]);
            } else if ($step == 3) {
                $validated = $request->validate([
                    'selectedImage' => 'required|string',
                ]);

                File::create([
                    'file_type'     => 'image',
                    'path'          => 'images/' . $validated['selectedImage'] . '.jpg', // stored path
                    'property_type' => 'car',
                    'car_id'        => $request->input('car_id'),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Demo image saved successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid step'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in Car registration step: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
