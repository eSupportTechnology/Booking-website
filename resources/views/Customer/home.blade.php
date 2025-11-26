@extends('frontend.master')

@section('title', 'Home')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/Customer/css/home.css') }}">
@endpush
{{-- Dependencies for Autocomplete --}}
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@section('content')

<!-- Hero Section -->
<section class="text-white py-8 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 mt-1">
            <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-2">
                {{ __('messages.Find your next stay') }}
            </h1>
            <p class="text-[18px] md:text-[20px] mt-1 font-sans">
                {{ __('messages.Search low prices on hotels, homes and much more...') }}
            </p>
        </div>
    </div>
</section>

<!-- Search Box -->
<div class="relative z-10 -mt-8 px-2 sm:px-4">
    @php $searchData = $searchData ?? []; @endphp
    <form action="{{ route('customer.search') }}" method="GET"
        class="bg-white rounded-xl px-2 py-1 sm:px-3 sm:py-2 shadow-lg
           flex flex-col md:flex-row items-stretch md:items-center
           gap-2 md:gap-0 border-2 sm:border-4 border-yellow-400
           max-w-full md:max-w-6xl mx-auto overflow-visible text-sm md:text-base">

        <!-- Live Destination Autocomplete -->
        <div
            x-data="{
            query: '{{ $searchData['destination'] ?? '' }}',
            results: [],
            open: false,
            selectCity(city) {
              this.query = city;
              this.open = false;
            },
            fetchSuggestions: _.debounce(function() {
              if (this.query.length < 2) { this.results = []; this.open = false; return; }
              axios.get('{{ route('customer.search.suggest') }}', { params: { q: this.query } })
                .then(res => {
                  this.results = res.data;
                  this.open = this.results.length > 0;
                })
                .catch(() => { this.results = []; });
            }, 300)
          }"
            class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1">
            <div class="flex items-center gap-2 w-full">
                <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-5 h-5 sm:w-6 sm:h-6" />
                <input
                    type="text"
                    name="destination"
                    x-model="query"
                    @input="fetchSuggestions"
                    placeholder="Where are you going?"
                    autocomplete="off"
                    class="w-full bg-transparent focus:outline-none text-sm sm:text-base text-gray-800" />
            </div>

            <!-- Suggestion Dropdown -->
            <ul
                x-show="open"
                @click.away="open = false"
                class="absolute z-30 bg-white border border-gray-200 rounded-xl shadow-xl mt-2 w-64 sm:w-72 max-h-64 overflow-y-auto">
                <template x-for="city in results" :key="city">
                    <li
                        @click="selectCity(city)"
                        class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm text-gray-800"
                        x-text="city"></li>
                </template>
            </ul>
        </div>

        <!-- Dates Selector -->
        <div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }"
            class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1">
            <button @click="open = !open" type="button"
                class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/calender.svg') }}" class="w-5 h-5" />
                <span class="text-gray-800 truncate text-sm sm:text-base">
                    <template x-if="activeTab === 'check'">
                        <span><span x-text="checkIn || '{{ __('messages.Check-in') }}'"></span> —
                            <span x-text="checkOut || '{{ __('messages.Check-out') }}'"></span></span>
                    </template>
                    <template x-if="activeTab === 'flexible'">
                        <span x-text="flexibleOption || 'Flexible dates'"></span>
                    </template>
                </span>
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-80 sm:w-96 left-0 md:left-auto md:right-0 text-gray-800 text-sm" x-transition>
                <nav class="flex border-b border-gray-200 mb-4 text-xs sm:text-sm">
                    <button @click.prevent="activeTab = 'check'"
                        :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                        class="px-2 sm:px-4 py-1 sm:py-2 border-b-2 font-semibold">Check-in / Check-out</button>
                    <button @click.prevent="activeTab = 'flexible'"
                        :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                        class="px-2 sm:px-4 py-1 sm:py-2 border-b-2 font-semibold">Flexible dates</button>
                </nav>

                <div x-show="activeTab === 'check'" x-transition>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Check-in Date</label>
                            <input type="date" name="checkIn" x-model="checkIn"
                                class="w-full border border-gray-300 rounded px-2 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Check-out Date</label>
                            <input type="date" name="checkOut" x-model="checkOut"
                                class="w-full border border-gray-300 rounded px-2 py-2 text-sm" />
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'flexible'" x-transition>
                    <label class="block text-xs text-gray-500 mb-1">Select Flexible Dates</label>
                    <select x-model="flexibleOption"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="" disabled>Select option</option>
                        <option value="Weekend Getaway">Weekend Getaway</option>
                        <option value="Next Month">Next Month</option>
                        <option value="Anytime">Anytime</option>
                        <option value="Custom Range">Custom Range</option>
                    </select>
                </div>

                <div class="mt-4 text-right">
                    <button type="button" @click="open = false"
                        class="bg-blue-600 text-white px-3 sm:px-4 py-2 rounded hover:bg-blue-700 text-xs sm:text-sm">
                        Done
                    </button>

                </div>
            </div>
        </div>

        <!-- Guests Selector -->
        <div x-data="{ open: false, adults: 2, children: 0, rooms: 1, pets: false }"
            class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1">
            <button @click="open = !open" type="button"
                class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/user.svg') }}" class="w-5 h-5" />
                <span x-text="`${adults} adults · ${children} children · ${rooms} room${rooms>1?'s':''}`"
                    class="text-gray-800 text-sm sm:text-base truncate"></span>
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-64 sm:w-72 left-0 md:left-auto md:right-0 text-gray-800 space-y-4 text-sm">
                <div class="flex justify-between"><span>Adults</span>
                    <div class="flex gap-2">
                        <button type="button" @click="if(adults>1) adults--" class="px-2 bg-gray-200 rounded">−</button>
                        <span x-text="adults"></span>
                        <button type="button" @click="adults++" class="px-2 bg-gray-200 rounded">+</button>
                    </div>
                </div>
                <div class="flex justify-between"><span>Children</span>
                    <div class="flex gap-2">
                        <button type="button" @click="if(children>0) children--" class="px-2 bg-gray-200 rounded">−</button>
                        <span x-text="children"></span>
                        <button type="button" @click="children++" class="px-2 bg-gray-200 rounded">+</button>
                    </div>
                </div>
                <div class="flex justify-between"><span>Rooms</span>
                    <div class="flex gap-2">
                        <button type="button" @click="if(rooms>1) rooms--" class="px-2 bg-gray-200 rounded">−</button>
                        <span x-text="rooms"></span>
                        <button type="button" @click="rooms++" class="px-2 bg-gray-200 rounded">+</button>
                    </div>
                </div>
                <div class="flex justify-between"><span>Travelling with pets?</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="pets" class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                        </div>
                    </label>
                </div>

                <button type="button" @click="open = false"
                    class="block w-full text-center bg-white border border-blue-600 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50">
                    Done
                </button>
            </div>
            <input type="hidden" name="adults" x-model="adults">
            <input type="hidden" name="children" x-model="children">
            <input type="hidden" name="rooms" x-model="rooms">
        </div>

        <!-- Search Button -->
        <div class="w-full md:w-auto px-2 py-1">
            <button type="submit"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 sm:px-4 py-2 rounded-lg text-sm"
                style="background-color:#3CC0E9;">
                Search
            </button>
        </div>
        <input type="hidden" name="adults" x-model="adults">
        <input type="hidden" name="children" x-model="children">
        <input type="hidden" name="rooms" x-model="rooms">
        <input type="hidden" name="pets" x-model="pets">

    </form>
</div>


<!-- Offers Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Title -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ __('messages.Offers') }}</h2>
        <p class="mb-6 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Promotions, deals and special offers for you') }}</p>

        <!-- Offer Card -->
        <div class="bg-white-50 p-2 rounded flex items-center justify-between border border-solid border-gray-300">
            <!-- Text Content -->
            <div class="ml-4">
                <p class="font-medium font-semibold">{{ __('messages.Quick escape, quality time') }}</p>
                <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Save up to 20% with a Gateway Deal!')}}</p>
                <button class=" text-white px-4 py-1 rounded mt-2 w-auto"
                    style="font-family: 'Noto Sans', sans-serif;background-color:#3CC0E9;">{{ __('messages.Save on stays') }}</button>
            </div>

            <!-- Image -->
            <img src="{{ asset('images/offers.png') }}" alt="Offer Image" class="w-32 h-32 rounded ml-4">
        </div>
    </div>
</section>
<!--End Offers Section-->

<!-- Browse by Property Type Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Browse by property type</h2>
        <div class="flex space-x-4 overflow-x-auto pb-2">

            <!-- Hotels -->
            <a href="{{ route('hotel-listing') }}" class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('images/hotels.jpg') }}" alt="Hotels" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">
                        Hotels
                    </h6>
                </div>
            </a>


            <!-- Apartments -->
            <a href="{{ route('apartment-listing') }}" class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('images/apartments.jpg') }}" alt="Apartments" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">
                        Apartments
                    </h6>
                </div>
            </a>

            <!-- Resorts -->
            <a href="{{ route('home-listing') }}" class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('images/villas.jpg') }}" alt="Resorts" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">
                        Holiday Homes
                    </h6>
                </div>
            </a>



            <!-- Villas -->
            <a href="{{ route('alternative-places-listing') }}" class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('images/resorts.jpg') }}" alt="Villas" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">
                        Villas
                    </h6>
                </div>
            </a>

        </div>
    </div>
</section>
<!--End Section-->

<!-- Trending Destinations Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ __('messages.Trending destinations') }}</h2>
        <p class="mb-8 text-gray-600 font-sans">{{ __('messages.Most popular choices travelers from Sri Lanka') }}</p>

        @php
        $cities = collect($cities ?? []);

        $fallbackCities = [
        ['city' => 'Colombo', 'image' => asset('images/colombo.jpg')],
        ['city' => 'Nuwara Eliya', 'image' => asset('images/nuwara.jpg')],
        ['city' => 'Sigiriya', 'image' => asset('images/sigiriya.jpg')],
        ['city' => 'Ella', 'image' => asset('images/ella.png')],
        ['city' => 'Dambulla', 'image' => asset('images/dambulla.jpg')],
        ];

        $totalNeeded = 5;
        $missingCount = $totalNeeded - $cities->count();

        if ($missingCount > 0) {
        $cities = $cities->merge(array_slice($fallbackCities, 0, $missingCount));
        }
        @endphp

        <!-- First Row: Top 2 cities -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            @foreach($cities->take(2) as $city)
            <div class="relative rounded-[10px] overflow-hidden">
                <img src="{{ $city['image'] }}" alt="{{ $city['city'] }}" class="w-full h-64 object-cover rounded-[10px]">
                <div class="absolute top-0 left-0 w-full p-4 text-white bg-black bg-opacity-25">
                    <h3 class="text-lg font-semibold flex items-center gap-2">
                        {{ $city['city'] }}
                        <img src="{{ asset('images/srilanka.jpg') }}" alt="Sri Lanka Flag" class="h-4 w-6" />
                    </h3>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Second Row: Remaining 3 cities -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($cities->slice(2) as $city)
            <div class="relative rounded-[10px] overflow-hidden">
                <img src="{{ $city['image'] }}" alt="{{ $city['city'] }}" class="w-full h-64 object-cover rounded-[10px]">
                <div class="absolute top-0 left-0 w-full p-4 text-white bg-black bg-opacity-25">
                    <h3 class="text-lg font-semibold flex items-center gap-2">
                        {{ $city['city'] }}
                        <img src="{{ asset('images/srilanka.jpg') }}" alt="Sri Lanka Flag" class="h-4 w-6" />
                    </h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



<!-- End Trending Destination Section-->

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ __('messages.Browse by property type')}}</h2>
            <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                {{ __('messages.Most popular choices Pick a vibe and explore the top destination in Sri Lanka from Sri Lanka') }}
            </p>
        </div>

        <!-- Tab Buttons -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button id="ptype-tab-city"
                class="rounded-full ptype-tab-button active-ptype-tab flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('city')">
                <img src="{{ asset('assets/city.svg') }}" alt="city" class="w-5 h-5"
                    style="filter: brightness(0) saturate(100%);" />
                <span style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.City')}}</span>
            </button>

            <button id="ptype-tab-beach"
                class="rounded-full ptype-tab-button active-ptype-tab flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('beach')">
                <img src="{{ asset('assets/beach.svg') }}" alt="Beach" class="w-5 h-5" />
                <span style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Beach')}}</span>
            </button>

            <button id="ptype-tab-outdoors" class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('outdoors')">
                <img src="{{ asset('assets/outdoors.svg') }}" alt="Outdoors" class="w-5 h-5"
                    style="filter: brightness(0) saturate(100%);" />
                <span style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Outdoors')}}</span>
            </button>

            <button id="ptype-tab-relax" class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('relax')">
                <img src="{{ asset('assets/relax.svg') }}" alt="Relax" class="w-5 h-5" />
                <span style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Relax')}}</span>
            </button>

            <button id="ptype-tab-romance" class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('romance')">
                <img src="{{ asset('assets/romance.svg') }}" alt="Romance" class="w-5 h-5" />
                <span style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Romance')}}</span>
            </button>

            <button id="ptype-tab-food" class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('food')">
                <img src="{{ asset('assets/food.svg') }}" alt="Food" class="w-5 h-5" />
                <span style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Food')}}</span>
            </button>
        </div>

        <!-- Tab Contents -->
        <div id="ptype-tab-content">
            <!-- City Tab -->
            <div id="ptype-content-city" class="px-2 py-6 block">

                <div class="scroll-section">

                    <div class="relative">
                        <div class="scroll-container flex overflow-x-auto scroll-smooth gap-3 no-scrollbar">
                            @php
                            $destinations = [
                            ['name' => 'Kandy', 'image' => 'kandy.jpg', 'properties' => '1,166'],
                            ['name' => 'Colombo', 'image' => 'colombo.jpg', 'properties' => '622'],
                            ['name' => 'Nuwara Eliya', 'image' => 'colombo.jpg', 'properties' => '843'],
                            ['name' => 'Ella', 'image' => 'kandy.jpg', 'properties' => '876'],
                            ['name' => 'Galle', 'image' => 'kandy.jpg', 'properties' => '1,118'],
                            ['name' => 'Negombo', 'image' => 'colombo.jpg', 'properties' => '822'],
                            ['name' => 'Anuradhapura', 'image' => 'colombo.jpg', 'properties' => '710'],
                            ['name' => 'Trincomalee', 'image' => 'colombo.jpg', 'properties' => '588'],
                            ];
                            @endphp

                            @foreach ($destinations as $destination)
                            <div class="min-w-[230px]">
                                <!-- Container with only image -->
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    <img src="{{ asset('images/' . $destination['image']) }}"
                                        alt="{{ $destination['name'] }}" class="w-full h-40 object-cover">
                                </div>

                                <!-- Text outside the image container, below it -->
                                <div class="mt-2 px-1">
                                    <h3 class="text-sm font-semibold text-gray-800"
                                        style="font-family: 'Noto Sans', sans-serif;">
                                        {{ $destination['name'] }}
                                    </h3>
                                    <p class="text-xs text-gray-500"
                                        style="font-family: 'Noto Sans', sans-serif;">
                                        {{ $destination['properties'] }} {{ __('messages.Properties')}}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Left Arrow -->
                        <button
                            class="scroll-left hidden absolute  top-[42%]  left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100  "
                            style="margin-left:-16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Right Arrow -->
                        <button
                            class="scroll-right absolute  top-[42%] right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 "
                            style="margin-right:-16px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
            <!-- Other Tabs -->
            <div id="ptype-content-beach" class="hidden px-2 py-6">Beach content here...</div>
            <div id="ptype-content-outdoors" class="hidden px-2 py-6">Outdoors content here...</div>
            <div id="ptype-content-relax" class="hidden px-2 py-6">Relax content here...</div>
            <div id="ptype-content-romance" class="hidden px-2 py-6">Romance content here...</div>
            <div id="ptype-content-food" class="hidden px-2 py-6">Food content here...</div>
        </div>
    </div>
</section>

<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ __('messages.Explore Sri Lanka')}}</h2>
        <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.These popular destinations have a lot to offer')}}</p>
    </div>

    <div class="relative">
        <!-- Wrapper for scroll and arrows -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Scrollable container -->
            <div class="scroll-container flex overflow-x-auto scroll-smooth gap-4 no-scrollbar">
                @php
                $destinations = [
                ['name' => 'Kandy', 'image' => 'kandy.jpg', 'properties' => '1,166'],
                ['name' => 'Colombo', 'image' => 'colombo.jpg', 'properties' => '622'],
                ['name' => 'Nuwara Eliya', 'image' => 'colombo.jpg', 'properties' => '843'],
                ['name' => 'Ella', 'image' => 'kandy.jpg', 'properties' => '876'],
                ['name' => 'Galle', 'image' => 'kandy.jpg', 'properties' => '1,118'],
                ['name' => 'Negombo', 'image' => 'colombo.jpg', 'properties' => '822'],
                ['name' => 'Anuradhapura', 'image' => 'colombo.jpg', 'properties' => '710'],
                ['name' => 'Trincomalee', 'image' => 'colombo.jpg', 'properties' => '588'],
                ];
                @endphp

                @foreach ($destinations as $destination)
                <div class="min-w-[230px]">
                    <!-- Container with only image -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/' . $destination['image']) }}"
                            alt="{{ $destination['name'] }}" class="w-full h-40 object-cover">
                    </div>

                    <!-- Text outside the image container, below it -->
                    <div class="mt-2 px-1">
                        <h3 class="text-sm font-semibold text-gray-800"
                            style="font-family: 'Noto Sans', sans-serif;">
                            {{ $destination['name'] }}
                        </h3>
                        <p class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">
                            {{ $destination['properties'] }} {{ __('messages.Properties')}}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Left Arrow -->
            <button
                class="scroll-left hidden absolute  top-[42%]  left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-4 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow -->
            <button
                class="scroll-right absolute  top-[42%] right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-4 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</section>

<!--  Special Deals Section -->
<section class="scroll-section py-12 bg-white" id="deals-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            {{-- {{ __('messages.Special Deals')}} --}}
            {{ __('Special Deals')}}
        </h2>
        <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Save big with our exclusive offers
        </p>
    </div>

    <div class="relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="scroll-container flex gap-4 overflow-x-auto scroll-smooth no-scrollbar" id="deals-container">
                <!-- Deals will be loaded here -->
            </div>

            <button class="scroll-left hidden absolute top-[42%] left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button class="scroll-right absolute top-[42%] right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
    // Load deals on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/deals/active')
            .then(response => response.json())
            .then(deals => {
                const container = document.getElementById('deals-container');
                if (deals.length === 0) {
                    container.innerHTML = '<div class="text-center text-gray-500 w-full py-8">No deals available at the moment</div>';
                    return;
                }

                container.innerHTML = deals.map(deal => {
                    let discountBadge = '';
                    let priceDisplay = '';
                    let availableDates = '';
                    let roomInfo = '';

                    // Discount badge based on deal type
                    switch (deal.deal_type) {
                        case 'percentage':
                            discountBadge = `${deal.discount_percentage}% OFF`;
                            break;
                        case 'fixed':
                            discountBadge = `$${deal.fixed_discount_amount} OFF`;
                            break;
                        case 'special':
                            discountBadge = 'Special Offer';
                            break;
                    }

                    // Price display based on deal type
                    if (deal.deal_type === 'special') {
                        priceDisplay = `<span class="text-black font-bold text-sm">${deal.special_offer_text}</span>`;
                    } else {
                        priceDisplay = `
                            <span class="text-xs line-through text-red-500">$${deal.original_price}</span>
                            <span class="text-black font-bold"> $${deal.discounted_price}</span>
                        `;
                    }

                    // Available dates for weekend deals
                    if (deal.available_dates && deal.available_dates.length > 0) {
                        const dates = deal.available_dates.slice(0, 3).map(date => {
                            const d = new Date(date);
                            return d.toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            });
                        }).join(', ');
                        const moreCount = deal.available_dates.length > 3 ? ` +${deal.available_dates.length - 3} more` : '';
                        availableDates = `
                            <div class="text-xs text-blue-600 mt-1" style="font-family: 'Noto Sans', sans-serif;">
                                📅 Available: ${dates}${moreCount}
                            </div>
                        `;
                    }

                    // Room information
                    if (deal.applicable_to === 'room' && deal.room) {
                        roomInfo = `
                            <div class="text-xs text-gray-500 mt-1" style="font-family: 'Noto Sans', sans-serif;">
                                🏠 Room: ${deal.room.name}
                            </div>
                        `;
                    }

                    return `
                        <div class="min-w-[300px] max-w-[300px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0">
                            <img src="${deal.property.image}" alt="${deal.property.title}" class="w-full h-[230px] object-cover" onerror="this.src='/images/property.png'">
                            <div class="p-4">
                                <span class="text-white px-2 py-1 rounded text-xs" style="background-color:#1D9D39;">${discountBadge}</span>
                                <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">${deal.property.title}</h3>
                                <p class="text-xs text-gray-600" style="font-family: 'Noto Sans', sans-serif;">${deal.property.city}</p>
                                ${roomInfo}
                                <div class="flex items-center mt-2">
                                    <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178);">${Math.round(deal.property.rating)}</span>
                                    <div class="ml-2" style="font-family: 'Noto Sans', sans-serif;">
                                        <span class="text-xs block">Rating</span>
                                        <span class="text-xs block">${deal.property.reviews_count} Reviews</span>
                                    </div>
                                </div>
                                <p class="text-gray-600 mt-2 text-xs" style="font-family: 'Noto Sans', sans-serif;">
                                    ${priceDisplay}
                                </p>
                                ${availableDates}
                                <div class="mt-3">
                                    <a href="/customer/properties/${deal.property.id}/book?deal_id=${deal.id}"
                                       class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded text-sm font-semibold hover:bg-blue-700 transition"
                                       style="background-color: #1F8FB2;">
                                        Book This Deal
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            })
            .catch(error => {
                console.error('Error loading deals:', error);
                document.getElementById('deals-container').innerHTML = '<div class="text-center text-gray-500 w-full py-8">Unable to load deals</div>';
            });
    });
</script>

<!--End Section-->

<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ __('messages.Stay at our top unique properties')}}</h2>
        <p class="text-gray-600 mb-4" style="font-family: 'Noto Sans', sans-serif;">
            {{ __("messages.From castles and villas to boats and igloos, we’ve got it all") }}
        </p>

        <div class="relative">
            <div class="scroll-container flex space-x-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                @for ($i = 0; $i < 5; $i++)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden relative min-w-[250px]">
                    <button
                        style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;"
                        onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';">🤍</button>
                    <img src="{{ asset('images/A.jpg') }}" alt="Hotel Image" class="w-full h-64 object-cover">
                    <div class="p-4">
                        <span class="text-white px-2 py-1 rounded text-xs"
                            style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
                        <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">Eagle
                            Regency Hotel</h3>
                        <p class="text-xs text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Kandy, Sri
                            Lanka</p>
                        <div class="flex items-center mt-2">
                            <span class="text-white px-2 py-1 rounded text-xs"
                                style="background-color: rgb(31, 143, 178); font-family: 'Noto Sans', sans-serif;">8</span>
                            <div style="font-family: 'Noto Sans', sans-serif;">
                                <span class="text-xs ml-2 block">Very Good</span>
                                <span class="text-xs ml-2 block">337 Reviews</span>
                            </div>
                        </div>
                    </div>
            </div>
            @endfor
        </div>

        <!-- Arrows -->
        <button
            class="scroll-left hidden absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2" style="margin-left:-20px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button
            class="scroll-right absolute top-1/2 right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-2"
            style="margin-right:-20px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    </div>
</section>

<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('messages.Homes guests love')}}</h2>

        <div class="relative">
            <div class="scroll-container flex space-x-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
                @for ($i = 0; $i < 5; $i++)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden relative min-w-[250px]">
                    <button
                        style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;"
                        onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';">🤍</button>
                    <img src="{{ asset('images/AAAA.jpg') }}" alt="Hotel Image"
                        class="w-full h-64 object-cover">
                    <div class="p-4">
                        <span class="text-white px-2 py-1 rounded text-xs"
                            style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
                        <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">Eagle
                            Regency Hotel</h3>
                        <p class="text-xs text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Kandy, Sri
                            Lanka</p>
                        <div class="flex items-center mt-2">
                            <span class="text-white px-2 py-1 rounded text-xs"
                                style="background-color: rgb(31, 143, 178); font-family: 'Noto Sans', sans-serif;">8</span>
                            <div style="font-family: 'Noto Sans', sans-serif;">
                                <span class="text-xs ml-2 block">Very Good</span>
                                <span class="text-xs ml-2 block">337 Reviews</span>
                            </div>
                        </div>
                        <div class="mt-1 text-right" style="font-family: 'Noto Sans', sans-serif;">
                            <span class="text-xs text-gray-700 font-semibold">Starting from</span>
                            <span class="text-sm text-black font-bold"> @price(82896, 'LKR')</span>
                        </div>
                    </div>
            </div>
            @endfor
        </div>

        <!-- Arrows -->
        <button
            class="scroll-left hidden absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2" style="margin-left:-20px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button
            class="scroll-right absolute top-1/2 right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-2"
            style="margin-right:-20px;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">

            <!-- Card 1 -->
            <div
                class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/cal.png') }}" alt="Mountains"
                    class="w-16 h-16 object-cover rounded-md mr-4">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1"
                        style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Book now, pay at the property')}}
                    </h2>
                    <p class="text-sm text-gray-600 mb-3" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.FREE cancellation on most rooms')}}
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/world.png') }}" alt="Beach"
                    class="w-16 h-16 object-cover rounded-md mr-4">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1"
                        style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.2+ million properties worldwide')}}
                    </h2>
                    <p class="text-sm text-gray-600 mb-3" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Hotels, guest houses, apartments, and more...')}}'
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/man.png') }}" alt="City"
                    class="w-16 h-16 object-cover rounded-md mr-4">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1"
                        style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Trusted customer service you can rely on, 24/7')}}
                    </h2>
                    <p class="text-sm text-gray-600 mb-3" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __("messages.We’re always here to help")}}
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
            {{ __('messages.Get inspiration for your next trip')}}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Large Card -->
            <div class="relative rounded-lg overflow-hidden h-96 md:col-span-6">
                <img src="{{ asset('images/newyear.png') }}" alt="New Year's Eve"
                    class="w-full h-full object-cover">
                <div
                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white p-4">
                    <h3 class="text-xl font-bold" style="font-family: 'Noto Sans', sans-serif;">New Year’s Eve in New
                        York City</h3>
                    <p class="text-sm mt-1" style="font-family: 'Noto Sans', sans-serif;">Ring in the new year with
                        iconic moments and unforgettable memories in New York City</p>
                </div>
            </div>

            <!-- Small Card 1 -->

            <div class="min-w-[250px]  md:col-span-3 flex flex-col">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/AA.png') }}" alt="Apartments" class="w-full h-60 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">6
                        best ryokans in Japan to
                        rejuverate yourself
                        </h3>
                        <p class="text-sm mt-1" style="font-family: 'Noto Sans', sans-serif;">Discover unmissable
                            ryokans to relax and
                            unwind in style
                        </p>
                </div>
            </div>

            <!-- Small Card 2 -->
            <div class="min-w-[250px]  md:col-span-3 flex flex-col">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/AAA.png') }}" alt="Apartments" class="w-full h-60 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">7
                        best places in Asia to celebrate
                        Christmas
                    </h6>
                    <p class="text-sm mt-1" style="font-family: 'Noto Sans', sans-serif;">Discover the shimmering
                        lights and festive
                        sights of Asia’s Holiday season.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Offers Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Title -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ __('messages.Travel more, spend less')}}</h2>

        <!-- Offer Card -->
        <div class="bg-white-50 p-2 rounded flex items-center justify-between border border-solid border-gray-300">
            <!-- Text Content -->
            <div class="ml-4">
                <p class="font-medium font-semibold">{{ __('messages.Sign in, save money')}}</p>
                <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Save 10% or more at participating properties -just look for the blue Genius label')}}</p>
                <button class=" text-white px-4 py-1 rounded mt-2 w-auto"
                    style="font-family: 'Noto Sans', sans-serif;background-color:#3CC0E9;">{{ __('messages.Sign In')}}</button>
            </div>

            <!-- Image -->
            <img src="{{ asset('images/genius.png') }}" alt="Offer Image" class="w-32 h-32 rounded ml-4">
        </div>
    </div>
</section>
<!--End Offers Section-->
<section class="py-2 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="rounded-lg overflow-hidden shadow-md flex flex-col lg:flex-row items-center justify-between border border-gray-200">

            <!-- Left Side -->
            <div class="relative w-full lg:w-1/2 bg-white flex items-center justify-center py-4 px-4">

                <!-- Decorative Half Circle -->
                <img src="/images/small-ellipse.png" alt="Decorative Circle"
                    class="absolute left-[-40px] top-1/2 transform -translate-y-1/2 w-20 h-20" />

                <!-- Container for Ellipse and Text -->
                <div class="relative">
                    <!-- Ellipse Image -->
                    <img src="{{ asset('images/Ellipse 6.png') }}" alt="Find homes background"
                        class="max-w-xs md:max-w-sm lg:max-w-md" style="margin-top:-130px;" />

                    <!-- Text Overlay -->
                    <div
                        class="absolute inset-0 flex flex-col items-center justify-center text-center text-white font-semibold space-y-1">
                        <h2 class="text-2xl md:text-3xl lg:text-4xl " style="margin-top:-70px;">{{ __('messages.Find homes')}}</h2>

                        <p class="text-xl md:text-2xl">{{ __('messages.For your next trip')}}</p>
                        <a href="#"
                            class="mt-2 text-[#35C1EA] bg-white px-4 py-2 rounded shadow hover:bg-gray-100 transition text-sm md:text-base">
                            {{ __('messages.Discover homes')}}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side -->
            <div class="w-full lg:w-1/2 px-4 py-4 flex justify-center">
                <img src="{{ asset('assets/home.svg') }}" alt="Travel Illustration" class="w-full max-w-md" />
            </div>
        </div>
    </div>
</section>

<!--Popular with Travellers-->
<section class="py-12 bg-white mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
            {{ __('messages.Popular with travelers from Sri Lanka') }}
        </h2>

        <!-- Tabs -->
        <div class="flex space-x-4 overflow-x-auto mb-4">
            <button id="tab-domestic" class="rounded-full tab-button active-tab"
                onclick="toggleTab('domestic')">{{ __('messages.Domestic cities')}}</button>
            <button id="tab-international" class="rounded-full tab-button"
                onclick="toggleTab('international')">{{ __('messages.International cities')}}</button>
            <button id="tab-regions" class="rounded-full tab-button"
                onclick="toggleTab('regions')">{{ __('messages.Regions')}}</button>
            <button id="tab-countries" class="rounded-full tab-button"
                onclick="toggleTab('countries')">{{ __('messages.Countries')}}</button>
            <button id="tab-places" class="rounded-full tab-button"
                onclick="toggleTab('places')">{{ __('messages.Places to stay')}}</button>
        </div>

        <!-- Content Panels -->
        <div id="tab-content" class="mt-4">
            <!-- Domestic -->
            <!-- Domestic -->
            <div id="content-domestic"
                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-y-2 w-full text-sm"
                    style="font-family: 'Lato', sans-serif;">

                @foreach ($cities as $city)
                    <span>{{ $city['city'] }} hotels</span>
                @endforeach


                <div class="col-span-full w-full text-left mt-2 mb-16">
                    <button class="text-blue-600 hover:underline" style="color:rgb(31, 143, 178);">+ Show more</button>
                </div>
            </div>

            <!-- International -->
            <div id="content-international" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 hidden"></div>

            <!-- Regions -->
            <div id="content-regions" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 hidden"></div>

            <!-- Countries -->
            <div id="content-countries" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 hidden"></div>

            <!-- Places -->
            <div id="content-places" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 hidden"></div>
        </div>
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

@push('scripts')
<script src="{{ asset('assets/Customer/js/home.js') }}"></script>
@endpush

@endsection