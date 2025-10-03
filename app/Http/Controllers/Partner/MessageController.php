<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Actions\Partner\GetMessagesDataAction;
use App\Services\Partner\MessageService;
use App\Models\Booking;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct(
        private MessageService $messageService
    ) {}

    public function index(GetMessagesDataAction $action)
    {
        $data = $action->execute();
        
        return view('partner.messages.index', $data);
    }

    public function conversation($bookingId)
    {
        $booking = Booking::with(['user', 'property'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($bookingId);

        $messages = Message::with(['sender', 'receiver'])
            ->forBooking($bookingId)
            ->orderBy('created_at')
            ->get();

        $this->messageService->markAsRead($bookingId);

        return view('partner.messages.conversation', compact('booking', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'content' => 'required|string|max:1000'
        ]);

        $message = $this->messageService->sendMessage(
            $request->booking_id,
            $request->content
        );

        return response()->json([
            'success' => true,
            'message' => $message->load('sender')
        ]);
    }

    public function updateBookingStatus(Request $request, $bookingId)
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