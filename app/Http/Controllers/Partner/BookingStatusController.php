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
            'status' => 'required|in:pending,confirmed,completed,cancelled,declined'
        ]);

        if ($booking->property->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update(['status' => $request->status]);

        if ($request->status === 'confirmed') {
            $this->messagingService->sendBookingConfirmedMessage($booking);
        } elseif ($request->status === 'completed') {
            $this->messagingService->sendBookingCompletedMessage($booking);
        } elseif ($request->status === 'cancelled') {
            $this->messagingService->sendBookingCancelledMessage($booking);
        }

        return response()->json(['success' => true, 'message' => 'Booking status updated successfully.']);
    }
}