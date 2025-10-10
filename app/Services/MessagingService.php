<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Booking;

class MessagingService
{
    public function sendBookingCreatedMessage(Booking $booking): void
    {
        $content = "New booking received!\n\n";
        $content .= "Property: {$booking->property->title}\n";
        $content .= "Guest: {$booking->user->name}\n";
        $content .= "Check-in: {$booking->check_in->format('M d, Y')}\n";
        $content .= "Check-out: {$booking->check_out->format('M d, Y')}\n";
        $content .= "Guests: {$booking->guest_count}\n";
        if ($booking->room) {
            $content .= "Room: {$booking->room->name}\n";
        }
        $content .= "Total: LKR " . number_format($booking->total_price) . "\n\n";
        $content .= "Please confirm or decline this booking.";

        Message::create([
            'sender_id' => $booking->user_id,
            'receiver_id' => $booking->property->user_id,
            'booking_id' => $booking->id,
            'content' => $content,
            'is_read' => false
        ]);
    }

    public function sendBookingConfirmedMessage(Booking $booking): void
    {
        $content = "Your booking has been confirmed!\n\n";
        $content .= "Property: {$booking->property->title}\n";
        $content .= "Check-in: {$booking->check_in->format('M d, Y')}\n";
        $content .= "Check-out: {$booking->check_out->format('M d, Y')}\n";
        $content .= "Guests: {$booking->guest_count}\n";
        if ($booking->room) {
            $content .= "Room: {$booking->room->name}\n";
        }
        $content .= "Total: LKR " . number_format($booking->total_price) . "\n\n";
        $content .= "We look forward to hosting you!";

        Message::create([
            'sender_id' => $booking->property->user_id,
            'receiver_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'content' => $content,
            'is_read' => false
        ]);
    }

    public function sendBookingCompletedMessage(Booking $booking): void
    {
        $content = "Your booking has been completed!\n\n";
        $content .= "Property: {$booking->property->title}\n";
        $content .= "Check-in: {$booking->check_in->format('M d, Y')}\n";
        $content .= "Check-out: {$booking->check_out->format('M d, Y')}\n";
        $content .= "Thank you for staying with us! We hope you enjoyed your visit.";

        Message::create([
            'sender_id' => $booking->property->user_id,
            'receiver_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'content' => $content,
            'is_read' => false
        ]);
    }

    public function sendBookingCancelledMessage(Booking $booking): void
    {
        $content = "Your booking has been cancelled.\n\n";
        $content .= "Property: {$booking->property->title}\n";
        $content .= "Check-in: {$booking->check_in->format('M d, Y')}\n";
        $content .= "Check-out: {$booking->check_out->format('M d, Y')}\n";
        $content .= "We apologize for any inconvenience. Please contact us if you have any questions.";

        Message::create([
            'sender_id' => $booking->property->user_id,
            'receiver_id' => $booking->user_id,
            'booking_id' => $booking->id,
            'content' => $content,
            'is_read' => false
        ]);
    }

    public function sendCustomerCancelledMessage(Booking $booking): void
    {
        $content = "Booking cancelled by customer.\n\n";
        $content .= "Property: {$booking->property->title}\n";
        $content .= "Guest: {$booking->user->name}\n";
        $content .= "Check-in: {$booking->check_in->format('M d, Y')}\n";
        $content .= "Check-out: {$booking->check_out->format('M d, Y')}\n";
        $content .= "Guests: {$booking->guest_count}\n";
        if ($booking->room) {
            $content .= "Room: {$booking->room->name}\n";
        }
        $content .= "Total: LKR " . number_format($booking->total_price) . "\n\n";
        $content .= "The customer has cancelled this booking.";

        Message::create([
            'sender_id' => $booking->user_id,
            'receiver_id' => $booking->property->user_id,
            'booking_id' => $booking->id,
            'content' => $content,
            'is_read' => false
        ]);
    }
}