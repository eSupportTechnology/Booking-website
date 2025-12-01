@extends('frontend.master')
@section('title','Airport Taxi Search')
@section('content')

@php
    if (!function_exists('simple_slug')) {
        function simple_slug($text) {
            return preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($text)));
        }
    }
@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/css/all.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
/* --- your existing styles (kept unchanged) --- */
:root{
    --primary: #1F8FB2;
    --primary-dark: #127695;
    --muted: #6b7280;
    --card: #ffffff;
    --bg: #F6F7F9;
    --border: #e6e6e6;
}

body { background: var(--bg) !important; }
.page-container { max-width: 1200px; margin: 0 auto; padding: 28px 16px; font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color: #111827; }

/* TOP SEARCH */
.top-search { display:flex; gap:12px; align-items:center; margin-bottom:18px; }
.top-search .input { border:1px solid var(--border); padding:10px 12px; border-radius:8px; background:#fff; width:100%; box-shadow:0 1px 2px rgba(16,24,40,0.03); }
.top-search .search-btn { background:var(--primary); color:#fff; padding:10px 14px; border-radius:8px; border:none; cursor:pointer; }

/* LAYOUT */
.columns { display:flex; gap:24px; align-items:flex-start; }
.sidebar {
    width:280px;
    flex-shrink:0;
    background:var(--card);
    border-radius:12px;
    padding:18px;
    border:1px solid var(--border);
    box-shadow:0 6px 24px rgba(2,6,23,0.04);
    position:relative;
    max-height:none;
    overflow:visible;
}

.content { flex:1; }

/* SIDEBAR */
.filter-title { font-size:18px; font-weight:700; margin-bottom:14px; }
.section-title { font-weight:600; color:#111827; margin-bottom:8px; font-size:14px; }
.filter-item { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom: 1px dashed #f5f7fa; }
.filter-item:last-child { border-bottom: none; }
.filter-label { display:flex; align-items:center; gap:10px; }
.count { font-size:12px; color:var(--muted); min-width:36px; text-align:right; }

/* RESULTS TOP */
.results-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; gap:12px; }
.results-left h2 { font-size:20px; font-weight:800; margin:0; }
.category-list { display:flex; gap:8px; flex-wrap:wrap; margin-top:6px; }
.category-btn { background:#fff; border:1px solid #d1d5db; padding:6px 10px; border-radius:999px; font-size:13px; cursor:pointer; color:#111827; }
.category-btn.active { background:var(--primary); color:#fff; border-color:var(--primary); }

/* VIEW TOGGLE */
.view-toggle { display:flex; gap:6px; border:1px solid var(--border); padding:6px; border-radius:8px; background:#fff; }
.view-toggle button { background:transparent; border:none; padding:6px; cursor:pointer; display:flex; align-items:center; gap:6px; color:var(--muted); }
.view-toggle button.active { color:var(--primary); font-weight:700; }

/* RESULTS */
.results-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:16px; }
.results-list { display:flex; flex-direction:column; gap:12px; }

/* GRID CARD (compact) */
.grid-card {
    background: var(--card);
    border-radius: 12px;
    border: 1px solid var(--border);
    overflow: hidden;
    display:flex;
    flex-direction:column;
    box-shadow:0 6px 20px rgba(2,6,23,0.04);
}
.grid-card .thumb { width:100%; height:160px; background:#f3f4f6; overflow:hidden; }
.grid-card .thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.grid-card .inner { padding:12px; display:flex; justify-content:space-between; gap:12px; align-items:flex-start; }
.grid-meta { flex:1; }
.grid-title { font-weight:700; font-size:16px; margin-bottom:4px; }
.grid-sub { color:var(--muted); font-size:13px; margin-bottom:8px; }

/* LIST CARD (booking.com style horizontal) */
.taxi-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #E4E4E4;
    padding: 0;
    display: flex;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    align-items:stretch;
}
.taxi-card .image-block {
    width: 260px;
    height: 180px;
    flex-shrink: 0;
    background:#f3f4f6;
}
.taxi-card .image-block img { width:100%; height:100%; object-fit:cover; display:block; }
.taxi-card .taxi-meta {
    flex:1;
    padding:18px 22px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}
.taxi-card .taxi-title { font-size:20px; font-weight:700; color:#111827; }
.taxi-card .taxi-sub { font-size:14px; color:var(--muted); margin-top:4px; }
.taxi-specs { display:flex; gap:14px; color:#374151; margin-top:10px; font-size:14px; flex-wrap:wrap; }
.taxi-card .taxi-side {
    width: 220px;
    border-left: 1px solid #E4E4E4;
    padding: 18px 22px;
    display:flex;
    justify-content:space-between;
    flex-direction:column;
    align-items:flex-end;
    background:#fbfdff;
}
.price-small { font-size:12px; color:var(--muted); }
.price-big { font-size:26px; font-weight:800; color:#0f172a; }
.book-btn { background:var(--primary); color:#fff; padding:10px 18px; border-radius:8px; font-weight:600; text-decoration:none; display:inline-block; transition:.18s; }
.book-btn:hover { background:var(--primary-dark); }

/* EMPTY */
.empty { background:#fff; border-radius:12px; padding:30px; text-align:center; border:1px solid #f0f0f0; }

/* PAGINATION */
.pagination-wrap { margin-top:18px; display:flex; justify-content:center; }

/* RESPONSIVE */
@media (max-width: 1024px) {
    .sidebar { display:none; position:static; max-height:none; }
    .columns { flex-direction:column; }
    .results-grid { grid-template-columns: repeat(auto-fill, minmax(280px,1fr)); }
}
@media (max-width: 768px) {
    .taxi-card { flex-direction:column; }
    .taxi-card .image-block { width:100%; height:200px; }
    .taxi-card .taxi-side { width:100%; border-left:0; border-top:1px solid #eaeff3; align-items:center; }
}

/* autocomplete styles */
.autocomplete-box {
    position: absolute;
    z-index: 100;
    width: 100%;
    background: white;
    border: 1px solid #ddd;
    border-radius: 6px;
    max-height: 180px;
    overflow-y: auto;
}
.autocomplete-item {
    padding: 8px 12px;
    cursor: pointer;
}
.autocomplete-item:hover {
    background: #f2f2f2;
}
.autocomplete-db {
    font-weight: bold;
    color: #1F8FB2;
}
</style>

<div class="page-container">
    <!-- ADVANCED SEARCH BAR -->
<section x-data="locationSearchComponent()" x-init="init()" class="mb-6">

    <!-- Trip type toggle -->
    <div class="flex flex-wrap gap-6 mb-4">
        <label class="inline-flex items-center">
            <input type="radio" name="trip_type" value="one-way"
                   class="form-radio text-blue-500"
                   @click="isReturnTrip = false" checked>
            <span class="ml-2">One-way</span>
        </label>

        <label class="inline-flex items-center">
            <input type="radio" name="trip_type" value="return"
                   class="form-radio text-blue-500"
                   @click="isReturnTrip = true">
            <span class="ml-2">Return</span>
        </label>
    </div>

    <!-- Booking form -->
    <form method="GET"
          action="{{ route('customer.airport-taxi.search') }}"
          class="bg-white rounded-xl px-3 py-3 shadow-lg border-4 border-yellow-400 w-full mx-auto text-sm">

        <div class="flex flex-col md:flex-row md:items-center w-full gap-3 md:gap-4">

            <!-- Pickup -->
            <div class="relative flex-1 min-w-0">
                <input type="text"
                    placeholder="Enter pickup location"
                    class="border p-2 rounded w-full"
                    x-model="pickup"
                    @input.debounce.300ms="fetchSuggestions('suggestionsPickup', pickup)"
                    autocomplete="off">

                <ul class="autocomplete-box" x-show="suggestionsPickup.length > 0" style="display:block;" x-cloak>
                    <template x-for="item in suggestionsPickup" :key="item.display_name">
                        <li class="autocomplete-item" @click="selectPickup(item)">
                            <span x-text="item.display_name"></span>
                            <span x-show="item.isDb" class="autocomplete-db"> (Recommended)</span>
                        </li>
                    </template>
                </ul>

                <input type="hidden" name="pickup" :value="pickup">
            </div>

            <!-- Arrow -->
            <div class="hidden md:flex items-center justify-center w-auto">
                <img src="{{ asset('assets/arrows.svg') }}" class="w-5 h-5" />
            </div>

            <!-- Destination -->
            <div class="relative flex-1 min-w-0">
                <input type="text"
                    placeholder="Enter destination"
                    class="border p-2 rounded w-full"
                    x-model="destination"
                    @input.debounce.300ms="fetchSuggestions('suggestionsDestination', destination)"
                    autocomplete="off">

                <ul class="autocomplete-box" x-show="suggestionsDestination.length > 0" style="display:block;" x-cloak>
                    <template x-for="item in suggestionsDestination" :key="item.display_name">
                        <li class="autocomplete-item" @click="selectDestination(item)">
                            <span x-text="item.display_name"></span>
                            <span x-show="item.isDb" class="autocomplete-db"> (Recommended)</span>
                        </li>
                    </template>
                </ul>

                <input type="hidden" name="destination" :value="destination">
            </div>

            <!-- MAP PREVIEW -->
            <div x-show="mapVisible" class="mt-3 w-full" x-cloak>
                <div id="locationMap" style="height: 230px; border-radius: 10px;"></div>
            </div>

            <!-- Date & Time -->
            <div x-data="{ open: false, checkin: '{{ request('checkin') }}' }"
                 class="relative flex-1 min-w-0">

                <button @click="open = !open" type="button"
                        class="flex items-center gap-2 w-full text-left border p-2 rounded">
                    <img src="{{ asset('assets/calender.svg') }}" class="w-5 h-5" />
                    <span x-text="checkin ? new Date(checkin).toLocaleString() : 'Date & Time'"
                          class="text-gray-800 truncate text-base"></span>
                </button>

                <div x-show="open" @click.away="open = false"
                     class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0">
                    <label class="block text-sm font-medium mb-1">Pick Date & Time</label>
                    <input type="datetime-local" x-model="checkin"
                           class="w-full border p-2 rounded outline-none" />
                </div>

                <input type="hidden" name="checkin" :value="checkin">
            </div>

            <!-- Return Date -->
            <div x-data="{ open: false, returnDate: '{{ request('return_date') }}'}"
                 class="relative flex-1 min-w-0"
                 :class="{ 'opacity-50 pointer-events-none': !isReturnTrip }">

                <button @click="if(isReturnTrip) open = !open" type="button"
                        class="flex items-center gap-2 w-full text-left border p-2 rounded">
                    <img src="{{ asset('assets/calender.svg') }}" class="w-5 h-5" />
                    <span x-text="returnDate ? new Date(returnDate).toLocaleString() : 'Return Date & Time'"
                          class="text-gray-800 truncate text-base"></span>
                </button>

                <div x-show="open && isReturnTrip" @click.away="open = false"
                     class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0">
                    <label class="block text-sm font-medium mb-1">Pick Date & Time</label>
                    <input type="datetime-local" x-model="returnDate"
                           class="w-full border p-2 rounded outline-none" />
                </div>

                <input type="hidden" name="return_date" :value="returnDate">
            </div>

            <!-- Passengers -->
            <div x-data="{ open: false, passengers: '{{ request('users') }}' }"
                 class="relative flex-1 min-w-0">

                <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full border p-2 rounded">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('assets/user.svg') }}" class="w-5 h-5" />
                        <span x-text="passengers || '0'"
                              class="text-gray-800 text-base"></span>
                    </div>
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false"
                     class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-48 right-0">
                    <template x-for="count in [1,2,3,4,5]" :key="count">
                        <button type="button"
                                @click="passengers = count; open = false"
                                class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                            <span x-text="count"></span>
                        </button>
                    </template>
                </div>

                <input type="hidden" name="users" :value="passengers">
            </div>

            <!-- Submit -->
            <div class="flex-shrink-0 w-full md:w-auto">
                <button type="submit"
                        class="w-full h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm"
                        style="background-color:#3CC0E9;">
                    Search
                </button>
            </div>

        </div>
    </form>
</section>

    <div class="columns">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="filter-title">Filters</div>

            <form id="filter-form" method="GET" action="{{ route('customer.airport-taxi.search') }}">
                @foreach (['pickup','destination','checkin'] as $k)
                    @if(request($k))
                        <input type="hidden" name="{{ $k }}" value="{{ request($k) }}">
                    @endif
                @endforeach

                {{-- TAXI TYPES --}}
                <div>
                    <div class="section-title">Taxi type</div>

                    @php
                        $allTypes = $filterGroups['taxi_type'] ?? [];
                    @endphp

                    @if(!empty($allTypes))
                        @foreach($allTypes as $name => $count)
                            @php $id = 'taxi_type-'.simple_slug($name); @endphp
                            <label class="filter-item" for="{{ $id }}">
                                <div class="filter-label">
                                    <input type="checkbox" id="{{ $id }}" name="taxi_type[]" value="{{ $name }}"
                                           {{ in_array($name, $currentFilters['taxi_type'] ?? []) ? 'checked' : '' }}>
                                    <span>{{ $name }}</span>
                                </div>
                                <div class="count">{{ $count ?? 0 }}</div>
                            </label>
                        @endforeach
                    @else
                        @foreach(\App\Models\TaxiType::pluck('name') as $name)
                            @php $id = 'taxi_type-'.simple_slug($name); @endphp
                            <label class="filter-item" for="{{ $id }}">
                                <div class="filter-label">
                                    <input type="checkbox" id="{{ $id }}" name="taxi_type[]" value="{{ $name }}"
                                           {{ in_array($name, $currentFilters['taxi_type'] ?? []) ? 'checked' : '' }}>
                                    <span>{{ $name }}</span>
                                </div>
                                <div class="count">0</div>
                            </label>
                        @endforeach
                    @endif
                </div>

                <div style="height:12px"></div>

                {{-- PASSENGER RANGES --}}
                <div>
                    <div class="section-title">Passengers</div>

                    @php
                        $fixedRanges = [
                            ['label'=>'1 - 4 passengers','value'=>'1-4','min'=>1,'max'=>4],
                            ['label'=>'5 - 8 passengers','value'=>'5-8','min'=>5,'max'=>8],
                            ['label'=>'9 - 12 passengers','value'=>'9-12','min'=>9,'max'=>12],
                            ['label'=>'13+ passengers','value'=>'13+','min'=>13,'max'=>999],
                        ];
                        $pc = $filterGroups['passenger_capacity'] ?? [];
                    @endphp

                    @foreach($fixedRanges as $r)
                        @php
                            $countForRange = 0;
                            foreach($pc as $cap => $cnt){
                                $capInt = (int)$cap;
                                if($capInt >= $r['min'] && $capInt <= $r['max']) $countForRange += $cnt;
                            }
                        @endphp
                        <label class="filter-item">
                            <div class="filter-label">
                                <input type="checkbox" name="passenger_range[]" value="{{ $r['value'] }}"
                                       {{ in_array($r['value'], Arr::wrap($currentFilters['passenger_range'] ?? [])) ? 'checked' : '' }}>
                                <span>{{ $r['label'] }}</span>
                            </div>
                            <div class="count">{{ $countForRange }}</div>
                        </label>
                    @endforeach

                    <div style="height:8px"></div>
                    <div class="text-xs" style="color:var(--muted); margin-bottom:6px;">Or pick exact passenger counts</div>

                    @foreach($filterGroups['passenger_capacity'] ?? [] as $value => $count)
                        @php $id = 'passenger_'.simple_slug($value); @endphp
                        <label class="filter-item" for="{{ $id }}">
                            <div class="filter-label">
                                <input type="checkbox" id="{{ $id }}" name="passenger_capacity[]" value="{{ $value }}"
                                       {{ in_array($value, $currentFilters['passenger_capacity'] ?? []) ? 'checked' : '' }}>
                                <span>{{ $value }} pax</span>
                            </div>
                            <div class="count">{{ $count }}</div>
                        </label>
                    @endforeach
                </div>

                <div style="height:12px"></div>

                {{-- LUGGAGE --}}
                <div>
                    <div class="section-title">Luggage</div>
                    @foreach($filterGroups['luggage_capacity'] ?? [] as $value => $count)
                        @php $id='luggage_'.simple_slug($value); @endphp
                        <label class="filter-item" for="{{ $id }}">
                            <div class="filter-label">
                                <input type="checkbox" id="{{ $id }}" name="luggage_capacity[]" value="{{ $value }}"
                                       {{ in_array($value, $currentFilters['luggage_capacity'] ?? []) ? 'checked' : '' }}>
                                <span>{{ $value }} bags</span>
                            </div>
                            <div class="count">{{ $count }}</div>
                        </label>
                    @endforeach
                </div>

                <div style="height:12px"></div>

                {{-- CITIES --}}
                <div>
                    <div class="section-title">Cities</div>
                    @foreach($filterGroups['nearest_city'] ?? [] as $city => $count)
                        @php $id='city_'.simple_slug($city); @endphp
                        <label class="filter-item" for="{{ $id }}">
                            <div class="filter-label">
                                <input type="checkbox" id="{{ $id }}" name="nearest_city[]" value="{{ $city }}"
                                       {{ in_array($city, $currentFilters['nearest_city'] ?? []) ? 'checked' : '' }}>
                                <span>{{ $city }}</span>
                            </div>
                            <div class="count">{{ $count }}</div>
                        </label>
                    @endforeach
                </div>

                <div style="height:12px"></div>

                <div style="text-align:right;">
                    <a href="{{ route('customer.airport-taxi.search') }}" class="text-sm" style="color:var(--primary)">Clear all</a>
                </div>
            </form>
        </aside>

        <!-- CONTENT -->
        <main class="content">
            <div class="results-top">
                <div>
                    <div class="results-left">
                        <h2>{{ $filteredTaxis->total() ?? 0 }} taxis available</h2>
                        <div class="category-list" id="category-list">
                            @foreach($taxiCategoryTabs as $tab)
                                @php
                                    if(is_array($tab)){
                                        $label = $tab['label'] ?? ($tab['value'] ?? '');
                                        $value = $tab['value'] ?? $label;
                                    } else {
                                        $label = $tab;
                                        $value = $tab;
                                    }
                                    $dataValue = preg_match('/\d/', $value) ? $value : 'type::'.$value;
                                @endphp
                                <button class="category-btn" data-value="{{ $dataValue }}">{{ $label }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="controls">
                    <div class="view-toggle" role="tablist" aria-label="View">
                        <button id="btn-grid" title="Grid view" class="active" aria-pressed="true"><i class="fa fa-th"></i></button>
                        <button id="btn-list" title="List view"><i class="fa fa-list"></i></button>
                    </div>
                </div>
            </div>

            <div id="results-area">
                <!-- GRID -->
                <div id="grid-view" class="results-grid" style="display:grid;">
                    @php
                        $localFallback = '/mnt/data/ed62ea73-6b5d-4f7e-90f1-c76b6f705355.png';
                    @endphp

                    @forelse($filteredTaxis as $taxi)
                        @php
                            $fare = $taxi->fare ?? null;
                            $fareAmount = $fare->base_fare ?? $fare->price ?? $fare->price_per_day ?? $fare->base_price ?? 0;
                        @endphp

                        <article class="grid-card">
                            <div class="thumb">
                                <img src="{{ $taxi->front_image ? asset('storage/'.$taxi->front_image) : $localFallback }}" alt="taxi"
                                     onerror="this.onerror=null; this.src='{{ $localFallback }}'">
                            </div>

                            <div class="inner">
                                <div class="grid-meta">
                                    <div class="grid-title">{{ $taxi->brand_model ?? 'Taxi' }}</div>
                                    <div class="grid-sub">{{ $taxi->type->name ?? 'Standard' }} • Plate: {{ $taxi->number_plate ?? '—' }}</div>

                                    <div class="taxi-specs" style="margin-top:10px;">
                                        <div><i class="fa fa-user" style="color:var(--primary)"></i>&nbsp;{{ $taxi->passenger_capacity ?? '-' }} seats</div>
                                        <div><i class="fa fa-suitcase" style="color:var(--primary)"></i>&nbsp;{{ $taxi->luggage_capacity ?? '-' }} bags</div>
                                        <div><i class="fa fa-map-marker-alt" style="color:var(--primary)"></i>&nbsp;{{ $taxi->nearest_city ?? '-' }}</div>
                                    </div>
                                </div>

                                <div style="text-align:right; min-width:120px;">
                                    <div class="price-small">Price per day</div>
                                    <div class="price-big">${{ number_format($fareAmount,0) }}</div>
                                    <div style="margin-top:10px;">
                                        <a href="{{ route('customer.airport-taxi.show', $taxi->id) }}" class="book-btn">View deal</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="empty">No taxis found for the selected filters.</div>
                    @endforelse
                </div>

                <!-- LIST -->
                <div id="list-view" class="results-list" style="display:none;">
                    @forelse($filteredTaxis as $taxi)
                        @php
                            $fare = $taxi->fare ?? null;
                            $fareAmount = $fare->base_fare ?? $fare->price ?? $fare->price_per_day ?? $fare->base_price ?? 0;
                        @endphp

                        <article class="taxi-card">
                            <div class="image-block">
                                <img src="{{ $taxi->front_image ? asset('storage/'.$taxi->front_image) : $localFallback }}" alt="taxi"
                                     onerror="this.onerror=null; this.src='{{ $localFallback }}'">
                            </div>

                            <div class="taxi-meta">
                                <div>
                                    <div class="taxi-title">{{ $taxi->brand_model ?? 'Taxi' }} <span class="taxi-sub">- {{ $taxi->type->name ?? 'Standard' }}</span></div>
                                    <div class="taxi-sub">Plate: {{ $taxi->number_plate ?? '—' }}</div>

                                    <div class="taxi-specs">
                                        <div><i class="fa fa-user" style="color:var(--primary)"></i>&nbsp;{{ $taxi->passenger_capacity ?? '-' }} seats</div>
                                        <div><i class="fa fa-suitcase" style="color:var(--primary)"></i>&nbsp;{{ $taxi->luggage_capacity ?? '-' }} bags</div>
                                        <div><i class="fa fa-map-marker-alt" style="color:var(--primary)"></i>&nbsp;{{ $taxi->nearest_city ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="mt-3 text-sm" style="color:var(--muted);">Added {{ $taxi->created_at ? $taxi->created_at->diffForHumans() : '' }}</div>
                            </div>

                            <div class="taxi-side">
                                <div class="text-right">
                                    <div class="price-small">Supplier</div>
                                    <div class="price-big">${{ number_format($fareAmount,0) }}</div>
                                </div>

                                <a href="{{ route('customer.airport-taxi.show', $taxi->id) }}" class="book-btn">Book</a>
                            </div>
                        </article>
                    @empty
                        <div class="empty">No taxis found for the selected filters.</div>
                    @endforelse
                </div>
            </div>

            <div class="pagination-wrap">
                {{ $filteredTaxis->links() }}
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const gridBtn = document.getElementById('btn-grid');
    const listBtn = document.getElementById('btn-list');
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');

    const saved = localStorage.getItem('taxi_view') || 'grid';
    function setView(v){
        if(v === 'grid'){
            gridView.style.display = 'grid';
            listView.style.display = 'none';
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        } else {
            gridView.style.display = 'none';
            listView.style.display = 'block';
            gridBtn.classList.remove('active');
            listBtn.classList.add('active');
        }
        localStorage.setItem('taxi_view', v);
    }
    setView(saved);

    gridBtn.addEventListener('click', ()=> setView('grid'));
    listBtn.addEventListener('click', ()=> setView('list'));

    // category buttons
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const raw = this.dataset.value;
            const form = document.getElementById('filter-form');
            if(!form) return;

            // clear taxi_type & passenger filters
            document.querySelectorAll('input[name="taxi_type[]"]').forEach(i => i.checked = false);
            document.querySelectorAll('input[name="passenger_capacity[]"]').forEach(i => i.checked = false);
            document.querySelectorAll('input[name="passenger_range[]"]').forEach(i => i.checked = false);

            if(raw.startsWith('type::')) {
                const typeName = raw.replace('type::','');
                const candidate = Array.from(document.querySelectorAll('input[name="taxi_type[]"]')).find(i => i.value === typeName);
                if(candidate) {
                    candidate.checked = true;
                } else {
                    // hidden fallback
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'taxi_type[]';
                    hidden.value = typeName;
                    form.appendChild(hidden);
                }
            } else {
                const candidate = Array.from(document.querySelectorAll('input[name="passenger_range[]"]')).find(i => i.value === raw);
                if(candidate) candidate.checked = true;
                else {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'passenger_range[]';
                    hidden.value = raw;
                    form.appendChild(hidden);
                }
            }

            form.submit();
        });
    });

    const sidebar = document.getElementById('sidebar');
    if(sidebar){
        sidebar.addEventListener('change', function(e){
            setTimeout(()=> {
                document.getElementById('filter-form').submit();
            }, 50);
        });
    }
});

// Helper: detect user's city (https to avoid mixed-content)
async function detectUserCitySecure() {
    try {
        // ip-api has https endpoint; in some hosting environments this might still be blocked.
        const res = await fetch("https://ip-api.io/json"); // alternative: https://ipapi.co/json/ . pick one that works for you.
        if (!res.ok) return "";
        const data = await res.json();
        return data.city || "";
    } catch (e) {
        // fallback: try another provider
        try {
            const r2 = await fetch("https://ipapi.co/json/");
            if (!r2.ok) return "";
            const d2 = await r2.json();
            return d2.city || "";
        } catch (e2) {
            return "";
        }
    }
}

// Main Alpine component factory (single shared instance)
function locationSearchComponent() {
    return {
        // UI state
        isReturnTrip: false,
        pickup: @json(request('pickup') ?? ''),
        destination: @json(request('destination') ?? ''),
        checkin: @json(request('checkin') ?? ''),
        returnDate: @json(request('return_date') ?? ''),
        passengers: @json(request('users') ?? ''),

        suggestionsPickup: [],
        suggestionsDestination: [],

        // DB cities from server (priority suggestions)
        dbCities: @json(\App\Models\Taxi::select('nearest_city')->whereNotNull('nearest_city')->groupBy('nearest_city')->pluck('nearest_city')),

        // map state
        map: null,
        marker: null,
        mapVisible: false,

        // fetch suggestions (type must be 'suggestionsPickup' or 'suggestionsDestination')
        async fetchSuggestions(type, query) {
            try {
                if (!query || query.length < 2) {
                    this[type] = [];
                    return;
                }

                // local DB matches first (simple contains)
                const matchedDB = this.dbCities
                    .filter(c => c && c.toLowerCase().includes(query.toLowerCase()))
                    .map(c => ({ display_name: c, isDb: true }));

                // Nominatim (restricted to Sri Lanka)
                const url = `https://nominatim.openstreetmap.org/search?format=json&countrycodes=lk&limit=8&q=${encodeURIComponent(query)}`;

                const res = await fetch(url, {
                    headers: {
                        // browsers don't allow changing User-Agent; provide Accept header instead
                        'Accept': 'application/json'
                    }
                });

                let osm = [];
                if (res.ok) {
                    const data = await res.json();
                    osm = data.map(item => ({
                        display_name: item.display_name,
                        lat: item.lat,
                        lon: item.lon,
                        isDb: false
                    }));
                }

                // merge, dedupe by display_name (keep DB items first)
                const combined = [...matchedDB, ...osm];
                const seen = new Set();
                const dedup = [];
                for (const it of combined) {
                    const key = (it.display_name || '').toString();
                    if (!seen.has(key)) {
                        seen.add(key);
                        dedup.push(it);
                    }
                }

                this[type] = dedup;
            } catch (e) {
                console.error('autocomplete error', e);
                this[type] = [];
            }
        },

        // when a pickup suggestion selected
        selectPickup(item) {
            this.pickup = item.display_name || '';
            this.suggestionsPickup = [];
            if (item.lat && item.lon) this.showMap(item.lat, item.lon);
        },

        // when a destination suggestion selected
        selectDestination(item) {
            this.destination = item.display_name || '';
            this.suggestionsDestination = [];
            if (item.lat && item.lon) this.showMap(item.lat, item.lon);
        },

        // show map preview using Leaflet
        showMap(lat, lon) {
            try {
                const la = parseFloat(lat);
                const lo = parseFloat(lon);
                if (Number.isNaN(la) || Number.isNaN(lo)) return;
                this.mapVisible = true;

                // create map on first call
                if (!this.map) {
                    this.map = L.map('locationMap', { attributionControl: false }).setView([la, lo], 12);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 18,
                    }).addTo(this.map);

                    this.marker = L.marker([la, lo]).addTo(this.map);
                } else {
                    this.map.setView([la, lo], 12);
                    if (this.marker) this.marker.setLatLng([la, lo]);
                    else this.marker = L.marker([la, lo]).addTo(this.map);
                }
            } catch (e) {
                console.error('map error', e);
            }
        },

        // init - only auto-detect city if pickup is empty
        async init() {
            try {
                if (!this.pickup) {
                    const city = await detectUserCitySecure();
                    if (city) {
                        // prefer server DB city names if available (case-insensitive)
                        const dbMatch = this.dbCities.find(c => c.toLowerCase() === city.toLowerCase());
                        this.pickup = dbMatch || city;
                    }
                }
            } catch (e) {
                console.warn('city detect failed', e);
            }
        }
    };
}
</script>

@endsection
