<?php

namespace App\Services\Partner;

use App\Models\Message;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    public function getConversations(): array
    {
        return Booking::with(['user', 'property', 'messages'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereHas('messages')
            ->latest()
            ->get()
            ->map(function($booking) {
                $lastMessage = $booking->messages()->latest()->first();
                return [
                    'id' => $booking->id,
                    'guest_name' => $booking->user->name ?? 'Guest',
                    'property_name' => $booking->property->title ?? 'Property',
                    'last_message' => $lastMessage ? $lastMessage->content : 'No messages yet',
                    'time_ago' => $lastMessage ? $lastMessage->created_at->diffForHumans() : $booking->created_at->diffForHumans(),
                    'unread' => $booking->messages()->where('receiver_id', Auth::id())->where('is_read', false)->count()
                ];
            })->toArray();
    }

    public function getActiveConversation(): ?array
    {
        $booking = Booking::with(['user', 'property', 'messages.sender'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->whereHas('messages')
            ->first();

        if (!$booking) return null;

        return [
            'booking_id' => $booking->id,
            'guest_name' => $booking->user->name ?? 'Guest',
            'property_name' => $booking->property->title ?? 'Property',
            'messages' => $booking->messages->map(function($message) {
                return [
                    'id' => $message->id,
                    'content' => $message->content,
                    'sender_type' => $message->sender_id == Auth::id() ? 'host' : 'guest',
                    'sender_name' => $message->sender->name ?? 'User',
                    'time' => $message->created_at->diffForHumans(),
                    'is_read' => $message->is_read
                ];
            })->toArray()
        ];
    }

    public function getUnreadCount(): int
    {
        try {
            return Message::whereHas('booking.property', function($query) {
                $query->where('user_id', Auth::id());
            })->where('receiver_id', Auth::id())->where('is_read', false)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function sendMessage(int $bookingId, string $content): Message
    {
        $booking = Booking::whereHas('property', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($bookingId);

        return Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $booking->user_id,
            'booking_id' => $bookingId,
            'content' => $content,
            'is_read' => false
        ]);
    }

    public function markAsRead(int $bookingId): void
    {
        Message::where('booking_id', $bookingId)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);
    }
}