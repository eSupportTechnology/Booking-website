<?php

namespace App\Services\Admin;

use App\Models\Property;
use App\Models\Partner;
use App\Models\Customer;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardService
{
    public function getDashboardStats(): array
    {
        return [
            'totalProperties' => Property::count(),
            'totalPartners' => Partner::count(),
            'totalCustomers' => Customer::count(),
            'totalBookings' => Booking::count(),
            'newPropertiesThisMonth' => Property::whereMonth('created_at', now()->month)->count(),
            'newPartnersThisMonth' => Partner::whereMonth('created_at', now()->month)->count(),
            'newCustomersThisMonth' => Customer::whereMonth('created_at', now()->month)->count(),
            'newBookingsThisMonth' => Booking::whereMonth('created_at', now()->month)->count(),
            'pendingApprovals' => Property::where('status', 'pending')->count(),
        ];
    }

    public function getPendingProperties(array $filters = []): LengthAwarePaginator
    {
        $query = Property::with(['partner', 'photos'])
            ->where('status', 'pending')
            ->latest();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhereHas('partner', function ($q) use ($filters) {
                      $q->where('name', 'like', "%{$filters['search']}%")
                        ->orWhere('email', 'like', "%{$filters['search']}%");
                  });
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        return $query->paginate(9);
    }

    public function getRecentPendingProperties(int $limit = 5): Collection
    {
        return Property::with(['partner', 'photos'])
            ->where('status', 'pending')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getPropertyTypeStats(): array
    {
        return [
            'hotels' => Property::where('type', 'hotel')->count(),
            'apartments' => Property::where('type', 'apartment')->count(),
            'homes' => Property::where('type', 'home')->count(),
            'alternative' => Property::where('type', 'alternative')->count(),
        ];
    }

    public function getMonthlyBookingStats(): array
    {
        $months = collect(range(1, 12))->map(function($month) {
            return [
                'month' => now()->month($month)->format('M'),
                'count' => Booking::whereMonth('created_at', $month)
                    ->whereYear('created_at', now()->year)
                    ->count()
            ];
        });

        return [
            'labels' => $months->pluck('month'),
            'data' => $months->pluck('count'),
        ];
    }
}
