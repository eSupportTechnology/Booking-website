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
        // Stripe multi-currency payment processing
        $amount = $booking->total_price * 100; // Convert to cents
        $currency = strtolower($booking->currency);
        
        try {
            // Initialize Stripe (placeholder - requires actual Stripe SDK)
            // \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            
            // Create payment intent with currency
            // $paymentIntent = \Stripe\PaymentIntent::create([
            //     'amount' => $amount,
            //     'currency' => $currency,
            //     'metadata' => [
            //         'booking_id' => $booking->id,
            //         'property_id' => $booking->property_id
            //     ]
            // ]);
            
            $booking->update([
                'payment_method' => 'stripe',
                'payment_status' => 'processing',
                'payment_reference' => 'stripe_' . uniqid(),
                'currency' => $booking->currency
            ]);

            return [
                'success' => true, 
                'message' => "Stripe payment initiated for {$booking->currency} {$booking->total_price}",
                'currency' => $booking->currency,
                'amount' => $booking->total_price
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Payment processing failed: ' . $e->getMessage()];
        }
    }

    private function processPayPalPayment(Booking $booking, array $data): array
    {
        // PayPal multi-currency payment processing
        $amount = $booking->total_price;
        $currency = $booking->currency;
        
        try {
            // PayPal supports multiple currencies
            // Supported: USD, EUR, GBP, AUD, CAD, JPY, etc.
            $supportedCurrencies = ['USD', 'EUR', 'GBP', 'AUD', 'CAD', 'JPY'];
            
            if (!in_array($currency, $supportedCurrencies)) {
                // Convert to USD if currency not supported
                $convertedAmount = app(\App\Services\CurrencyService::class)->convert($amount, $currency, 'USD');
                $currency = 'USD';
                $amount = $convertedAmount;
            }
            
            $booking->update([
                'payment_method' => 'paypal',
                'payment_status' => 'processing',
                'payment_reference' => 'paypal_' . uniqid(),
                'currency' => $booking->currency
            ]);

            return [
                'success' => true, 
                'message' => "PayPal payment initiated for {$currency} {$amount}",
                'currency' => $currency,
                'amount' => $amount
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'PayPal processing failed: ' . $e->getMessage()];
        }
    }

    private function processManualPayment(Booking $booking, array $data): array
    {
        $booking->update([
            'payment_method' => 'manual',
            'payment_status' => 'pending',
            'payment_reference' => 'manual_' . $booking->id,
            'payment_deadline' => now()->addHours(24),
            'currency' => $booking->currency
        ]);

        $formattedAmount = app(\App\Services\CurrencyService::class)->formatPrice($booking->total_price, $booking->currency);

        return [
            'success' => true, 
            'message' => "Manual payment option selected. Please pay {$formattedAmount} within 24 hours.",
            'currency' => $booking->currency,
            'amount' => $booking->total_price,
            'formatted_amount' => $formattedAmount
        ];
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