<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    /**
     * Display pending and recent payouts
     */
    public function index()
    {
        $pendingPayouts = Payout::with(['booking.property', 'host'])
            ->where('payout_status', 'pending')
            ->latest()
            ->paginate(20);

        $recentPayouts = Payout::with(['booking.property', 'host'])
            ->whereIn('payout_status', ['processing', 'completed', 'failed'])
            ->latest()
            ->paginate(10);

        $stats = [
            'pending_count' => Payout::where('payout_status', 'pending')->count(),
            'pending_amount' => Payout::where('payout_status', 'pending')->sum('amount'),
            'completed_this_month' => Payout::where('payout_status', 'completed')
                ->whereMonth('payout_date', now()->month)
                ->whereYear('payout_date', now()->year)
                ->count(),
            'completed_amount_this_month' => Payout::where('payout_status', 'completed')
                ->whereMonth('payout_date', now()->month)
                ->whereYear('payout_date', now()->year)
                ->sum('amount'),
        ];

        return view('admin.payouts.index', compact('pendingPayouts', 'recentPayouts', 'stats'));
    }

    /**
     * Show single payout details
     */
    public function show(Payout $payout)
    {
        $payout->load(['booking.property', 'booking.user', 'host']);

        return view('admin.payouts.show', compact('payout'));
    }

    /**
     * Mark payout as processing
     */
    public function process(Payout $payout)
    {
        if (!$payout->canBeProcessed()) {
            return back()->with('error', 'This payout cannot be processed. Ensure the booking payment is completed.');
        }

        $payout->markAsProcessing();

        return back()->with('success', 'Payout marked as processing. Complete the payment via your payment gateway.');
    }

    /**
     * Mark payout as completed with transaction reference
     */
    public function complete(Request $request, Payout $payout)
    {
        $request->validate([
            'transaction_reference' => 'required|string|max:255'
        ]);

        $payout->markAsCompleted($request->transaction_reference);

        // Update booking commission status
        if ($payout->booking) {
            $payout->booking->update(['commission_status' => 'paid']);
        }

        return back()->with('success', 'Payout marked as completed successfully!');
    }

    /**
     * Mark payout as failed
     */
    public function fail(Request $request, Payout $payout)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255'
        ]);

        $payout->markAsFailed($request->reason);

        return back()->with('error', 'Payout marked as failed.');
    }

    /**
     * Bulk process payouts
     */
    public function bulkProcess(Request $request)
    {
        $request->validate([
            'payout_ids' => 'required|array',
            'payout_ids.*' => 'exists:payouts,id'
        ]);

        $count = 0;
        foreach ($request->payout_ids as $payoutId) {
            $payout = Payout::find($payoutId);
            if ($payout && $payout->canBeProcessed()) {
                $payout->markAsProcessing();
                $count++;
            }
        }

        return back()->with('success', "Successfully marked {$count} payout(s) as processing.");
    }
}
