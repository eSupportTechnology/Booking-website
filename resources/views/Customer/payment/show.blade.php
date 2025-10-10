@extends('frontend.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Complete Payment</h1>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Booking Summary</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Property:</span> {{ $booking->property->title }}</p>
                <p><span class="font-medium">Check-in:</span> {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</p>
                <p><span class="font-medium">Check-out:</span> {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</p>
                <p><span class="font-medium">Guests:</span> {{ $booking->guest_count }}</p>
                <p class="text-xl font-bold"><span class="font-medium">Total:</span> LKR {{ number_format($booking->total_price) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Payment Method</h3>

            <form action="{{ route('customer.payment.process', $booking) }}" method="POST" id="payment-form">
                @csrf

                <div class="space-y-4">
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="stripe" class="mr-3">
                        <div class="flex items-center">
                            <i class="fab fa-cc-stripe text-2xl text-blue-600 mr-3"></i>
                            <span class="font-medium">Credit/Debit Card (Stripe)</span>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="paypal" class="mr-3">
                        <div class="flex items-center">
                            <i class="fab fa-paypal text-2xl text-blue-500 mr-3"></i>
                            <span class="font-medium">PayPal</span>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="manual" class="mr-3">
                        <div class="flex items-center">
                            <i class="fas fa-money-bill text-2xl text-green-600 mr-3"></i>
                            <div>
                                <span class="font-medium">Manual Payment</span>
                                <p class="text-sm text-gray-600">Pay later via bank transfer or cash</p>
                            </div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="w-full mt-6 bg-[#3CC0E9] text-white py-3 rounded-lg font-semibold hover:bg-[#2BA8D1] transition">
                    <span class="loading-text">Complete Payment</span>
                    <span class="loading-spinner hidden">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Processing...
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('payment-form').addEventListener('submit', function() {
    const button = this.querySelector('button[type="submit"]');
    const loadingText = button.querySelector('.loading-text');
    const loadingSpinner = button.querySelector('.loading-spinner');

    loadingText.classList.add('hidden');
    loadingSpinner.classList.remove('hidden');
    button.disabled = true;
});
</script>
@endsection
