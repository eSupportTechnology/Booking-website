<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarReservationController extends Controller
{
    public function search(Request $request)
    {
        $pickup = $request->input('pickup');
        $destination = $request->input('destination'); // in case you use it later
        $pickupDate = $request->input('pickup_date');
        $dropoffDate = $request->input('dropoff_date');

        $request->validate([
            'pickup' => 'required|string',
            'pickup_date' => 'required|date',
            'dropoff_date' => 'required|date|after:pickup_date',
        ]);

        $query = Car::with(['model.brand', 'company', 'carType']);

        $query->whereDoesntHave('reservations', function ($q) use ($pickupDate, $dropoffDate) {
            $q->where('status', 'confirmed')
                ->whereNotExists(function ($query) use ($pickupDate, $dropoffDate) {
                    $query->select(DB::raw(1))
                        ->from('reservations') // ✅ correct
                        ->whereColumn('cars.id', 'reservations.car_id')
                        ->where('status', 'confirmed')
                        ->where(function ($q) use ($pickupDate, $dropoffDate) {
                            $q->whereBetween('start_date', [$pickupDate, $dropoffDate])
                                ->orWhereBetween('end_date', [$pickupDate, $dropoffDate])
                                ->orWhere(function ($q2) use ($pickupDate, $dropoffDate) {
                                    $q2->where('start_date', '<=', $pickupDate)
                                        ->where('end_date', '>=', $dropoffDate);
                                });
                        });
                });
        });



        $cars = $query->get();

        Log::info('Car search performed', [
            'pickup' => $pickup,
            'pickup_date' => $pickupDate,
            'dropoff_date' => $dropoffDate,
            'cars_found' => $cars->count(),
        ]);
    }
}
