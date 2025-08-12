<?php

namespace App\Services\Partner;

use App\Models\Message;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    public function getConversations(): array
    {
        return Booking::with(['user', 'property'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->limit(10)
            ->get()
            ->map(function($booking) {
                return [
                    'id' => $booking->id,
                    'guest_name' => $booking->user->name ?? 'Guest',
                    'property_name' => $booking->property->title ?? 'Property',
                    'last_message' => 'Booking confirmed',
                    'time_ago' => $booking->created_at->diffForHumans(),
                    'unread' => 0
                ];
            })->toArray();
    }

    public function getActiveConversation(): ?array
    {
        $booking = Booking::with(['user', 'property'])
            ->whereHas('property', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->first();

        if (!$booking) return null;

        return [
            'booking_id' => $booking->id,
            'guest_name' => $booking->user->name ?? 'Guest',
            'property_name' => $booking->property->title ?? 'Property',
            'messages' => [
                [
                    'id' => 1,
                    'message' => 'Hi! What time is check-in for tomorrow?',
                    'sender' => 'guest',
                    'time' => '2h ago'
                ],
                [
                    'id' => 2,
                    'message' => 'Check-in is from 3:00 PM onwards. I\'ll be available to meet you at the property.',
                    'sender' => 'host',
                    'time' => '1h ago'
                ]
            ]
        ];
    }

    public function getUnreadCount(): int
    {
        try {
            return Message::whereHas('booking.property', function($query) {
                $query->where('user_id', Auth::id());
            })->where('is_read', false)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}