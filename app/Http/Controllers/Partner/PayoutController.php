<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    /**
     * Display partner's payout history
     */
    public function index()
    {
        $payouts = Payout::where('host_id', Auth::id())
            ->with(['booking.property', 'booking.user'])
            ->latest()
            ->paginate(20);

        $stats = [
            'pending_amount' => Payout::where('host_id', Auth::id())
                ->where('payout_status', 'pending')
                ->sum('amount'),
            'processing_amount' => Payout::where('host_id', Auth::id())
                ->where('payout_status', 'processing')
                ->sum('amount'),
            'completed_this_month' => Payout::where('host_id', Auth::id())
                ->where('payout_status', 'completed')
                ->whereMonth('payout_date', now()->month)
                ->whereYear('payout_date', now()->year)
                ->sum('amount'),
            'total_earned' => Payout::where('host_id', Auth::id())
                ->where('payout_status', 'completed')
                ->sum('amount'),
            'pending_count' => Payout::where('host_id', Auth::id())
                ->where('payout_status', 'pending')
                ->count(),
        ];

        return view('partner.payouts.index', compact('payouts', 'stats'));
    }

    /**
     * Show single payout details
     */
    public function show(Payout $payout)
    {
        // Ensure payout belongs to authenticated partner
        if ($payout->host_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payout details.');
        }

        $payout->load(['booking.property', 'booking.user']);

        return view('partner.payouts.show', compact('payout'));
    }
}
