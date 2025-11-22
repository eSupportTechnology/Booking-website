@extends('frontend.master')

@php
use Carbon\Carbon;
@endphp
<!-- Hire Status -->
@php
    $status = $reservation->status;

    $statusColor = match($status) {
        'confirmed' => 'bg-green-100 text-green-700 border-green-300',
        'pending'   => 'bg-yellow-100 text-yellow-700 border-yellow-300',
        'cancelled' => 'bg-red-100 text-red-700 border-red-300',
        'completed' => 'bg-blue-100 text-blue-700 border-blue-300',
        default     => 'bg-gray-100 text-gray-700 border-gray-300'
    };
@endphp

<style>
    body { background: #F6F7F9; }

    .view-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #D3E4F2;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    .booking-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid #E6F4FA;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #0B7DB6;
        margin-bottom: 10px;
    }

    .info-box {
        background: #F8FCFF;
        border: 1px solid #D3E4F2;
        padding: 12px 16px;
        border-radius: 12px;
    }

    .label { font-size: 13px; color: #6b7280; }
    .value { font-size: 15px; font-weight: 600; color: #333; }

    .back-btn {
        background: #3CC0E9;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
    }
</style>


@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <a href="{{ route('customer.reservations.index') }}" class="back-btn mb-4 inline-block">← Back to My Bookings</a>

    <div class="view-card">

        <!-- Header -->
        <h1 class="text-2xl font-bold mb-4">
            Booking #{{ $reservation->id }}
        </h1>
        <div class="inline-block mt-2 mb-5 px-4 py-2 rounded-full border font-semibold {{ $statusColor }}">
            Hire Status: {{ ucfirst($status) }}
        </div>

        <!-- Car Image -->
        <img src="{{ $reservation->car->mainPhoto() }}" class="booking-img mb-6">

        <h2 class="section-title">Car Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
            <div class="info-box">
                <div class="label">Car</div>
                <div class="value">
                    {{ $reservation->car->brand->brand_name }} 
                    {{ $reservation->car->model->model_name }}
                </div>
            </div>

            <div class="info-box">
                <div class="label">Type</div>
                <div class="value">{{ $reservation->car->carType->name }}</div>
            </div>
        </div>

        <h2 class="section-title">Booking Details</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
            <div class="info-box">
                <div class="label">Start Date</div>
                <div class="value">{{ Carbon::parse($reservation->start_date)->format('d M Y') }}</div>
            </div>

            <div class="info-box">
                <div class="label">End Date</div>
                <div class="value">{{ Carbon::parse($reservation->end_date)->format('d M Y') }}</div>
            </div>

            <div class="info-box">
                <div class="label">Pickup Location</div>
                <div class="value">{{ $reservation->pickup_location }}</div>
            </div>

            <div class="info-box">
                <div class="label">Dropoff Location</div>
                <div class="value">{{ $reservation->dropoff_location }}</div>
            </div>

            <div class="info-box">
                <div class="label">Pickup Time</div>
                <div class="value">{{ Carbon::parse($reservation->pickup_datetime)->format('d M Y - h:i A') }}</div>
            </div>

            <div class="info-box">
                <div class="label">Dropoff Time</div>
                <div class="value">{{ Carbon::parse($reservation->dropoff_datetime)->format('d M Y - h:i A') }}</div>
            </div>
        </div>

        <h2 class="section-title">Payment & Notes</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
            <div class="info-box">
                <div class="label">Total Price</div>
                <div class="value">${{ number_format($reservation->total_price, 2) }}</div>
            </div>

            <div class="info-box">
                <div class="label">Payment Status</div>
                <div class="value text-blue-600">{{ ucfirst($reservation->payment_status) }}</div>
            </div>
        </div>

        @if($reservation->notes)
        <div class="info-box mb-6">
            <div class="label">Notes</div>
            <div class="value">{{ $reservation->notes }}</div>
        </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('customer.reservations.cancel', $reservation->id) }}"
                class="px-5 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700">
                Cancel Booking
            </a>
        </div>

    </div>
</div>
@endsection
