<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\Partner\EarningsService;

class AdminPartnerDetailsController extends Controller
{
    protected $earningsService;

    public function __construct(EarningsService $earningsService)
    {
        $this->earningsService = $earningsService;
    }

    /**
     * Show detailed partner information including financial data
     */
    public function show($partner_id)
    {
        // Get partner with related data
        $partner = User::with([
            'partner',
            'partnerPersonalDetail',
            'properties.category',
            'properties.propertySubcategory',
            'properties.photos',
            'properties.pricing',
            'properties.accommodation.businessEntities',
            'properties.accommodation.individuals',
        ])->findOrFail($partner_id);

        // Get financial stats
        $stats = $this->getFinancialStats($partner_id);

        // Get property stats
        $propertyStats = $this->getPropertyStats($partner->properties);

        // Get latest bookings
        $latestBookings = $this->getLatestBookings($partner_id);

        // Get payout history
        $payoutHistory = $this->getPayoutHistory($partner_id);

        return view('admin.partner-details', compact(
            'partner',
            'stats',
            'propertyStats',
            'latestBookings',
            'payoutHistory'
        ));
    }

    /**
     * Get financial statistics for the partner
     */
    protected function getFinancialStats($partner_id)
    {
        $user = User::findOrFail($partner_id);

        // Calculate earnings for different periods
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        return [
            'total_earnings' => Booking::whereHas('property', function($query) use ($partner_id) {
                $query->where('user_id', $partner_id);
            })->sum('total_price'),

            'monthly_earnings' => Booking::whereHas('property', function($query) use ($partner_id) {
                $query->where('user_id', $partner_id);
            })->whereYear('created_at', $currentYear)
              ->whereMonth('created_at', $currentMonth)
              ->sum('total_price'),

            'pending_payouts' => Payout::where('host_id', $partner_id)
                ->where('payout_status', 'pending')
                ->sum('amount'),

            'completed_payouts' => Payout::where('host_id', $partner_id)
                ->where('payout_status', 'completed')
                ->sum('amount'),

            'earnings_by_month' => $this->getMonthlyEarnings($partner_id),
        ];
    }

    /**
     * Get property-related statistics
     */
    protected function getPropertyStats($properties)
    {
        $totalProperties = $properties->count();
        $activeProperties = $properties->where('status', 'active')->count();

        $propertiesByCategory = $properties->groupBy('category.name')
            ->map(fn($items) => $items->count());

        $averageRating = $properties->flatMap->reviews->avg('rating') ?? 0;

        return [
            'total_properties' => $totalProperties,
            'active_properties' => $activeProperties,
            'by_category' => $propertiesByCategory,
            'average_rating' => round($averageRating, 1),
        ];
    }

    /**
     * Get latest bookings for the partner
     */
    protected function getLatestBookings($partner_id)
    {
        return Booking::whereHas('property', function($query) use ($partner_id) {
            $query->where('user_id', $partner_id);
        })->with(['property', 'user'])
          ->latest()
          ->limit(10)
          ->get()
          ->map(function($booking) {
            return [
                'id' => $booking->id,
                'property_name' => $booking->property->name ?? 'N/A',
                'guest_name' => $booking->user->name ?? 'N/A',
                'check_in' => $booking->check_in,
                'check_out' => $booking->check_out,
                'total_amount' => $booking->total_price,
                'status' => $booking->status,
                'created_at' => $booking->created_at,
            ];
        });
    }

    /**
     * Get payout history for the partner
     */
    protected function getPayoutHistory($partner_id)
    {
        return Payout::where('host_id', $partner_id)
            ->with('booking')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($payout) {
                return [
                    'id' => $payout->id,
                    'amount' => $payout->amount,
                    'status' => $payout->payout_status,
                    'method' => $payout->payout_method,
                    'date' => $payout->payout_date,
                    'booking_id' => $payout->booking_id,
                    'transaction_ref' => $payout->transaction_reference,
                ];
            });
    }

    /**
     * Get monthly earnings for the current year
     */
    protected function getMonthlyEarnings($partner_id)
    {
        $currentYear = Carbon::now()->year;

        return Booking::whereHas('property', function($query) use ($partner_id) {
            $query->where('user_id', $partner_id);
        })->whereYear('created_at', $currentYear)
          ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
          ->groupBy('month')
          ->get()
          ->pluck('total', 'month')
          ->all();
    }

    /**
     * Toggle partner account status
     */
    public function toggleStatus(Request $request, $partner_id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending'
        ]);

        $partner = Partner::where('user_id', $partner_id)->firstOrFail();
        $partner->update([
            'is_verified' => $request->status === 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Partner status updated successfully'
        ]);
    }

    /**
     * Get financial data filtered by date range
     */
    public function getFinancialData(Request $request, $partner_id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $earnings = Booking::whereHas('property', function($query) use ($partner_id) {
            $query->where('user_id', $partner_id);
        })->whereBetween('created_at', [$startDate, $endDate])
          ->sum('total_price');

        $payouts = Payout::where('host_id', $partner_id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy('payout_status')
            ->map(fn($group) => $group->sum('amount'));

        return response()->json([
            'earnings' => $earnings,
            'payouts' => $payouts
        ]);
    }
}
