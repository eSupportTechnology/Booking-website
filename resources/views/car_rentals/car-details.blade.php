@extends('Customer.master')

@section('content')
<!-- Tailwind, Alpine and SwiperCDN -->
<link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css" />
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://unpkg.com/swiper@9/swiper-bundle.min.js" defer></script>
<script src="https://cdn.tailwindcss.com"></script>

@php
    use Carbon\Carbon;

    // Context from request (search)
    $pickup = request('pickup');
    $destination = request('destination');
    $checkin = request('checkin');
    $checkout = request('checkout');

    function fmt($dt) {
        return $dt ? Carbon::parse($dt)->format('D, d M Y • h:i A') : null;
    }

    // Build gallery
    $gallery = collect();
    if (!empty($car->car_front)) $gallery->push(asset('storage/' . $car->car_front));
    if (!empty($car->car_back)) $gallery->push(asset('storage/' . $car->car_back));
    if (!empty($car->car_inside)) $gallery->push(asset('storage/' . $car->car_inside));

    if (method_exists($car, 'files')) {
        foreach ($car->files as $f) {
            // adapt to your files table columns
            $path = $f->path ?? $f->file_path ?? $f->file_name ?? $f->file ?? $f->filename ?? null;
            if ($path) {
                $url = asset('storage/' . ltrim($path, '/'));
                if (! $gallery->contains($url)) $gallery->push($url);
            }
        }
    }

    if ($gallery->isEmpty()) {
        $gallery->push('https://placehold.co/1200x800?text=No+Image');
    }

    // Included in price: derive from car fields (no DB column)
    $included = [];
    // mileage
    if ($car->mileage_type === 'unlimited') {
        $included[] = 'Unlimited mileage';
    } else {
        $included[] = 'Limited mileage';
    }
    // fuel
    if ($car->fuel_type) {
        $included[] = ucfirst($car->fuel_type) . ' (fuel policy applies)';
    }
    // pricing type
    if ($car->pricing_type === 'perKm') {
        $included[] = 'Pricing: Pay per kilometre';
    } else {
        $included[] = 'Pricing: Per day';
    }
    // driver
    if ($car->with_driver === 'yes') {
        $included[] = 'Driver included';
    } else {
        $included[] = 'Driver not included';
    }

    // Price calculation (server-side safety)
    $days = 1;
    try {
        if ($checkin && $checkout) {
            $s = Carbon::parse($checkin);
            $e = Carbon::parse($checkout);
            $d = $s->diffInDays($e);
            $days = $d > 0 ? $d : 1;
        }
    } catch (\Throwable $e) {
        $days = 1;
    }
    $pricePerDay = $car->price_per_day ?? 0;
    $total = $pricePerDay * $days;

    // Discount from renter relation (use $car->renter)
    $renter = $car->renter ?? null;
    $discountPercentage = (int)($renter->discount_percentage ?? 0);
    $discountAmountPerDay = $discountPercentage > 0 ? ($pricePerDay * $discountPercentage / 100) : 0;
    $pricePerDayAfterDiscount = max(0, $pricePerDay - $discountAmountPerDay);
    $totalDiscount = $discountAmountPerDay * $days;
    $finalTotal = $pricePerDayAfterDiscount * $days;
@endphp

<!-- ================= TOP SEARCH BAR (your code) ================= -->
<div class="relative z-10 -mt-8 px-4">
  <form method="GET" action="{{ route('customer.carsearch') }}" ?pickup={{ request('pickup') }}&destination={{ request('destination') }}&checkin={{ request('checkin') }}&checkout={{ request('checkout') }}"
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
<!-- ================= END SEARCH BAR ================= -->

<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT: Gallery + details -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Back -->
            <a href="{{ route('customer.carsearch') }}" class="text-blue-600 inline-block mb-2">← Back to results</a>

            <!-- Gallery -->
            <div class="bg-white rounded-xl shadow border overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Main swiper (col-span 3) -->
                    <div class="md:col-span-3 p-4">
                        <div class="swiper mySwiperMain">
                            <div class="swiper-wrapper">
                                @foreach($gallery as $img)
                                    <div class="swiper-slide">
                                        <img src="{{ $img }}" class="w-full h-[520px] object-cover rounded-lg" alt="Car image" />
                                    </div>
                                @endforeach
                            </div>
                            <!-- navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>

                    <!-- Thumbs -->
                    <div class="md:col-span-1 p-4 space-y-3">
                        <div class="grid grid-cols-3 md:grid-cols-1 gap-3">
                            @foreach($gallery as $idx => $img)
                                <button type="button" class="thumb-btn rounded-lg overflow-hidden focus:outline-none" data-index="{{ $idx }}">
                                    <img src="{{ $img }}" class="w-full h-20 object-cover" alt="thumb-{{ $idx }}">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Car short info -->
            <div class="bg-white p-6 rounded-xl shadow border">
                <div class="flex justify-between items-start gap-4">
                    <div>
                        <h1 class="text-2xl font-bold">{{ $car->model->model_name ?? 'Model' }}</h1>
                        <p class="text-gray-600">{{ $car->brand->name ?? '' }} • {{ $car->carType->name ?? '' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Supplier</div>
                        <div class="font-semibold">{{ $car->company->name ?? 'Supplier' }}</div>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-700">
                    <div>Seats: <strong>{{ $car->seats }}</strong></div>
                    <div>Transmission: <strong>{{ ucfirst($car->transmission) }}</strong></div>
                    <div>Fuel: <strong>{{ ucfirst($car->fuel_type) }}</strong></div>
                </div>
            </div>

            <!-- Included in price (derived) -->
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-lg font-bold mb-3">Included in the price</h2>
                <ul class="list-inside list-disc text-gray-700 space-y-1">
                    @foreach($included as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                    {{-- small extras always shown --}}
                    <li>Basic insurance included</li>
                    <li>Free cancellation (see policy)</li>
                </ul>
            </div>

            <!-- Pickup & Important info -->
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-lg font-bold mb-3">Pickup & Important info</h2>
                <p class="text-sm text-gray-700">
                    Pickup city: <strong>{{ $car->nearest_city ?? '—' }}</strong><br>
                    Deposit: <strong>{{ $car->deposit ? ('$' . number_format($car->deposit,2)) : '—' }}</strong><br>
                    With driver: <strong>{{ $car->with_driver === 'yes' ? 'Yes' : 'No' }}</strong>
                </p>

                <div class="mt-4 border-t pt-4 text-sm text-gray-700">
                    <h3 class="font-semibold mb-2">What to carry</h3>
                    <ul class="list-disc list-inside">
                        <li>Driving licence</li>
                        <li>Credit card (for deposit if required)</li>
                        <li>Passport / ID</li>
                    </ul>
                </div>
            </div>

            <!-- Further Information (company / renter) -->
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-lg font-bold mb-3">Further Information</h2>
                <p class="text-sm text-gray-700"><strong>Company Name:</strong> {{ $car->renter->company_name ?? $car->renter->full_name ?? '—' }}</p>
                <p class="text-sm text-gray-700"><strong>Business Reg No:</strong> {{ $car->renter->business_reg_no ?? '—' }}</p>
                <p class="text-sm text-gray-700"><strong>TIN:</strong> {{ $car->renter->tin_number ?? '—' }}</p>
                <p class="text-sm text-gray-700"><strong>Address:</strong> {{ $car->renter->address ?? '—' }}</p>

                <p class="text-xs text-gray-500 mt-3">
                    This partner has self-certified that its vehicles and services conform to applicable local rules and safety standards.
                </p>
            </div>

        </div>

        <!-- RIGHT: Price & booking -->
        <aside class="space-y-6">

            <div class="bg-white p-6 rounded-xl shadow border">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-sm text-gray-500">Price per day</div>
                        <div class="text-2xl font-bold">US$ {{ number_format($pricePerDay, 2) }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Rating</div>
                        <div class="inline-flex items-center bg-green-600 text-white px-2 py-1 rounded font-bold">
                            {{ $car->review_score ?? '—' }}
                        </div>
                    </div>
                </div>

                {{-- Days & base price --}}
                <div class="mt-4 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>{{ $days }} day(s)</span>
                        <span>US$ {{ number_format($pricePerDay * $days, 2) }}</span>
                    </div>
                </div>

                {{-- Discount & totals --}}
                <div class="mt-4 pt-4 border-t text-sm text-gray-700 space-y-2">
                    @if($discountPercentage > 0)
                        <div class="flex justify-between text-green-700">
                            <span>Renter discount ({{ $discountPercentage }}%)</span>
                            <span>-US$ {{ number_format($totalDiscount, 2) }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-lg font-bold mt-2">
                        <span>Total</span>
                        <span>US$ {{ number_format($finalTotal, 2) }}</span>
                    </div>
                </div>
                <!-- Pick-up and Drop-off Summary -->
                
                <div class="bg-white p-6 rounded-xl shadow border">
                    <h2 class="text-lg font-bold mb-4">Pick-up and drop-off</h2>

                    <!-- Pick-up -->
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-3 h-3 rounded-full border border-gray-700"></div>
                        <div>
                            <p class="font-semibold">
                                {{ $checkin ? Carbon::parse($checkin)->format('D d M • H:i') : 'Pick-up date not selected' }}
                            </p>

                            <p class="text-sm text-gray-700 font-bold">
                                {{ $pickup ? $pickup : 'Pick-up location not selected' }}
                            </p>

                            <a href="#" class="text-blue-600 text-xs">View pick-up instructions</a>
                        </div>
                    </div>

                    <div class="border-l ml-1 h-8 border-gray-400 my-2"></div>

                    <!-- Drop-off -->
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-3 h-3 rounded-full border border-gray-700"></div>
                        <div>
                            <p class="font-semibold">
                                {{ $checkout ? Carbon::parse($checkout)->format('D d M • H:i') : 'Drop-off date not selected' }}
                            </p>

                            <p class="text-sm text-gray-700 font-bold">
                                {{ $destination ? $destination : 'Drop-off location not selected' }}
                            </p>

                            <a href="#" class="text-blue-600 text-xs">View drop-off instructions</a>
                        </div>
                    </div>
                </div>



                <!-- Car Price Breakdown -->
                <div class="bg-white p-6 rounded-xl shadow border">
                    <h2 class="text-lg font-bold mb-4">Car price breakdown</h2>

                    <div class="flex justify-between text-sm text-gray-700 mb-2">
                        <span>Car hire charge</span>
                        <span>US$ {{ number_format($pricePerDay * $days, 2) }}</span>
                    </div>

                    @if($discountPercentage > 0)
                        <div class="flex justify-between text-sm text-green-700 mb-1">
                            <span>{{ $discountPercentage }}% discount</span>
                            <span>-US$ {{ number_format($totalDiscount, 2) }}</span>
                        </div>

                        <p class="text-xs text-gray-500 -mt-1 mb-3">
                            {{ $discountPercentage }}% off because the renter offers a discount
                        </p>
                    @endif

                    <hr class="my-3">

                    <div class="flex justify-between font-bold text-base">
                        <span>Price for {{ $days }} days:</span>
                        <span>US$ {{ number_format($finalTotal, 2) }}</span>
                    </div>
                </div>


                <!-- Booking form (posts to your CarBookingController@store) -->
                <form method="POST" action="{{ route('customer.car.book', $car->id) }}" class="mt-4">
                    @csrf
                    <!-- Carry search context -->
                    <input type="hidden" name="pickup_location" value="{{ $pickup }}">
                    <input type="hidden" name="dropoff_location" value="{{ $destination }}">
                    <input type="hidden" name="pickup_datetime" value="{{ $checkin }}">
                    <input type="hidden" name="dropoff_datetime" value="{{ $checkout }}">
                    <input type="hidden" name="total_price" value="{{ number_format($finalTotal, 2, '.', '') }}">

                    <!-- If your controller expects different names, adjust above accordingly -->

                    @if(isset($car->with_driver))
                        <div class="mt-3">
                            <label class="text-sm text-gray-700">Driver option</label>
                            <select name="with_driver" class="w-full mt-1 border rounded p-2 text-sm">
                                <option value="{{ $car->with_driver === 'yes' ? 'yes' : 'no' }}">{{ $car->with_driver === 'yes' ? 'With driver' : 'Without driver' }}</option>
                                <option value="{{ $car->with_driver === 'yes' ? 'no' : 'yes' }}">{{ $car->with_driver === 'yes' ? 'Without driver' : 'With driver' }}</option>
                            </select>
                        </div>
                    @endif

                    <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold">
                        Continue to Book
                    </button>
                </form>

                {{-- Bargain box --}}
                @if($discountPercentage > 0)
                <div class="mt-4 p-3 rounded-md bg-green-50 text-green-800 text-sm">
                    <strong>Good deal:</strong> You save {{ $discountPercentage }}% (US$ {{ number_format($totalDiscount,2) }}) on this booking.
                </div>
                @endif
            </div>

            <!-- Supplier info -->
            <div class="bg-white p-4 rounded-xl shadow border text-sm text-gray-700">
                <h4 class="font-semibold mb-2">Supplier</h4>
                <div>{{ $car->company->name ?? '—' }}</div>
                <div class="mt-2 text-xs text-gray-500">Pickup location: {{ $car->nearest_city ?? '—' }}</div>
            </div>

        </aside>

    </div>
</div>

<!-- Swiper + thumb wiring -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let mainSwiper;
        function initSwiper() {
            if (typeof Swiper === 'undefined') {
                return setTimeout(initSwiper, 100);
            }

            mainSwiper = new Swiper('.mySwiperMain', {
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                spaceBetween: 10,
            });

            document.querySelectorAll('.thumb-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idx = parseInt(btn.getAttribute('data-index'));
                    if (!isNaN(idx) && mainSwiper) {
                        mainSwiper.slideTo(idx);
                        window.scrollTo({ top: 200, behavior: 'smooth' });
                    }
                });
            });

            document.addEventListener('keydown', function(e){
                if (e.key === 'ArrowLeft') mainSwiper.slidePrev();
                if (e.key === 'ArrowRight') mainSwiper.slideNext();
            });
        }
        initSwiper();
    });
</script>

@endsection
