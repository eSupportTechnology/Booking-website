<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarRenter;
use Illuminate\Http\Request;
use App\Models\CarType;
use App\Models\VehicleTypeCommission;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\TaxiBooking;
use App\Models\TaxiTypeCommission;
use App\Models\TaxiType;

class UsersController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!auth('admin')->user()->can('view_rental_providers')) {
            abort(403, 'You do not have permission to view rental service providers.');
        }
        $query = CarRenter::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by account type
        if ($request->filled('account_type')) {
            $query->where('account_type', $request->account_type);
        }

        $providers = $query->withCount(['cars', 'taxis'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('admin.admin-RentalServiceProviders', compact('providers'));
    }

    public function show(CarRenter $provider)
{
    if (!auth('admin')->user()->can('view_rental_providers')) {
        abort(403);
    }

    // Taxi Types
    $taxiTypes = TaxiType::orderBy('name')->get();

    // Taxi commissions
    $taxiCommissions = TaxiTypeCommission::where('car_renter_id', $provider->id)
        ->get()
        ->keyBy('taxi_type_id');


    // Load cars & taxis
    $provider->load([
        'cars.carType',
        'taxis.type'
    ]);

    // Vehicle types
    $vehicleTypes = CarType::orderBy('name')->get();

    // Commission per vehicle type
    $commissions = VehicleTypeCommission::where('car_renter_id', $provider->id)
        ->get()
        ->keyBy('vehicle_type_id');

    // ✅ Get all car IDs owned by this provider
    $carIds = $provider->cars->pluck('id');
    $taxiIds = $provider->taxis->pluck('id');

    // =======================
    // 💰 Earnings Calculations
    // =======================

    // Total Earnings
    $totalEarnings = Reservation::whereIn('car_id', $carIds)
        ->where('status', 'completed')
        ->sum('total_price');

    // This Month Earnings
    $monthlyEarnings = Reservation::whereIn('car_id', $carIds)
        ->where('status', 'completed')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_price');

    // Monthly earnings grouped by month (for chart)
    $earningsByMonth = Reservation::whereIn('car_id', $carIds)
        ->where('status', 'completed')
        ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
        ->groupByRaw('MONTH(created_at)')
        ->pluck('total', 'month');


    // Pending Payouts
    $carPendingPayouts = Reservation::with(['car.carType'])
    ->whereIn('car_id', $carIds)
    ->where('status', 'completed')
    ->where('payment_status', 'pending')
    ->get()
    ->sum(function ($reservation) use ($commissions) {

        $typeId = optional($reservation->car->carType)->id;
        $rate   = $commissions[$typeId]->commission_rate ?? 15;

        $adminCut = ($reservation->total_price * $rate) / 100;

        return $reservation->total_price - $adminCut;
    });

    $taxiPendingPayouts = TaxiBooking::with(['taxi.type'])
        ->whereIn('taxi_id', $taxiIds)
        ->where('status', 'completed')
        ->where('payment_status', 'pending')
        ->get()
        ->sum(function ($booking) use ($taxiCommissions) {

            $typeId = $booking->taxi->type_id ?? null;
            $rate   = $taxiCommissions[$typeId]->commission_rate ?? 15;

            $adminCut = ($booking->total_amount * $rate) / 100;
            return $booking->total_amount - $adminCut;
        });

    $pendingPayouts = $carPendingPayouts + $taxiPendingPayouts;


    // Completed Payouts
    $completedPayouts = Reservation::whereIn('car_id', $carIds)
        ->where('status', 'completed')
        ->where('payment_status', 'paid')
        ->sum('total_price');
    
    // =======================
    // 📋 Completed Reservations (Detailed)
    // =======================

    $completedReservations = Reservation::with(['car.carType'])
        ->whereIn('car_id', $carIds)
        ->where('status', 'completed')
        ->orderByDesc('created_at')
        ->get()
        ->map(function ($reservation) use ($commissions) {

            $vehicleTypeId = optional($reservation->car->carType)->id;

            // Commission rate (fallback to default 15%)
            $commissionRate = $commissions[$vehicleTypeId]->commission_rate ?? 15;

            $commissionAmount = ($reservation->total_price * $commissionRate) / 100;
            $providerEarning  = $reservation->total_price - $commissionAmount;

            return [
                'id'                => $reservation->id,
                'vehicle'           => $reservation->car->name ?? 'Car #' . $reservation->car_id,
                'vehicle_type'      => $reservation->car->carType->name ?? 'N/A',
                'start_date'        => $reservation->start_date,
                'end_date'          => $reservation->end_date,
                'total_price'       => $reservation->total_price,
                'commission_rate'   => $commissionRate,
                'commission_amount' => $commissionAmount,
                'provider_earning'  => $providerEarning,
                'created_at'        => $reservation->created_at,
            ];
        });

    // =======================
    // 💼 Admin Earnings
    // =======================

    $adminTotalEarnings = $completedReservations->sum('commission_amount');

    $adminMonthlyEarnings = $completedReservations
        ->filter(fn ($r) => Carbon::parse($r['created_at'])->isCurrentMonth())
        ->sum('commission_amount');

    // =======================
// 🚕 Taxi Booking Earnings
// =======================

// Completed Taxi Bookings
$completedTaxiBookings = TaxiBooking::whereIn('taxi_id', $taxiIds)
    ->where('status', 'completed')
    ->with(['taxi'])
    ->orderBy('created_at', 'desc')
    ->get();

// Taxi Total Earnings
$taxiTotalEarnings = $completedTaxiBookings->sum('total_amount');

// Taxi Monthly Earnings
$taxiMonthlyEarnings = $completedTaxiBookings
    ->whereBetween('created_at', [
        now()->startOfMonth(),
        now()->endOfMonth()
    ])
    ->sum('total_amount');

// =======================
// 💰 Admin Taxi Commission
// =======================

$adminTaxiEarnings = 0;

foreach ($completedTaxiBookings as $booking) {
    $typeId = $booking->taxi->type_id ?? null;
    $rate   = $taxiCommissions[$typeId]->commission_rate ?? 15;

    $adminTaxiEarnings += ($booking->total_amount * $rate) / 100;
}




   $stats = [
    'total_earnings'        => $totalEarnings + $taxiTotalEarnings,
    'monthly_earnings'      => $monthlyEarnings + $taxiMonthlyEarnings,
    'pending_payouts'       => $pendingPayouts,
    'completed_payouts'     => $completedPayouts,
    // Chart data
    'earnings_by_month'     => $earningsByMonth,

    'admin_total_earnings'  => $adminTotalEarnings + $adminTaxiEarnings,
    'admin_monthly_earnings'=> $adminMonthlyEarnings + (
        $completedTaxiBookings
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum(fn($b) => 
    $b->total_amount * (($taxiCommissions[$b->taxi->type_id]->commission_rate ?? 15) / 100)
)

    ),
];



    $carIds = $provider->cars->pluck('id');

    if ($carIds->isEmpty()) {
        $stats = [
            'total_earnings' => 0,
            'monthly_earnings' => 0,
            'pending_payouts' => 0,
            'completed_payouts' => 0,
            'earnings_by_month' => collect(),
        ];
    }

    return view(
        'admin.admin-RentalServiceProviders-details',
        compact('provider', 'vehicleTypes', 'commissions', 'stats', 'completedReservations','completedTaxiBookings','taxiTypes',
        'taxiCommissions')
    );
}


}