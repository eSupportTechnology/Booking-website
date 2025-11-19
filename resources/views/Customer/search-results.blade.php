@extends('frontend.master')

@push('styles')
<style>
/* Tailwind/Booking.com color theme approximation */
.bg-primary { background-color: #0071C2; }
.text-primary { color: #0071C2; }
.hover\:bg-primary-dark:hover { background-color: #005A9C; }
.filter-section-divider {
    display: block;
    height: 1px;
    background-color: #e5e7eb; /* gray-200 */
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.result-image {
    height: 250px;
    min-width: 33.333%; /* 1/3 width for the image */
}
/* Style for toggle indicators (optional visual enhancement) */
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
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 30; /* Below the sidebar (z-40) */
    display: none;
}

/* --- NEW STYLES FOR GRID/LIST VIEW --- */

/* Base style for a result item in List View (original layout) */
.result-item-list {
    display: flex; /* Original horizontal layout */
    flex-direction: column;
}
@media (min-width: 640px) {
    .result-item-list {
        flex-direction: row; /* Horizontal on sm+ screens */
    }
}

/* Styles for the Grid View */
.results-grid-container {
    display: grid;
    grid-template-columns: repeat(1, minmax(0, 1fr));
    gap: 1.5rem; /* space-y-6 equivalent in grid gap */
}
@media (min-width: 768px) { /* md breakpoint */
    .results-grid-container {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
.results-grid-container .result-item {
    flex-direction: column; /* Stack image and content vertically */
}
.results-grid-container .result-item .result-image {
    height: 200px;
    min-width: 100%; /* Image takes full width in grid item */
}
.results-grid-container .result-item .sm\:w-1\/2 {
    width: 100%; /* Content takes full width */
}
.results-grid-container .result-item .sm\:w-1\/4 {
    width: 100%; /* Price/CTA takes full width */
}
.results-grid-container .result-item .sm\:border-t-0 {
    border-top: 1px solid #f3f4f6; /* Re-add top border for separation in stacked layout */
    border-left: none; /* Remove left border */
}
.results-grid-container .result-item .sm\:items-end {
    align-items: flex-start; /* Align price details to the start for better stack readability */
}
.loader-overlay {
  transition: opacity 0.3s ease;
}
.loader-overlay.hidden {
  opacity: 0;
  pointer-events: none;
}

</style>
@endpush

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<!-- Alpine.js for interactivity (required for x-data, x-show, etc.) -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>



{{-- 🔹 SEARCH FILTER BAR (property search kept intact, enhanced with the same structure as first file) --}}
<div class="relative z-10 -mt-8 px-2 sm:px-4 mb-6">
    <form id="search-form" action="{{ route('customer.search') }}" method="GET"
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
          class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1"
        >
          <div class="flex items-center gap-2 w-full">
            <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-5 h-5 sm:w-6 sm:h-6" />
            <input
              type="text"
              name="destination"
              x-model="query"
              @input="fetchSuggestions"
              placeholder="Where are you going?"
              autocomplete="off"
              class="w-full bg-transparent focus:outline-none text-sm sm:text-base text-gray-800"
            />
          </div>

          <!-- Suggestion Dropdown -->
          <ul 
            x-show="open" 
            @click.away="open = false"
            class="absolute z-30 bg-white border border-gray-200 rounded-xl shadow-xl mt-2 w-64 sm:w-72 max-h-64 overflow-y-auto"
          >
            <template x-for="city in results" :key="city">
              <li 
                @click="selectCity(city)"
                class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm text-gray-800"
                x-text="city"
              ></li>
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
        </div>


        <!-- Search Button -->
        <div class="w-full md:w-auto px-2 py-1">
            <button type="submit"
                class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 sm:px-4 py-2 rounded-lg text-sm"
                style="background-color:#3CC0E9;">
                Search
            </button>
        </div>
    </form>
</div>

{{-- 🔹 END SEARCH BAR SECTION --}}

<div id="mobile-backdrop" class="mobile-backdrop"></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col lg:flex-row gap-6">

        <aside id="filters-sidebar" class="filter-sidebar
            fixed inset-0 z-40 bg-white shadow-xl max-w-xs
            transform -translate-x-full transition-transform duration-300
            lg:w-72 lg:static lg:block lg:translate-x-0 lg:sticky lg:top-6 lg:h-fit
        ">
            <div class="h-full overflow-y-auto p-4 border-r lg:border-none">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Filter by:</h2>
                    <button id="close-sidebar-btn" class="lg:hidden p-1 text-gray-500 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- --- UNIQUE MANUAL FILTERS (kept exactly as you had them) --- --}}
                <div class="mb-4" id="budget-filter-section">
                    <h3 class="font-semibold text-gray-700 mb-2 flex justify-between items-center cursor-pointer filter-toggle-header" data-target="budget-content">
                        Your budget (per night)
                        <svg class="w-4 h-4 text-gray-400 filter-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </h3>
                    <div id="budget-content">
                        <div id="budget-display" class="text-lg font-bold text-primary mb-2">US$50</div>
                        <input type="range" id="budget-range" class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer range-sm accent-primary" value="50" min="0" max="500">
                        <input type="hidden" name="min_price" id="minPrice" value="0">
                        <input type="hidden" name="max_price" id="maxPrice" value="50">
                        <div class="flex justify-between text-xs text-gray-500 mt-1"><span>US$0</span><span>US$500+</span></div>
                    </div>
                </div>
                <div class="filter-section-divider"></div>

                <div class="mb-4" id="review-score-filter-section">
                    <h3 class="font-semibold text-gray-700 mb-2 flex justify-between items-center cursor-pointer filter-toggle-header" data-target="review-content">
                        Review Score
                        <svg class="w-4 h-4 text-gray-400 filter-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </h3>
                    <div id="review-content">
                        <div id="review-filter" class="flex flex-col space-y-2">
                            <label for="score-9" class="flex items-center text-gray-700 cursor-pointer"><input type="radio" id="score-9" name="min_score" value="9" class="form-radio h-4 w-4 text-primary accent-primary"><span class="ml-2">Superb (9+)</span></label>
                            <label for="score-8" class="flex items-center text-gray-700 cursor-pointer"><input type="radio" id="score-8" name="min_score" value="8" class="form-radio h-4 w-4 text-primary accent-primary"><span class="ml-2">Very Good (8+)</span></label>
                            <label for="score-7" class="flex items-center text-gray-700 cursor-pointer"><input type="radio" id="score-7" name="min_score" value="7" class="form-radio h-4 w-4 text-primary accent-primary"><span class="ml-2">Good (7+)</span></label>
                            <label for="score-0" class="flex items-center text-gray-700 cursor-pointer"><input type="radio" id="score-0" name="min_score" value="0" class="form-radio h-4 w-4 text-primary accent-primary"><span class="ml-2">Any Score</span></label>
                        </div>
                    </div>
                </div>
                <div class="filter-section-divider"></div>

                <div class="mb-6" id="property-rating-filter-section">
    <h3 class="font-bold text-lg text-gray-900 mb-1 flex justify-between items-center cursor-pointer filter-toggle-header" data-target="rating-content">
        Property rating
        <svg class="w-4 h-4 text-gray-400 filter-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </h3>

    <div id="rating-content">
        <p class="text-sm text-gray-500 mb-4">Find high-quality hotels and holiday rentals</p>

        <div id="property-rating-filter" class="space-y-3">
            @foreach ($stars as $star => $count)
                <label for="star-{{ $star }}" class="flex justify-between items-center cursor-pointer">
                    <div class="flex items-center">
                        <input type="checkbox"
                               id="star-{{ $star }}"
                               name="property_rating[]"
                               value="{{ $star }}"
                               class="form-checkbox h-4 w-4 text-primary rounded accent-primary"
                               @if(in_array($star, request()->get('property_rating', []))) checked @endif>
                        <span class="ml-3 text-gray-700">{{ $star }} stars</span>
                    </div>

                    <span class="text-xs text-gray-500 font-semibold property-count" data-rating="{{ $star }}">
                        {{ $count }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>
</div>

               @foreach ($filterGroups as $group)
    @php
        $isComplex = count($group['items']) > $group['visible_count'];
        $items = collect($group['items']);
        $visibleItems = $items->take($group['visible_count']);
        $hiddenItems = $isComplex ? $items->skip($group['visible_count']) : collect();
        $containerId = "{$group['id_prefix']}-filter";
        $contentId = "{$group['id_prefix']}-content";
        $hiddenId = "hidden-{$group['id_prefix']}";
        $toggleId = "toggle-{$group['id_prefix']}";
    @endphp

    <div class="mb-6" id="{{ $group['id_prefix'] }}-section">
        <h3 class="font-bold text-lg text-gray-900 mb-2 flex justify-between items-center cursor-pointer filter-toggle-header" data-target="{{ $contentId }}">
            {{ $group['title'] }}
            <svg class="w-4 h-4 text-gray-400 filter-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </h3>

        <div id="{{ $contentId }}">
            <div id="{{ $containerId }}" class="space-y-3">

                {{-- Visible Items --}}
                @foreach($visibleItems as $value => $count)
                    <label for="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}" class="flex justify-between items-center cursor-pointer">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}"
                                   name="{{ $group['name'] }}[]"
                                   value="{{ $value }}"
                                   class="form-checkbox h-4 w-4 text-primary rounded accent-primary">
                            <span class="ml-3 text-gray-700">{{ $value }}</span>
                        </div>
                        <span class="text-xs text-gray-500 font-semibold">{{ $count }}</span>
                    </label>
                @endforeach

                {{-- Hidden Items (for "Show More") --}}
                @if ($hiddenItems->isNotEmpty())
                    <div id="{{ $hiddenId }}" class="space-y-3 hidden">
                        @foreach($hiddenItems as $value => $count)
                            <label for="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}" class="flex justify-between items-center cursor-pointer">
                                <div class="flex items-center">
                                    <input type="checkbox"
                                           id="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}"
                                           name="{{ $group['name'] }}[]"
                                           value="{{ $value }}"
                                           class="form-checkbox h-4 w-4 text-primary rounded accent-primary">
                                    <span class="ml-3 text-gray-700">{{ $value }}</span>
                                </div>
                                <span class="text-xs text-gray-500 font-semibold">{{ $count }}</span>
                            </label>
                        @endforeach
                    </div>

                    {{-- Toggle Button --}}
                    <button id="{{ $toggleId }}" class="mt-3 text-sm font-medium text-primary hover:text-primary-dark">
                        Show more
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if (!$loop->last)
        <div class="filter-section-divider"></div>
    @endif
@endforeach

        </aside>

        {{-- --- RIGHT COLUMN: Search Results and Listings --- --}}
        <main class="flex-1 min-w-0">

            <div class="lg:hidden mb-4">
                <button id="open-sidebar-btn" class="w-full py-3 bg-primary text-white font-bold rounded-lg shadow-lg flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zM15 10a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1v-2zM3 16a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2zM19 16a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2z"/></svg>
                    Filter Results
                </button>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 mb-6">
                <div class="h-64 bg-gray-100 rounded-lg mb-4 flex items-center justify-center text-gray-400">
                    <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM4 10a6 6 0 1112 0 6 6 0 01-12 0zm10-3a1 1 0 00-1-1H7a1 1 0 00-1 1v6a1 1 0 001 1h6a1 1 0 001-1V7zm-2 2a1 1 0 00-1 1v2a1 1 0 102 0v-2a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    Show on map
                </div>
                <div class="flex justify-between items-center border-t pt-4">
                    <h1 class="text-xl font-bold text-gray-800">Search Results: {{ $properties->total() }} properties found</h1>
                    <div class="flex items-center space-x-2 text-gray-600">
                        <span class="text-sm hidden sm:inline">Sort by: Top Picks</span>
                        <div class="flex border rounded-lg overflow-hidden">
                            {{-- List View Button --}}
                            <button id="list-view-btn" class="p-2 bg-gray-200 text-gray-800 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M1 4h18v2H1V4zm0 6h18v2H1v-2zm0 6h18v2H1v-2z"/></svg>
                            </button>
                            {{-- Grid View Button --}}
                            <button id="grid-view-btn" class="p-2 hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm-6 4a1 1 0 011-1h2a1 1 0 011 1v8a1 1 0 11-2 0V7H5a1 1 0 01-1-1zm10-1a1 1 0 00-1 1v8a1 1 0 102 0V7a1 1 0 00-1-1z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- --- RESULT CONTAINER: This is the element that will switch display styles --- --}}
            <div id="results-container" class="space-y-6">
                @include('Customer._searchResults', ['properties' => $properties])

                <!-- {{-- Dynamic result cards loop based on $properties --}} -->
                <!-- @forelse ($properties as $property)
                
                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                {{-- Use facilities for features if available --}}
                                @if($property->facilities && $property->facilities->count())
                                    @foreach($property->facilities->take(5) as $f)
                                        <li>{{ $f->facility_name }}</li>
                                    @endforeach
                                @else
                                    <li>{{ \Illuminate\Support\Str::limit($property->description, 120) }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                </div>
                @empty
                {{-- No results placeholder (keeps look & feel similar to your original card) --}}
                <div class="col-span-full bg-white rounded-xl p-10 shadow-lg text-center">
                    <h3 class="text-2xl font-semibold text-red-500 mb-2">No properties found.</h3>
                    <p class="text-gray-500">We couldn't find any listings that match your search. Try changing filters or clearing some fields.</p>
                </div>
                @endforelse -->
            </div>
                <!-- Loader overlay -->
                <div id="loader-overlay"
                    class="hidden fixed inset-0 bg-white/70 z-40 flex items-center justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-600"></div>
                </div>

                {{-- Pagination --}}
                @if(method_exists($properties, 'links'))
                    <div class="bg-white rounded-xl p-4 mt-6 shadow-sm">
                        {{ $properties->links() }}
                    </div>
                @endif
            </div>
            <div class="mt-8 flex justify-center"><p class="text-center text-gray-500">End of results.</p></div>
        </main>

    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", () => {

    /* ========= DOM ELEMENTS ========= */
    const form = document.querySelector("#search-form");
    const resultsContainer = document.querySelector("#results-container");
    const loader = document.querySelector("#loader-overlay");
    const listViewBtn = document.querySelector("#list-view-btn");
    const gridViewBtn = document.querySelector("#grid-view-btn");
    const budgetRange = document.getElementById("budget-range");
    const budgetDisplay = document.getElementById("budget-display");
    const minPrice = document.getElementById("minPrice");
    const maxPrice = document.getElementById("maxPrice");

    /* ========= LOADER ========= */
    function showLoader() { loader.classList.remove("hidden"); }
    function hideLoader() { loader.classList.add("hidden"); }

    /* ========= UPDATE RESULTS (AJAX) ========= */
    window.updateResults = function () {

    const params = new URLSearchParams();

    // -----------------------------
    // 1. ALWAYS READ TOP SEARCH BAR
    // -----------------------------
    params.set("destination", document.querySelector("input[name='destination']").value || "");
    params.set("checkIn", document.querySelector("input[name='checkIn']").value || "");
    params.set("checkOut", document.querySelector("input[name='checkOut']").value || "");
    params.set("adults", document.getElementById("guests-adults").value || 0);
    params.set("children", document.getElementById("guests-children").value || 0);
    params.set("rooms", document.getElementById("guests-rooms").value || 1);
    params.set("pets", document.getElementById("guests-pets").value || 0);

    // -----------------------------
    // 2. READ SIDEBAR FILTERS CLEAN
    // -----------------------------
    document.querySelectorAll(".filter-sidebar input, .filter-sidebar select")
    .forEach(el => {

        // For checkboxes & radio buttons
        if (el.type === "checkbox" || el.type === "radio") {
            el.addEventListener("change", () => {
                updateResults();
            });
        }

        // For selects
        if (el.tagName.toLowerCase() === "select") {
            el.addEventListener("change", () => {
                updateResults();
            });
        }
    });

    // -----------------------------
    // 3. SEND AJAX REQUEST (main)
    // -----------------------------
    axios.get("/customer/search?" + params.toString())
        .then(res => {
            document.querySelector("#results-container").innerHTML = res.data.html;

            // Update browser URL WITHOUT reload
            history.replaceState(null, "", "/customer/search?" + params.toString());
        })
        .catch(err => console.error(err));
    // -----------------------------
    // 4. SEND REQUEST
    // -----------------------------
    axios.get("/customer/search?" + params.toString())
        .then(res => {
            document.querySelector("#results-container").innerHTML = res.data.html;

            // Update browser URL WITHOUT reloading
            history.replaceState(null, "", "/customer/search?" + params.toString());
        })
        .catch(err => console.error(err));
};



    /* ========= FILTER EVENT LISTENERS ========= */
    document.addEventListener("change", function(e) {

    // If user clicks a Price Bucket checkbox
    if (e.target.name === 'price_buckets[]') {
        const budgetRange = document.getElementById("budget-range");
        const minPrice = document.getElementById("minPrice");
        const maxPrice = document.getElementById("maxPrice");

        // Reset slider values to avoid filter conflict
        if (budgetRange) budgetRange.value = 0;
        if (minPrice) minPrice.value = "";
        if (maxPrice) maxPrice.value = "";
    }

    // Run AJAX update on any filter input
    if (e.target.matches("input[type=checkbox], input[type=radio], select")) {
        updateResults();
    }
});


// build the debounced function once (don't recreate it on every event)
const destDebounced = _.debounce(() => updateResults(), 400);

document.addEventListener("input", function(e) {
    if (e.target.matches("input[name='destination']")) {
        destDebounced();
    }
});



    /* ========= BUDGET SLIDER ========= */
    if (budgetRange) {
    budgetRange.addEventListener("input", _.debounce(function () {
        const value = parseInt(this.value);

        // Display text
        if (value >= 500) {
            budgetDisplay.textContent = "US$500+";
            minPrice.value = 0;
            maxPrice.value = 999999;
        } else {
            budgetDisplay.textContent = "US$" + value;
            minPrice.value = 0;
            maxPrice.value = value;
        }

        updateResults();
    }, 300));
}


    /* ========= PAGINATION AJAX ========= */
    document.addEventListener("click", function (e) {
        const link = e.target.closest(".pagination a");
        if (!link) return;
        e.preventDefault();
        showLoader();
        axios.get(link.href)
            .then(res => resultsContainer.innerHTML = res.data.html)
            .finally(hideLoader);
    });

    /* ========= SORTING (if present) ========= */
    const sortSelect = document.getElementById("sort-select");
    if (sortSelect) {
        sortSelect.addEventListener("change", updateResults);
    }

    /* ========= LIST/GRID VIEW ========= */
    function toggleViewMode(mode) {
        if (mode === "grid") {
            resultsContainer.classList.add("results-grid-container");
            resultsContainer.classList.remove("space-y-6");
            gridViewBtn.classList.add("bg-gray-200");
            listViewBtn.classList.remove("bg-gray-200");
        } else {
            resultsContainer.classList.remove("results-grid-container");
            resultsContainer.classList.add("space-y-6");
            listViewBtn.classList.add("bg-gray-200");
            gridViewBtn.classList.remove("bg-gray-200");
        }
    }
    if (listViewBtn) listViewBtn.addEventListener("click", () => toggleViewMode('list'));
    if (gridViewBtn) gridViewBtn.addEventListener("click", () => toggleViewMode('grid'));
    toggleViewMode('list');

    /* ========= COLLAPSIBLE FILTER SECTIONS ========= */
    document.querySelectorAll('.filter-toggle-header').forEach(header => {
        header.addEventListener('click', () => {
            const target = document.getElementById(header.dataset.target);
            const icon = header.querySelector('.filter-toggle-icon');
            target.classList.toggle("hidden");
            icon.classList.toggle("rotated");
        });
    });

    /* ========= SHOW MORE / SHOW LESS HANDLERS ========= */
document.querySelectorAll("button[id^='toggle-']").forEach(toggleBtn => {
    toggleBtn.addEventListener("click", function () {
        const prefix = this.id.replace("toggle-", "");
        const hiddenContainer = document.getElementById("hidden-" + prefix);

        if (!hiddenContainer) return;

        const isHidden = hiddenContainer.classList.contains("hidden");

        if (isHidden) {
            hiddenContainer.classList.remove("hidden");
            this.textContent = "Show less";
        } else {
            hiddenContainer.classList.add("hidden");
            this.textContent = "Show more";
        }
    });
});
console.log("Filter changed:", el.name, el.value);


});
</script>


@endsection
