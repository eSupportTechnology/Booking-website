<?php

namespace App\Services\Customer;

use App\Models\Review;
use App\Models\Booking;

class ReviewService
{
    public function canUserReview(Booking $booking, $userId): bool
    {
        return $booking->user_id === $userId && 
               $booking->status === 'confirmed' && 
               $booking->check_out <= now() && 
               !Review::where('booking_id', $booking->id)->exists();
    }

    public function getUserReviews($userId)
    {
        return Review::where('user_id', $userId)
            ->with(['property', 'booking.room'])
            ->latest()
            ->paginate(10);
    }
}