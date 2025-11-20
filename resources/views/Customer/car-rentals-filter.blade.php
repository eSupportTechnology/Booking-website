@extends('frontend.master')

<style>
/* Tailwind/Booking.com color theme approximation */
.bg-primary { background-color: #0071C2; }
.text-primary { color: #0071C2; }
.hover\:bg-primary-dark\:hover { background-color: #005A9C; }
.filter-section-divider {
    display: block;
    height: 1px;
    background-color: #e5e7eb; /* gray-200 */
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.result-image {
    height: 200px;
    min-width: 33.333%; /* 1/3 width for the image */
}
/* Style for toggle indicators */
.filter-toggle-icon {
    transition: transform 0.2s;
}
.filter-toggle-icon.rotated {
    transform: rotate(180deg);
}
/* Mobile Sidebar */
.sidebar-open {
    transform: translateX(0) !important;
}
.mobile-backdrop {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); z-index: 30; display: none;
}
/* Car Category Tags (Top of Results) */
.category-tab {
    padding: 0.5rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 9999px; /* full rounded */
    cursor: pointer;
    transition: all 0.2s;
}
.category-tab.active {
    background-color: #0071C2;
    color: white;
    border-color: #0071C2;
}

.results-wrapper {
    margin-top: 0 !important; 
    padding-top: 30px; /* Adjust to match the look */
}

@media (min-width: 1024px) {
    .results-wrapper {
        padding-top: 50px; /* Desktop spacing */
    }
}

</style>


@section('content')

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@php
// Define the filter groups structure using the data passed from the controller ($filterGroups)
$groupedFacets = [
    [ 'title' => 'Transmission', 'name' => 'transmission', 'id_prefix' => 'transmission', 'items' => $filterGroups['transmission'] ?? [], 'visible_count' => 5, 'type' => 'radio' ],
    [ 'title' => 'Supplier', 'name' => 'supplier', 'id_prefix' => 'supplier', 'items' => $filterGroups['supplier'] ?? [], 'visible_count' => 5, 'type' => 'checkbox' ],
    [ 'title' => 'Mileage/Kilometres', 'name' => 'mileage', 'id_prefix' => 'mileage', 'items' => $filterGroups['mileage'] ?? [], 'visible_count' => 5, 'type' => 'checkbox' ],
    [ 'title' => 'Number of seats', 'name' => 'seats', 'id_prefix' => 'seats', 'items' => $filterGroups['seats'] ?? [], 'visible_count' => 5, 'type' => 'radio' ],
    [ 'title' => 'Car category', 'name' => 'car_category', 'id_prefix' => 'car-category', 'items' => $filterGroups['car_category'] ?? [], 'visible_count' => 5, 'type' => 'checkbox' ],
    [ 'title' => 'Price per day', 'name' => 'price_range', 'id_prefix' => 'price', 'items' => $filterGroups['price_range'] ?? [], 'visible_count' => 5, 'type' => 'checkbox' ],
    [ 'title' => 'Review Score', 'name' => 'review_score', 'id_prefix' => 'review-score', 'items' => $filterGroups['review_score'] ?? [], 'visible_count' => 5, 'type' => 'checkbox' ],
    [ 'title' => 'Fuel Type', 'name' => 'fuel_type', 'id_prefix' => 'fuel_type', 'items' => $filterGroups['fuel_type'] ?? [], 'visible_count' => 5, 'type' => 'checkbox' ],
    [ 'title' => 'Cities', 'name' => 'nearest_city',  'id_prefix' => 'nearest_city', 'items' => $filterGroups['nearest_city'] ?? [], 'visible_count' => 5, 'type' => 'checkbox'],

];

// Helper function definition
if (!function_exists('simple_slug')) {
    function simple_slug($text) {
        return preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($text)));
    }
}
@endphp

<!-- Hero Section -->
<section class="text-white py-8 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
    </div>
</section>

<!-- Booking Form -->
<div class="relative z-10 -mt-8 px-4">
  <form method="GET" action="{{ route('customer.carsearch') }}"
    class="bg-white rounded-xl px-3 py-2 shadow-lg flex flex-col md:flex-row 
           items-stretch md:items-center gap-3 md:gap-0 
           border-2 sm:border-4 border-yellow-400 
           w-full max-w-6xl mx-auto overflow-visible text-sm">

    <div class="flex flex-col md:flex-row flex-wrap md:flex-nowrap items-stretch w-full gap-3 md:gap-x-4">

      <!-- Pickup -->
      <div x-data="{ openPickup: false, pickupLocation: '{{ request('pickup') }}' }" class="relative flex-1 min-w-[200px]">
        <button @click="openPickup = !openPickup" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded">
          <i class="fas fa-search text-lg"></i>
          <span x-text="pickupLocation || 'Pick-up location'" class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="openPickup" @click.outside="openPickup = false"
          class="absolute z-50 bg-white shadow-lg rounded mt-1 w-full sm:max-w-xs border">
          <ul class="max-h-48 overflow-y-auto">
            <li @click="pickupLocation = 'Colombo'; openPickup = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Colombo</li>
            <li @click="pickupLocation = 'Negombo'; openPickup = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Negombo</li>
            <li @click="pickupLocation = 'Kandy'; openPickup = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Kandy</li>
          </ul>
        </div>
        <input type="hidden" name="pickup" :value="pickupLocation" />
      </div>

      <!-- Divider -->
      <div class="hidden md:flex justify-center items-center">
        <div class="border-r border-black h-8"></div>
      </div>

      <!-- Drop-off -->
      <div x-data="{ openDestination: false, destinationLocation: '{{ request('destination') }}' }"
        id="dropoffField"
        class="relative flex-1 min-w-[200px]">
        <button @click="openDestination = !openDestination" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded">
          <i class="fas fa-flag-checkered text-lg"></i>
          <span x-text="destinationLocation || 'Drop-off location'"
            class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="openDestination" @click.outside="openDestination = false"
          class="absolute z-50 bg-white shadow-lg rounded mt-1 w-full sm:max-w-xs border">
          <ul class="max-h-48 overflow-y-auto">
            <li @click="destinationLocation = 'Airport'; openDestination = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Airport</li>
            <li @click="destinationLocation = 'Galle'; openDestination = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Galle</li>
            <li @click="destinationLocation = 'Matara'; openDestination = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Matara</li>
          </ul>
        </div>
        <input type="hidden" name="destination" :value="destinationLocation" />
      </div>

      <!-- Divider -->
      <div class="hidden md:flex justify-center items-center">
        <div class="border-r border-black h-8"></div>
      </div>

      <!-- Pickup Date -->
      <div x-data="{ open: false, checkin: '{{ request('checkin') }}' }" class="relative flex-1 min-w-[200px]">
        <button @click="open = !open" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded">
          <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
          <span x-text="checkin ? new Date(checkin).toLocaleString() : 'Pick-up Date & Time'"
            class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="open" @click.outside="open = false"
          class="absolute z-50 bg-white shadow-xl rounded-xl p-4 mt-2 w-full sm:w-72 max-w-xs right-0 text-gray-800 space-y-2 text-sm">
          <label for="checkin-date" class="block text-sm font-medium text-gray-700 mb-1">Pick Date & Time</label>
          <input type="datetime-local" id="checkin-date" x-model="checkin"
            class="w-full border p-2 rounded outline-none" />
        </div>
        <input type="hidden" name="checkin" :value="checkin" />
      </div>

      <!-- Divider -->
      <div class="hidden md:flex justify-center items-center">
        <div class="border-r border-black h-8"></div>
      </div>

      <!-- Drop-off Date -->
      <div x-data="{ open: false, checkout: '{{ request('checkout') }}' }" class="relative flex-1 min-w-[200px]">
        <button @click="open = !open" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded">
          <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
          <span x-text="checkout ? new Date(checkout).toLocaleString() : 'Drop-off Date & Time'"
            class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="open" @click.outside="open = false"
          class="absolute z-50 bg-white shadow-xl rounded-xl p-4 mt-2 w-full sm:w-72 max-w-xs right-0 text-gray-800 space-y-2 text-sm">
          <label for="checkout-date" class="block text-sm font-medium text-gray-700 mb-1">Drop Date & Time</label>
          <input type="datetime-local" id="checkout-date" x-model="checkout"
            class="w-full border p-2 rounded outline-none" />
        </div>
        <input type="hidden" name="checkout" :value="checkout" />
      </div>

      <!-- Submit Button -->
      <div class="flex-shrink-0 w-full md:w-auto md:self-center">
        <button type="submit"
          class="w-full bg-[#3CC0E9] hover:bg-blue-700 text-white font-semibold px-4 py-[10px] rounded-lg text-sm">
          Search
        </button>
      </div>

    </div>
  </form>
</div>
<!-- ===================== END TOP SEARCH FILTER SECTION ===================== -->

<div id="mobile-backdrop" class="mobile-backdrop"></div>

<div class="results-wrapper max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col lg:flex-row gap-6">

        {{-- --- LEFT COLUMN: Filter Sidebar --- --}}
        <aside id="filters-sidebar" class="
            fixed inset-0 z-40 bg-white shadow-xl max-w-xs
            transform -translate-x-full transition-transform duration-300
            lg:w-72 lg:static lg:block lg:translate-x-0 lg:sticky lg:top-6 lg:h-fit
        ">
            <div class="h-full overflow-y-auto p-4 border-r lg:border-none">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Filter</h2>
                    <button id="close-sidebar-btn" class="lg:hidden p-1 text-gray-500 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Clear Filters (Uses the dedicated search route) --}}
                <a href="{{ route('customer.carsearch') }}" class="text-sm text-primary hover:text-primary-dark mb-4 block text-right">Clear all filters</a>

                {{-- --- START FILTER FORM (Submits filter changes via GET) --- --}}
                <form method="GET" action="{{ route('customer.carsearch') }}" id="filter-form">
                    {{-- Hidden inputs to maintain booking form context when applying sidebar filters --}}
                    @foreach (['pickup', 'destination', 'checkin', 'checkout'] as $key)
                        @if (request($key))
                            <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
                        @endif
                    @endforeach

                    {{-- --- CONSOLIDATED LOOPED FILTERS (Faceted Checkboxes/Radio) --- --}}
                    @foreach ($groupedFacets as $group)
                        @php
                            $isComplex = count($group['items']) > $group['visible_count'];
                            $items = collect($group['items']);
                            $visibleItems = $items->take($group['visible_count']);
                            $hiddenItems = $isComplex ? $items->skip($group['visible_count']) : collect();
                            $contentId = "{$group['id_prefix']}-content";
                            $hiddenId = "hidden-{$group['id_prefix']}";
                            $toggleId = "toggle-{$group['id_prefix']}";
                            
                            $currentValues = $currentFilters[$group['name']] ?? [];
                            if (!is_array($currentValues)) {
                                $currentValues = [$currentValues];
                            }
                            // Determine input type and name format
                            $inputType = $group['type'] ?? 'checkbox';
                            $inputName = $group['name'] . ($inputType === 'checkbox' ? '[]' : '');
                        @endphp

                        <div class="mb-6" id="{{ $group['id_prefix'] }}-section">
                            <h3 class="font-bold text-lg text-gray-900 mb-2 flex justify-between items-center cursor-pointer filter-toggle-header" data-target="{{ $contentId }}">
                                {{ $group['title'] }}
                                <svg class="w-4 h-4 text-gray-400 filter-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </h3>
                            <div id="{{ $contentId }}" class="space-y-3">
                                {{-- Visible Items --}}
                                @foreach($visibleItems as $value => $count)
                                    <label for="{{ $group['id_prefix'] }}-{{ simple_slug($value) }}" class="flex justify-between items-center cursor-pointer">
                                        <div class="flex items-center">
                                            <input type="{{ $inputType }}" id="{{ $group['id_prefix'] }}-{{ simple_slug($value) }}" name="{{ $inputName }}" value="{{ $value }}" class="form-checkbox h-4 w-4 text-primary rounded accent-primary"
                                                {{ in_array($value, $currentValues) ? 'checked' : '' }} onchange="this.form.submit()">
                                            <span class="ml-3 text-gray-700">{{ $value }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500 font-semibold count" data-{{ $group['name'] }}="{{ $value }}">{{ $count }}</span>
                                    </label>
                                @endforeach

                                {{-- Hidden Items Container --}}
                                @if ($hiddenItems->isNotEmpty())
                                    <div id="{{ $hiddenId }}" class="space-y-3 hidden">
                                        @foreach($hiddenItems as $value => $count)
                                            <label for="{{ $group['id_prefix'] }}-{{ simple_slug($value) }}" class="flex justify-between items-center cursor-pointer">
                                                <div class="flex items-center">
                                                    <input type="{{ $inputType }}" id="{{ $group['id_prefix'] }}-{{ simple_slug($value) }}" name="{{ $inputName }}" value="{{ $value }}" class="form-checkbox h-4 w-4 text-primary rounded accent-primary"
                                                        {{ in_array($value, $currentValues) ? 'checked' : '' }} onchange="this.form.submit()">
                                                    <span class="ml-3 text-gray-700">{{ $value }}</span>
                                                </div>
                                                <span class="text-xs text-gray-500 font-semibold count" data-{{ $group['name'] }}="{{ $value }}">{{ $count }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    {{-- Internal Show More/Less Toggle Button --}}
                                    <button id="{{ $toggleId }}" type="button" class="mt-3 text-sm font-medium text-primary hover:text-primary-dark">
                                        Show more
                                    </button>
                                @endif
                            </div>
                        </div>
                        @if (!$loop->last)
                            <div class="filter-section-divider"></div>
                        @endif
                    @endforeach
                </form>
            </div>
        </aside>

        {{-- --- RIGHT COLUMN: Search Results and Category Tabs --- --}}
        <main class="flex-1 min-w-0">
            
            {{-- Mobile Filter Button --}}
            <div class="lg:hidden mb-4">
                <button id="open-sidebar-btn" class="w-full py-3 bg-primary text-white font-bold rounded-lg shadow-lg flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zM15 10a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1v-2zM3 16a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zM19 16a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2z"/></svg>
                    Filter Results
                </button>
            </div>
            
            <div class="mb-4">
                <h1 class="text-xl font-bold text-gray-800 mb-3">{{ $filteredCars->total() }} cars available</h1>
                
                {{-- Category Tabs (From video) --}}
                <div class="flex flex-wrap gap-2 text-sm text-gray-600 border-b pb-3" id="category-tabs-container">
                    @foreach ($carCategoryTabs as $category)
                        @php 
                            $isActive = in_array($category, $currentFilters['car_category'] ?? []);
                        @endphp
                        <div data-category="{{ $category }}" 
                             class="category-tab {{ $isActive ? 'active' : '' }}">
                            {{ $category }}
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- --- RESULT CONTAINER --- --}}
            <div id="results-container" class="space-y-6">
                
                @if ($filteredCars->isEmpty())
                    {{-- Not Found Message (when no cars match) --}}
                    <div class="bg-white rounded-xl p-10 shadow-lg text-center border-t-4 border-yellow-500">
                        <h3 class="text-2xl font-semibold text-gray-800 mb-2">No Cars Found Matching Your Criteria.</h3>
                        <p class="text-gray-500">We could not find any active rentals for your selected locations, dates, or sidebar filters. Please try widening your search or clearing some filters.</p>
                        
                        {{-- Display filtered data for user context --}}
                        @if (array_filter(request()->all()))
                        <div class="mt-4 text-left inline-block p-3 bg-gray-50 rounded-lg text-xs text-gray-600">
                            **Active Search Parameters:**
                            <ul class="list-disc list-inside mt-1">
                            @foreach(array_filter(request()->all()) as $key => $value)
                                <li>**{{ $key }}:** {{ is_array($value) ? implode(', ', $value) : $value }}</li>
                            @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                @else
                    {{-- Dynamic result cards loop using LIVE $filteredCars --}}
                    @foreach ($filteredCars as $car)
                    <div class="flex bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow border border-gray-200 overflow-hidden result-item-list">
                        
                        {{-- Car Image (1/3 width) --}}
                        <div class="result-image flex items-center justify-center bg-gray-100 p-4">
                            @php
                                $img = $car->car_front
                                    ? asset('storage/' . $car->car_front)
                                    : 'https://placehold.co/300x200/cccccc/333333?text=Car+Image';
                            @endphp

                            <img src="{{ $img }}"
                                onerror="this.src='https://placehold.co/300x200/cccccc/333333?text=Car+Image'"
                                alt="{{ $car->model->model_name ?? 'Car' }}"
                                class="object-cover w-full h-full">
                        </div>


                        <div class="sm:w-1/2 p-4 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ $car->brand->brand_name ?? 'Unknown Brand' }}
                                        {{ $car->model->model_name ?? 'Unknown Model' }}
                                    </h3>
                                </div>

                                <p class="text-sm text-gray-500 mb-2">or similar {{ $car->carType->name ?? 'medium' }}</p>
                                
                                {{-- Specs list --}}
                                <div class="flex flex-col space-y-1 text-sm text-gray-700 mt-4">
                                    <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zm3 5a1 1 0 100 2h6a1 1 0 100-2H7z"/></svg>{{ $car->seats ?? 4 }} Seats</p>
                                    <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M7 4a1 1 0 011-1h4a1 1 0 011 1v1h-6V4zM4 6h12v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm2 2a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z"/></svg>{{ $car->large_bags ?? 1 }} Large bag</p>
                                    <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v4a1 1 0 00.293.707l2.5 2.5a1 1 0 001.414-1.414L11 9.586V5z"/></svg>{{ $car->transmission ?? 'Automatic' }}</p>
                                    <p class="flex items-center"><svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M12 12a2 2 0 100-4 2 2 0 000 4z"/></svg>{{ $car->mileage_type === 'unlimited' ? 'Unlimited mileage' : 'Limited mileage' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Price and CTA (1/4 width) --}}
                        <div class="sm:w-1/4 p-4 flex flex-col justify-between items-end border-t sm:border-t-0 sm:border-l border-gray-100 bg-gray-50">
                            <div class="flex items-center space-x-2 w-full justify-end">
                                <span class="text-xs text-gray-500">{{ $car->company->name ?? 'Supplier' }}</span>
                                <span class="inline-flex items-center bg-primary text-white text-sm font-bold px-2 py-1 rounded-sm">{{ $car->review_score ?? 7.6 }}</span>
                            </div>
                            <div class="text-right w-full mt-auto">
                                <div class="text-sm text-gray-500">Price per day</div>
                                <div class="text-3xl font-bold text-gray-800">US${{ number_format($car->price_per_day ?? 150, 0) }}</div>
                                <div class="text-xs text-green-600 mb-4 font-semibold">Free cancellation</div>
                            </div>
                            <a href="{{ route('customer.car.show', [
                                    'id' => $car->id,
                                    'pickup' => request('pickup'),
                                    'destination' => request('destination'),
                                    'checkin' => request('checkin'),
                                    'checkout' => request('checkout')
                                ]) }}" 
                            class="w-full bg-primary text-white text-center px-4 py-3 rounded-lg font-bold hover:bg-primary-dark transition-colors shadow-lg">
                                View deal
                            </a>

                        </div>
                    </div>
                    @endforeach
                    
                    {{-- Pagination Links --}}
                    <div class="mt-8 flex justify-center">
                        {{ $filteredCars->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>

<script>
    // --- CONSOLIDATED JAVASCRIPT LOGIC (To handle UI interactions) ---

    // Global elements for mobile toggle
    const sidebar = document.getElementById('filters-sidebar');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');
    const backdrop = document.getElementById('mobile-backdrop');
    const lgBreakpoint = 1024; // Tailwind's 'lg' breakpoint
    const filterForm = document.getElementById('filter-form');
    
    // Function to open/close the mobile sidebar
    function toggleSidebar(open) {
        if (window.innerWidth < lgBreakpoint) {
            if (open) {
                sidebar.classList.add('sidebar-open');
                backdrop.style.display = 'block';
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.remove('sidebar-open');
                backdrop.style.display = 'none';
                document.body.style.overflow = '';
            }
        }
    }
    if (openBtn) openBtn.addEventListener('click', () => toggleSidebar(true));
    if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(false));
    if (backdrop) backdrop.addEventListener('click', () => toggleSidebar(false));
    window.addEventListener('resize', () => {
        if (window.innerWidth >= lgBreakpoint) {
            sidebar.classList.remove('sidebar-open');
            backdrop.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    /**
     * Reusable function to manage the internal "Show more/less" toggle within a filter section.
     */
    function initializeShowMoreToggle(idPrefix, groupName) {
        const hiddenContainer = document.getElementById(`hidden-${idPrefix}`);
        const toggleButton = document.getElementById(`toggle-${idPrefix}`);

        if (toggleButton && hiddenContainer) {
            toggleButton.addEventListener('click', () => {
                hiddenContainer.classList.toggle('hidden');
                toggleButton.textContent = hiddenContainer.classList.contains('hidden') ? 'Show more' : 'Show less';
            });
        }
    }

    /**
     * Reusable function to manage the primary section minimization toggle.
     */
    function initializeSectionToggle() {
        document.querySelectorAll('.filter-toggle-header').forEach(header => {
            header.addEventListener('click', () => {
                const targetId = header.getAttribute('data-target');
                const targetContent = document.getElementById(targetId);
                const icon = header.querySelector('.filter-toggle-icon');

                if (targetContent) {
                    targetContent.classList.toggle('hidden');
                    if (icon) {
                        icon.classList.toggle('rotated', targetContent.classList.contains('hidden'));
                    }
                }
            });
            
            // Set initial icon state (down arrow = open)
            const targetContent = document.getElementById(header.getAttribute('data-target'));
            const icon = header.querySelector('.filter-toggle-icon');
            if (icon && targetContent && !targetContent.classList.contains('hidden')) {
                icon.classList.remove('rotated');
            }
        });
    }

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        initializeSectionToggle();

        const groupsToInitialize = [
            'transmission', 'supplier', 'mileage', 'extras', 'car-category', 'seats','nearest_city', 'price','payment', 'car-specs', 'fuel_type', 'deposit', 'fuel-policy', 'review-score' 
        ];

        groupsToInitialize.forEach(prefix => {
            let groupName = prefix.replace(/-/g, '_');
            initializeShowMoreToggle(prefix, groupName);
        });
        
        
        // Category Tab Handler (Clicking a top tab should select the corresponding sidebar filter)
        document.querySelectorAll('#category-tabs-container .category-tab').forEach(tab => {
            tab.addEventListener('click', (e) => {
                const category = e.currentTarget.getAttribute('data-category');
                const categoryFilterName = 'car_category[]';

                // 1. Deselect all other category checkboxes/tabs
                document.querySelectorAll(`input[name="${categoryFilterName}"]`).forEach(input => {
                    input.checked = false;
                });

                // 2. Find and select the corresponding checkbox in the sidebar
                const carCategoryInput = document.querySelector(`input[name="${categoryFilterName}"][value="${category}"]`);

                if (carCategoryInput) {
                    carCategoryInput.checked = true;
                }
                
                // 3. Submit the form to apply the filter
                filterForm.submit();
            });
        });
    });
</script>

@endsection
