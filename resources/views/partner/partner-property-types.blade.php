@extends('frontend.master')

@section('title', 'List your property')

@push('styles')
@include('partner.partials.wizard-styles')
@endpush

@section('content')
<div class="wiz-shell">
    {{-- Hero --}}
    <section class="bg-[#003b95] text-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
            <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-white/70 mb-2">Become a partner</p>
            <h1 class="text-3xl sm:text-4xl font-bold leading-tight">List your property on {{ config('domains.domain') }}</h1>
            <p class="text-base sm:text-lg text-white/85 mt-3 max-w-2xl">
                Start welcoming guests in no time. Choose the type of property you want to list.
            </p>
        </div>
    </section>

    {{-- Property type cards --}}
    <div class="wiz-page-wide">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
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
                            $description = 'Apartments, holiday homes, villas, etc.';
                            $route = url('/partner/property_subcategory/1');
                            break;
                        case 'Apartment':
                            $image = 'images/accomm_one_apt_main@2x.png';
                            $description = 'Furnished, self-catering places where guests rent the entire apartment.';
                            $route = url('/partner/property_subcategory/2');
                            $showQuickStart = true;
                            break;
                        case 'Hotel, B&Bs, and more':
                            $image = 'images/accomm_hotels_main_v2@2x.png';
                            $description = 'Hotels, B&Bs, guest houses, hostels, aparthotels.';
                            $route = url('/partner/property_subcategory/3');
                            break;
                        case 'Alternative places':
                            $image = 'images/tent-big@2x.png';
                            $description = 'Boats, campsites, luxury tents, and more.';
                            $route = url('/partner/property_subcategory/4');
                            break;
                    }
                @endphp

                <a href="{{ $route }}" class="group relative flex flex-col bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-[#0071c2] hover:shadow-md transition">
                    @if($showQuickStart)
                        <span class="absolute -top-3 left-6 bg-emerald-500 text-white text-xs px-3 py-1 rounded-full font-semibold flex items-center gap-1">
                            <i class="fas fa-bolt text-[10px]"></i> Quick start
                        </span>
                    @endif

                    <div class="w-16 h-16 mb-5 bg-[#f5f9fc] rounded-xl flex items-center justify-center">
                        <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-10 h-10 object-contain">
                    </div>

                    <h2 class="wiz-h2 mb-2">{{ $name }}</h2>
                    <p class="wiz-help flex-1">{{ $description }}</p>

                    <div class="mt-5 flex items-center text-[#0071c2] font-semibold text-sm group-hover:gap-2 transition-all">
                        List your property
                        <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Why list with us --}}
        <div class="mt-12 bg-white border border-gray-200 rounded-xl p-6 sm:p-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 text-center">Why list with {{ config('domains.domain') }}?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach ([
                    ['icon' => 'fa-coins', 'title' => 'Earn more', 'desc' => 'Competitive commission and flexible pricing'],
                    ['icon' => 'fa-globe', 'title' => 'Global reach', 'desc' => 'Connect with travellers worldwide'],
                    ['icon' => 'fa-shield-halved', 'title' => 'Secure payments', 'desc' => 'Protected transactions and reliable payouts'],
                ] as $b)
                    <div class="text-center">
                        <div class="w-14 h-14 bg-[#0071c2]/10 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas {{ $b['icon'] }} text-2xl text-[#0071c2]"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $b['title'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $b['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
