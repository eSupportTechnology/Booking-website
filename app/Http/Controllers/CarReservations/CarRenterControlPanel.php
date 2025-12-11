<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use App\Models\Company;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Reservation;
use App\Models\TaxiBooking;
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

        $cars = Car::with(['carType', 'company', 'brand', 'model'])
            ->where('car_renter_id', $user->id)
            ->get();

        return view('car_rentals.my_car_rentals', compact('cars'));
    }

    public function show($id)
    {
        $user = Auth::guard('car_renter')->user();

        $car = Car::with(['carType', 'company', 'brand', 'model'])
            ->where('car_renter_id', $user->id)
            ->findOrFail($id);

        return view('car_rentals.show_car', compact('car'));
    }

    public function destroy($id)
    {
        $user = Auth::guard('car_renter')->user();

        $car = Car::where('car_renter_id', $user->id)->findOrFail($id);
        $car->delete();

        return redirect()->route('car_rentals-listing')->with('success', 'Car deleted successfully.');
    }

    public function edit($id)
    {
        $user = Auth::guard('car_renter')->user();
        $car = Car::where('car_renter_id', $user->id)->findOrFail($id);

        return view('car_rentals.car_edit', [
            'car' => $car,
            'car_types' => CarType::all(),
            'companies' => Company::all(),
            'car_brands' => CarBrand::all(),
            'car_models' => CarModel::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('car_renter')->user();
        $car = Car::where('car_renter_id', $user->id)->findOrFail($id);

        $request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'company_id'  => 'required|exists:companies,id',
            'brand_id'    => 'required|exists:car_brands,id',
            'model_id'    => 'required|exists:car_models,id',
            'seats'       => 'required|integer|min:2|max:20',
            'transmission'=> 'required',
            'mileage_type'=> 'required',
            'fuel_type'   => 'required',
            'pricingType' => 'required',
            'pricePerDay' => 'required_if:pricingType,perDay|nullable|numeric|min:0',
            'pricePerKm'  => 'required_if:pricingType,perKm|nullable|numeric|min:0',
            'car_front'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'car_back'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'car_inside'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $car->fill($request->except(['car_front', 'car_back', 'car_inside']));

        foreach (['car_front', 'car_back', 'car_inside'] as $field) {
            if ($request->hasFile($field)) {
                $car->$field = $request->file($field)->store('cars', 'public');
            }
        }

        $car->save();

        return redirect()->route('car_rentals-listing')
            ->with('success', 'Car details updated successfully.');
    }

    /* ----------------------------- CAR BOOKINGS ---------------------------- */

    public function getCarBookings(): array
{
    $partnerId = Auth::guard('car_renter')->id();

    $carBookings = \App\Models\Reservation::whereHas('car', function($q) use ($partnerId) {
            $q->where('car_renter_id', $partnerId);
        })
        ->with([
            'car.model:id,model_name',
            'user:id,name'
        ])
        ->latest()
        ->limit(10)
        ->get();

    // Convert to array format for view
    return $carBookings->map(function ($booking) {
        return [
            'id' => $booking->id,
            'guest_name' => $booking->user->name ?? 'Guest',
            'vehicle' => $booking->car->model->model_name ?? 'Vehicle',
            'start_date' => $booking->start_date,
            'end_date' => $booking->end_date,
            'pickup' => $booking->pickup_datetime ?? $booking->start_date,
            'status' => ucfirst($booking->status),
            'amount' => $booking->total_price ?? 0,
        ];
    })->toArray(); // <-- REQUIRED!
}


    /* ----------------------------- TAXI BOOKINGS ---------------------------- */

    public function getTaxiBookings()
{
    $partnerId = Auth::guard('car_renter')->id();

    $bookings = TaxiBooking::whereHas('taxi', function ($q) use ($partnerId) {
            $q->where('car_renter_id', $partnerId);
        })
        ->with(['taxi'])
        ->latest()
        ->get()
        ->map(function ($booking) {
            return [
                'id' => $booking->id,
                'guest_name' => $booking->name,
                'vehicle' => $booking->taxi->brand_model ?? 'Unknown Model',
                'start_date' => $booking->pickup_datetime,
                'end_date' => $booking->return_datetime,
                'total' => $booking->total_amount,
                'status' => $booking->status,
            ];
        });

    return $bookings;
}


    /* ----------------------------- CONTROL PANEL ---------------------------- */

    public function controlPanel()
    {
        $carRenter = Auth::guard('car_renter')->user();

        $carBookings = $this->getCarBookings();
        $taxiBookings = $this->getTaxiBookings();

        return view('car_rentals.carrenters_control_panel', compact(
            'carRenter', 'carBookings', 'taxiBookings'
        ));
    }

    public function manageBookings()
{
    $partnerId = Auth::guard('car_renter')->id();

    /* ---------------- CAR BOOKINGS ---------------- */
    $carBookings = Reservation::whereHas('car', function($q) use ($partnerId) {
            $q->where('car_renter_id', $partnerId);
        })
        ->with(['car.model', 'user'])
        ->latest()
        ->get()
        ->map(function ($b) {
            return [
                'type' => 'car',
                'id' => $b->id,
                'guest' => $b->user->name ?? 'Guest',
                'vehicle' => $b->car->model->model_name ?? 'Car',
                'date_from' => $b->start_date,
                'date_to' => $b->end_date,
                'status' => $b->status,
                'amount' => $b->total_price,
            ];
        });

    /* ---------------- TAXI BOOKINGS ---------------- */
    $taxiBookings = TaxiBooking::whereHas('taxi', function($q) use ($partnerId) {
            $q->where('car_renter_id', $partnerId);
        })
        ->with(['taxi'])
        ->latest()
        ->get()
        ->map(function ($t) {
            return [
                'type' => 'taxi',
                'id' => $t->id,
                'guest' => $t->name,
                'vehicle' => $t->taxi->brand_model ?? 'Taxi',
                'date_from' => $t->pickup_datetime,
                'date_to' => $t->return_datetime,
                'status' => $t->status,
                'amount' => $t->total_amount,
            ];
        });

    /* ---- MERGE BOTH INTO ONE LIST ---- */
    $bookings = $carBookings
        ->merge($taxiBookings)
        ->sortByDesc('date_from')
        ->values(); // re-index

    return view('car_rentals.manage_bookings', compact('bookings'));
}

public function updateBookingStatus(Request $request, $id)
{
    $type = $request->type; // "car" or "taxi"

    if ($type === 'car') {
        // Update Car Reservation
        $booking = Reservation::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

    } else {
        // Update Taxi Booking
        $booking = TaxiBooking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();
    }

    return back()->with('success', 'Booking status updated successfully!');
}


}
