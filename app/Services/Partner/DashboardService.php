<?php

namespace App\Services\Partner;

use App\DTOs\Partner\DashboardStatsDTO;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboardStats(): DashboardStatsDTO
    {
        $partnerId = Auth::id();

        $totalProperties = Property::where('user_id', $partnerId)->count();
        $activeBookings = Booking::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->where('status', 'confirmed')->count();

        $monthlyEarnings = Booking::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->whereMonth('created_at', Carbon::now()->month)
          ->whereYear('created_at', Carbon::now()->year)
          ->sum('total_price') ?? 0;

        $averageRating = Review::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->avg('rating') ?? 0;

        return DashboardStatsDTO::fromArray([
            'total_properties' => $totalProperties,
            'active_bookings' => $activeBookings,
            'monthly_earnings' => $monthlyEarnings,
            'average_rating' => round($averageRating, 1)
        ]);
    }

    public function getRecentBookings(): array
    {
        $partnerId = Auth::id();

        $bookings = Booking::with(['user', 'property'])
            ->whereHas('property', function($query) use ($partnerId) {
                $query->where('user_id', $partnerId);
            })
            ->latest()
            ->limit(5)
            ->get();

        return $bookings->map(function($booking) {
            return [
                'id' => 'BK' . $booking->id,
                'guest_name' => $booking->user->name ?? 'Guest',
                'property_name' => $booking->property->title ?? 'Property',
                'check_in' => $booking->check_in ? Carbon::parse($booking->check_in)->format('Y-m-d') : 'TBD',
                'status' => ucfirst($booking->status ?? 'pending'),
                'earnings' => $booking->total_price ?? 0
            ];
        })->toArray();
    }

    public function getChartData(): array
    {
        $partnerId = Auth::id();

        $monthlyData = Booking::whereHas('property', function($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->selectRaw('MONTH(created_at) as month, SUM(total_price) as earnings, COUNT(*) as bookings')
          ->whereYear('created_at', Carbon::now()->year)
          ->groupBy('month')
          ->orderBy('month')
          ->get();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $earnings = array_fill(0, 12, 0);
        $bookings = array_fill(0, 12, 0);

        foreach ($monthlyData as $data) {
            $earnings[$data->month - 1] = (float)($data->earnings ?? 0);
            $bookings[$data->month - 1] = (int)($data->bookings ?? 0);
        }

        // // Add fallback data if no bookings exist
        // if (array_sum($earnings) == 0 && array_sum($bookings) == 0) {
        //     $earnings = [100, 200, 150, 300, 250, 400, 350, 500, 450, 600, 550, 700];
        //     $bookings = [2, 4, 3, 6, 5, 8, 7, 10, 9, 12, 11, 14];
        // }

        return [
            'labels' => $labels,
            'earnings' => $earnings,
            'bookings' => $bookings
        ];
    }

    public function getRecentActivity(): array
    {
        $partnerId = Auth::id();
        $activities = [];

        // Recent bookings
        $recentBooking = Booking::with('property')
            ->whereHas('property', function($query) use ($partnerId) {
                $query->where('user_id', $partnerId);
            })
            ->latest()
            ->first();

        if ($recentBooking) {
            $activities[] = "New booking received for {$recentBooking->property->title}";
        }

        // Recent reviews
        $recentReview = Review::with('property')
            ->whereHas('property', function($query) use ($partnerId) {
                $query->where('user_id', $partnerId);
            })
            ->latest()
            ->first();

        if ($recentReview) {
            $activities[] = "Guest review: {$recentReview->rating} stars for {$recentReview->property->title}";
        }

        // Recent payment
        if ($recentBooking) {
            $activities[] = "Payment received: $" . number_format($recentBooking->total_price ?? 0) . " for booking BK{$recentBooking->id}";
        }

        // Property updates
        $recentProperty = Property::where('user_id', $partnerId)
            ->latest('updated_at')
            ->first();

        if ($recentProperty) {
            $activities[] = "Property information updated for {$recentProperty->title}";
        }

        return array_slice($activities, 0, 4);
    }
}
