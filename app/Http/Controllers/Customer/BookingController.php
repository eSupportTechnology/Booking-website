<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Deal;
use App\DTOs\Customer\BookingDTO;
use App\Actions\Customer\CreateBookingAction;
use App\Services\Customer\BookingService;
use App\Services\DealBookingService;
use App\Services\MessagingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService,
        private DealBookingService $dealBookingService,
        private CreateBookingAction $createBookingAction,
        private MessagingService $messagingService
    ) {}

    public function show(Property $property, Request $request)
    {
        $property->load(['photos', 'amenities', 'category', 'pricing', 'rooms.amenities', 'rooms.roomType']);

        $selectedDeal = null;
        if ($request->has('deal_id')) {
            $selectedDeal = Deal::with(['room', 'dealDates'])->find($request->deal_id);
        }

        return view('Customer.bookings.show', compact('property', 'selectedDeal'));
    }

    public function store(Request $request, Property $property)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')->with('error', 'Please login to make a booking.');
        }

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_id' => 'nullable|exists:rooms,id',
            'deal_id' => 'nullable|exists:deals,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
        ]);

        $guestCount = $request->adults + $request->children;

        // Validate guest count against room/property limits
        if ($request->room_id) {
            $room = \App\Models\Room::find($request->room_id);
            if ($room && $room->max_guests && $guestCount > $room->max_guests) {
                return back()->with('error', "Selected room allows maximum {$room->max_guests} guests.");
            }
        } else {
            $property->load('additionalDetails');
            if ($property->additionalDetails && $property->additionalDetails->guests && $guestCount > $property->additionalDetails->guests) {
                return back()->with('error', "This property allows maximum {$property->additionalDetails->guests} guests.");
            }
        }

        $bookingDTO = BookingDTO::fromRequest($request);

        if (!$this->bookingService->isRoomAvailable($property, $bookingDTO->room_id, $bookingDTO->check_in, $bookingDTO->check_out)) {
            return back()->with('error', 'Selected room is not available for the chosen dates.');
        }

        $priceData = $this->bookingService->calculatePrice(
            $property,
            $bookingDTO->room_id,
            $bookingDTO->check_in,
            $bookingDTO->check_out,
            $bookingDTO->adults,
            $bookingDTO->children
        );

        $originalPrice = $priceData['total_price'];
        $finalPrice = $originalPrice;
        $discountAmount = 0;
        $dealId = null;

        // Apply deal discount if deal is selected
        if ($request->deal_id) {
            $dealValidation = $this->dealBookingService->validateDealBooking(
                $request->deal_id,
                $bookingDTO->check_in,
                $bookingDTO->check_out,
                $bookingDTO->room_id
            );

            if (!$dealValidation['valid']) {
                return back()->with('error', $dealValidation['message']);
            }

            $dealPricing = $this->dealBookingService->applyDealDiscount(
                $dealValidation['deal'],
                $originalPrice,
                $bookingDTO->check_in,
                $bookingDTO->check_out
            );

            $finalPrice = $dealPricing['final_price'];
            $discountAmount = $dealPricing['discount_amount'];
            $dealId = $request->deal_id;
        }

        $bookingDTO->total_price = $finalPrice;

        // Set default commission rate (can be customized per property/partner)
        $bookingDTO->commission_rate = 10.00;

        // Create booking with currency and deal data
        $booking = Booking::create([
            'user_id' => Auth::guard('customer')->id(),
            'property_id' => $bookingDTO->property_id,
            'room_id' => $bookingDTO->room_id,
            'deal_id' => $dealId,
            'check_in' => $bookingDTO->check_in,
            'check_out' => $bookingDTO->check_out,
            'guest_count' => $bookingDTO->guest_count,
            'adults' => $bookingDTO->adults,
            'children' => $bookingDTO->children,
            'total_price' => $finalPrice,
            'original_price' => $originalPrice,
            'discount_amount' => $discountAmount,
            'currency' => $priceData['currency'],
            'base_currency' => $priceData['base_currency'],
            'status' => 'pending',
            'commission_rate' => 10.00
        ]);

        // Set booking status to pending for partner approval
        $booking->update([
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_deadline' => now()->addHours(24)
        ]);

        // Send automatic message to partner
        $this->messagingService->sendBookingCreatedMessage($booking);

        $successMessage = 'Booking created! Please complete payment within 24 hours.';
        if ($dealId) {
            $successMessage .= " You saved $" . number_format($discountAmount, 2) . " with this deal!";
        }

        return redirect()->route('customer.payment.show', $booking)
            ->with('success', $successMessage);
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

    public function getAvailableDeals(Request $request, Property $property)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'room_id' => 'nullable|exists:rooms,id'
        ]);

        $deals = $this->dealBookingService->getAvailableDealsForProperty(
            $property->id,
            $request->check_in,
            $request->check_out,
            $request->room_id
        );

        return response()->json([
            'deals' => $deals->map(function ($deal) {
                return [
                    'id' => $deal->id,
                    'title' => $deal->title,
                    'description' => $deal->description,
                    'deal_type' => $deal->deal_type,
                    'discount_display' => $deal->discount_display,
                    'applicable_to' => $deal->applicable_to,
                    'room_name' => $deal->room ? $deal->room->name : null,
                    'available_dates' => $deal->dealDates->pluck('available_date')->map(fn($d) => $d->format('M d'))->join(', ')
                ];
            })
        ]);
    }
}
