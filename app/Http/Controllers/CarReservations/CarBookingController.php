<?php
namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarBookingController extends Controller
{
    public function create($id)
    {
        // 🔐 Require login
        if (!auth()->check()) {
            return redirect('/customer/login')
                ->with('error', 'Please login to continue your booking.');
        }

        $car = Car::with('company', 'model', 'carType', 'renter')->findOrFail($id);

        return view('car_rentals.continue-booking', compact('car'));


    }

    public function store(Request $request, $id)
{
    if (!auth()->check()) {
        return redirect('/customer/login')
            ->with('error', 'Please login to complete your booking.');
    }

    if (!$request->dropoff_location) {
        $request->merge([
            'dropoff_location' => $request->pickup_location
        ]);
    }

    $car = Car::findOrFail($id);

    $request->validate([
        'pickup_location' => 'required|string|max:255',
        'dropoff_location' => 'required|string|max:255',
        'pickup_datetime'  => 'required|date',
        'dropoff_datetime' => 'required|date|after:pickup_datetime',
        'payment_method'   => 'required|string',
    ]);

    $start = Carbon::parse($request->pickup_datetime);
    $end   = Carbon::parse($request->dropoff_datetime);

    // Prevent overlapping reservations
    $overlap = Reservation::where('car_id', $car->id)
        ->where(function($q) use ($start, $end) {
            $q->whereBetween('pickup_datetime', [$start, $end])
              ->orWhereBetween('dropoff_datetime', [$start, $end])
              ->orWhere(function($q2) use ($start, $end) {
                  $q2->where('pickup_datetime', '<=', $start)
                     ->where('dropoff_datetime', '>=', $end);
              });
        })->exists();

    if ($overlap) {
        return back()->withInput()
            ->withErrors([
                'pickup_datetime' => 'This vehicle is already booked for the selected date/time.'
            ]);
    }

    // Days calculation
    $days = $start->diffInDays($end);
    if ($days <= 0) $days = 1;

    // Price calculation + discount
    $pricePerDay = $car->price_per_day ?? 0;

    $renter = $car->renter;
    $discountPercentage = (int)($renter->discount_percentage ?? 0);
    $discountAmount = $discountPercentage > 0
        ? ($pricePerDay * $discountPercentage / 100)
        : 0;

    $finalPricePerDay = $pricePerDay - $discountAmount;
    $finalTotal = $finalPricePerDay * $days;

    // ⭐ PAYMENT STATUS FIXED HERE
    $paymentMethod = $request->payment_method;

    if ($paymentMethod === 'driver') {
        $paymentStatus = 'pending'; // Pay at pickup
    } else {
        $paymentStatus = 'paid'; // Online payment (future integration)
    }

    // Save reservation
    $reservation = Reservation::create([
        'car_id'           => $car->id,
        'user_id'          => auth()->id(),
        'pickup_location'  => $request->pickup_location,
        'dropoff_location' => $request->dropoff_location,
        'pickup_datetime'  => $request->pickup_datetime,
        'dropoff_datetime' => $request->dropoff_datetime,
        'start_date'       => $start->format('Y-m-d'),
        'end_date'         => $end->format('Y-m-d'),
        'total_price'      => $finalTotal,
        'status'           => 'pending',
        'payment_status'   => $paymentStatus,   // ✔ NOW VALID
        'notes'            => null,
    ]);

    return redirect()
        ->route('customer.booking.confirmation', $reservation->id)
        ->with('success', 'Reservation created successfully!');
}


    public function confirmation($id)
    {
        $booking = Reservation::with('car')->findOrFail($id);
        return view('car_rentals.booking-confirmation', compact('booking'));

    }
}
