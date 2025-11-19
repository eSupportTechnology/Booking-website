<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PropertyAnalyticsController extends Controller
{
    public function analytics($propertyId)
    {
        $property = Property::where('id', $propertyId)
            ->where('user_id', auth()->id())
            ->with(['bookings', 'reviews'])
            ->firstOrFail();

        $analytics = [
            'overview' => $this->getOverviewStats($property),
            'revenue' => $this->getRevenueStats($property),
            'bookings' => $this->getBookingStats($property),
            'performance' => $this->getPerformanceStats($property),
            'trends' => $this->getTrendData($property),
        ];

        return response()->json($analytics);
    }

    public function dashboard()
    {
        $properties = Property::where('user_id', auth()->id())
            ->with(['bookings', 'reviews'])
            ->get();

        $analytics = [
            'overview' => $this->getDashboardOverview($properties),
            'top_performers' => $this->getTopPerformers($properties),
            'recent_activity' => $this->getRecentActivity($properties),
            'monthly_trends' => $this->getMonthlyTrends($properties),
        ];

        return view('partner.analytics.dashboard', compact('analytics'));
    }

    private function getOverviewStats($property)
    {
        $bookings = $property->bookings;
        $reviews = $property->reviews;

        return [
            'total_views' => $this->getPropertyViews($property->id),
            'total_bookings' => $bookings->count(),
            'total_revenue' => $bookings->sum('total_amount'),
            'avg_rating' => round($reviews->avg('rating') ?? 0, 1),
            'total_reviews' => $reviews->count(),
            'occupancy_rate' => $this->calculateOccupancyRate($property),
            'conversion_rate' => $this->calculateConversionRate($property),
        ];
    }

    private function getRevenueStats($property)
    {
        $bookings = $property->bookings()->where('status', 'confirmed');
        
        return [
            'total_revenue' => $bookings->sum('total_amount'),
            'this_month' => $bookings->whereMonth('created_at', now()->month)->sum('total_amount'),
            'last_month' => $bookings->whereMonth('created_at', now()->subMonth()->month)->sum('total_amount'),
            'avg_booking_value' => round($bookings->avg('total_amount') ?? 0, 2),
            'commission_earned' => $this->calculateCommissionEarned($property),
        ];
    }

    private function getBookingStats($property)
    {
        $bookings = $property->bookings;
        
        return [
            'total_bookings' => $bookings->count(),
            'confirmed_bookings' => $bookings->where('status', 'confirmed')->count(),
            'cancelled_bookings' => $bookings->where('status', 'cancelled')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
            'avg_stay_duration' => $this->calculateAvgStayDuration($bookings),
            'repeat_customers' => $this->getRepeatCustomers($bookings),
        ];
    }

    private function getPerformanceStats($property)
    {
        return [
            'listing_score' => $this->calculateListingScore($property),
            'response_rate' => 95, // Placeholder
            'acceptance_rate' => 88, // Placeholder
            'search_ranking' => $this->getSearchRanking($property),
            'completion_rate' => $this->calculateCompletionRate($property),
        ];
    }

    private function getTrendData($property)
    {
        $months = [];
        $bookings = [];
        $revenue = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthBookings = $property->bookings()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->get();

            $months[] = $date->format('M Y');
            $bookings[] = $monthBookings->count();
            $revenue[] = $monthBookings->sum('total_amount');
        }

        return [
            'months' => $months,
            'bookings' => $bookings,
            'revenue' => $revenue,
        ];
    }

    private function getDashboardOverview($properties)
    {
        $totalBookings = $properties->sum(function ($property) {
            return $property->bookings->count();
        });

        $totalRevenue = $properties->sum(function ($property) {
            return $property->bookings->sum('total_amount');
        });

        return [
            'total_properties' => $properties->count(),
            'active_properties' => $properties->where('status', 'active')->count(),
            'total_bookings' => $totalBookings,
            'total_revenue' => $totalRevenue,
            'avg_rating' => round($properties->avg(function ($property) {
                return $property->reviews->avg('rating') ?? 0;
            }), 1),
        ];
    }

    private function getTopPerformers($properties)
    {
        return $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'title' => $property->title,
                'bookings' => $property->bookings->count(),
                'revenue' => $property->bookings->sum('total_amount'),
                'rating' => round($property->reviews->avg('rating') ?? 0, 1),
            ];
        })->sortByDesc('revenue')->take(5)->values();
    }

    private function getRecentActivity($properties)
    {
        $activities = [];

        foreach ($properties as $property) {
            $recentBookings = $property->bookings()
                ->latest()
                ->take(5)
                ->get();

            foreach ($recentBookings as $booking) {
                $activities[] = [
                    'type' => 'booking',
                    'property_title' => $property->title,
                    'message' => "New booking for {$property->title}",
                    'amount' => $booking->total_amount,
                    'date' => $booking->created_at,
                ];
            }
        }

        return collect($activities)->sortByDesc('date')->take(10)->values();
    }

    private function getMonthlyTrends($properties)
    {
        $months = [];
        $bookings = [];
        $revenue = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthBookings = Booking::whereIn('property_id', $properties->pluck('id'))
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->get();

            $months[] = $date->format('M Y');
            $bookings[] = $monthBookings->count();
            $revenue[] = $monthBookings->sum('total_amount');
        }

        return [
            'months' => $months,
            'bookings' => $bookings,
            'revenue' => $revenue,
        ];
    }

    // Helper methods
    private function getPropertyViews($propertyId)
    {
        // Placeholder - implement actual view tracking
        return rand(100, 1000);
    }

    private function calculateOccupancyRate($property)
    {
        // Simplified calculation - implement actual logic
        $totalDays = 365;
        $bookedDays = $property->bookings->sum(function ($booking) {
            return Carbon::parse($booking->check_out)->diffInDays(Carbon::parse($booking->check_in));
        });

        return round(($bookedDays / $totalDays) * 100, 1);
    }

    private function calculateConversionRate($property)
    {
        $views = $this->getPropertyViews($property->id);
        $bookings = $property->bookings->count();
        
        return $views > 0 ? round(($bookings / $views) * 100, 1) : 0;
    }

    private function calculateCommissionEarned($property)
    {
        return $property->bookings->sum(function ($booking) {
            $baseAmount = $booking->total_amount;
            $commissionRate = $property->commission_rate ?? 10;
            return $baseAmount * ($commissionRate / 100);
        });
    }

    private function calculateAvgStayDuration($bookings)
    {
        if ($bookings->isEmpty()) return 0;

        $totalDays = $bookings->sum(function ($booking) {
            return Carbon::parse($booking->check_out)->diffInDays(Carbon::parse($booking->check_in));
        });

        return round($totalDays / $bookings->count(), 1);
    }

    private function getRepeatCustomers($bookings)
    {
        return $bookings->groupBy('user_id')
            ->filter(function ($customerBookings) {
                return $customerBookings->count() > 1;
            })->count();
    }

    private function calculateListingScore($property)
    {
        $score = 0;
        
        // Basic info completeness (30 points)
        if ($property->title) $score += 5;
        if ($property->description) $score += 10;
        if ($property->address) $score += 5;
        if ($property->adult_price) $score += 10;

        // Photos (20 points)
        $photoCount = $property->photos->count();
        $score += min($photoCount * 4, 20);

        // Amenities (20 points)
        $amenityCount = $property->amenities->count();
        $score += min($amenityCount * 2, 20);

        // Reviews (30 points)
        $reviewCount = $property->reviews->count();
        $avgRating = $property->reviews->avg('rating') ?? 0;
        $score += min($reviewCount * 2, 15);
        $score += ($avgRating / 5) * 15;

        return round($score, 1);
    }

    private function getSearchRanking($property)
    {
        // Placeholder - implement actual search ranking logic
        return rand(1, 100);
    }

    private function calculateCompletionRate($property)
    {
        $steps = [
            'basic_info' => !empty($property->title) && !empty($property->description),
            'photos' => $property->photos->count() >= 3,
            'pricing' => !empty($property->adult_price),
            'amenities' => $property->amenities->count() > 0,
            'policies' => $property->policies()->exists(),
        ];

        $completed = array_sum($steps);
        $total = count($steps);

        return round(($completed / $total) * 100, 1);
    }
}