<?php

namespace App\Http\Controllers\CarReservations;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class CarMessageController extends Controller
{
    public function index()
    {
        $renter = Auth::guard('car_renter')->user();

        // Conversations grouped by reservation
        $conversations = Reservation::whereHas('car', function ($q) use ($renter) {
                $q->where('car_renter_id', $renter->id);
            })
            ->with(['user', 'messages' => function ($q) {
                $q->latest();
            }])
            ->get()
            ->map(function ($r) {
                $lastMessage = $r->messages->first();

                return [
                    'booking_id' => $r->id,
                    'customer_name' => $r->user->name ?? 'Guest',
                    'property_name' => $r->car->name ?? 'Car',
                    'last_message' => $lastMessage?->content ?? 'No messages yet',
                    'time_ago' => $lastMessage?->created_at?->diffForHumans() ?? '',
                    'unread' => 0,
                ];
            });

        return view('car_rentals.messages.index', compact('conversations'));
    }

    public function show(Reservation $booking)
    {
        $messages = Message::where('booking_id', $booking->id)
            ->orderBy('created_at')
            ->get();

        return view('car_rentals.messages.conversation', compact('booking', 'messages'));
    }

    public function store()
    {
        $message = Message::create([
            'booking_id' => request('booking_id'),
            'sender_id' => Auth::guard('car_renter')->id(),
            'sender_type' => 'car_renter',
            'content' => request('content'),
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
