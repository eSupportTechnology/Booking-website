<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\Partner;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total properties and new properties this month
        $totalProperties = Accommodation::count();
        $newPropertiesThisMonth = Accommodation::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Get total users and new users this month
        $totalPartners = Partner::count();
        $totalCustomers = User::has('customerPersonalDetail')->count();
        $newPartnersThisMonth = Partner::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $newCustomersThisMonth = User::has('customerPersonalDetail')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Get pending approvals
        $pendingApprovals = Property::where('status', 'pending')->count();
        $pendingProperties = Property::with(['user', 'photos'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Get total bookings and growth
        $totalBookings = Booking::count();
        $lastMonthBookings = Booking::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $thisMonthBookings = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $bookingGrowth = $lastMonthBookings > 0
            ? round((($thisMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100)
            : 100;

        // Get recent bookings
        $recentBookings = Booking::with(['property', 'user.customerPersonalDetail'])
            ->latest()
            ->take(5)
            ->get();

        // Get booking stats for the last 6 months
        $bookingStats = $this->getBookingStats();

        // Get property type distribution
        $propertyTypeStats = $this->getPropertyTypeStats();

        return view('admin.admin-dashboard', compact(
            'totalProperties',
            'newPropertiesThisMonth',
            'totalPartners',
            'totalCustomers',
            'newPartnersThisMonth',
            'newCustomersThisMonth',
            'pendingApprovals',
            'pendingProperties',
            'totalBookings',
            'bookingGrowth',
            'recentBookings',
            'bookingStats',
            'propertyTypeStats'
        ));
    }

    private function getBookingStats()
    {
        $stats = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        )
            ->whereDate('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        // Fill in any missing months with zero bookings
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;

            $monthData = $stats->first(function ($item) use ($month, $year) {
                return $item->month == $month && $item->year == $year;
            });

            $labels[] = $date->format('M Y');
            $data[] = $monthData ? $monthData->total : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getPropertyTypeStats()
    {
        $categories = PropertyCategory::withCount('properties')->get();
        $stats = [];

        foreach ($categories as $category) {
            $stats[$category->name] = $category->properties_count;
        }

        return $stats;
    }
}
