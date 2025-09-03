<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class PartnerViewController extends Controller
{
    public function show($partner_id)
    {
        // Validate the ID exists
        Validator::make(['partner_id' => $partner_id], [
            'partner_id' => 'required|integer|exists:users,id'
        ])->validate();

        $partner = User::with([
            'partner',
            'properties' => function($query) {
                $query->with([
                    'accommodation.businessEntities',
                    'accommodation.individuals',
                    'category',
                    'propertySubcategory',
                    'photos',
                    'reviews'
                ]);
            }
        ])
        ->whereHas('partner')
        ->findOrFail($partner_id);

        // Calculate financial stats
        $stats = $this->getFinancialStats($partner_id);

        // Calculate property stats
        $propertyStats = $this->getPropertyStats($partner->properties);

        // Get latest bookings
        $latestBookings = $this->getLatestBookings($partner_id);

        // Get payout history (empty array for now, implement when payout system is ready)
        $payoutHistory = [];

        return view('admin.admin-partner-view', compact('partner', 'stats', 'propertyStats', 'latestBookings', 'payoutHistory'));
    }

    protected function getFinancialStats($partner_id)
    {
        $now = Carbon::now();

        return [
            'total_earnings' => Booking::whereHas('property', function($query) use ($partner_id) {
                $query->where('user_id', $partner_id);
            })->sum('total_price') ?? 0,

            'monthly_earnings' => Booking::whereHas('property', function($query) use ($partner_id) {
                $query->where('user_id', $partner_id);
            })
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total_price') ?? 0,

            'pending_payouts' => 0, // Implement when payout system is ready
            'completed_payouts' => 0, // Implement when payout system is ready

            'earnings_by_month' => $this->getMonthlyEarnings($partner_id)
        ];
    }

    protected function getPropertyStats($properties)
    {
        $totalProperties = $properties->count();
        $activeProperties = $properties->where('status', 'active')->count();

        $propertiesByCategory = $properties->groupBy('category.name')
            ->map(fn($items) => $items->count())
            ->toArray();

        $averageRating = $properties->flatMap->reviews->avg('rating') ?? 0;

        return [
            'total_properties' => $totalProperties,
            'active_properties' => $activeProperties,
            'by_category' => $propertiesByCategory,
            'average_rating' => round($averageRating, 1)
        ];
    }

    protected function getLatestBookings($partner_id)
    {
        return Booking::whereHas('property', function($query) use ($partner_id) {
            $query->where('user_id', $partner_id);
        })
        ->with(['property', 'user'])
        ->latest()
        ->limit(10)
        ->get()
        ->map(function($booking) {
            return [
                'id' => $booking->id,
                'property_name' => $booking->property->title ?? 'N/A',
                'guest_name' => $booking->user->name ?? 'N/A',
                'check_in' => $booking->check_in,
                'check_out' => $booking->check_out,
                'total_amount' => $booking->total_price,
                'status' => $booking->status,
            ];
        })
        ->toArray();
    }

    protected function getMonthlyEarnings($partner_id)
    {
        $currentYear = Carbon::now()->year;

        return Booking::whereHas('property', function($query) use ($partner_id) {
            $query->where('user_id', $partner_id);
        })
        ->whereYear('created_at', $currentYear)
        ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
        ->groupBy('month')
        ->get()
        ->pluck('total', 'month')
        ->toArray();
    }
}
