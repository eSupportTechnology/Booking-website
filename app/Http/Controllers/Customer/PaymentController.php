<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth('customer')->id()) {
            abort(403);
        }

        return view('Customer.payment.show', compact('booking'));
    }

    public function process(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth('customer')->id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => 'required|in:stripe,paypal,manual'
        ]);

        $result = $this->paymentService->processPayment(
            $booking, 
            $request->payment_method, 
            $request->all()
        );

        if ($result['success']) {
            return redirect()->route('customer.bookings.confirmation', $booking)
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}