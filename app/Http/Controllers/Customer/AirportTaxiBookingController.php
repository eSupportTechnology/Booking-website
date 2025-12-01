<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\TaxiBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Taxi;

class AirportTaxiBookingController extends Controller
{
    /**
     * Store airport taxi booking
     */
    public function store(Request $request)
    {
        // Ensure user is logged in
        if (!Auth::guard('customer')->check()) {
            return redirect('/customer/login')->with('error', 'Please log in to book a taxi.');
        }

        // Validate request
        $validated = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'pickup_datetime' => 'required|date',
            'return_datetime' => 'nullable|date|after:pickup_datetime',
            'distance' => 'nullable|numeric|min:0',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone1' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
            'taxi_id' => 'required|integer|exists:taxis,id',
            'payment_method' => 'required|in:card,paypal,stripe,bank_transfer,pay_to_driver',
        ]);

        $customerId = Auth::guard('customer')->id();
        $pickup = $request->pickup_datetime;
        $return = $request->return_datetime ?? $pickup;

        /**
         * ---------------------------------------------------------
         * ★ Prevent overlapping bookings for the same taxi
         * ---------------------------------------------------------
         */
        $conflict = TaxiBooking::where('taxi_id', $request->taxi_id)
            ->where('pickup_datetime', '<', $return)
            ->where(function ($q) use ($pickup) {
                $q->where('return_datetime', '>', $pickup)
                  ->orWhereNull('return_datetime');
            })
            ->exists();

        if ($conflict) {
            return back()
                ->with('error', 'This taxi is already booked for the selected date/time.')
                ->withInput();
        }

        /**
         * ---------------------------------------------------------
         * Fare Calculation
         * ---------------------------------------------------------
         */
        $baseFare = 200;
        $distanceFare = ($request->distance ?? 0) * 60;
        $serviceFee = 150;
        $total = $baseFare + $distanceFare + $serviceFee;

        // Unique booking ID
        $bookingRef = 'TAXI-' . strtoupper(Str::random(8));

        /**
         * ---------------------------------------------------------
         * Create booking
         * ---------------------------------------------------------
         */
        $booking = TaxiBooking::create([
            'booking_id'       => $bookingRef,
            'user_id'          => $customerId,
            'taxi_id'          => $request->taxi_id,

            // Trip
            'pickup_location'  => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'pickup_datetime'  => $pickup,
            'return_datetime'  => $return,
            'distance'         => $request->distance,

            // Fare
            'base_fare'        => $baseFare,
            'distance_fare'    => $distanceFare,
            'service_fee'      => $serviceFee,
            'total_amount'     => $total,

            // Customer
            'name'             => $request->name,
            'address'          => $request->address,
            'email'            => $request->email,
            'phone1'           => $request->phone1,
            'phone2'           => $request->phone2,

            // Payment
            'payment_method'   => $request->payment_method,
            'payment_status'   => 'pending',

            // Status
            'status'           => 'active',
        ]);

        return redirect()
            ->route('frontend.taxi.booking.completed', $booking->id)
            ->with('success', 'Taxi booked successfully!');
    }

    /**
     * Show booking form
     */
    public function create($id)
    {
        $taxi = Taxi::with('drivers')->findOrFail($id);
        return view('airport_taxis.booking-form', compact('taxi'));
    }

    /**
     * Completed booking page
     */
    public function completed($id)
    {
        $booking = TaxiBooking::with(['taxi', 'taxi.drivers'])->findOrFail($id);
        return view('airport_taxis.taxi-booking-confirm', compact('booking'));
    }

    /**
     * Cancel booking
     */
    public function cancel($id)
    {
        $booking = TaxiBooking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('frontend.dashboard')->with('message', 'Booking cancelled.');
    }

    /**
     * Invoice (Placeholder)
     */
    public function invoice($id)
    {
        return "Invoice Download Coming Soon!";
    }
}
