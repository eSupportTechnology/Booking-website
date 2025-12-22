<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\TaxiBooking;
use App\Models\VehicleTypeCommission;
use App\Models\TaxiTypeCommission;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CarEarningsController extends Controller
{
    public function index()
    {
        $renterId = Auth::guard('car_renter')->id();

        /* =======================
           RAW EARNINGS
        ======================= */
        $carEarnings = Reservation::whereHas('car', function ($q) use ($renterId) {
                $q->where('car_renter_id', $renterId);
            })
            ->where('status', 'completed')
            ->sum('total_price');

        $taxiEarnings = TaxiBooking::whereHas('taxi', function ($q) use ($renterId) {
                $q->where('car_renter_id', $renterId);
            })
            ->where('status', 'completed')
            ->sum('total_amount');


        $grossEarnings = $carEarnings + $taxiEarnings;

        /* =======================
           COMMISSIONS
        ======================= */
        $carCommissionRate = VehicleTypeCommission::where('car_renter_id', $renterId)
            ->value('commission_rate') ?? 15;

        $taxiCommissionRate = TaxiTypeCommission::where('car_renter_id', $renterId)
            ->value('commission_rate') ?? 12;

        $carCommission = ($carEarnings * $carCommissionRate) / 100;
        $taxiCommission = ($taxiEarnings * $taxiCommissionRate) / 100;

        $totalCommission = $carCommission + $taxiCommission;
        $netEarnings = $grossEarnings - $totalCommission;

        /* =======================
           MONTHLY CHART
        ======================= */
       $labels = [];
        $earnings = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $carMonthly = Reservation::whereHas('car', function ($q) use ($renterId) {
                    $q->where('car_renter_id', $renterId);
                })
                ->where('status', 'completed')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_price');

            $taxiMonthly = TaxiBooking::whereHas('taxi', function ($q) use ($renterId) {
                    $q->where('car_renter_id', $renterId);
                })
                ->where('status', 'completed')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_amount');

            $labels[] = $month->format('M Y');
            $earnings[] = $carMonthly + $taxiMonthly;
        }

        /* =======================
        RECENT TRANSACTIONS
        ======================= */

        // Car transactions
        $carTransactions = Reservation::whereHas('car', function ($q) use ($renterId) {
                $q->where('car_renter_id', $renterId);
            })
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($r) {
                return [
                    'date' => $r->created_at->format('M d, Y'),
                    'booking_id' => 'CAR-' . $r->id,
                    'car' => $r->car->name ?? 'Car',
                    'amount' => $r->total_price,
                ];
            });

        // Taxi transactions
        $taxiTransactions = TaxiBooking::whereHas('taxi', function ($q) use ($renterId) {
                $q->where('car_renter_id', $renterId);
            })
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($t) {
                return [
                    'date' => $t->created_at->format('M d, Y'),
                    'booking_id' => 'TAXI-' . $t->id,
                    'car' => $t->taxi->number_plate ?? 'Taxi',
                    'amount' => $t->total_amount,
                ];
            });

        // Merge & sort
        $transactions = $carTransactions
            ->merge($taxiTransactions)
            ->sortByDesc('date')
            ->values();



        return view('car_rentals.earnings_dashboard', compact(
            'carEarnings',
            'taxiEarnings',
            'grossEarnings',
            'carCommission',
            'taxiCommission',
            'totalCommission',
            'netEarnings',
            'carCommissionRate',
            'taxiCommissionRate',
            'labels',
            'earnings',
            'transactions'
        ));
    }

    /* =======================
       PDF INVOICE
    ======================= */
    public function invoice()
    {
        $renter = Auth::guard('car_renter')->user();

        $data = $this->index()->getData();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'car_rentals.invoice_pdf',
            array_merge((array) $data, ['renter' => $renter])
        );

        return $pdf->download('earnings-invoice-' . now()->format('Y-m-d') . '.pdf');
    }
}
