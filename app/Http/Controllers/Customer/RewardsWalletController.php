<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\CurrencyManager;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardsWalletController extends Controller
{
    public function index()
    {
        $user = Auth::guard('customer')->user();

        // Get user's selected currency
        $currency = app(CurrencyManager::class)->getUserCurrency();
        $currencyService = app(CurrencyService::class);

        // Calculate wallet balance from completed bookings
        $walletData = $this->calculateWalletData($user);

        // Get recent wallet activity
        $recentActivity = $this->getRecentActivity($user);

        return view('Customer.rewards-wallet', compact('user', 'walletData', 'recentActivity', 'currency', 'currencyService'));
    }

    private function calculateWalletData($user)
    {
        // Get completed bookings to calculate potential rewards
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Simple rewards calculation: 1% cashback on completed bookings
        $totalSpent = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_price');

        $credits = round($totalSpent * 0.01, 2); // 1% cashback as credits

        return [
            'balance' => $credits,
            'credits' => $credits,
            'vouchers' => 0,
            'voucher_count' => 0,
            'pending_rewards' => 0,
            'total_earned' => $credits,
            'total_spent' => 0,
            'completed_bookings' => $completedBookings,
        ];
    }

    private function getRecentActivity($user)
    {
        // Get recent booking activity for rewards tracking
        return Booking::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'confirmed'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($booking) {
                $reward = round($booking->total_price * 0.01, 2);
                return [
                    'type' => $booking->status === 'completed' ? 'earned' : 'pending',
                    'description' => 'Booking at ' . ($booking->property->title ?? 'Property'),
                    'amount' => $reward,
                    'date' => $booking->created_at,
                    'status' => $booking->status,
                ];
            });
    }

    public function addCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ]);

        // Placeholder for coupon validation logic
        // In a real system, you'd validate against a coupons table

        return back()->with('error', 'Invalid coupon code. Please try again.');
    }
}
