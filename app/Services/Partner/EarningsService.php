<?php

namespace App\Services\Partner;

use App\Models\Booking;
use App\Models\Payout;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EarningsService
{
    public function getTotalEarnings(): float
    {
        $bookings = Booking::whereHas('property', function ($query) {
            $query->where('user_id', Auth::id());
        })->get(['total_price', 'commission_rate', 'currency']);

        $total = 0;
        foreach ($bookings as $booking) {
            // Calculate net earnings after commission
            $commissionAmount = ($booking->total_price * ($booking->commission_rate ?? 10)) / 100;
            $netEarnings = $booking->total_price - $commissionAmount;

            $total += app(\App\Services\CurrencyService::class)->convert(
                $netEarnings,
                $booking->currency ?? 'USD',
                'USD'
            );
        }

        return $total;
    }

    public function getMonthlyEarnings(): float
    {
        $bookings = Booking::whereHas('property', function ($query) {
            $query->where('user_id', Auth::id());
        })->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->get(['total_price', 'commission_rate', 'currency']);

        $total = 0;
        foreach ($bookings as $booking) {
            // Calculate net earnings after commission
            $commissionAmount = ($booking->total_price * ($booking->commission_rate ?? 10)) / 100;
            $netEarnings = $booking->total_price - $commissionAmount;

            $total += app(\App\Services\CurrencyService::class)->convert(
                $netEarnings,
                $booking->currency ?? 'USD',
                'USD'
            );
        }

        return $total;
    }

    public function getPendingPayout(): float
    {
        // Get actual pending payouts from database
        return Payout::where('host_id', Auth::id())
            ->where('payout_status', 'pending')
            ->sum('amount');
    }

    public function getAverageBooking(): float
    {
        $total = $this->getTotalEarnings();
        $count = Booking::whereHas('property', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();

        return $count > 0 ? $total / $count : 0;
    }

    public function getTransactions(): array
    {
        return Booking::with(['user', 'property'])
            ->whereHas('property', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($booking) {
                // Calculate net earnings after commission
                $commissionAmount = ($booking->total_price * ($booking->commission_rate ?? 10)) / 100;
                $netEarnings = $booking->total_price - $commissionAmount;

                $convertedAmount = app(\App\Services\CurrencyService::class)->convert(
                    $netEarnings,
                    $booking->currency ?? 'USD',
                    'USD'
                );

                return [
                    'date' => $booking->created_at->format('M d, Y'),
                    'booking_id' => 'BK' . $booking->id,
                    'property' => $booking->property->title ?? 'Property',
                    'guest' => $booking->user->name ?? 'Guest',
                    'status' => ucfirst($booking->status ?? 'pending'),
                    'amount' => $convertedAmount,
                    'commission' => $commissionAmount,
                    'gross_amount' => $booking->total_price ?? 0,
                    'original_currency' => $booking->currency ?? 'USD'
                ];
            })->toArray();
    }

    public function getChartData(): array
    {
        $partnerId = Auth::id();

        $bookings = Booking::whereHas('property', function ($query) use ($partnerId) {
            $query->where('user_id', $partnerId);
        })->selectRaw('MONTH(created_at) as month, total_price, currency')
            ->whereYear('created_at', Carbon::now()->year)
            ->get();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $earnings = array_fill(0, 12, 0);

        foreach ($bookings as $booking) {
            // Calculate net earnings after commission
            $commissionAmount = ($booking->total_price * ($booking->commission_rate ?? 10)) / 100;
            $netEarnings = $booking->total_price - $commissionAmount;

            $convertedAmount = app(\App\Services\CurrencyService::class)->convert(
                $netEarnings,
                $booking->currency ?? 'USD',
                'USD'
            );
            $earnings[$booking->month - 1] += $convertedAmount;
        }

        return [
            'labels' => $labels,
            'earnings' => $earnings
        ];
    }
}
