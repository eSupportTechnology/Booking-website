@extends('frontend.master')

@push('styles')
<style>
/* Tailwind/Booking.com color theme approximation */
.bg-primary { background-color: #0071C2; }
.text-primary { color: #0071C2; }
.hover:bg-primary-dark:hover { background-color: #005A9C; }
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

/* Custom class for the responsive sidebar state */
/* This class FORCES the sidebar into view on mobile. */
.sidebar-open {
    transform: translateX(0) !important;
}
/* Custom class for the mobile overlay backdrop */
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

</style>
@endpush

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

@php
// --- 1. DATA CONSOLIDATION (Simplified for brevity) ---
$filterCounts = [
    'popular' => ['Swimming pool' => 113, 'Beach' => 153, 'Private bathroom' => 333, 'Breakfast included' => 155, 'Restaurant' => 105],
    'meals' => ['Breakfast included' => 155, 'All meals included' => 12],
    'property_type' => ['Family friendly properties' => 4444, 'Hotels' => 3688, 'Guest houses' => 3335, 'Apartments' => 2013, 'Villas' => 1816, 'Homestays' => 1633, 'Bed and breakfasts' => 1208, 'Holiday homes' => 703, 'Resorts' => 546, 'Hostels' => 375, 'Lodges' => 362, 'Campsites' => 89, 'Chalets' => 83, 'Country houses' => 78, 'Luxury tents' => 56, 'Farm stays' => 24, 'Boats' => 24, 'Holiday parks' => 9, 'Capsule hotels' => 9, 'Motels' => 8, 'Love hotels' => 2, 'Economy hotels' => 1],
];

$filterGroups = [
    [ 'title' => 'Popular filters', 'name' => 'popular', 'id_prefix' => 'popular', 'items' => $filterCounts['popular'], 'visible_count' => 5 ],
    [ 'title' => 'Meals', 'name' => 'meals', 'id_prefix' => 'meals', 'items' => $filterCounts['meals'], 'visible_count' => 5 ],
    [ 'title' => 'Travel group', 'name' => 'travel_group', 'id_prefix' => 'travel-group', 'items' => ['Pets allowed' => 4566, 'Family friendly properties' => 4444, 'Travel Proud (LGBTQ+ friendly)' => 27], 'visible_count' => 5 ],
    [ 'title' => 'Certifications', 'name' => 'certifications', 'id_prefix' => 'certifications', 'items' => ['Sustainability certification' => 29], 'visible_count' => 5 ],
    [ 'title' => 'Entire places', 'name' => 'entire_places', 'id_prefix' => 'entire-places', 'items' => ['Entire homes & apartments' => 16121], 'visible_count' => 5 ],
    [ 'title' => 'Room facilities', 'name' => 'room_facility', 'id_prefix' => 'room-facilities', 'visible_count' => 5, 'items' => ["Children's high chair" => 629, "Coffee/tea maker" => 10535, "Electric kettle" => 9921, "View" => 12746, "Soundproofing" => 3229, "Patio" => 3015, "Washing machine" => 4038, "Flat-screen TV" => 6593, "Balcony" => 9930, "Terrace" => 7950, "Bath" => 4080, "Desk" => 8884, "Air conditioning" => 11593, "Kitchenette" => 3856, "Private bathroom" => 14154, "Kitchen/kitchenette" => 6352] ],
    [ 'title' => 'Facilities', 'name' => 'facility', 'id_prefix' => 'facilities', 'visible_count' => 5, 'items' => ["Parking" => 14917, "Restaurant" => 4888, "Room service" => 7761, "24-hour front desk" => 5796, "Fitness centre" => 613, "Non-smoking rooms" => 10081, "Airport shuttle" => 7766, "Spa and wellness centre" => 1204, "Hot tub/Jacuzzi" => 619, "Free WiFi" => 12363, "Electric vehicle charging station" => 435, "Wheelchair accessible" => 745] ],
    [ 'title' => 'Top destinations in Sri Lanka', 'name' => 'destination', 'id_prefix' => 'destinations', 'visible_count' => 5, 'items' => ["Galle District" => 3466, "Matara District" => 2317, "Kandy District" => 1287, "Gampaha District" => 1168, "Badulla District" => 1130, "Colombo District" => 898, "Matale District" => 891, "Hambantota District" => 878, "Nuwara Eliya District" => 818, "Anuradhapura District" => 590, "Ratnapura District" => 388, "Trincomalee District" => 362, "Ampara District" => 349, "Kalutara District" => 346, "Puttalam District" => 220, "Jaffna District" => 200, "Monaragala District" => 144, "Polonnaruwa District" => 138, "Kegalle District" => 126, "Batticaloa District" => 90, "Kurunegala District" => 82, "Mannar District" => 23, "Kilinochchi District" => 11, "Vavuniya District" => 7, "Mullaitivu District" => 3] ],
    [ 'title' => 'Brands', 'name' => 'brand', 'id_prefix' => 'brands', 'visible_count' => 5, 'items' => ["Jetwing Hotels Limited" => 42, "Cinnamon Hotels & Resorts" => 13, "Thema Collection" => 13, "Aitken Spence Hotels" => 9, "Your.Rentals" => 8, "Hilton Hotels & Resorts" => 3, "OYO Rooms" => 3, "Ramada" => 2, "Shangri-La Group" => 2, "Anantara Hotels & Resorts" => 2, "Radisson" => 2, "Yoho Bed" => 2, "Sheraton" => 2, "Collection by Aston" => 2, "GRANBELL HOTELS & RESORTS" => 2, "Best Western" => 1, "Marriott Hotels & Resorts" => 1, "Courtyard by Marriott" => 1, "Doubletree by Hilton" => 1, "Berjaya Hotels & Resorts" => 1] ],
    [ 'title' => 'City', 'name' => 'city', 'id_prefix' => 'cities', 'visible_count' => 5, 'items' => ["Kandy" => 982, "Hikkaduwa" => 791, "Ella" => 780, "Weligama" => 736, "Galle" => 732, "Negombo" => 664, "Nuwara Eliya" => 626, "Mirissa" => 576, "Ahangama" => 512, "Unawatuna" => 510, "Tangalle" => 495, "Sigiriya" => 467, "Anuradhapura" => 391, "Colombo" => 379, "Matara" => 301, "Arugam Bay" => 280, "Dickwella" => 275, "Trincomalee" => 270, "Bentota" => 264, "Udawalawe" => 250, "Dambulla" => 196, "Tissamaharama" => 192, "Katunayake" => 173, "Jaffna" => 155, "Nikawatawana" => 134] ],
    [ 'title' => 'Landmarks', 'name' => 'landmark', 'id_prefix' => 'landmarks', 'visible_count' => 5, 'items' => ["Ella Railway Station" => 432, "Negombo Beach Park" => 215, "Sri Dalada Maligawa" => 162, "Temple of Tooth Relic" => 162, "Nuwara Eliya Golf Club" => 161, "Galle International Cricket Stadium" => 138, "Galle Railway Station" => 134, "Tangalle Lagoon" => 121, "Galle Fort" => 105, "Bentota Lake" => 101, "Kandy Lake" => 97, "Gregory Lake" => 95, "Paradise Road" => 91, "Demodara Nine Arch Bridge" => 89, "Galle Light house" => 85, "Turtle Farm" => 76, "Sigiriya Museum" => 73, "Japanese Peace Pagoda" => 67, "Dambulla Cave Temple" => 42, "Yatagala Temple" => 42, "Sigiriya Rock" => 40, "Laksala" => 38, "Angurukaramulla Temple" => 36, "Habarana Lake" => 33, "Haputale Railway Station" => 29] ],
    [ 'title' => 'Fun things to do', 'name' => 'activity', 'id_prefix' => 'fun-activities', 'visible_count' => 5, 'items' => ["Bicycle rental" => 5784, "Beach" => 4053, "Walking tours" => 4004, "Bike tours" => 3770, "Cycling" => 3553] ],
    [ 'title' => 'Property accessibility', 'name' => 'prop_accessibility', 'id_prefix' => 'property-accessibility', 'visible_count' => 5, 'items' => ['Toilet with grab rails' => 278, 'Higher level toilet' => 222, 'Lower bathroom sink' => 242, 'Emergency cord in bathroom' => 87, 'Visual aids: Braille' => 41, 'Visual aids: Tactile signs' => 43, 'Auditory guidance' => 62] ],
    [ 'title' => 'Room accessibility', 'name' => 'room_accessibility', 'id_prefix' => 'room-accessibility', 'visible_count' => 5, 'items' => ['Entire unit located on ground floor' => 4459, 'Upper floors accessible by elevator' => 588, 'Entire unit wheelchair accessible' => 1765, 'Toilet with grab rails' => 351, 'Adapted bath' => 214, 'Roll-in shower' => 604, 'Walk-in shower' => 2279, 'Raised toilet' => 638, 'Lowered sink' => 845, 'Emergency cord in bathroom' => 134, 'Shower chair' => 101] ],
];

// Replicate a result for grid view demonstration
$sampleResults = [
    [
        'title' => 'The Grand Consolidated Hotel',
        'location' => 'Colombo',
        'score' => 9.1,
        'reviews' => 102,
        'price' => 450,
        'features' => ['Luxury Suite with Ocean View', 'Free cancellation', '<span class="text-green-600 font-semibold">No prepayment needed</span> - pay at the property'],
    ],
    [
        'title' => 'Sunset Beach Villa',
        'location' => 'Hikkaduwa',
        'score' => 8.7,
        'reviews' => 234,
        'price' => 210,
        'features' => ['Private pool', 'Free WiFi', 'Breakfast included'],
    ],
    [
        'title' => 'Kandy Mountain View Guest House',
        'location' => 'Kandy',
        'score' => 9.5,
        'reviews' => 48,
        'price' => 95,
        'features' => ['Terrace with view', 'Family friendly', 'Self-catering option'],
    ],
    [
        'title' => 'Luxury Apartment Galle Fort',
        'location' => 'Galle',
        'score' => 9.0,
        'reviews' => 110,
        'price' => 320,
        'features' => ['Near Galle Fort', 'Fully equipped kitchen', 'Washing machine'],
    ]
];
@endphp

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

                {{-- --- UNIQUE MANUAL FILTERS --- --}}
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

                {{-- --- CONSOLIDATED LOOP FILTERS --- --}}
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
                    <h1 class="text-xl font-bold text-gray-800">Search Results: {{ count($sampleResults) }} properties found</h1>
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

                {{-- Dynamic result cards loop based on $sampleResults --}}
                @foreach ($sampleResults as $result)
                <div class="result-item result-item-list bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow border border-gray-200 overflow-hidden">
                    <div class="result-image">
                        <div class="w-full h-full bg-gray-300 flex items-center justify-center"><span class="text-gray-500">Property Image Placeholder</span></div>
                    </div>
                    <div class="sm:w-1/2 p-4 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-xl font-bold text-primary hover:text-primary-dark transition-colors">{{ $result['title'] }}</h3>
                                <div class="flex items-center space-x-2">
                                    <div class="text-sm text-gray-500 font-medium">{{ $result['reviews'] }} reviews</div>
                                    <span class="inline-flex items-center bg-primary text-white text-base font-bold px-2 py-1 rounded-t-md rounded-r-md">{{ $result['score'] }}</span>
                                </div>
                            </div>
                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6c0 4.42 4 10 6 10s6-5.58 6-10a6 6 0 00-6-6zm0 10a2 2 0 110-4 2 2 0 010 4z"/></svg>
                                <span class="font-medium mr-1">{{ $result['location'] }}</span>
                                <span class="text-xs underline cursor-pointer hover:text-gray-700">Show on map</span>
                            </div>
                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                @foreach ($result['features'] as $feature)
                                    <li>{!! $feature !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sm:w-1/4 p-4 bg-gray-50 flex flex-col justify-end items-center sm:items-end border-t sm:border-t-0 sm:border-l border-gray-100">
                        <div class="text-right w-full mb-3">
                            <div class="text-sm text-gray-500">Price for 2 nights</div>
                            <div class="text-3xl font-bold text-gray-800">@currency($result['price'], 'USD')</div>
                            <div class="text-xs text-gray-500 mb-4">Includes taxes and fees</div>
                        </div>
                        <a href="#" class="w-full sm:w-auto bg-primary text-white text-center px-4 py-3 rounded-lg font-bold hover:bg-primary-dark transition-colors shadow-lg">See Availability</a>
                    </div>
                </div>
                @endforeach

                {{-- Original Placeholder/No Results Message --}}
                <div class="col-span-full bg-white rounded-xl p-10 shadow-lg text-center">
                    <h3 class="text-2xl font-semibold text-red-500 mb-2">Data Simulation.</h3>
                    <p class="text-gray-500">The results are simulated using the $sampleResults array to demonstrate list/grid switching.</p>
                </div>
            </div>
            <div class="mt-8 flex justify-center"><p class="text-center text-gray-500">End of results.</p></div>
        </main>
    </div>
</div>

<script>
    // --- CONSOLIDATED JAVASCRIPT LOGIC ---

    // Global elements for mobile toggle
    const sidebar = document.getElementById('filters-sidebar');
    const openBtn = document.getElementById('open-sidebar-btn');
    const closeBtn = document.getElementById('close-sidebar-btn');
    const backdrop = document.getElementById('mobile-backdrop');
    const lgBreakpoint = 1024; // Tailwind's 'lg' breakpoint

    // Elements for View Switcher
    const resultsContainer = document.getElementById('results-container');
    const listViewBtn = document.getElementById('list-view-btn');
    const gridViewBtn = document.getElementById('grid-view-btn');

    // Function to open/close the mobile sidebar
    function toggleSidebar(open) {
        // Only run on small screens
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

    // Handlers for mobile toggle
    if (openBtn) openBtn.addEventListener('click', () => toggleSidebar(true));
    if (closeBtn) closeBtn.addEventListener('click', () => toggleSidebar(false));
    if (backdrop) backdrop.addEventListener('click', () => toggleSidebar(false));

    // Handle resize to ensure desktop mode works correctly if resized from mobile
    window.addEventListener('resize', () => {
        if (window.innerWidth >= lgBreakpoint) {
            // Ensure classes are clean if we switch from mobile overlay to desktop static view
            sidebar.classList.remove('sidebar-open');
            backdrop.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    /**
     * Toggles the display mode between list and grid.
     * @param {string} mode - 'list' or 'grid'
     */
    function toggleViewMode(mode) {
        if (!resultsContainer || !listViewBtn || !gridViewBtn) return;

        if (mode === 'grid') {
            resultsContainer.classList.remove('space-y-6');
            resultsContainer.classList.add('results-grid-container');

            listViewBtn.classList.remove('bg-gray-200');
            listViewBtn.classList.add('hover:bg-gray-100');

            gridViewBtn.classList.add('bg-gray-200');
            gridViewBtn.classList.remove('hover:bg-gray-100');
        } else { // 'list' mode (default)
            resultsContainer.classList.add('space-y-6');
            resultsContainer.classList.remove('results-grid-container');

            listViewBtn.classList.add('bg-gray-200');
            listViewBtn.classList.remove('hover:bg-gray-100');

            gridViewBtn.classList.remove('bg-gray-200');
            gridViewBtn.classList.add('hover:bg-gray-100');
        }
    }

    // Handlers for View Switcher
    if (listViewBtn) listViewBtn.addEventListener('click', () => toggleViewMode('list'));
    if (gridViewBtn) gridViewBtn.addEventListener('click', () => toggleViewMode('grid'));

    /**
     * Reusable function to manage the internal "Show more/less" toggle within a filter section.
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

        if (container) {
            container.addEventListener('change', (e) => {
                if (e.target.tagName === 'INPUT' && e.target.type === 'checkbox' && e.target.name === groupName) {
                    const selected = Array.from(container.querySelectorAll(`input[name="${groupName}"]:checked`)).map(cb => cb.value);
                    console.log(`[Filter Change] Selected ${groupName} Filters:`, selected);
                }
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
                    // Add initial rotation to icons for sections that start visible (like 'Budget' and 'Review Score')
                    // For the provided code, all sections seem to start open, so let's apply rotation to indicate a collapse state
                    const sectionId = header.closest('[id$="-section"]').id;
                    const isManualSection = ['budget-filter-section', 'review-score-filter-section', 'property-rating-filter-section'].includes(sectionId);

                    // For the initial state, we assume the content is visible (not 'hidden') by default.
                    // If content is not hidden, the icon should be in the default (down) position.
                    // If the content is toggled to be hidden, the icon should rotate.
                    if (icon) {
                        // Check if the content is NOT hidden to determine the starting icon position (down arrow)
                        // This logic is simplified: if we click, we toggle 'hidden' and 'rotated'
                        icon.classList.toggle('rotated', targetContent.classList.contains('hidden'));
                    }
                }
            });
             // Set initial icon state for all headers if the content starts visible (which is the case here)
             const targetContent = document.getElementById(header.getAttribute('data-target'));
             const icon = header.querySelector('.filter-toggle-icon');
             if (icon && targetContent && !targetContent.classList.contains('hidden')) {
                 icon.classList.remove('rotated'); // Down arrow for open sections
             }
        });
    }

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        initializeSectionToggle();

        const groupsToInitialize = [
            'popular', 'meals', 'travel-group', 'certifications', 'entire-places',
            'room-facilities', 'facilities', 'destinations', 'brands',
            'cities', 'landmarks', 'fun-activities', 'property-accessibility', 'room-accessibility'
        ];

        groupsToInitialize.forEach(prefix => {
            let groupName = prefix.replace(/-/g, '_');
            if (prefix === 'fun-activities') groupName = 'activity';
            initializeShowMoreToggle(prefix, groupName);
        });

        // Unique/Manual Filter JS handlers (Budget, Review, Rating, Prop Type)
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

        // Initialize view mode to 'list' on page load
        toggleViewMode('list');
    });
</script>

@endsection
