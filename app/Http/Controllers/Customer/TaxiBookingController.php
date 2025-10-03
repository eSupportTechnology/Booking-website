<?php

namespace App\Http\Controllers;

use App\Models\TaxiBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxiBookingController extends Controller
{
    public function store(Request $request)
    {
        // Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to book a taxi.');
        }

        // Validation
        $validated = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'pickup_datetime' => 'required|date',
            'return_datetime' => 'nullable|date|after:pickup_datetime',
            'distance' => 'nullable|numeric',
            'fare' => 'nullable|numeric',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email',
            'phone1' => 'required|string|max:20',
            'phone2' => 'nullable|string|max:20',
        ]);

        // Save booking
        $booking = new TaxiBooking();
        $booking->user_id = Auth::id();
        $booking->pickup_location = $request->pickup_location;
        $booking->dropoff_location = $request->dropoff_location;
        $booking->pickup_datetime = $request->pickup_datetime;
        $booking->return_datetime = $request->return_datetime;
        $booking->distance_km = $request->distance;
        $booking->fare_lkr = $request->fare;
        $booking->name = $request->name;
        $booking->address = $request->address;
        $booking->email = $request->email;
        $booking->phone1 = $request->phone1;
        $booking->phone2 = $request->phone2;
        $booking->save();

        return redirect()->back()->with('success', 'Taxi booked successfully!');
    }
}
