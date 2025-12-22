<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use App\Models\CarReview;
use Illuminate\Support\Facades\Auth;

class CarReviewController extends Controller
{
    public function index()
    {
        $renterId = Auth::guard('car_renter')->id();

        /* =======================
           BASE QUERY (DO NOT MUTATE)
        ======================= */
        $baseQuery = CarReview::whereHas('reservation.car', function ($q) use ($renterId) {
            $q->where('car_renter_id', $renterId);
        });

        /* =======================
           STATS
        ======================= */
        $totalReviews = (clone $baseQuery)->count();

        $averageRating = round((clone $baseQuery)->avg('rating'), 1) ?? 0;

        $monthlyReviews = (clone $baseQuery)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $responseRate = $totalReviews > 0
            ? round(((clone $baseQuery)->whereNotNull('reply')->count() / $totalReviews) * 100)
            : 0;

        $stats = (object) [
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
            'monthlyReviews' => $monthlyReviews,
            'responseRate' => $responseRate,
        ];

        /* =======================
           RATING DISTRIBUTION
        ======================= */
        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = (clone $baseQuery)
                ->where('rating', $i)
                ->count();
        }

        /* =======================
           RECENT REVIEWS
           (NO PROPERTY / CAR NAME)
        ======================= */
        $reviews = (clone $baseQuery)
            ->with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($r) {
                return [
                    'guest_name' => $r->user->name ?? 'Guest',
                    'rating'     => $r->rating,
                    'comment'    => $r->comment,
                    'reply'      => $r->reply,
                    'date'       => $r->created_at->format('M d, Y'),
                ];
            });

        return view('car_rentals.reviews.index', compact(
            'stats',
            'ratingCounts',
            'reviews'
        ));
    }
}
