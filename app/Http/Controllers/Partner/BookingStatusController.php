<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\MessagingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingStatusController extends Controller
{
    public function __construct(private MessagingService $messagingService) {}

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:confirmed,declined'
        ]);

        if ($booking->property->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update(['status' => $request->status]);

        if ($request->status === 'confirmed') {
            $this->messagingService->sendBookingConfirmedMessage($booking);
        }

        return back()->with('success', 'Booking status updated successfully.');
    }
}