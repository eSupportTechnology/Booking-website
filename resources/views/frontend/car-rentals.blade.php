@extends('frontend.user-master')

@section('content')
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="container mx-auto px-4 md:px-8">
        <!-- Hero Text -->
        <div class="text-left mb-10 mt-2">
            <h1 class="text-4xl md:text-3xl font-bold mb-2" style="font-size:50px;">Find your next stay</h1>
            <p class="text-base md:text-lg" style="font-family: 'Noto Sans', sans-serif;font-size:20px;margin-top:20px;">
                Search low prices on hotels, homes and much more...
            </p>
        </div>
    </div>
</section>
<div class="relative z-10 -mt-8 px-4">

        <!-- Main form -->
      <form method="GET" class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-1 md:gap-0 border-4 border-yellow-400 max-w-6xl mx-auto overflow-visible text-sm">
            <!-- Pick-up Location -->
            <div class="flex items-center gap-2 border-r pr-3">
                <i class="fas fa-search text-lg"></i>
                <input type="text" placeholder="Airport, city or station" class="border-none outline-none text-sm" />
            </div>

            <!-- Pick-up Date -->
            <div class="flex items-center gap-2 border-r pr-3">
                <i class="fas fa-calendar-alt text-lg"></i>
                <input type="date" class="border-none outline-none text-sm" />
            </div>

            <!-- Pick-up Time -->
            <div class="flex items-center gap-2 border-r pr-3">
                <i class="fas fa-clock text-lg"></i>
                <input type="time" class="border-none outline-none text-sm" />
            </div>

            <!-- Drop-off Date -->
            <div class="flex items-center gap-2 border-r pr-3">
                <i class="fas fa-calendar-alt text-lg"></i>
                <input type="date" class="border-none outline-none text-sm" />
            </div>

            <!-- Drop-off Time -->
            <div class="flex items-center gap-2 border-r pr-3">
                <i class="fas fa-clock text-lg"></i>
                <input type="time" class="border-none outline-none text-sm" />
            </div>

            <!-- Drop-off location (space reserved, but hidden initially) -->
            <div id="dropoffLocationWrapper" class="relative">
                <div id="dropoffLocation" class="flex items-center gap-2 border-r pr-3 invisible absolute inset-0">
                    <i class="fas fa-location-dot text-lg"></i>
                    <input type="text" placeholder="Drop-off location" class="border-none outline-none text-sm" />
                </div>
            </div>

            <!-- Search Button -->
            <div class="ml-auto">
                <button type="submit" class="bg-sky-500 text-white font-bold px-6 py-2 rounded hover:bg-sky-600 transition-all">
                    Search
                </button>
            </div>
        </form>

        <!-- Options section -->
        <div class="mt-3 space-y-2 text-sm">
            <!-- Drop-off checkbox -->
            <label class="flex items-center gap-2">
                <input type="checkbox" id="toggleDropoff" onchange="toggleDropoffLocation()" />
                Drop car off at different location
            </label>

            <!-- Driver Age checkbox -->
            <label class="flex items-center gap-2">
                <input type="checkbox" id="toggleAge" onchange="toggleDriverAge()" />
                Driver aged between 30 - 65?
            </label>

            <!-- Driver's Age box (outside main form box) -->
            <div id="driverAgeBox" class="hidden ml-6">
                <label class="mr-2">Driver’s Age:</label>
                <input type="number" class="border px-2 py-1 rounded text-sm w-24" placeholder="Age" />
            </div>
        </div>
    </div>

</div>

<script>
    function toggleDropoffLocation() {
        const field = document.getElementById('dropoffLocation');
        field.classList.toggle('invisible');
    }

    function toggleDriverAge() {
        document.getElementById('driverAgeBox').classList.toggle('hidden');
    }
</script>




<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Popular car hire brands</h2>

        <!-- Container limited to 50% width with 4 images and gap -->
        <div class="flex gap-x-2 w-[40%]">
            <!-- SR Rent A Car -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/sr.png') }}" alt="SR Rent A Car" class="h-16 w-full object-cover">
            </div>

            <!-- Europcar -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/uro.png') }}" alt="Europcar" class="h-16 w-full object-cover">
            </div>

            <!-- Sixt -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/siz.png') }}" alt="Sixt" class="h-16 w-full object-cover">
            </div>

            <!-- Hertz -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/her.png') }}" alt="Hertz" class="h-16 w-full object-cover">
            </div>
        </div>
    </div>
</section>
<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Heading and link -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Travel more, spend less</h2>
            <a href="#" class="text-sm text-blue-600 hover:underline">Learn more about your rewards</a>
        </div>
    </div>

    <!-- Relative container for arrows and scrolling -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Scrollable container -->
        <div class="scroll-container flex overflow-x-auto scroll-smooth gap-4 no-scrollbar">
            @php
                $destinations = [
                    ['name' => 'Kandy', 'properties' => '1,166'],
                    ['name' => 'Colombo', 'properties' => '622'],
                    ['name' => 'Nuwara Eliya', 'properties' => '843'],
                    ['name' => 'Ella', 'properties' => '876'],
                    ['name' => 'Galle', 'properties' => '1,118'],
                    ['name' => 'Negombo', 'properties' => '822'],
                    ['name' => 'Anuradhapura', 'properties' => '710'],
                    ['name' => 'Trincomalee', 'properties' => '588'],
                ];
            @endphp

            @foreach ($destinations as $destination)
                <div class="min-w-[230px]">
                    <!-- Card box -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 h-40 flex flex-col justify-center items-center">
                        <span class="text-lg font-bold text-gray-700" style="font-family: 'Noto Sans', sans-serif;">
                            {{ $destination['name'] }}
                        </span>
                        <span class="text-sm text-gray-500 mt-1" style="font-family: 'Noto Sans', sans-serif;">
                            {{ $destination['properties'] }} Properties
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Left Arrow -->
        <button class="scroll-left hidden absolute top-[42%] left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Right Arrow -->
        <button class="scroll-right absolute top-[42%] right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</section>

<!-- Tailwind scroll styling -->
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Cards Container -->
        <div class="flex flex-col md:flex-row justify-between gap-4 md:gap-8">
            <!-- Card 1 -->
            <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-4">
                <img src="/images/icon-customer-support.png" alt="Customer Support Icon" class="w-12 h-12">
                <div>
                    <h3 class="text-lg font-semibold">We're here for you</h3>
                    <p class="text-sm text-gray-600">Customer support in over 30 languages</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-4">
                <img src="/images/icon-free-cancellation.png" alt="Free Cancellation Icon" class="w-12 h-12">
                <div>
                    <h3 class="text-lg font-semibold">Free cancellation</h3>
                    <p class="text-sm text-gray-600">Up to 48 hours before pick-up, on most bookings</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-gray-100 p-4 rounded-lg flex items-center gap-4">
                <img src="/images/icon-reviews.png" alt="Reviews Icon" class="w-12 h-12">
                <div>
                    <h3 class="text-lg font-semibold">5 million+ reviews</h3>
                    <p class="text-sm text-gray-600">By real, verified customers</p>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Heading -->
        <div class="mb-10 text-center">
            <h2 class="text-2xl font-semibold text-gray-800">Frequently Asked Questions</h2>
        </div>

        <!-- Two column layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        How can I contact support?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        You can contact our support team via email at support@example.com.
                    </p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        Can I upgrade my plan later?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        Absolutely! You can upgrade your plan at any time from your dashboard.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggles = document.querySelectorAll('.toggle-answer');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const answer = toggle.nextElementSibling;
                const icon = toggle.querySelector('svg');
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollSections = document.querySelectorAll('.scroll-section');
        const scrollAmount = 648;

        scrollSections.forEach(section => {
            const scrollContainer = section.querySelector('.scroll-container');
            const scrollLeftBtn = section.querySelector('.scroll-left');
            const scrollRightBtn = section.querySelector('.scroll-right');

            function toggleArrows() {
                const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                scrollLeftBtn.classList.toggle('hidden', scrollContainer.scrollLeft <= 0);
                scrollRightBtn.classList.toggle('hidden', scrollContainer.scrollLeft >= maxScrollLeft - 10);
            }

            scrollLeftBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                setTimeout(toggleArrows, 400);
            });

            scrollRightBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                setTimeout(toggleArrows, 400);
            });

            scrollContainer.addEventListener('scroll', toggleArrows);

            toggleArrows();
        });
    });
</script>

<!-- Popular with Travellers -->
<section class="py-12 bg-white" style="margin-bottom: 60px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Popular with travelers from Sri Lanka</h2>

        <!-- Tabs -->
        <div class="flex space-x-4 overflow-x-auto mb-4">
            <button id="tab-domestic" class="rounded-full tab-button active-tab px-4 py-2 bg-blue-600 text-white" onclick="toggleTab('domestic')">Domestic cities</button>
            <button id="tab-international" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('international')">International cities</button>
            <button id="tab-regions" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('regions')">Regions</button>
            <button id="tab-countries" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('countries')">Countries</button>
            <button id="tab-places" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('places')">Places to stay</button>
        </div>

        <!-- Tab Content -->
        <div id="tab-content" class="mt-4 text-sm font-lato">
            <!-- Domestic -->
            <div id="content-domestic" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                @for ($i = 0; $i < 4; $i++)
                    <span>Kandy hotels</span>
                    <span>Nuwara Eliya hotels</span>
                    <span>Colombo hotels</span>
                    <span>Ella hotels</span>
                    <span>Anuradhapura hotels</span>
                @endfor
                <div class="col-span-full text-left mt-2">
                    <button class="text-blue-600">+ Show more</button>
                </div>
            </div>

            <!-- International -->
            <div id="content-international" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Singapore hotels</span>
                <span>Bangkok hotels</span>
                <span>London hotels</span>
                <span>New York hotels</span>
                <span>Dubai hotels</span>
            </div>

            <!-- Regions -->
            <div id="content-regions" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Southern Province</span>
                <span>Central Province</span>
                <span>Western Province</span>
                <span>Eastern Province</span>
                <span>Northern Province</span>
            </div>

            <!-- Countries -->
            <div id="content-countries" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Japan</span>
                <span>United Kingdom</span>
                <span>India</span>
                <span>France</span>
                <span>Germany</span>
            </div>

            <!-- Places -->
            <div id="content-places" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Luxury Villas</span>
                <span>Hostels</span>
                <span>Budget hotels</span>
                <span>Resorts</span>
                <span>Homestays</span>
            </div>
        </div>
    </div>
</section>
<style>
    .tab-button {
        transition: all 0.2s;
    }

    .active-tab {
        background-color: rgb(37, 99, 235);
        color: white;
    }
</style>
<script>
    function toggleTab(tabName) {
        const panels = document.querySelectorAll('#tab-content > div');
        panels.forEach(panel => panel.classList.add('hidden'));

        const selectedPanel = document.getElementById(`content-${tabName}`);
        if (selectedPanel) selectedPanel.classList.remove('hidden');

        const tabs = document.querySelectorAll('.tab-button');
        tabs.forEach(tab => tab.classList.remove('active-tab', 'bg-blue-600', 'text-white'));
        tabs.forEach(tab => tab.classList.add('bg-gray-100', 'text-gray-800'));

        const selectedTab = document.getElementById(`tab-${tabName}`);
        if (selectedTab) {
            selectedTab.classList.remove('bg-gray-100', 'text-gray-800');
            selectedTab.classList.add('active-tab', 'bg-blue-600', 'text-white');
        }
    }

    // Set default tab
    document.addEventListener('DOMContentLoaded', () => {
        toggleTab('domestic');
    });
</script>


@endsection