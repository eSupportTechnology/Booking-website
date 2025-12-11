
@extends('frontend.master')

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
@endphp


<style>
  /* Small helpers to supplement Tailwind */
  :root { --primary: #0071C2; --muted: #6b7280; --card-shadow: 0 6px 20px rgba(15,23,42,0.06); --radius: 10px; }

  /* Container sizing */
  .container-max { max-width: 1200px; margin: 0 auto; }

  /* Grid / List cards */
  .card-tile { background:white; border-radius:var(--radius); overflow:hidden; box-shadow:var(--card-shadow); display:flex; flex-direction:column; }
  .tile-image { width:100%; height:170px; object-fit:cover; display:block; }

  .card-list { background:white; border-radius:var(--radius); overflow:hidden; box-shadow:var(--card-shadow); display:grid; grid-template-columns: 160px 1fr 170px; gap:1rem; align-items:start; padding:1rem; }
  @media (max-width:900px) {
    .card-list { grid-template-columns: 1fr; padding:0.75rem; }
    .card-list .list-side { display:flex; flex-direction:row; gap:.5rem; justify-content:flex-end; margin-top:.5rem; }
  }
  .list-image { width:100%; height:120px; object-fit:cover; border-radius:8px; }

  .tile-body, .list-body { padding:0.9rem; display:flex; flex-direction:column; gap:0.5rem; }
  .title { font-weight:700; color:var(--primary); font-size:1.05rem; }
  .muted { color:var(--muted); font-size:.92rem; }

  .btn-primary { background:var(--primary); color:#fff; padding:.45rem .9rem; border-radius:8px; display:inline-block; text-align:center; }
  .btn-outline { border:1px solid #e5e7eb; padding:.45rem .9rem; border-radius:8px; display:inline-block; color:#111827; background:#fff; }

  /* Results grid responsive */
  .results-grid { display:grid; gap:1rem; grid-template-columns: 1fr; }
  @media (min-width:768px) { .results-grid.grid-2 { grid-template-columns: repeat(2,1fr); } }
  @media (min-width:1024px) { .results-grid.grid-3 { grid-template-columns: repeat(3,1fr); } }

  /* View toggle */
  .view-toggle { background:#fff; border:1px solid #e6eef6; border-radius:8px; padding:6px; display:inline-flex; gap:6px; align-items:center; }
  .view-toggle button[aria-pressed="true"] { background:#eef8ff; border-radius:6px; }

  /* Small spacing tweak for pagination box */
  .pagination-box { background:#fff; padding:0.75rem; border-radius:8px; box-shadow:var(--card-shadow); }

  /* Small helpers for the search dropdown */
  [x-cloak] { display:none !important; }
</style>


@section('content')
{{-- Dependencies for Autocomplete & utils --}}
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="container-max px-4 sm:px-6 lg:px-8 py-6">

  <!-- SEARCH BAR MATCHING HOME UI -->
<div class="relative z-30 w-full flex justify-center px-4 -mt-10">
    <form action="{{ route('customer.search') }}" method="GET"
        x-data="{
            query: '{{ request('destination') }}',
            results: [],
            open: false,
            fetchSuggestions() {
                if (this.query.length < 2) { this.results = []; this.open = false; return; }
                axios.get('{{ route('customer.search.suggest') }}', { params: { q: this.query } })
                    .then(res => { this.results = res.data; this.open = true; });
            },
            choose(city) { this.query = city; this.open = false; }
        }"
        class="bg-white shadow-xl border border-gray-200 rounded-2xl
               flex flex-col md:flex-row items-center gap-3 md:gap-0
               w-full max-w-6xl py-3 px-4 md:px-6 lg:px-8">

        <!-- DESTINATION -->
        <div class="flex items-center gap-3 flex-1 px-2 md:border-r border-gray-200 relative">
            <img src="{{ asset('assets/stay.svg') }}" class="w-6 h-6 opacity-70" />

            <input type="text" name="destination" placeholder="Where are you going?"
                x-model="query" @input="fetchSuggestions"
                autocomplete="off"
                class="w-full bg-transparent focus:outline-none text-gray-800 placeholder-gray-500" />

            <!-- Suggestions Dropdown -->
            <div x-show="open" @click.away="open = false"
                 class="absolute z-50 left-0 right-0 bg-white border border-gray-200 rounded-xl shadow-lg mt-2 max-h-64 overflow-y-auto">
                <template x-for="item in results" :key="item">
                    <div @click="choose(item)"
                         class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-gray-700 text-sm"
                         x-text="item"></div>
                </template>
            </div>
        </div>

        <!-- DATES -->
        <div class="flex items-center gap-3 flex-1 px-2 md:border-r border-gray-200 cursor-pointer"
             @click="$dispatch('open-dates')">
            <img src="{{ asset('assets/calender.svg') }}" class="w-6 h-6 opacity-70" />
            <span class="text-gray-700">
                {{ request('checkIn') ?: 'Check-in' }} — {{ request('checkOut') ?: 'Check-out' }}
            </span>
        </div>

        <!-- GUESTS -->
        <div class="flex items-center gap-3 flex-1 px-2 md:border-r border-gray-200 cursor-pointer"
             @click="$dispatch('open-guests')">
            <img src="{{ asset('assets/user.svg') }}" class="w-6 h-6 opacity-70" />
            <span class="truncate text-gray-700">
                {{ request('adults', 2) }} adults · {{ request('children', 0) }} children · {{ request('rooms', 1) }} room
            </span>
        </div>

        <!-- SEARCH BUTTON -->
        <button type="submit"
            class="bg-[#1F8FB2] hover:bg-[#0e7fa0] text-white font-semibold 
                   px-6 py-3 rounded-xl text-base whitespace-nowrap">
            Search
        </button>

        <!-- HIDDEN FIELDS -->
        <input type="hidden" name="checkIn" value="{{ request('checkIn') }}">
        <input type="hidden" name="checkOut" value="{{ request('checkOut') }}">
        <input type="hidden" name="adults" value="{{ request('adults') }}">
        <input type="hidden" name="children" value="{{ request('children') }}">
        <input type="hidden" name="rooms" value="{{ request('rooms') }}">
        <input type="hidden" name="pets" value="{{ request('pets') }}">
    </form>
</div>


  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    {{-- Sidebar --}}
    <aside class="hidden lg:block lg:col-span-3">
      <div class="bg-white p-4 rounded-lg shadow-sm">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-lg font-semibold">Filters</h3>
          <a href="{{ route('customer.search') }}" class="text-sm text-gray-500">Clear</a>
        </div>

        <form id="sidebar-filters" method="GET" action="{{ route('customer.search') }}">
          {{-- keep top-level search params in sidebar filter requests --}}
          <input type="hidden" name="destination" value="{{ request('destination') }}" />
          <input type="hidden" name="checkIn" value="{{ request('checkIn') }}" />
          <input type="hidden" name="checkOut" value="{{ request('checkOut') }}" />
          <input type="hidden" name="adults" value="{{ request('adults') }}" />
          <input type="hidden" name="children" value="{{ request('children') }}" />
          <input type="hidden" name="rooms" value="{{ request('rooms') }}" />
          <input type="hidden" name="min_price" value="{{ request('min_price') }}" />
          <input type="hidden" name="max_price" value="{{ request('max_price') }}" />
          <input type="hidden" name="sort" value="{{ request('sort') }}" />

          @foreach($filterGroups as $group)
            @php
              $gname = $group['name'];
              $id = $group['id_prefix'] ?? $gname;
              $items = $group['items'] ?? [];
              $visible = $group['visible_count'] ?? 6;
              $i = 0;
            @endphp

            <div class="mb-4">
              <h4 class="font-medium text-gray-700 mb-2">{{ $group['title'] }}</h4>

              <div>
                @foreach($items as $label => $count)
                  @php
                    $inputName = $gname . '[]';
                    $vals = request()->get($gname, []);
                    if (!is_array($vals)) $vals = [$vals];
                    $checked = in_array($label, $vals) || in_array((string)$label, $vals);
                  @endphp

                  <label class="flex justify-between items-center mb-2 text-sm">
                    <div class="flex items-center gap-2">
                      <input type="checkbox" name="{{ $inputName }}" value="{{ $label }}" {{ $checked ? 'checked' : '' }} onchange="this.form.submit()" />
                      <span class="text-gray-700 truncate" style="max-width:160px;">{{ $label }}</span>
                    </div>
                    <span class="text-xs text-gray-500">{{ $count }}</span>
                  </label>

                  @php $i++; @endphp
                  @if($i == $visible && count($items) > $visible)
                    <div id="more-{{ $id }}" class="hidden">
                  @endif
                @endforeach

                @if(count($items) > $visible)
                    </div>
                    <button type="button" data-target="more-{{ $id }}" class="mt-2 text-sm text-blue-600 toggle-more">Show more</button>
                @endif
              </div>
            </div>

            <div style="height:1px;background:#f1f5f9;margin-bottom:0.75rem;"></div>
          @endforeach
        </form>
      </div>
    </aside>

    {{-- Results --}}
    <main class="lg:col-span-9">
      <div class="flex items-start justify-between mb-4 gap-4">
        <div>
          <h1 class="text-xl font-bold">{{ $properties->total() }} properties found</h1>
          <div class="text-sm text-gray-500 mt-1">Showing page {{ $properties->currentPage() }} of {{ $properties->lastPage() }}</div>
        </div>

        <div class="ml-auto flex items-center gap-3">
          <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">
            <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">{{ $properties->total() }} results</span>
          </div>

          {{-- View toggle --}}
          <div class="view-toggle" role="tablist" aria-label="View mode" style="padding:6px;">
            <button id="view-grid" aria-pressed="true" class="p-2 rounded" title="Grid view">
              <svg class="w-5 h-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3h4v4H3V3zm0 6h4v4H3V9zm6-6h4v4H9V3zm0 6h4v4H9V9z"/></svg>
            </button>
            <button id="view-list" aria-pressed="false" class="p-2 rounded" title="List view">
              <svg class="w-5 h-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor"><path d="M3 5h14v2H3V5zm0 4h14v2H3V9zm0 4h14v2H3v-2z"/></svg>
            </button>
          </div>
        </div>
      </div>

      {{-- Results container --}}
      <div id="results-wrapper">
        <div id="results-grid" class="results-grid grid-2">
          @forelse($properties as $property)
            @php
              // safe image path
              $file = $property->files->first();
              if ($file && !empty($file->path)) {
                  $p = $file->path;
                  if (Str::startsWith($p, ['http://','https://'])) {
                      $img = $p;
                  } elseif (Str::startsWith($p,'public/')) {
                      $img = asset(str_replace('public/','storage/',$p));
                  } else {
                      $img = asset('storage/' . ltrim($p,'/'));
                  }
              } else {
                  $img = asset('assets/default-property.jpg');
              }

              // price: support Collection | Model | fallback DB
              $price = null;

              // If single pricing exists
              if ($property->pricing && $property->pricing->price_per_night) {
                  $price = $property->pricing->price_per_night;
              }
              // If multiple rooms exist use lowest room price
              elseif ($property->rooms && $property->rooms->count()) {
                  $price = $property->rooms->min('price_per_night');
              }

              // Final fallback
              $price = $price ?? 0;

              $short = Str::limit(strip_tags($property->description ?? ''), 140);
            @endphp

            {{-- GRID TILE --}}
            <article class="card-tile" data-id="{{ $property->id }}">
              <img src="{{ $img }}" alt="{{ $property->title }}" class="tile-image" loading="lazy">

              <div class="tile-body">
                <div>
                  <a href="{{ route('customer.properties.details', $property->id) }}" class="title">{{ $property->title }}</a>
                  <div class="muted">{{ $property->city }}, {{ $property->country }}</div>
                  <p class="muted mt-2">{{ $short }}</p>
                </div>

                <div class="tile-bottom">
                  <div class="muted">
                    <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">• {{ optional($property->additionalDetails)->guests ?? '-' }} guests</span>
                    <span class="ml-2 px-2 py-1 bg-gray-100 rounded-full text-xs">• {{ optional($property->additionalDetails)->bathrooms ?? '-' }} baths</span>
                  </div>

                  <div class="flex items-center gap-3">
                    <div class="text-right">
                      <div class="muted text-xs">From</div>
                      <div class="font-bold text-lg">${{ number_format($price,0) }}</div>
                    </div>

                    <div>
                      <a href="{{ route('customer.properties.details', $property->id) }}" class="btn-primary">View deal</a>
                    </div>
                  </div>
                </div>
              </div>
            </article>

            {{-- LIST ROW --}}
            <article class="card-list hidden" data-id="{{ $property->id }}">
              <div>
                <img src="{{ $img }}" alt="{{ $property->title }}" class="list-image">
              </div>

              <div class="list-body p-0">
                <a href="{{ route('customer.properties.details', $property->id) }}" class="list-title title">{{ $property->title }}</a>
                <div class="list-location muted">{{ $property->city }}, {{ $property->country }}</div>
                <p class="list-description muted mt-2">{{ $short }}</p>

                <div class="mt-3 flex gap-3 text-sm text-gray-600">
                  <span class="kv">• {{ optional($property->additionalDetails)->guests ?? '-' }} guests</span>
                  <span class="kv">• {{ optional($property->additionalDetails)->bathrooms ?? '-' }} baths</span>
                  <span class="kv">• Category: {{ optional($property->category)->name ?? '-' }}</span>
                </div>

                <div class="mt-2 text-sm text-gray-500">Added {{ optional($property->created_at)->diffForHumans() ?? '-' }}</div>
              </div>

              <div class="list-side">
                <div>
                  <div class="muted text-xs">Price per night</div>
                  <div class="price-small font-bold">${{ number_format($price,0) }}</div>
                </div>

                <div class="mt-2">
                  <a href="{{ route('customer.properties.details', $property->id) }}" class="btn-primary mb-2 block text-center">View deal</a>
                  <a href="{{ route('customer.properties.details', $property->id) }}" class="btn-outline block text-center">Book now</a>
                </div>
              </div>
            </article>

          @empty
            <div class="bg-white p-6 rounded-lg shadow-sm text-center col-span-full">
              <h3 class="text-lg font-semibold">No properties found</h3>
              <p class="text-gray-500 mt-2">Try clearing filters or widening your search.</p>
            </div>
          @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
          @if(method_exists($properties,'links'))
            <div class="pagination-box">
              {{ $properties->links() }}
            </div>
          @endif
        </div>
      </div>
    </main>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const btnGrid = document.getElementById('view-grid');
  const btnList = document.getElementById('view-list');
  const resultsGrid = document.getElementById('results-grid');

  // pick visible tile/list sets - handle dynamic updates (re-query when needed)
  function refreshCardLists() {
    window.tileCards = Array.from(resultsGrid.querySelectorAll('.card-tile'));
    window.listCards = Array.from(resultsGrid.querySelectorAll('.card-list'));
  }
  refreshCardLists();

  function showGrid() {
    resultsGrid.classList.remove('space-y-6');
    resultsGrid.classList.add('grid-2');
    window.tileCards.forEach(t => t.classList.remove('hidden'));
    window.listCards.forEach(l => l.classList.add('hidden'));
    if (btnGrid) btnGrid.setAttribute('aria-pressed','true');
    if (btnList) btnList.setAttribute('aria-pressed','false');
  }

  function showList() {
    resultsGrid.classList.remove('grid-2','grid-3');
    resultsGrid.classList.add('space-y-6');
    window.tileCards.forEach(t => t.classList.add('hidden'));
    window.listCards.forEach(l => l.classList.remove('hidden'));
    if (btnGrid) btnGrid.setAttribute('aria-pressed','false');
    if (btnList) btnList.setAttribute('aria-pressed','true');
    resultsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  if (btnGrid) btnGrid.addEventListener('click', (e) => { e.preventDefault(); showGrid(); });
  if (btnList) btnList.addEventListener('click', (e) => { e.preventDefault(); showList(); });

  // default behaviour
  showGrid();

  // Toggle "show more" on sidebar filter groups
  document.querySelectorAll('.toggle-more').forEach(btn => {
    btn.addEventListener('click', function () {
      const target = document.getElementById(this.dataset.target);
      if (!target) return;
      target.classList.toggle('hidden');
      this.textContent = target.classList.contains('hidden') ? 'Show more' : 'Show less';
    });
  });

  // Keyboard support for view toggle
  [btnGrid, btnList].forEach(b => {
    if (!b) return;
    b.addEventListener('keydown', (ev) => {
      if (ev.key === 'Enter' || ev.key === ' ') {
        ev.preventDefault();
        b.click();
      }
    });
  });

  // Recompute card sets if DOM changes (e.g., after AJAX replace)
  const observer = new MutationObserver(() => { refreshCardLists(); });
  observer.observe(resultsGrid, { childList: true, subtree: true });
});
</script>
@endpush

@endsection
