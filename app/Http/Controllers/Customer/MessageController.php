<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = $this->getConversations();
        $unreadCount = $this->getUnreadCount();
        
        return view('Customer.messages.index', compact('conversations', 'unreadCount'));
    }

    public function conversation(Request $request, $bookingId)
    {
        $booking = Booking::with(['property', 'property.user'])
            ->where('user_id', Auth::guard('customer')->id())
            ->findOrFail($bookingId);

        $messages = Message::with(['sender', 'receiver'])
            ->forBooking($bookingId)
            ->orderBy('created_at')
            ->get();

        Message::where('booking_id', $bookingId)
            ->where('receiver_id', Auth::guard('customer')->id())
            ->update(['is_read' => true]);

        // Return partial for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return view('Customer.messages.conversation', compact('booking', 'messages'));
        }

        // Full page - return index with active conversation
        $conversations = $this->getConversations();
        $unreadCount = $this->getUnreadCount();

        return view('Customer.messages.index', compact('conversations', 'unreadCount', 'booking', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'content' => 'required|string|max:1000'
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', Auth::guard('customer')->id())
            ->firstOrFail();

        $message = Message::create([
            'sender_id' => Auth::guard('customer')->id(),
            'receiver_id' => $booking->property->user_id,
            'booking_id' => $request->booking_id,
            'content' => $request->content,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender')
        ]);
    }

    private function getConversations()
    {
        return Booking::with(['property', 'property.user'])
            ->where('user_id', Auth::guard('customer')->id())
            ->whereHas('messages')
            ->latest()
            ->get()
            ->map(function($booking) {
                $lastMessage = $booking->messages()->latest()->first();
                return [
                    'booking_id' => $booking->id,
                    'property_name' => $booking->property->title ?? 'Property',
                    'partner_name' => $booking->property->user->name ?? 'Host',
                    'last_message' => $lastMessage ? $lastMessage->content : 'No messages yet',
                    'time_ago' => $lastMessage ? $lastMessage->created_at->diffForHumans() : '',
                    'unread' => $booking->messages()->where('receiver_id', Auth::guard('customer')->id())->unread()->count()
                ];
            });
    }

    private function getUnreadCount()
    {
        return Message::whereHas('booking', function($query) {
            $query->where('user_id', Auth::guard('customer')->id());
        })->where('receiver_id', Auth::guard('customer')->id())->unread()->count();
    }
}