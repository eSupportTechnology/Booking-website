@extends('frontend.master')

@section('content')

<!-- resources/views/components/airport-taxi-booking.blade.php -->
<section class="py-8 bg-gray-100" x-data="{ isReturnTrip: false, checkin: '', returnDate: '' }">

    <!-- Search Box: Overlapping both sections -->
    <div class="relative z-10 -mt-8 px-4">
        <div class="p-6 max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold mb-2 mt-4">Find the perfect hotel on {{ config('domains.domain') }}</h1>
            <p class="text-gray-600 mb-6 text-xl">From cheap hotels to luxury rooms and everything in between</p>

            <!-- Alpine.js CDN (Required for Dropdowns) -->
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

            <!-- Search Form -->
            <form method="GET"
                  class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-2 md:gap-0 border-4 border-yellow-400 max-w-4xl mx-auto lg:ml-0 overflow-visible text-sm">

                <!-- Destination Selector -->
                <div x-data="{ open: false, destination: '' }"
                     class="relative px-2 py-1 flex-1 border-b md:border-b-0 md:border-r border-gray-300 w-full">
                    <button @click="open = !open" type="button"
                            class="flex items-center gap-2 w-full text-left text-sm">
                        <i class="fas fa-search text-lg"></i>
                        <span x-text="destination || 'Search by destination'"
                              style="font-family: 'Noto Sans', sans-serif;"
                              class="text-gray-800 truncate text-base"></span>
                    </button>

                    <!-- Dropdown Box -->
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

                <!-- Search Button -->
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


<!-- resources/views/hotels.blade.php -->
<!-- resources/views/hotels.blade.php -->
<section class="bg-white py-8">
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Heading -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">
            Latest hotels for you
        </h2>
        <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
            Find a great deal on a hotel for tonight or an upcoming trip
        </p>

        <!-- Hotels Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($properties as $property)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col w-full max-w-sm">
                    <div class="relative">
                        <img src="{{ $property->files->where('file_type', 'image')->first() ? asset('storage/' . $property->files->where('file_type', 'image')->first()->path) : asset('images/AAA.png') }}"
                             alt="{{ $property->title }}" class="w-full h-48 object-cover">
                        @include('components.deal-banner', ['property' => $property])
                    </div>
                    <div class="p-4 flex flex-col justify-between flex-1">
                        <div class="flex justify-between items-center mb-2">
                            <a href="{{ route('single-hotel', $property->id) }}" class="text-lg font-semibold hover:text-blue-600 transition">{{ $property->title }}</a>
                            @if($property->stars)
                                <span class="inline-block bg-yellow-400 text-white text-xs font-medium px-2 py-1 rounded">
                                    {{ $property->stars }}-Star
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mb-2">{{ $property->city }} • {{ $property->address }}</p>
                        <div class="flex items-center mb-4">
                            @php
                                $avgRating = $property->reviews->avg('rating') ?? 0;
                                $reviewCount = $property->reviews->count();
                            @endphp
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <div class="w-3 h-3 {{ $i <= $avgRating ? 'bg-yellow-500' : 'bg-gray-300' }} rounded-full"></div>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">{{ number_format($avgRating, 1) }} ({{ $reviewCount }} reviews)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-right">
                                @if($property->pricing)
                                    <p class="text-sm text-gray-500">Starting from</p>
                                    <p class="text-lg font-bold text-gray-800">@currency($property->pricing->price_per_night ?? 0, $property->pricing->currency ?? 'USD')</p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('single-hotel', $property->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white text-sm px-3 py-2 rounded-lg transition">
                                    View Details
                                </a>
                                <a href="{{ route('customer.bookings.show', $property->id) }}" class="bg-[#3CC0E9] hover:bg-blue-600 text-white text-sm px-3 py-2 rounded-lg transition">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500 text-lg">No hotels available at the moment.</p>
                </div>
            @endforelse
        </div> <!-- End of Hotels Grid -->

        <!-- Pagination -->
        @if($properties->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $properties->links() }}
            </div>
        @endif

    </div>


</section>

<!-- Deals Section -->
@include('components.deals-section', ['title' => 'Hotel Deals & Offers', 'limit' => 6])

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
@endsection
