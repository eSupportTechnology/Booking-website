<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingStatusController extends Controller
{
    public function update(Request $request, $bookingId)
    {
        $request->validate([
            'status' => 'required|in:confirmed,cancelled,completed,pending'
        ]);

        $booking = Booking::whereHas('property', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($bookingId);

        $booking->status = $request->status;
        $booking->save();

        return response()->json([
            'success' => true,
            'message' => 'Booking status updated successfully',
            'status' => $request->status
        ]);
    }
}