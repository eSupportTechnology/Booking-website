<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereHas('messages')
            ->latest()
            ->get()
            ->map(function($booking) {
                $lastMessage = $booking->messages()->latest()->first();
                return [
                    'booking_id' => $booking->id,
                    'property_name' => $booking->property->title ?? 'Property',
                    'customer_name' => $booking->user->name ?? 'Guest',
                    'last_message' => $lastMessage ? $lastMessage->content : 'No messages yet',
                    'time_ago' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'unread' => $booking->messages()->where('receiver_id', Auth::id())->unread()->count()
                ];
            });

        return view('partner.messages.index', compact('conversations'));
    }

    public function conversation($bookingId)
    {
        $booking = Booking::with(['property', 'user'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($bookingId);

        $messages = Message::with(['sender', 'receiver'])
            ->forBooking($bookingId)
            ->orderBy('created_at')
            ->get();

        Message::where('booking_id', $bookingId)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);

        return view('partner.messages.conversation', compact('booking', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'content' => 'required|string|max:1000'
        ]);

        $booking = Booking::whereHas('property', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($request->booking_id);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $booking->user_id,
            'booking_id' => $request->booking_id,
            'content' => $request->content,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender')
        ]);
    }
}