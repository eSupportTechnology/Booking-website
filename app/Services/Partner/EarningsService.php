<?php

namespace App\Services\Partner;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EarningsService
{
    public function getTotalEarnings(): float
    {
        return Booking::whereHas('property', function($query) {
            $query->where('user_id', Auth::id());
        })->sum('total_price') ?? 0;
    }

    public function getMonthlyEarnings(): float
    {
        return Booking::whereHas('property', function($query) {
            $query->where('user_id', Auth::id());
        })->whereMonth('created_at', Carbon::now()->month)
          ->whereYear('created_at', Carbon::now()->year)
          ->sum('total_price') ?? 0;
    }

    public function getPendingPayout(): float
    {
        return $this->getMonthlyEarnings() * 0.35;
    }

    public function getAverageBooking(): float
    {
        $total = $this->getTotalEarnings();
        $count = Booking::whereHas('property', function($query) {
            $query->where('user_id', Auth::id());
        })->count();
        
        return $count > 0 ? $total / $count : 0;
    }

    public function getTransactions(): array
    {
        return Booking::with(['user', 'property'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($booking) {
                return [
                    'date' => $booking->created_at->format('M d, Y'),
                    'booking_id' => 'BK' . $booking->id,
                    'property' => $booking->property->title ?? 'Property',
                    'guest' => $booking->user->name ?? 'Guest',
                    'status' => ucfirst($booking->status ?? 'pending'),
                    'amount' => $booking->total_price ?? 0
                ];
            })->toArray();
    }
}