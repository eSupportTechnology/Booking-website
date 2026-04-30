@extends('frontend.master')

@php
    use App\Helpers\CurrencyHelper;
    use Carbon\Carbon;

    /**
     * Expecting $reservations (car rentals) and $hotelBookings (hotel bookings) from controller
     */
    function fmtDT($dt) {
        return $dt ? Carbon::parse($dt)->format('D, d M Y • h:i A') : '—';
    }
@endphp


<style>
  /* Booking.com inspired, but using Tailwind utility-friendly classes */
  body { background: #F6F7F9; }

  .bk-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #D3E4F2; /* soft blue outline */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: .15s ease;
}

.bk-card:hover {
    border-color: #3CC0E9;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    transform: translateY(-3px);
}

  .bk-badge { font-weight: 700; font-size: 12px; padding: 6px 10px; border-radius: 999px; display:inline-block; }

  /* status colors */
  .status-confirmed { background: #E6F6EE; color: #0f9d58; border: 1px solid rgba(15,157,88,0.12); }
  .status-pending   { background: #FFF4E5; color: #D97706; border: 1px solid rgba(217,119,6,0.12); }
  .status-cancelled { background: #FEECEF; color: #D32F2F; border: 1px solid rgba(211,47,47,0.08); }
  .status-completed { background: #EEF2FF; color: #3730A3; border: 1px solid rgba(55,48,163,0.08); }

  .payment-paid { background: #EEF9F6; color:#0f9d58; border:1px solid rgba(15,157,88,0.08); padding:6px 8px; border-radius:8px; font-weight:600; font-size:12px; }
  .payment-pending { background:#FFF8F0;color:#D97706;border:1px solid rgba(217,119,6,0.08); padding:6px 8px;border-radius:8px;font-weight:600;font-size:12px; }
  .payment-completed { background: #EEF9F6; color:#0f9d58; border:1px solid rgba(15,157,88,0.08); padding:6px 8px; border-radius:8px; font-weight:600; font-size:12px; }
  .payment-expired { background:#FEECEF;color:#D32F2F;border:1px solid rgba(211,47,47,0.08); padding:6px 8px;border-radius:8px;font-weight:600;font-size:12px; }

  /* image */
  .booking-img { width: 100%; height: 160px; object-fit: cover; border-radius: 8px; border: 2px solid #E6F4FA;}

  /* responsive tweaks */
  @media (min-width: 768px) {
    .booking-img { height: 140px; }
  }

  /* grid/list mode helpers */
  .results-grid { display:grid; grid-template-columns: repeat(1, 1fr); gap: 1rem; min-height: 280px; }
  @media(min-width: 768px) {
    .results-grid.cols-2 { grid-template-columns: repeat(2, 1fr); }
  }
  .results-list .bk-card { display:flex; gap:1rem; align-items:stretch; border-left: 4px solid #3CC0E9; }

  /* small meta */
  .muted { color: #6b7280; font-size: 13px; }

  /* tabs */
  .tab-btn { padding: 12px 24px; font-weight: 600; border-bottom: 3px solid transparent; transition: .15s ease; }
  .tab-btn:hover { background: #f3f4f6; }
  .tab-btn.active { border-bottom-color: #0071C2; color: #0071C2; }
  .tab-content { display: none; }
  .tab-content.active { display: block; }

  /* type badge */
  .type-hotel { background: #E0F2FE; color: #0369A1; }
  .type-car { background: #FEF3C7; color: #D97706; }
</style>


@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">My Bookings & Trips</h1>
      <p class="text-sm text-gray-600 mt-1">View, edit or cancel your reservations</p>
    </div>

    <div class="flex items-center gap-3">
      <!-- Grid/List toggle -->
      <button id="grid-view-btn" class="px-3 py-2 rounded-md text-sm bg-white border border-gray-200 shadow-sm" title="Grid view">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3h4v4H3V3zM3 13h4v4H3v-4zM13 3h4v4h-4V3zM13 13h4v4h-4v-4z"/></svg>
      </button>
      <button id="list-view-btn" class="px-3 py-2 rounded-md text-sm bg-white border border-gray-200 shadow-sm" title="List view">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor"><path d="M3 6h14v2H3V6zM3 12h14v2H3v-2zM3 4h14v1H3V4z"/></svg>
      </button>
    </div>
  </div>

  <!-- Tabs -->
  <div class="bg-white rounded-lg shadow-sm mb-6">
    <div class="flex border-b">
      <button class="tab-btn active" data-tab="all">All Bookings</button>
      <button class="tab-btn" data-tab="hotels">Hotels ({{ isset($hotelBookings) ? $hotelBookings->count() : 0 }})</button>
      <button class="tab-btn" data-tab="cars">Car Rentals ({{ $reservations->count() }})</button>
    </div>
  </div>

  <!-- Results -->
  <div class="flex flex-col lg:flex-row gap-6">

    <!-- Left: results -->
    <main class="flex-1">

      <!-- All Bookings Tab -->
      <div id="tab-all" class="tab-content active">
        @if(($reservations->count() + (isset($hotelBookings) ? $hotelBookings->count() : 0)) > 0)
          <div id="results" class="results-grid cols-2">

            {{-- Hotel Bookings --}}
            @if(isset($hotelBookings) && $hotelBookings->count())
              @foreach($hotelBookings as $booking)
                @php
                  $property = $booking->property ?? null;
                  $photo = $property && $property->photos && $property->photos->count() > 0
                    ? asset('storage/' . $property->photos->first()->path)
                    : asset('assets/default-property.jpg');

                  $status = $booking->status ?? 'pending';
                  $statusClass = match($status) {
                    'confirmed' => 'status-confirmed',
                    'pending' => 'status-pending',
                    'cancelled' => 'status-cancelled',
                    'completed' => 'status-completed',
                    default => 'status-pending'
                  };
                  $payment = $booking->payment_status ?? 'pending';
                  $paymentClass = match($payment) {
                    'paid', 'completed' => 'payment-completed',
                    'expired' => 'payment-expired',
                    default => 'payment-pending'
                  };
                @endphp

                <article id="hotel-card-{{ $booking->id }}" class="bk-card p-4">
                  <div class="flex flex-col md:flex-row gap-4">
                    <!-- image -->
                    <div class="md:w-44 w-full flex-shrink-0 relative">
                      <img src="{{ $photo }}" alt="Property image" class="booking-img w-full" />
                      <span class="absolute top-2 left-2 bk-badge type-hotel">Hotel</span>
                    </div>

                    <!-- body -->
                    <div class="flex-1 flex flex-col justify-between">
                      <div>
                        <div class="flex justify-between items-start gap-3">
                          <div>
                            <h2 class="text-lg font-semibold text-[#0B7DB6]">
                              {{ $property->title ?? 'Property' }}
                            </h2>
                            <p class="muted mt-1">{{ $property->address ?? '—' }}</p>
                          </div>

                          <div class="text-right">
                            <div class="inline-flex items-center gap-2">
                              <span class="bk-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                            </div>
                            <div class="mt-2">
                              <span class="{{ $paymentClass }}">Payment {{ strtoupper($payment) }}</span>
                            </div>
                          </div>
                        </div>

                        <!-- booking meta -->
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                          <div>
                            <div class="text-xs text-gray-500">Check-in</div>
                            <div class="font-semibold">{{ $booking->check_in ? Carbon::parse($booking->check_in)->format('D, d M Y') : '—' }}</div>
                          </div>
                          <div>
                            <div class="text-xs text-gray-500">Check-out</div>
                            <div class="font-semibold">{{ $booking->check_out ? Carbon::parse($booking->check_out)->format('D, d M Y') : '—' }}</div>
                          </div>
                        </div>

                        <!-- guests & room -->
                        <div class="mt-3 text-sm text-gray-700">
                          <div class="flex items-center gap-4">
                            <span class="muted">Guests: {{ $booking->guest_count ?? ($booking->adults + $booking->children) }}</span>
                            @if($booking->room)
                              <span class="muted">Room: {{ $booking->room->name }}</span>
                            @endif
                          </div>
                        </div>
                      </div>

                      <!-- bottom actions -->
                      <div class="mt-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                          <div class="text-sm muted">Total</div>
                          <div class="text-lg font-bold text-[#0071C2]">@currency($booking->total_price ?? 0, $booking->currency ?? 'USD')</div>
                        </div>

                        <div class="flex items-center gap-2">
                          @if($booking->payment_status === 'pending' && $booking->status !== 'cancelled')
                            <a href="{{ route('customer.payment.show', $booking) }}" class="px-4 py-2 rounded text-sm font-medium text-white bg-green-500 hover:bg-green-600 transition">Pay Now</a>
                          @endif

                          @if($booking->status !== 'cancelled')
                            <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" onsubmit="return confirm('Cancel this booking?')">
                              @csrf
                              @method('PATCH')
                              <button type="submit" class="px-3 py-2 rounded text-sm text-red-600 border border-red-100 bg-red-50">Cancel</button>
                            </form>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </article>
              @endforeach
            @endif

            {{-- Car Reservations --}}
            @foreach($reservations as $res)
              @php
                $car = $res->car ?? null;
                $photo = null;
                if ($car && $car->car_front) {
                  $photo = $car->mainPhoto();
                } else {
                  $photo = asset('assets/default-property.jpg');
                }

                $status = $res->status ?? 'pending';
                $statusClass = match($status) {
                  'confirmed' => 'status-confirmed',
                  'pending' => 'status-pending',
                  'cancelled' => 'status-cancelled',
                  'completed' => 'status-completed',
                  default => 'status-pending'
                };
                $payment = $res->payment_status ?? 'pending';
              @endphp

              <article id="res-card-{{ $res->id }}" class="bk-card p-4">
                <div class="flex flex-col md:flex-row gap-4">
                  <!-- image -->
                  <div class="md:w-44 w-full flex-shrink-0 relative">
                    <img src="{{ $photo }}" alt="Car image" class="booking-img w-full" />
                    <span class="absolute top-2 left-2 bk-badge type-car">Car</span>
                  </div>

                  <!-- body -->
                  <div class="flex-1 flex flex-col justify-between">
                    <div>
                      <div class="flex justify-between items-start gap-3">
                        <div>
                          <h2 class="text-lg font-semibold text-[#0B7DB6]">
                            {{ $car ? ($car->brand->brand_name ?? '') . ' ' . ($car->model->model_name ?? '') : 'Vehicle' }}
                          </h2>
                          <p class="muted mt-1">{{ $car->carType->name ?? ($car->category ?? '') ?? '—' }}</p>
                        </div>

                        <div class="text-right">
                          <div class="inline-flex items-center gap-2">
                            <span class="bk-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                          </div>
                          <div class="mt-2">
                            <span class="{{ $payment === 'paid' ? 'payment-paid' : 'payment-pending' }}">Payment {{ strtoupper($payment) }}</span>
                          </div>
                        </div>
                      </div>

                      <!-- booking meta -->
                      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                        <div>
                          <div class="text-xs text-gray-500">Pick-up</div>
                          <div class="font-semibold">{{ $res->pickup_location ?: '—' }}</div>
                          <div class="muted">{{ fmtDT($res->pickup_datetime) }}</div>
                        </div>
                        <div>
                          <div class="text-xs text-gray-500">Drop-off</div>
                          <div class="font-semibold">{{ $res->dropoff_location ?: '—' }}</div>
                          <div class="muted">{{ fmtDT($res->dropoff_datetime) }}</div>
                        </div>
                      </div>

                      <!-- dates & notes -->
                      <div class="mt-3 text-sm text-gray-700">
                        <div class="flex items-center justify-between">
                          <div class="muted">Reservation dates</div>
                          <div class="font-semibold">{{ Carbon::parse($res->start_date)->format('d M Y') }} — {{ Carbon::parse($res->end_date)->format('d M Y') }}</div>
                        </div>

                        @if($res->notes)
                          <div class="mt-2 text-sm text-gray-600">Notes: {{ Str::limit($res->notes, 120) }}</div>
                        @endif
                      </div>
                    </div>

                    <!-- bottom actions -->
                    <div class="mt-4 flex items-center justify-between gap-3">
                      <div class="flex items-center gap-2">
                        <div class="text-sm muted">Total</div>
                        <div class="text-lg font-bold text-[#0071C2]">{{ CurrencyHelper::formatPrice($res->total_price ?? 0, 'USD') }}</div>
                      </div>

                      <div class="flex items-center gap-2">
                        <a href="{{ route('customer.reservations.show', $res->id) }}" class="px-4 py-2 rounded text-sm font-medium text-white bg-[#0071C2] hover:bg-[#005B9E] transition">View</a>

                        <form method="POST"
                              action="{{ route('customer.reservations.cancel', $res->id) }}"
                              onsubmit="return confirmCancel(event, '{{ $car->brand->brand_name ?? '' }} {{ $car->model->model_name ?? '' }}', '{{ $res->id }}')">
                          @csrf
                          <button type="submit" class="px-3 py-2 rounded text-sm text-red-600 border border-red-100 bg-red-50">Cancel</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <div class="bk-card p-8 text-center">
            <h3 class="text-lg font-semibold">You have no bookings yet</h3>
            <p class="muted mt-2">Search properties or cars and make your first reservation.</p>
            <div class="mt-4 flex justify-center gap-3">
              <a href="{{ route('home-listing') }}" class="inline-block bg-[#3CC0E9] text-white px-4 py-2 rounded font-semibold">Browse Hotels</a>
              <a href="{{ route('customer.carsearch') }}" class="inline-block bg-[#0071C2] text-white px-4 py-2 rounded font-semibold">Browse Cars</a>
            </div>
          </div>
        @endif
      </div>

      <!-- Hotels Only Tab -->
      <div id="tab-hotels" class="tab-content">
        @if(isset($hotelBookings) && $hotelBookings->count())
          <div class="results-grid cols-2">
            @foreach($hotelBookings as $booking)
              @php
                $property = $booking->property ?? null;
                $photo = $property && $property->photos && $property->photos->count() > 0
                  ? asset('storage/' . $property->photos->first()->path)
                  : asset('assets/default-property.jpg');

                $status = $booking->status ?? 'pending';
                $statusClass = match($status) {
                  'confirmed' => 'status-confirmed',
                  'pending' => 'status-pending',
                  'cancelled' => 'status-cancelled',
                  'completed' => 'status-completed',
                  default => 'status-pending'
                };
                $payment = $booking->payment_status ?? 'pending';
                $paymentClass = match($payment) {
                  'paid', 'completed' => 'payment-completed',
                  'expired' => 'payment-expired',
                  default => 'payment-pending'
                };
              @endphp

              <article class="bk-card p-4">
                <div class="flex flex-col md:flex-row gap-4">
                  <div class="md:w-44 w-full flex-shrink-0">
                    <img src="{{ $photo }}" alt="Property image" class="booking-img w-full" />
                  </div>
                  <div class="flex-1 flex flex-col justify-between">
                    <div>
                      <div class="flex justify-between items-start gap-3">
                        <div>
                          <h2 class="text-lg font-semibold text-[#0B7DB6]">{{ $property->title ?? 'Property' }}</h2>
                          <p class="muted mt-1">{{ $property->address ?? '—' }}</p>
                        </div>
                        <div class="text-right">
                          <span class="bk-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                          <div class="mt-2">
                            <span class="{{ $paymentClass }}">Payment {{ strtoupper($payment) }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                        <div>
                          <div class="text-xs text-gray-500">Check-in</div>
                          <div class="font-semibold">{{ $booking->check_in ? Carbon::parse($booking->check_in)->format('D, d M Y') : '—' }}</div>
                        </div>
                        <div>
                          <div class="text-xs text-gray-500">Check-out</div>
                          <div class="font-semibold">{{ $booking->check_out ? Carbon::parse($booking->check_out)->format('D, d M Y') : '—' }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-3">
                      <div class="text-lg font-bold text-[#0071C2]">@currency($booking->total_price ?? 0, $booking->currency ?? 'USD')</div>
                      <div class="flex items-center gap-2">
                        @if($booking->payment_status === 'pending' && $booking->status !== 'cancelled')
                          <a href="{{ route('customer.payment.show', $booking) }}" class="px-4 py-2 rounded text-sm font-medium text-white bg-green-500 hover:bg-green-600 transition">Pay Now</a>
                        @endif
                        @if($booking->status !== 'cancelled')
                          <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" onsubmit="return confirm('Cancel this booking?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-2 rounded text-sm text-red-600 border border-red-100 bg-red-50">Cancel</button>
                          </form>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <div class="bk-card p-8 text-center">
            <h3 class="text-lg font-semibold">No hotel bookings yet</h3>
            <p class="muted mt-2">Find your perfect stay and book now!</p>
            <div class="mt-4">
              <a href="{{ route('home-listing') }}" class="inline-block bg-[#3CC0E9] text-white px-4 py-2 rounded font-semibold">Browse Hotels</a>
            </div>
          </div>
        @endif
      </div>

      <!-- Cars Only Tab -->
      <div id="tab-cars" class="tab-content">
        @if($reservations->count())
          <div class="results-grid cols-2">
            @foreach($reservations as $res)
              @php
                $car = $res->car ?? null;
                $photo = null;
                if ($car && $car->car_front) {
                  $photo = $car->mainPhoto();
                } else {
                  $photo = asset('assets/default-property.jpg');
                }

                $status = $res->status ?? 'pending';
                $statusClass = match($status) {
                  'confirmed' => 'status-confirmed',
                  'pending' => 'status-pending',
                  'cancelled' => 'status-cancelled',
                  'completed' => 'status-completed',
                  default => 'status-pending'
                };
                $payment = $res->payment_status ?? 'pending';
              @endphp

              <article class="bk-card p-4">
                <div class="flex flex-col md:flex-row gap-4">
                  <div class="md:w-44 w-full flex-shrink-0">
                    <img src="{{ $photo }}" alt="Car image" class="booking-img w-full" />
                  </div>
                  <div class="flex-1 flex flex-col justify-between">
                    <div>
                      <div class="flex justify-between items-start gap-3">
                        <div>
                          <h2 class="text-lg font-semibold text-[#0B7DB6]">
                            {{ $car ? ($car->brand->brand_name ?? '') . ' ' . ($car->model->model_name ?? '') : 'Vehicle' }}
                          </h2>
                          <p class="muted mt-1">{{ $car->carType->name ?? ($car->category ?? '') ?? '—' }}</p>
                        </div>
                        <div class="text-right">
                          <span class="bk-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                          <div class="mt-2">
                            <span class="{{ $payment === 'paid' ? 'payment-paid' : 'payment-pending' }}">Payment {{ strtoupper($payment) }}</span>
                          </div>
                        </div>
                      </div>
                      <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                        <div>
                          <div class="text-xs text-gray-500">Pick-up</div>
                          <div class="font-semibold">{{ $res->pickup_location ?: '—' }}</div>
                          <div class="muted">{{ fmtDT($res->pickup_datetime) }}</div>
                        </div>
                        <div>
                          <div class="text-xs text-gray-500">Drop-off</div>
                          <div class="font-semibold">{{ $res->dropoff_location ?: '—' }}</div>
                          <div class="muted">{{ fmtDT($res->dropoff_datetime) }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-3">
                      <div class="text-lg font-bold text-[#0071C2]">{{ CurrencyHelper::formatPrice($res->total_price ?? 0, 'USD') }}</div>
                      <div class="flex items-center gap-2">
                        <a href="{{ route('customer.reservations.show', $res->id) }}" class="px-4 py-2 rounded text-sm font-medium text-white bg-[#0071C2] hover:bg-[#005B9E] transition">View</a>
                        <form method="POST" action="{{ route('customer.reservations.cancel', $res->id) }}" onsubmit="return confirmCancel(event, '{{ $car->brand->brand_name ?? '' }} {{ $car->model->model_name ?? '' }}', '{{ $res->id }}')">
                          @csrf
                          <button type="submit" class="px-3 py-2 rounded text-sm text-red-600 border border-red-100 bg-red-50">Cancel</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <div class="bk-card p-8 text-center">
            <h3 class="text-lg font-semibold">No car rentals yet</h3>
            <p class="muted mt-2">Find your perfect ride and book now!</p>
            <div class="mt-4">
              <a href="{{ route('customer.carsearch') }}" class="inline-block bg-[#0071C2] text-white px-4 py-2 rounded font-semibold">Browse Cars</a>
            </div>
          </div>
        @endif
      </div>

    </main>

  </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const results = document.getElementById('results');
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');

    // Grid/List toggle
    function setGrid() {
        document.querySelectorAll('.results-grid').forEach(el => {
            el.classList.remove('results-list');
            el.classList.add('results-grid', 'cols-2');
        });
        gridBtn.classList.add('ring-2', 'ring-offset-1', 'ring-gray-200');
        listBtn.classList.remove('ring-2', 'ring-offset-1', 'ring-gray-200');
    }

    function setList() {
        document.querySelectorAll('.results-grid').forEach(el => {
            el.classList.remove('results-grid', 'cols-2');
            el.classList.add('results-list');
        });
        listBtn.classList.add('ring-2', 'ring-offset-1', 'ring-gray-200');
        gridBtn.classList.remove('ring-2', 'ring-offset-1', 'ring-gray-200');
    }

    if (window.innerWidth < 640) setList();
    else setGrid();

    gridBtn.addEventListener('click', setGrid);
    listBtn.addEventListener('click', setList);

    // Tab switching
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;

            // Update button states
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Show/hide tab content
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === 'tab-' + tabId) {
                    content.classList.add('active');
                }
            });
        });
    });
  });

  // Cancel confirmation
  function confirmCancel(e, carName, id) {
    if (!confirm('Cancel reservation #' + id + ' — ' + (carName || 'this vehicle') + '?\nThis action cannot be undone.')) {
        e.preventDefault();
        return false;
    }
    return true;
  }

  function cancelReservation(id) {
    if (!confirm("Are you sure you want to cancel this booking?")) return;

    fetch(`/customer/reservations/${id}/cancel`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json",
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            let card = document.getElementById("res-card-" + id);
            if (card) {
                card.style.transition = "0.3s";
                card.style.opacity = "0";
                setTimeout(() => card.remove(), 300);
            }
        }
    })
    .catch(err => console.error(err));
  }
</script>
@endsection
