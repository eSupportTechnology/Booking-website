<?php

namespace App\Services;

use App\Models\Booking;

class PaymentService
{
    public function processPayment(Booking $booking, string $method, array $data = []): array
    {
        switch ($method) {
            case 'stripe':
                return $this->processStripePayment($booking, $data);
            case 'paypal':
                return $this->processPayPalPayment($booking, $data);
            case 'manual':
                return $this->processManualPayment($booking, $data);
            default:
                return ['success' => false, 'message' => 'Invalid payment method'];
        }
    }

    private function processStripePayment(Booking $booking, array $data): array
    {
        // Placeholder for Stripe integration
        $booking->update([
            'payment_method' => 'stripe',
            'payment_status' => 'processing',
            'payment_reference' => 'stripe_' . uniqid()
        ]);

        return ['success' => true, 'message' => 'Stripe payment initiated'];
    }

    private function processPayPalPayment(Booking $booking, array $data): array
    {
        // Placeholder for PayPal integration
        $booking->update([
            'payment_method' => 'paypal',
            'payment_status' => 'processing',
            'payment_reference' => 'paypal_' . uniqid()
        ]);

        return ['success' => true, 'message' => 'PayPal payment initiated'];
    }

    private function processManualPayment(Booking $booking, array $data): array
    {
        $booking->update([
            'payment_method' => 'manual',
            'payment_status' => 'pending',
            'payment_reference' => 'manual_' . $booking->id,
            'payment_deadline' => now()->addHours(24)
        ]);

        return ['success' => true, 'message' => 'Manual payment option selected. Please complete payment within 24 hours.'];
    }

    public function confirmPayment(Booking $booking): bool
    {
        $booking->update([
            'payment_status' => 'completed',
            'status' => 'confirmed'
        ]);

        return true;
    }
}