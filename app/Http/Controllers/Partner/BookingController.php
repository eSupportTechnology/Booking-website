<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function manage()
    {
        $bookings = Booking::with(['user', 'property'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('partner.bookings.manage', compact('bookings'));
    }
}