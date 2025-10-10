<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\DTOs\Customer\BookingDTO;
use App\Actions\Customer\CreateBookingAction;
use App\Services\Customer\BookingService;
use App\Services\MessagingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService,
        private CreateBookingAction $createBookingAction,
        private MessagingService $messagingService
    ) {}

    public function show(Property $property)
    {
        $property->load(['photos', 'amenities', 'category', 'pricing', 'rooms.amenities', 'rooms.roomType']);
        
        return view('Customer.bookings.show', compact('property'));
    }

    public function store(Request $request, Property $property)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')->with('error', 'Please login to make a booking.');
        }

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'nullable|exists:rooms,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guest_count' => 'required|integer|min:1|max:20',
        ]);

        // Validate guest count against room/property limits
        if ($request->room_id) {
            $room = \App\Models\Room::find($request->room_id);
            if ($room && $room->max_guests && $request->guest_count > $room->max_guests) {
                return back()->with('error', "Selected room allows maximum {$room->max_guests} guests.");
            }
        } else {
            $property->load('additionalDetails');
            if ($property->additionalDetails && $property->additionalDetails->guests && $request->guest_count > $property->additionalDetails->guests) {
                return back()->with('error', "This property allows maximum {$property->additionalDetails->guests} guests.");
            }
        }

        $bookingDTO = BookingDTO::fromRequest($request);
        
        if (!$this->bookingService->isRoomAvailable($property, $bookingDTO->room_id, $bookingDTO->check_in, $bookingDTO->check_out)) {
            return back()->with('error', 'Selected room is not available for the chosen dates.');
        }

        $bookingDTO->total_price = $this->bookingService->calculatePrice(
            $property, 
            $bookingDTO->room_id,
            $bookingDTO->check_in, 
            $bookingDTO->check_out, 
            $bookingDTO->guest_count
        );
        
        // Set default commission rate (can be customized per property/partner)
        $bookingDTO->commission_rate = 10.00;

        $booking = $this->createBookingAction->execute($bookingDTO);
        
        // Set booking status to pending for partner approval
        $booking->update([
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_deadline' => now()->addHours(24)
        ]);

        // Send automatic message to partner
        $this->messagingService->sendBookingCreatedMessage($booking);

        return redirect()->route('customer.payment.show', $booking)
            ->with('success', 'Booking created! Please complete payment within 24 hours.');
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

    public function getBookedDates(Property $property)
    {
        $bookedDates = Booking::where('property_id', $property->id)
            ->where('status', '!=', 'cancelled')
            ->select('check_in', 'check_out')
            ->get()
            ->map(function ($booking) {
                $dates = [];
                $start = new \DateTime($booking->check_in);
                $end = new \DateTime($booking->check_out);
                
                while ($start < $end) {
                    $dates[] = $start->format('Y-m-d');
                    $start->add(new \DateInterval('P1D'));
                }
                
                return $dates;
            })
            ->flatten()
            ->unique()
            ->values();

        return response()->json($bookedDates);
    }

    public function getAvailableRooms(Request $request, Property $property)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $availableRooms = $this->bookingService->getAvailableRooms(
            $property, 
            $request->check_in, 
            $request->check_out
        );

        return response()->json($availableRooms);
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        $booking->cancelBooking();
        
        // Send cancellation message to partner
        $this->messagingService->sendCustomerCancelledMessage($booking);

        return back()->with('success', 'Booking cancelled successfully. No commission charges will apply.');
    }
}