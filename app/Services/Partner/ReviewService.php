<?php

namespace App\Services\Partner;

use App\Models\Review;
use App\DTOs\Partner\ReviewStatsDTO;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReviewService
{
    public function getReviewStats(): ReviewStatsDTO
    {
        $partnerId = Auth::id();
        
        $averageRating = Review::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->avg('rating') ?? 0;
        
        $totalReviews = Review::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->count();
        
        $monthlyReviews = Review::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->whereMonth('created_at', Carbon::now()->month)->count();
        
        $responseRate = 95; // Mock data
        
        return ReviewStatsDTO::fromArray([
            'average_rating' => round($averageRating, 1),
            'total_reviews' => $totalReviews,
            'monthly_reviews' => $monthlyReviews,
            'response_rate' => $responseRate
        ]);
    }

    public function getReviews(): array
    {
        return Review::with(['user', 'property'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($review) {
                return [
                    'id' => $review->id,
                    'guest_name' => $review->user->name ?? 'Guest',
                    'property_name' => $review->property->title ?? 'Property',
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'date' => $review->created_at->diffForHumans(),
                    'reply' => $review->reply
                ];
            })->toArray();
    }

    public function getRatingDistribution(): array
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = Review::whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })->where('rating', $i)->count();
            $distribution[$i] = $count;
        }
        return $distribution;
    }
}