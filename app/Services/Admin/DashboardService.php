<?php
// app/Services/Admin/DashboardService.php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Partner;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Booking;
use App\Helpers\CurrencyHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardService
{
    public function getDashboardData(Request $request = null): array
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $chartPeriod = $request?->get('chart_period', 6) ?? 6;
        $chartType = $request?->get('chart_type');

        return [
            'totalCustomers' => $this->getTotalCustomers(),
            'totalPartners' => $this->getTotalPartners(),
            'totalBookings' => $this->getTotalBookings($thirtyDaysAgo),
            'revenue' => $this->getRevenue($thirtyDaysAgo),
            'pendingVerifications' => 0,
            'recentBookings' => $this->getRecentBookings(),
            'monthlyStats' => $this->getMonthlyStats($chartPeriod, $chartType),
            'propertyTypes' => PropertyCategory::all()->toArray(),
        ];
    }

    private function getTotalCustomers(): int
    {
        return User::whereDoesntHave('partner')->count();
    }

    private function getTotalPartners(): int
    {
        return Partner::count();
    }

    private function getTotalBookings(Carbon $since): int
    {
        return Booking::where('created_at', '>=', $since)->count();
    }

    private function getRevenue(Carbon $since): float
    {
        $bookings = Booking::where('created_at', '>=', $since)
            ->select('total_price', 'currency')
            ->get();
        
        $totalUsd = 0.0;
        foreach ($bookings as $booking) {
            $usdAmount = CurrencyHelper::convertPrice(
                (float) $booking->total_price, 
                $booking->currency ?? 'USD', 
                'USD'
            );
            $totalUsd += (float) $usdAmount;
        }
        
        return (float) $totalUsd;
    }

    private function getPendingVerifications(): int
    {
        // Return 0 until verification system is properly implemented
        // The partners table doesn't have is_verified column yet
        return 0;
    }

    private function getRecentBookings(): array
    {
        return Booking::with(['user', 'property'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($booking) => [
                'id' => 'BK-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
                'customer_name' => $booking->user->name ?? 'N/A',
                'property_name' => $booking->property?->title ?? 'N/A',
                'date' => $booking->created_at->format('Y-m-d'),
                'status' => ucfirst($booking->status),
                'amount' => (float) CurrencyHelper::convertPrice(
                    (float) $booking->total_price, 
                    $booking->currency ?? 'USD', 
                    'USD'
                ),
                'original_amount' => (float) $booking->total_price,
                'original_currency' => $booking->currency ?? 'USD',
            ])->toArray();
    }

    private function getMonthlyStats(int $period = 6, ?string $propertyType = null): array
    {
        $months = collect(range($period, 0))->map(fn ($i) => Carbon::now()->subMonths($i)->startOfMonth());

        $labels = $months->map(fn ($date) => $date->format('M Y'));
        
        $bookings = $months->map(function ($date) use ($propertyType) {
            $query = Booking::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year);
            if ($propertyType) {
                $query->whereHas('property', fn($q) => $q->where('category_id', $propertyType));
            }
            return $query->count();
        });
        
        $cancellations = $months->map(function ($date) use ($propertyType) {
            $query = Booking::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->where('status', 'cancelled');
            if ($propertyType) {
                $query->whereHas('property', fn($q) => $q->where('category_id', $propertyType));
            }
            return $query->count();
        });

        return [
            'labels' => $labels->values()->toArray(),
            'bookings' => $bookings->values()->toArray(),
            'cancellations' => $cancellations->values()->toArray(),
        ];
    }
}
