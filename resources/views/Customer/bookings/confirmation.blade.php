@extends('frontend.master')

@section('title', 'Booking Confirmation')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/Customer/css/home.css') }}">
    <style>
        .noto-sans-font {
            font-family: 'Noto Sans', sans-serif;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            #printableArea, #printableArea * {
                visibility: visible;
            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 4px;
                font-size: 11px;
            }
            #printableArea .grid {
                grid-template-columns: 1fr 1fr !important;
                gap: 0.25rem !important;
            }
            #printableArea .gap-8 {
                gap: 0.25rem !important;
            }
            #printableArea img {
                height: 80px !important;
            }
            #printableArea .h-48 {
                height: 80px !important;
            }
            #printableArea .text-xl {
                font-size: 0.85rem !important;
                margin-bottom: 0.15rem !important;
                line-height: 1.2 !important;
            }
            #printableArea .text-lg {
                font-size: 0.8rem !important;
                line-height: 1.2 !important;
            }
            #printableArea .p-6 {
                padding: 0.35rem !important;
            }
            #printableArea .space-y-4 > * + * {
                margin-top: 0.25rem !important;
            }
            #printableArea .space-y-3 > * + * {
                margin-top: 0.2rem !important;
            }
            #printableArea .py-3 {
                padding-top: 0.2rem !important;
                padding-bottom: 0.2rem !important;
            }
            #printableArea .py-2 {
                padding-top: 0.15rem !important;
                padding-bottom: 0.15rem !important;
            }
            #printableArea .mb-6 {
                margin-bottom: 0.35rem !important;
            }
            #printableArea .mb-4 {
                margin-bottom: 0.25rem !important;
            }
            #printableArea .mb-2 {
                margin-bottom: 0.15rem !important;
            }
            #printableArea * {
                line-height: 1.3 !important;
            }
            .no-print {
                display: none !important;
            }
            .shadow-md {
                box-shadow: none !important;
            }
            @page {
                margin: 0.3cm;
                size: auto;
            }
        }
    </style>
@endpush

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header Section -->
    <section class="bg-[#1F8FB2] text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm mb-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:underline">Home</a>
                <span>></span>
                <a href="{{ route('customer.bookings.index') }}" class="hover:underline">My Bookings</a>
                <span>></span>
                <span>Confirmation</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold">Booking Confirmation</h1>
            <p class="text-lg mt-1">Your reservation details</p>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-green-800">Booking Confirmed!</h2>
                    <p class="text-green-700" style="font-family: 'Noto Sans', sans-serif;">
                        Your reservation has been successfully created. Booking ID: #{{ $booking->id }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" id="printableArea">
            <!-- Property Details -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($booking->property->files && $booking->property->files->count() > 0)
                    <img src="{{ $booking->property->files->where('file_type', 'image')->first() ? asset('storage/' . $booking->property->files->where('file_type', 'image')->first()->path) : asset('images/AA.png') }}"
                         alt="{{ $booking->property->title }}"
                         class="w-full h-48 object-cover">
                @else
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">No image available</span>
                    </div>
                @endif

                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $booking->property->title }}</h3>
                    <p class="text-gray-600 mb-4 noto-sans-font">
                        {{ $booking->property->address }}, {{ $booking->property->city }}
                    </p>
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                        {{ optional($booking->property->category)->name ?? 'N/A' }}
                    </span>
                </div>
                <!-- Customer Details -->
                <div class="p-6 mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Customer Information</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Name</span>
                            <span class="font-medium">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Email</span>
                            <span class="font-medium">{{ auth()->user()->email }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Phone</span>
                            <span class="font-medium">{{ auth()->user()->phone ?? 'Not provided' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Reservation Details</h3>

                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Booking ID</span>
                        <span class="font-medium">#{{ $booking->id }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Check-in</span>
                        <span class="font-medium">{{ $booking->check_in->format('l, M d, Y') }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Check-out</span>
                        <span class="font-medium">{{ $booking->check_out->format('l, M d, Y') }}</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-medium">{{ $booking->check_in->diffInDays($booking->check_out) }} nights</span>
                    </div>

                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600">Guests</span>
                        <span class="font-medium">{{ $booking->guest_count }} {{ $booking->guest_count === 1 ? 'guest' : 'guests' }}</span>
                    </div>

                    @if($booking->room_id)
                        <div class="flex justify-between py-3 border-b border-gray-200">
                            <span class="text-gray-600">Room</span>
                            <span class="font-medium">{{ $booking->room->name ?? 'N/A' }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between py-3 text-lg font-semibold">
                        <span>Total Amount</span>
                        <span class="text-[#1F8FB2]">LKR {{ number_format($booking->total_price) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.bookings.index') }}"
               class="bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white px-6 py-3 rounded-lg font-medium text-center transition duration-200">
                View All Bookings
            </a>
            <a href="{{ route('customer.dashboard') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium text-center transition duration-200">
                Back to Home
            </a>
            <button onclick="printBookingDetails()"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
                Print Confirmation
            </button>
        </div>

        <!-- Important Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h4 class="text-lg font-semibold text-blue-800 mb-3">Important Information</h4>
            <ul class="text-blue-700 space-y-2 noto-sans-font">
                <li>• Please arrive at the property between 2:00 PM - 11:00 PM on your check-in date</li>
                <li>• Check-out time is 11:00 AM</li>
                <li>• Please bring a valid ID for verification</li>
                <li>• Contact the property directly for any special requests</li>
                <li>• Cancellation policy applies as per property terms</li>
            </ul>
        </div>
    </div>
</div>
@push('scripts')
<script>
function printBookingDetails() {
    const printWindow = window.open('', '_blank');
    const printContent = document.getElementById('printableArea').innerHTML;

    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Booking Confirmation #{{ $booking->id }}</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <style>
                @page {
                    margin: 0.3cm;
                    size: auto;
                }
                body {
                    font-family: 'Arial', sans-serif;
                    line-height: 1.3;
                    font-size: 11px;
                    margin: 0;
                    padding: 4px;
                }
                .print-header {
                    text-align: center;
                    margin-bottom: 0.5rem;
                }
                .grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 0.25rem;
                }
                .bg-white {
                    background-color: white;
                }
                .rounded-lg {
                    border-radius: 0.5rem;
                }
                .shadow-md {
                    box-shadow: none;
                }
                .overflow-hidden {
                    overflow: hidden;
                }
                .p-6 {
                    padding: 0.35rem;
                }
                .mb-2, .mb-4, .mb-6 {
                    margin-bottom: 0.25rem;
                }
                .space-y-3 > * + *, .space-y-4 > * + * {
                    margin-top: 0.25rem;
                }
                .text-xl {
                    font-size: 0.85rem;
                    line-height: 1.2;
                }
                .text-lg {
                    font-size: 0.8rem;
                    line-height: 1.2;
                }
                .font-semibold {
                    font-weight: 600;
                }
                .py-2, .py-3 {
                    padding-top: 0.2rem;
                    padding-bottom: 0.2rem;
                }
                .border-b {
                    border-bottom: 1px solid #e5e7eb;
                }
                .flex {
                    display: flex;
                }
                .justify-between {
                    justify-content: space-between;
                }
                .text-gray-600 {
                    color: #4b5563;
                }
                .text-gray-800 {
                    color: #1f2937;
                }
                img {
                    max-height: 180px;
                    width: 100%;
                    object-fit: cover;
                }
                .h-48 {
                    height: 80px;
                }
                .rounded-full {
                    border-radius: 9999px;
                }
                .bg-blue-100 {
                    background-color: #dbeafe;
                }
                .text-blue-800 {
                    color: #1e40af;
                }
                .px-3 {
                    padding-left: 0.75rem;
                    padding-right: 0.75rem;
                }
                .py-1 {
                    padding-top: 0.25rem;
                    padding-bottom: 0.25rem;
                }
                .text-sm {
                    font-size: 0.75rem;
                }
                .bg-green-100 {
                    background-color: #dcfce7;
                }
                .text-green-800 {
                    color: #166534;
                }
                .bg-yellow-100 {
                    background-color: #fef9c3;
                }
                .text-yellow-800 {
                    color: #854d0e;
                }
                .text-[#1F8FB2] {
                    color: #1F8FB2;
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h1 style="font-size: 1.2rem; font-weight: bold; margin-bottom: 0.25rem;">Booking Confirmation</h1>
                <p style="color: #666; font-size: 0.8rem;">Generated on ${new Date().toLocaleString()}</p>
            </div>
            ${printContent}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.onload = function() {
        printWindow.print();
    };
}
</script>
@endpush

@endsection
