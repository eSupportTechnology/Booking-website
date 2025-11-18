@extends('Customer.master')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6 text-center">

        <h1 class="text-2xl font-bold mb-4 text-green-600">
            ✔ Booking Confirmed!
        </h1>

        <p class="text-gray-700 mb-4">
            Thank you for booking with us.
        </p>

        <div class="text-left bg-gray-50 p-4 rounded-lg">
            <p><strong>Car:</strong> {{ $booking->car->model->model_name }}</p>
            <p><strong>Pickup:</strong> {{ $booking->pickup_location }} at {{ $booking->pickup_datetime }}</p>
            <p><strong>Dropoff:</strong> {{ $booking->dropoff_location }} at {{ $booking->dropoff_datetime }}</p>
            <p><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
        </div>

        <a href="/" class="mt-6 inline-block bg-blue-600 text-white px-5 py-2 rounded-lg">
            Back to home
        </a>
    </div>
</div>
@endsection
