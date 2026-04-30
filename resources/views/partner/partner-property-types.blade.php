@extends('frontend.master')

@section('title', 'List Your Property')

@section('content')
<!-- Hero Section -->
<section class="text-white py-8 bg-[#1F8FB2]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 mt-4">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-2">
                List your property on {{ config('domains.domain') }}
            </h1>
            <p class="text-base sm:text-lg mt-1">
                Start welcoming guests in no time! Choose the type of property you want to list.
            </p>
        </div>
    </div>
</section>

<!-- Property Type Cards -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($properties as $property)
        @php
            $name = $property['name'];
            $image = '';
            $description = '';
            $route = '#';
            $showQuickStart = false;

            switch ($name) {
                case 'Homes':
                    $image = 'images/accomm_single_home@2x (1).png';
                    $description = 'Properties like apartments, holiday homes, villas, etc.';
                    $route = url('/partner/property_subcategory/1');
                    break;

                case 'Apartment':
                    $image = 'images/accomm_one_apt_main@2x.png';
                    $description = 'Furnished and self-catering accommodation, where guests rent the entire place.';
                    $route = url('/partner/property_subcategory/2');
                    $showQuickStart = true;
                    break;

                case 'Hotel, B&Bs, and more':
                    $image = 'images/accomm_hotels_main_v2@2x.png';
                    $description = 'Properties like hotels, B&Bs, guest houses, hostels, aparthotels, etc.';
                    $route = url('/partner/property_subcategory/3');
                    break;

                case 'Alternative places':
                    $image = 'images/tent-big@2x.png';
                    $description = 'Properties like boats, campsites, luxury tents, etc.';
                    $route = url('/partner/property_subcategory/4');
                    break;
            }
        @endphp

        <div class="relative bg-white p-5 rounded-xl shadow-md border border-gray-100 text-center flex flex-col items-center hover:shadow-lg transition">
            @if($showQuickStart)
            <span class="absolute -top-3 bg-green-600 text-white text-xs px-3 py-1 rounded-full font-semibold flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Quick start
            </span>
            @endif

            <div class="flex flex-col flex-grow items-center space-y-4 mt-4">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center">
                    <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-12 h-12 object-contain">
                </div>
                <h2 class="text-lg font-semibold text-gray-800">{{ $name }}</h2>
                <p class="text-sm text-gray-500 text-center min-h-[48px]">{{ $description }}</p>
            </div>

            <a href="{{ $route }}" class="w-full mt-4">
                <button class="w-full bg-[#1F8FB2] hover:bg-[#1a7a99] text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition">
                    List your property
                </button>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Benefits Section -->
    <div class="mt-12 bg-gray-50 rounded-xl p-6 sm:p-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Why list with {{ config('domains.domain') }}?</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-14 h-14 bg-[#1F8FB2]/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-[#1F8FB2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 8v1"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Earn More</h3>
                <p class="text-sm text-gray-500">Competitive commission rates and flexible pricing</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-[#1F8FB2]/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-[#1F8FB2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Global Reach</h3>
                <p class="text-sm text-gray-500">Connect with millions of travelers worldwide</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-[#1F8FB2]/10 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-[#1F8FB2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">Secure Payments</h3>
                <p class="text-sm text-gray-500">Protected transactions and reliable payouts</p>
            </div>
        </div>
    </div>
</div>
@endsection
