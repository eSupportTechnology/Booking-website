@extends('frontend.master')

@section('content')

<section class="py-8 bg-gray-100" x-data="{ isReturnTrip: false, checkin: '', returnDate: '' }">
    <div class="relative z-10 -mt-8 px-4">
        <div class="p-6 max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold mb-2 mt-4">Find the perfect Alternative Places on {{ config('domains.domain') }}</h1>
            <p class="text-gray-600 mb-6 text-xl">Discover unique stays and alternative accommodations</p>

            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

            <form method="GET"
                class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-2 md:gap-0 border-4 border-yellow-400 max-w-4xl mx-auto lg:ml-0 overflow-visible text-sm">

                <div x-data="{ open: false, destination: '' }"
                    class="relative px-2 py-1 flex-1 border-b md:border-b-0 md:border-r border-gray-300 w-full">
                    <button @click="open = !open" type="button"
                        class="flex items-center gap-2 w-full text-left text-sm">
                        <i class="fas fa-search text-lg"></i>
                        <span x-text="destination || 'Search by destination'"
                            style="font-family: 'Noto Sans', sans-serif;"
                            class="text-gray-800 truncate text-base"></span>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
                        <template x-for="city in ['New York', 'Los Angeles', 'London', 'Paris', 'Tokyo']" :key="city">
                            <button type="button"
                                @click="destination = city; open = false"
                                class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                                <span x-text="city"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Hidden field -->
                    <input type="hidden" name="destination" :value="destination">
                </div>

                <!-- Dates Selector -->
                <div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }"
                    class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1 w-full">
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
                    class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1 w-full">
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

                <div class="px-2 py-1 w-full md:w-auto">
                    <button type="submit"
                        class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm"
                        style="background-color:#3CC0E9;">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="bg-white py-8">
    <div class="p-6 max-w-7xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            Latest Alternative Places for you
        </h2>
        <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
            Discover unique and alternative accommodations for your stay
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($properties as $property)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col w-full max-w-sm">
                <div class="relative">
                    <a href="{{ route('single-hotel', $property->id) }}">
                        <img src="{{ $property->files->where('file_type', 'image')->first() ? asset('storage/' . $property->files->where('file_type', 'image')->first()->path) : asset('images/AA.png') }}"
                            alt="{{ $property->title }}" class="w-full h-48 object-cover hover:opacity-90 transition cursor-pointer">
                    </a>
                    @include('components.deal-banner', ['property' => $property])
                </div>
                <div class="p-4 flex flex-col justify-between flex-1">
                    <div class="flex justify-between items-center mb-2">
                        <a href="{{ route('single-hotel', $property->id) }}" class="text-lg font-semibold hover:text-blue-600 transition">{{ $property->title }}</a>
                        @php
                        $avgRating = $property->reviews->avg('rating') ?? 0;
                        $reviewCount = $property->reviews->count();
                        @endphp
                        <span class="ml-2 text-sm text-gray-600">{{ number_format($avgRating, 1) }} ({{ $reviewCount }} reviews)</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-2">{{ $property->city }} • {{ $property->address }}</p>
                    <div class="flex justify-between items-center">
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Per Night</p>
                            <p class="text-sm font-semibold text-gray-800">Adult: {{ \App\Helpers\CurrencyHelper::convertAndFormat($property->adult_price ?? 0, $property->currency ?? 'LKR') }}</p>
                            @if($property->child_price > 0)
                            <p class="text-xs text-gray-600">Child: {{ \App\Helpers\CurrencyHelper::convertAndFormat($property->child_price ?? 0, $property->currency ?? 'LKR') }}</p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('customer.bookings.show', $property->id) }}" class="bg-[#3CC0E9] hover:bg-blue-600 text-white text-sm px-3 py-2 rounded-lg transition w-full text-center">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500 text-lg">No alternative places available at the moment.</p>
            </div>
            @endforelse
        </div>

        @if($properties->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $properties->links() }}
        </div>
        @endif
    </div>
</section>

<!-- Deals Section -->
@include('components.deals-section', ['title' => 'Alternative Place Deals & Offers', 'limit' => 6])

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Browse by property type</h2>
        <div class="flex space-x-4 overflow-x-auto pb-2">

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

            <a href="{{ route('alternative-places-listing') }}" class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <img src="{{ asset('images/resorts.jpg') }}" alt="Alternative Places" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">
                        Alternative Places
                    </h6>
                </div>
            </a>

        </div>
    </div>
</section>
@endsection