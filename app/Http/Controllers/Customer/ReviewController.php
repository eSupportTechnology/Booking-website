<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Booking;
use App\Services\Customer\ReviewService;
use App\DTOs\Customer\ReviewDTO;
use App\Actions\Customer\CreateReviewAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(
        private ReviewService $reviewService,
        private CreateReviewAction $createReviewAction
    ) {}
    public function create(Booking $booking)
    {
        if ($booking->user_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        if ($booking->status !== 'confirmed' || $booking->check_out > now()) {
            return back()->with('error', 'You can only review completed stays.');
        }

        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this stay.');
        }

        $booking->load(['property', 'room']);
        
        return view('Customer.reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        if ($booking->status !== 'confirmed' || $booking->check_out > now()) {
            return back()->with('error', 'You can only review completed stays.');
        }

        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this stay.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'staff_rating' => 'nullable|numeric|min:1|max:5',
            'facilities_rating' => 'nullable|numeric|min:1|max:5',
            'cleanliness_rating' => 'nullable|numeric|min:1|max:5',
            'comfort_rating' => 'nullable|numeric|min:1|max:5',
            'value_rating' => 'nullable|numeric|min:1|max:5',
            'location_rating' => 'nullable|numeric|min:1|max:5',
            'wifi_rating' => 'nullable|numeric|min:1|max:5',
        ]);

        $reviewDTO = ReviewDTO::fromRequest(
            $request, 
            $booking->id, 
            $booking->property_id, 
            $booking->user_id
        );
        
        $this->createReviewAction->execute($reviewDTO);

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Thank you for your review!');
    }

    public function index()
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login');
        }

        $reviews = $this->reviewService->getUserReviews(Auth::guard('customer')->id());

        return view('Customer.reviews.index', compact('reviews'));
    }
}