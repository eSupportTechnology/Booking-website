<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Show all reservations (car rentals + hotel bookings) for logged user
     */
    public function index()
    {
        // Get car reservations
        $reservations = Reservation::with([
                'car',
                'car.brand',
                'car.model',
                'car.files',
                'car.carType',
                'car.renter',
                'car.company'
            ])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Get hotel bookings
        $hotelBookings = Booking::with([
                'property',
                'property.photos',
                'property.category',
                'room'
            ])
            ->where('user_id', Auth::guard('customer')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('car_rentals.bookings', compact('reservations', 'hotelBookings'));
    }

    /**
     * View single reservation details page
     */
    public function show($id)
    {
        $reservation = Reservation::with([
                'car',
                'car.brand',
                'car.model',
                'car.files',
                'car.carType',
                'car.renter',
                'car.company'
            ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('car_rentals.bookings-view', compact('reservation'));
    }

        
    /**
     * Cancel booking
     */
    public function cancel($id)
{
    $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);

    if ($reservation->status === 'cancelled') {
        return back()->with('error', 'This booking is already cancelled.');
    }

    // FIRST set status
    $reservation->status = 'cancelled';
    $reservation->save();

    // THEN soft delete
    $reservation->delete();

    return redirect()
        ->route('customer.reservations.index')
        ->with('success', 'Booking cancelled successfully.');
}



}
