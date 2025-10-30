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
<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form[action='{{ route('customer.search') }}']");
  const resultsContainer = document.querySelector("#results-container");
  const loader = document.querySelector("#loader-overlay");

  // --- Debounce helper ---
  function debounce(fn, delay = 400) {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn(...args), delay);
    };
  }

  // --- Show/hide loader ---
  function showLoader() {
    loader.classList.remove("hidden");
  }
  function hideLoader() {
    loader.classList.add("hidden");
  }

  // --- Update Results via AJAX ---
  const updateResults = debounce(async () => {
    const formData = new FormData(form);
    const query = new URLSearchParams(formData).toString();

    showLoader();
    try {
      const res = await axios.get("{{ route('customer.search.ajax') }}?" + query);
      resultsContainer.innerHTML = res.data.html;
    } catch (err) {
      console.error(err);
      resultsContainer.innerHTML =
        '<div class="text-center py-10 text-red-500">Error loading results</div>';
    } finally {
      hideLoader();
    }
  }, 500); // delay = 500ms for smoother UX

  // --- Listen to filter changes ---
  document.querySelectorAll("input[type=checkbox], input[type=radio], select").forEach(el => {
    el.addEventListener("change", updateResults);
  });

  // --- Handle pagination clicks dynamically ---
  document.addEventListener("click", function(e) {
    const link = e.target.closest(".pagination a");
    if (!link) return;

    e.preventDefault();
    const url = link.getAttribute("href");
    if (!url) return;

    showLoader();
    axios.get(url)
      .then(res => resultsContainer.innerHTML = res.data.html)
      .catch(() => resultsContainer.innerHTML = "Error loading page")
      .finally(hideLoader);
  });

  // --- Optional: Handle typing in destination search field (if any) ---
  const destinationInput = form.querySelector("input[name='destination']");
  if (destinationInput) {
    destinationInput.addEventListener("input", updateResults);
  }
});
</script>



{{-- 🔹 SEARCH FILTER BAR (property search kept intact, enhanced with the same structure as first file) --}}
<div class="relative z-10 -mt-8 px-2 sm:px-4 mb-6">
    <form action="{{ route('customer.search') }}" method="GET"
    x-data="{
        destination: '{{ $searchData['destination'] ?? '' }}',
        checkIn: '{{ $searchData['checkIn'] ?? '' }}',
        checkOut: '{{ $searchData['checkOut'] ?? '' }}',
        adults: {{ $searchData['adults'] ?? 2 }},
        children: {{ $searchData['children'] ?? 0 }},
        rooms: {{ $searchData['rooms'] ?? 1 }},
        pets: {{ $searchData['pets'] ? 'true' : 'false' }}
    }"
        class="bg-white rounded-xl px-2 py-1 sm:px-3 sm:py-2 shadow-lg
           flex flex-col md:flex-row items-stretch md:items-center
           gap-2 md:gap-0 border-2 sm:border-4 border-yellow-400
           max-w-full md:max-w-6xl mx-auto overflow-visible text-sm md:text-base">

        <!-- Destination Selector -->
        <div x-data="{ open: false, destination: '' }"
             class="relative flex-1 border-b md:border-b-0 md:border-r border-gray-300 px-2 py-1">
            <button @click="open = !open" type="button"
                class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/stay.svg') }}" class="w-5 h-5 sm:w-6 sm:h-6" />
                <span x-text="destination || '{{ __("messages.Where are you going?") }}'"
                      class="text-gray-800 truncate text-sm sm:text-base"></span>
            </button>
            <div x-show="open" @click.away="open = false"
                class="absolute z-20 bg-white shadow-xl rounded-xl p-3 mt-2 w-64 sm:w-72 left-0 md:left-auto md:right-0 text-gray-800 space-y-2 text-sm">
                <template x-for="city in ['New York','Los Angeles','London','Paris','Tokyo','Galle','Colombo']" :key="city">
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
                        <span><span x-text="checkIn || '{{ __('messages.Check-in') }}'"></span> — 
                            <span x-text="checkOut || '{{ __('messages.Check-out') }}'"></span></span>
                    </template>
                    <template x-if="activeTab === 'flexible'">
                        <span x-text="flexibleOption || 'Flexible dates'"></span>
                    </template>
                </span>
            </button>

            <!-- Dropdown -->
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
                    <button @click="open = false"
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

                <p class="text-xs text-gray-500">
                    Assistance animals aren’t considered pets.
                    <a href="#" class="text-blue-600 underline">Read more</a>
                </p>

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

        <aside id="filters-sidebar" class="
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
                            <label for="score-8" class="flex items-center text-gray-700 cursor-pointer"><input type="radio" id="score-8" name="min_score" value="8" checked class="form-radio h-4 w-4 text-primary accent-primary"><span class="ml-2">Very Good (8+)</span></label>
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
                            @php $starRatings = [539, 2162, 2841, 333, 125]; @endphp
                            @foreach (range(5, 1) as $star)
                                <label for="star-{{ $star }}" class="flex justify-between items-center cursor-pointer">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="star-{{ $star }}" name="property_rating" value="{{ $star }}" class="form-checkbox h-4 w-4 text-primary rounded accent-primary">
                                        <span class="ml-3 text-gray-700">{{ $star }} stars</span>
                                    </div>
                                    <span class="text-xs text-gray-500 font-semibold property-count" data-rating="{{ $star }}">{{ $starRatings[5 - $star] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="filter-section-divider"></div>

                {{-- --- Consolidated Loop Filters: we use $filterGroups passed from controller --- --}}
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
                            <svg class="w-4 h-4 text-gray-400 filter-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </h3>
                        <div id="{{ $contentId }}">
                            <div id="{{ $containerId }}" class="space-y-3">
                                {{-- Visible Items --}}
                                @foreach($visibleItems as $value => $count)
                                    <label for="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}" class="flex justify-between items-center cursor-pointer">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}" name="{{ $group['name'] }}" value="{{ $value }}" class="form-checkbox h-4 w-4 text-primary rounded accent-primary">
                                            <span class="ml-3 text-gray-700">{{ $value }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500 font-semibold count" data-{{ $group['name'] }}="{{ $value }}">{{ $count }}</span>
                                    </label>
                                @endforeach

                                {{-- Hidden Items Container (Only rendered if complex) --}}
                                @if ($hiddenItems->isNotEmpty())
                                    <div id="{{ $hiddenId }}" class="space-y-3 hidden">
                                        @foreach($hiddenItems as $value => $count)
                                            <label for="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}" class="flex justify-between items-center cursor-pointer">
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="{{ $group['id_prefix'] }}-{{ \Str::slug($value) }}" name="{{ $group['name'] }}" value="{{ $value }}" class="form-checkbox h-4 w-4 text-primary rounded accent-primary">
                                                    <span class="ml-3 text-gray-700">{{ $value }}</span>
                                                </div>
                                                <span class="text-xs text-gray-500 font-semibold count" data-{{ $group['name'] }}="{{ $value }}">{{ $count }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    {{-- Internal Show More/Less Toggle Button --}}
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

                <div class="mb-6" id="property-type-filter-section">
                    <h4 class="font-semibold text-gray-900 mb-2 flex justify-between items-center cursor-pointer filter-toggle-header" data-target="prop-type-content">
                        Property type
                        <svg class="w-4 h-4 text-gray-400 filter-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </h4>
                    <ul id="prop-type-content" class="space-y-2 text-sm">
                        @foreach(($filterCounts['property_type'] ?? []) as $name => $count)
                            <li>
                                <input type="checkbox" id="prop_type-{{ \Str::slug($name) }}" name="property_type" value="{{ $name }}" class="rounded text-blue-600 mr-2">
                                <label for="prop_type-{{ \Str::slug($name) }}">
                                    {{ $name }} <span class="text-gray-500">({{ $count }})</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="filter-section-divider"></div>

                <button class="w-full py-2 mt-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    Apply Filters
                </button>
            </div>
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

                {{-- Dynamic result cards loop based on $properties --}}
                @forelse ($properties as $property)
                
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
                    <div class="sm:w-1/4 p-4 bg-gray-50 flex flex-col justify-end items-center sm:items-end border-t sm:border-t-0 sm:border-l border-gray-100">
                        <div class="text-right w-full mb-3">
                            <div class="text-sm text-gray-500">Price from</div>
                            @php
                                $price = $property->rooms_min_price_per_night ?? null;
                            @endphp
                            <div class="text-3xl font-bold text-gray-800">@if($price) @currency($price, $property->rooms()->first()->currency ?? 'USD') @else N/A @endif</div>
                            <div class="text-xs text-gray-500 mb-4">Includes taxes and fees</div>
                        </div>
                        <a href="{{ route('customer.properties.details', $property->id ?? '#') }}" class="w-full sm:w-auto bg-primary text-white text-center px-4 py-3 rounded-lg font-bold hover:bg-primary-dark transition-colors shadow-lg">See Availability</a>
                    </div>
                </div>
                @empty
                {{-- No results placeholder (keeps look & feel similar to your original card) --}}
                <div class="col-span-full bg-white rounded-xl p-10 shadow-lg text-center">
                    <h3 class="text-2xl font-semibold text-red-500 mb-2">No properties found.</h3>
                    <p class="text-gray-500">We couldn't find any listings that match your search. Try changing filters or clearing some fields.</p>
                </div>
                @endforelse
                
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
    // --- CONSOLIDATED JAVASCRIPT LOGIC (combines second file behavior + extra mechanisms from first file) ---
    const sidebar = document.getElementById('filters-sidebar');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');
    const backdrop = document.getElementById('mobile-backdrop');
    const lgBreakpoint = 1024;

    const resultsContainer = document.getElementById('results-container');
    const listViewBtn = document.getElementById('list-view-btn');
    const gridViewBtn = document.getElementById('grid-view-btn');

    // Sidebar toggle behavior (from first file) — preserves existing sidebar markup and behavior
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

    // list/grid view toggle (kept from your second file)
    function toggleViewMode(mode) {
        if (!resultsContainer || !listViewBtn || !gridViewBtn) return;

        if (mode === 'grid') {
            resultsContainer.classList.remove('space-y-6');
            resultsContainer.classList.add('results-grid-container');

            listViewBtn.classList.remove('bg-gray-200');
            listViewBtn.classList.add('hover:bg-gray-100');

            gridViewBtn.classList.add('bg-gray-200');
            gridViewBtn.classList.remove('hover:bg-gray-100');
        } else {
            resultsContainer.classList.add('space-y-6');
            resultsContainer.classList.remove('results-grid-container');

            listViewBtn.classList.add('bg-gray-200');
            listViewBtn.classList.remove('hover:bg-gray-100');

            gridViewBtn.classList.remove('bg-gray-200');
            gridViewBtn.classList.add('hover:bg-gray-100');
        }
    }

    if (listViewBtn) listViewBtn.addEventListener('click', () => toggleViewMode('list'));
    if (gridViewBtn) gridViewBtn.addEventListener('click', () => toggleViewMode('grid'));

    /**
     * Initialize show more/less for any internal filter with "toggle-<prefix>" / "hidden-<prefix>" IDs.
     * This approach finds all toggles rendered by your Blade loop and wires them up — no need to hardcode prefixes.
     */
    function initializeShowMoreToggle(idPrefix, groupName) {
        const hiddenContainer = document.getElementById(`hidden-${idPrefix}`);
        const toggleButton = document.getElementById(`toggle-${idPrefix}`);
        const container = document.getElementById(`${idPrefix}-filter`);

        if (toggleButton && hiddenContainer) {
            toggleButton.addEventListener('click', () => {
                hiddenContainer.classList.toggle('hidden');
                toggleButton.textContent = hiddenContainer.classList.contains('hidden') ? 'Show more' : 'Show less';
            });
        }

        // Keep original second-file behavior: don't auto-submit here.
        // But we can optionally log selections for debugging (non-intrusive).
        if (container) {
            container.addEventListener('change', (e) => {
                if (e.target.tagName === 'INPUT' && (e.target.type === 'checkbox' || e.target.type === 'radio')) {
                    // Non-intrusive debug; remove if undesired
                    // console.log(`[Filter Change] ${groupName}:`, Array.from(container.querySelectorAll(`input[name="${groupName}"]:checked`)).map(cb => cb.value));
                }
            });
        }
    }

    /**
     * Collapsible section toggle (for headers with class filter-toggle-header)
     * This implements the rotating icon behavior from the first file.
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

    document.addEventListener('DOMContentLoaded', () => {
        // initialize collapsible sections
        initializeSectionToggle();

        // Wire up all internal "show more" toggles by searching for toggle-* elements
        document.querySelectorAll('[id^="toggle-"]').forEach(btn => {
            const id = btn.id.replace(/^toggle-/, '');
            initializeShowMoreToggle(id, id.replace(/-/g, '_'));
        });

        // Additional second-file listeners (budget range, review filters) preserved:
        const budgetRange = document.getElementById('budget-range');
        const budgetDisplay = document.getElementById('budget-display');
        function updateBudgetDisplay(value) {
            budgetDisplay.textContent = parseInt(value) >= 500 ? 'US$500+' : 'US$' + value;
        }
        if(budgetRange) budgetRange.addEventListener('input', (event) => { updateBudgetDisplay(event.target.value); });

        document.getElementById('review-filter')?.addEventListener('change', (e) => {
            if (e.target.type === 'radio' && e.target.name === 'min_score') {
                console.log('[Filter Change] Selected Minimum Review Score:', e.target.value);
            }
        });
        document.getElementById('property-rating-filter')?.addEventListener('change', () => {
            const selectedRatings = Array.from(document.querySelectorAll('#property-rating-filter input[name="property_rating"]:checked')).map(cb => cb.value);
            console.log('[Filter Change] Currently Selected Star Ratings:', selectedRatings);
        });
        document.getElementById('property-type-filter-section')?.addEventListener('change', (e) => {
            if (e.target.name === 'property_type') {
                const selected = Array.from(document.querySelectorAll('#prop-type-content input[name="property_type"]:checked')).map(cb => cb.value);
                console.log('[Filter Change] Selected Property Type Filters:', selected);
            }
        });

        // Default to list view on load (preserves prior behavior)
        toggleViewMode('list');
    });
</script>

@endsection
