<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\DTOs\Customer\BookingDTO;
use App\Actions\Customer\CreateBookingAction;
use App\Services\Customer\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService,
        private CreateBookingAction $createBookingAction
    ) {}

    public function show(Property $property)
    {
        $property->load(['photos', 'amenities', 'category', 'pricing', 'rooms.amenities']);
        
        return view('Customer.bookings.show', compact('property'));
    }

    public function store(Request $request, Property $property)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')->with('error', 'Please login to make a booking.');
        }

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guest_count' => 'required|integer|min:1|max:20',
        ]);

        $bookingDTO = BookingDTO::fromRequest($request);
        
        if (!$this->bookingService->isPropertyAvailable($property, $bookingDTO->check_in, $bookingDTO->check_out)) {
            return back()->with('error', 'Property is not available for selected dates.');
        }

        $bookingDTO->total_price = $this->bookingService->calculatePrice(
            $property, 
            $bookingDTO->check_in, 
            $bookingDTO->check_out, 
            $bookingDTO->guest_count
        );

        $booking = $this->createBookingAction->execute($bookingDTO);

        return redirect()->route('customer.bookings.confirmation', $booking)
            ->with('success', 'Booking created successfully!');
    }

    public function index()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $bookings = $this->bookingService->getUserBookings(Auth::guard('customer')->id());
        
        return view('Customer.bookings.index', compact('bookings'));
    }

    public function confirmation(Booking $booking)
    {
        if ($booking->user_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        $booking->load(['property.photos', 'property.category']);
        
        return view('Customer.bookings.confirmation', compact('booking'));
    }
}