<?php
// app/Services/Admin/DashboardService.php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Partner;
use App\Models\Property;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboardData(): array
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        return [
            'totalCustomers' => $this->getTotalCustomers(),
            'totalPartners' => $this->getTotalPartners(),
            'totalBookings' => $this->getTotalBookings($thirtyDaysAgo),
            'revenue' => $this->getRevenue($thirtyDaysAgo),
            'pendingVerifications' => 0, // Disabled until verification system is implemented
            'recentBookings' => $this->getRecentBookings(),
            'monthlyStats' => $this->getMonthlyStats(),
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
        return (float) Booking::where('created_at', '>=', $since)->sum('total_price');
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
                'amount' => number_format($booking->total_price, 2),
            ])->toArray();
    }

    private function getMonthlyStats(): array
    {
        $months = collect(range(6, 0))->map(fn ($i) => Carbon::now()->subMonths($i)->startOfMonth());

        $labels = $months->map(fn ($date) => $date->format('M Y'));
        $bookings = $months->map(fn ($date) => Booking::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count());
        $cancellations = $months->map(fn ($date) => Booking::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->where('status', 'cancelled')->count());
        $revenue = $months->map(fn ($date) => (float) Booking::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->sum('total_price'));

        return [
            'labels' => $labels->values()->toArray(),
            'bookings' => $bookings->values()->toArray(),
            'cancellations' => $cancellations->values()->toArray(),
            'revenue' => $revenue->values()->toArray(),
        ];
    }
}
