@extends('frontend.master')

@section('title', 'Choose Option')

@push('styles')
<style>
    .option-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .option-card.selected {
        border-color: #1F8FB2;
        background: linear-gradient(135deg, rgba(31,143,178,0.1) 0%, rgba(60,192,233,0.1) 100%);
    }
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            How would you like to continue?
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            Choose your role to get started
        </p>
    </div>
</section>

<!-- Options Section -->
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Guest Option -->
            <a href="/customer/login" class="option-card bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-8 flex flex-col items-center text-center hover:border-[#1F8FB2]">
                <div class="w-20 h-20 bg-[#1F8FB2] rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none">
                        <path d="M12 12a4 4 0 100-8 4 4 0 000 8zM3 20a9 9 0 0118 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Guest</h3>
                <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                    Book hotels, homes, and experiences as a traveler
                </p>
                <div class="mt-6">
                    <span class="inline-flex items-center text-[#1F8FB2] font-semibold">
                        Continue
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </a>

            <!-- Partner Option -->
            <a href="/partner/login" class="option-card bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-8 flex flex-col items-center text-center hover:border-[#1F8FB2]">
                <div class="w-20 h-20 bg-[#3CC0E9] rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-16 0H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 7h1m4 0h1M9 11h1m4 0h1M9 15h1m4 0h1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Partner</h3>
                <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                    List your property and manage bookings as a host
                </p>
                <div class="mt-6">
                    <span class="inline-flex items-center text-[#1F8FB2] font-semibold">
                        Continue
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </a>

            <!-- Car & Taxi Rental Option -->
            <a href="/car-renter/login/email" class="option-card bg-white rounded-2xl shadow-lg border-2 border-gray-200 p-8 flex flex-col items-center text-center hover:border-[#1F8FB2]">
                <div class="w-20 h-20 bg-[#1F8FB2] rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none">
                        <path d="M3 13l1-4h16l1 4v4a1 1 0 01-1 1h-1a1 1 0 01-1-1v-1H6v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-4z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="7.5" cy="16.5" r="1.5" fill="currentColor"/>
                        <circle cx="16.5" cy="16.5" r="1.5" fill="currentColor"/>
                        <path d="M5 9l1-4h12l1 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Car & Taxi Rental</h3>
                <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                    Rent cars or offer taxi services to travelers
                </p>
                <div class="mt-6">
                    <span class="inline-flex items-center text-[#1F8FB2] font-semibold">
                        Continue
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- Info Section (like home page) -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
            <!-- Card 1 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/cal.png') }}" alt="Calendar" class="w-16 h-16 object-cover rounded-md mr-4" onerror="this.style.display='none'">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        Book now, pay at the property
                    </h2>
                    <p class="text-sm text-gray-600 mb-3" style="font-family: 'Noto Sans', sans-serif;">
                        FREE cancellation on most rooms
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/world.png') }}" alt="World" class="w-16 h-16 object-cover rounded-md mr-4" onerror="this.style.display='none'">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        2+ million properties worldwide
                    </h2>
                    <p class="text-sm text-gray-600 mb-3" style="font-family: 'Noto Sans', sans-serif;">
                        Hotels, guest houses, apartments, and more...
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/man.png') }}" alt="Support" class="w-16 h-16 object-cover rounded-md mr-4" onerror="this.style.display='none'">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        Trusted customer service 24/7
                    </h2>
                    <p class="text-sm text-gray-600 mb-3" style="font-family: 'Noto Sans', sans-serif;">
                        We're always here to help
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
