@extends('frontend.master')

@section('title', 'Home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/Customer/css/home.css') }}">
@endpush
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@section('content')
    <!-- Hero Section -->
    <section class="text-white py-8 bg-[#1F8FB2] relative z-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Text -->
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

    <!-- Search Box: Overlapping both sections -->
    <div class="relative z-10 -mt-8 px-2 sm:px-4">
    <form action="{{ route('customer.search') }}" method="GET"
        class="bg-white rounded-xl px-2 py-1 sm:px-3 sm:py-2 shadow-lg
           flex flex-col md:flex-row items-stretch md:items-center
           gap-2 md:gap-0 border-2 sm:border-4 border-yellow-400
           max-w-full md:max-w-6xl mx-auto overflow-visible text-sm md:text-base">

        <!-- Destination Selector -->
        <div x-data="{ open: false, destination: '' }"
             class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1">
            <button @click="open = !open" type="button"
                class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/stay.svg') }}" alt="Stay"
                     class="w-5 h-5 sm:w-6 sm:h-6" />
                <span x-text="destination || '{{ __("messages.Where are you going?") }}'"
                      class="text-gray-800 truncate text-sm sm:text-base"></span>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false"
                class="absolute z-20 bg-white shadow-xl rounded-xl p-3 mt-2 w-64 sm:w-72 left-0 md:left-auto md:right-0 text-gray-800 space-y-2 text-sm">
                <template x-for="city in ['New York', 'Los Angeles', 'London', 'Paris', 'Tokyo', 'galle']" :key="city">
                    <button type="button" @click="destination = city; open = false"
                        class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                        <span x-text="city"></span>
                    </button>
                </template>
            </div>

            <input type="hidden" name="destination" :value="destination">
        </div>

        <!-- Dates Selector -->
        <div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }"
             class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1">
            <button @click="open = !open" type="button"
                class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/calender.svg') }}" class="w-5 h-5" />
                <span class="text-gray-800 truncate text-sm sm:text-base">
                    <template x-if="activeTab === 'check'">
                        <span>
                            <span x-text="checkIn || '{{ __("messages.Check-in") }}'"></span> —
                            <span x-text="checkOut || '{{ __("messages.Check-out") }}'"></span>
                        </span>
                    </template>
                    <template x-if="activeTab === 'flexible'">
                        <span x-text="flexibleOption || 'Flexible dates'"></span>
                    </template>
                </span>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false"
                class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-80 sm:w-96 left-0 md:left-auto md:right-0 text-gray-800 text-sm"
                x-transition>
                <!-- Tabs -->
                <nav class="flex border-b border-gray-200 mb-4 text-xs sm:text-sm">
                    <button @click.prevent="activeTab = 'check'"
                        :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                        class="px-2 sm:px-4 py-1 sm:py-2 border-b-2 font-semibold focus:outline-none">
                        {{ __('messages.Check-in / Check-out') }}
                    </button>
                    <button @click.prevent="activeTab = 'flexible'"
                        :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                        class="px-2 sm:px-4 py-1 sm:py-2 border-b-2 font-semibold focus:outline-none">
                        {{ __('messages.Flexible dates') }}
                    </button>
                </nav>

                <!-- Check-in/out -->
                <div x-show="activeTab === 'check'" x-transition>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-1">{{ __('messages.Check-in Date') }}</label>
                            <input type="date" name="checkIn" x-model="checkIn"
                                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-1">{{ __('messages.Check-out Date') }}</label>
                            <input type="date" name="checkOut" x-model="checkOut"
                                class="w-full border border-gray-300 rounded px-2 py-2 text-sm outline-none" />
                        </div>
                    </div>
                </div>

                <!-- Flexible -->
                <div x-show="activeTab === 'flexible'" x-transition>
                    <label class="block text-xs text-gray-500 font-semibold mb-1">{{ __('messages.Select Flexible Dates') }}</label>
                    <select x-model="flexibleOption"
                        class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none">
                        <option value="" disabled>{{ __('messages.Select option')}}</option>
                        <option value="Weekend Getaway">Weekend Getaway</option>
                        <option value="Next Month">Next Month</option>
                        <option value="Anytime">Anytime</option>
                        <option value="Custom Range">Custom Range</option>
                    </select>
                </div>

                <!-- Done -->
                <div class="mt-4 text-right">
                    <button @click="open = false"
                        class="bg-blue-600 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded hover:bg-blue-700 text-xs sm:text-sm">
                        {{ __('messages.Done') }}
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
                <span x-text="`${adults} {{ __('messages.adults') }} · ${children} {{ __('messages.children') }} · ${rooms} {{ __('messages.room') }}${rooms>1?'s':''}`"
                      class="text-gray-800 text-sm sm:text-base truncate"></span>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false"
                class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-64 sm:w-72 left-0 md:left-auto md:right-0 text-gray-800 space-y-4 text-sm">
                <!-- Adults -->
                <div class="flex items-center justify-between">
                    <span>{{ __('messages.adults') }}</span>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="if(adults>1) adults--"
                            class="px-2 py-1 bg-gray-200 rounded">−</button>
                        <span x-text="adults"></span>
                        <button type="button" @click="adults++"
                            class="px-2 py-1 bg-gray-200 rounded">+</button>
                    </div>
                </div>
                <!-- Children -->
                <div class="flex items-center justify-between">
                    <span>{{ __('messages.children')}}</span>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="if(children>0) children--"
                            class="px-2 py-1 bg-gray-200 rounded">−</button>
                        <span x-text="children"></span>
                        <button type="button" @click="children++"
                            class="px-2 py-1 bg-gray-200 rounded">+</button>
                    </div>
                </div>
                <!-- Rooms -->
                <div class="flex items-center justify-between">
                    <span>{{ __('messages.room')}}</span>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="if(rooms>1) rooms--"
                            class="px-2 py-1 bg-gray-200 rounded">−</button>
                        <span x-text="rooms"></span>
                        <button type="button" @click="rooms++"
                            class="px-2 py-1 bg-gray-200 rounded">+</button>
                    </div>
                </div>
                <!-- Pets -->
                <div class="flex items-center justify-between">
                    <span>{{ __('messages.Travelling with pets?') }}</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="pets" class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                        </div>
                    </label>
                </div>

                <p class="text-xs text-gray-500">
                    {{ __("messages.Assistance animals aren’t considered pets.") }}<br>
                    <a href="#" class="text-blue-600 underline">{{ __('messages.Read more about travelling with assistance animals') }}</a>
                </p>

                <!-- Done -->
                <button type="button" @click="open = false"
                    class="block w-full text-center bg-white border border-blue-600 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50">
                    {{ __('messages.Done')}}
                </button>
            </div>
        </div>

        <!-- Search Button -->
        <div class="w-full md:w-auto px-2 py-1">
            <button type="submit"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 sm:px-4 py-2 rounded-lg text-sm"
                style="background-color:#3CC0E9;">
                {{ __('messages.Search') }}
            </button>
        </div>
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

            // Predefined fallback cities (if backend has less than 5)
            $fallbackCities = [
                ['city' => 'Colombo', 'image' => asset('images/colombo.jpg')],
                ['city' => 'Nuwara Eliya', 'image' => asset('images/nuwara.jpg')],
                ['city' => 'Sigiriya', 'image' => asset('images/sigiriya.jpg')],
                ['city' => 'Ella', 'image' => asset('images/ella.png')],
                ['city' => 'Dambulla', 'image' => asset('images/dambulla.jpg')],
            ];

            // Fill missing cards from fallback
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

    <!--  Deals for the weekend Section -->
    <section class="scroll-section py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                {{ __('messages.Deals for the weekend')}}
            </h2>
            <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Save on stays for 16 May - 18 May
            </p>
        </div>

        <div class="relative">
            <!-- Scroll wrapper with arrows -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <!-- Scrollable container -->
                <div class="scroll-container flex gap-4 overflow-x-auto scroll-smooth no-scrollbar">
                    <!-- Hotel Card Template Start -->
                    @for ($i = 0; $i < 5; $i++)
                        <div
                            class="min-w-[300px] max-w-[300px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
                            <img src="{{ asset('images/property.png') }}" alt="Hotel Image"
                                class="w-full h-[230px] object-cover">
                            <div class="p-4">
                                <span class="text-white px-2 py-1 rounded text-xs"
                                    style="background-color: rgb(31, 143, 178); font-family: 'Noto Sans', sans-serif;">Genius</span>
                                <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">Eagle
                                    Regency Hotel</h3>
                                <p class="text-xs text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Kandy, Sri
                                    Lanka</p>
                                <div class="flex items-center mt-2">
                                    <span class="text-white px-2 py-1 rounded text-xs"
                                        style="background-color: rgb(31, 143, 178);">8</span>
                                    <div class="ml-2" style="font-family: 'Noto Sans', sans-serif;">
                                        <span class="text-xs block">Very Good</span>
                                        <span class="text-xs block">337 Reviews</span>
                                    </div>
                                </div>
                                <button class="text-xs text-white px-2 py-1 rounded mt-2"
                                    style="background-color:#1D9D39; font-family: 'Noto Sans', sans-serif;">Getaway
                                    Deal</button>
                                <p class="text-gray-600 mt-2 text-xs" style="font-family: 'Noto Sans', sans-serif;">
                                    2 nights
                                    <span class="text-xs line-through" style="color:#FF0004;"><x-price :amount="72000" currency="LKR" /></span>
                                    <span style="color:black; font-weight:bold;"><x-price :amount="26844" currency="LKR" /></span>
                                </p>
                            </div>
                        </div>
                    @endfor
                    <!-- Hotel Card Template End -->
                </div>

                <!-- Left Arrow -->
                <button
                    class="scroll-left hidden absolute top-[42%] left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Right Arrow -->
                <button
                    class="scroll-right absolute top-[42%] right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

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
                    class="scroll-left hidden absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2"style="margin-left:-20px;">
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
                    class="scroll-left hidden absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2"style="margin-left:-20px;">
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
            <div id="content-domestic"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-y-2 w-full text-sm"
                style="font-family: 'Lato', sans-serif;">

                <span>Kandy hotels</span>
                <span>Nuwara Eliya hotels</span>
                <span>Colombo hotels</span>
                <span>Ella hotels</span>
                <span>Anuradhapura hotels</span>

                <span>Kandy hotels</span>
                <span>Nuwara Eliya hotels</span>
                <span>Colombo hotels</span>
                <span>Ella hotels</span>
                <span>Anuradhapura hotels</span>

                <span>Kandy hotels</span>
                <span>Nuwara Eliya hotels</span>
                <span>Colombo hotels</span>
                <span>Ella hotels</span>
                <span>Anuradhapura hotels</span>

                <span>Kandy hotels</span>
                <span>Nuwara Eliya hotels</span>
                <span>Colombo hotels</span>
                <span>Ella hotels</span>
                <span>Anuradhapura hotels</span>

                <!-- Show more button -->
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


    @push('scripts')
        <script src="{{ asset('assets/Customer/js/home.js') }}"></script>
    @endpush

@endsection
