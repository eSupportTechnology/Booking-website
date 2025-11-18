<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarBookingController extends Controller
{
    public function create($id)
    {
        $car = Car::with('company', 'model', 'carType')->findOrFail($id);
        return view('Customer.book-car', compact('car'));
    }

    public function store(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'pickup_datetime' => 'required|date',
            'dropoff_datetime' => 'required|date|after:pickup_datetime',
        ]);

        // Calculate total price
        $start = Carbon::parse($request->pickup_datetime);
        $end   = Carbon::parse($request->dropoff_datetime);

        $days = $start->diffInDays($end);
        if ($days === 0) $days = 1; // minimum 1 day charge

        $total = $days * $car->price_per_day;

        $reservation = Reservation::create([
            'car_id'             => $car->id,
            'user_id'            => auth()->id() ?? 0,   // guest or logged in
            'pickup_location'    => $request->pickup_location,
            'dropoff_location'   => $request->dropoff_location,
            'pickup_datetime'    => $request->pickup_datetime,
            'dropoff_datetime'   => $request->dropoff_datetime,
            'total_price'        => $total,
            'status'             => 'pending',
            'payment_status'     => 'pending',
        ]);

        return redirect()
            ->route('customer.booking.confirmation', $reservation->id)
            ->with('success', 'Reservation created successfully!');

        // Prevent overlapping reservations for same car
            $overlap = \DB::table('reservations')
                ->where('car_id', $car->id)
                ->where(function($q) use ($start, $end) {
                    $q->whereBetween('pickup_datetime', [$start, $end])
                    ->orWhereBetween('dropoff_datetime', [$start, $end])
                    ->orWhere(function($q2) use ($start, $end) {
                        $q2->where('pickup_datetime', '<=', $start)->where('dropoff_datetime', '>=', $end);
                    });
                })->exists();

            if ($overlap) {
                return back()->with('error', 'This vehicle is already booked for the selected date/time.');
            }

    }
    public function confirmation($id)
{
    $booking = Reservation::with('car')->findOrFail($id);
    return view('Customer.booking-confirmation', compact('booking'));
}

}
