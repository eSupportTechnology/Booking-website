@extends('frontend.master')

@section('content')
<!-- Tailwind, Alpine and SwiperCDN -->
<link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://unpkg.com/swiper@9/swiper-bundle.min.js" defer></script>
<script src="https://cdn.tailwindcss.com"></script>

@php
    use Carbon\Carbon;

    // ==========================
    // SEARCH CONTEXT FROM REQUEST
    // ==========================
    $pickup = request('pickup');
    $destination = request('destination');
    $checkin = request('checkin');
    $checkout = request('checkout');

    function fmt($dt) {
        return $dt ? Carbon::parse($dt)->format('D, d M Y • h:i A') : null;
    }

    // ==========================
    // IMAGE GALLERY
    // ==========================
    $gallery = collect();
    if (!empty($car->car_front)) $gallery->push(asset('storage/' . $car->car_front));
    if (!empty($car->car_back)) $gallery->push(asset('storage/' . $car->car_back));
    if (!empty($car->car_inside)) $gallery->push(asset('storage/' . $car->car_inside));

    // Additional images from files table (if exists)
    if (method_exists($car, 'files')) {
        foreach ($car->files as $f) {
            $path = $f->path ?? $f->file_path ?? $f->file_name ?? $f->file ?? $f->filename ?? null;
            if ($path) {
                $url = asset('storage/' . ltrim($path, '/'));
                if (!$gallery->contains($url)) {
                    $gallery->push($url);
                }
            }
        }
    }

    if ($gallery->isEmpty()) {
        $gallery->push('https://placehold.co/1200x800?text=No+Image');
    }

    // ==========================
    // INCLUDED IN PRICE
    // ==========================
    $included = [];

    // mileage
    $included[] = $car->mileage_type === 'unlimited'
                    ? 'Unlimited mileage'
                    : 'Limited mileage';

    // fuel type
    if ($car->fuel_type) {
        $included[] = ucfirst($car->fuel_type) . ' (fuel policy applies)';
    }

    // pricing mode
    $included[] = $car->pricing_type === 'perKm'
                    ? 'Pricing: Pay per kilometre'
                    : 'Pricing: Per day';

    // driver included?
    $included[] = $car->with_driver === 'yes'
                    ? 'Driver included'
                    : 'Driver not included';

    // ==========================
    // PRICE CALCULATION
    // ==========================
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

    // ==========================
    // DISCOUNT LOGIC (FROM CAR RENTER)
    // ==========================
    $renter = $car->renter ?? null;
    $discountPercentage = (int)($renter->discount_percentage ?? 0);

    // discount per day
    $discountAmountPerDay = $discountPercentage > 0
                            ? ($pricePerDay * $discountPercentage / 100)
                            : 0;

    // adjusted daily price
    $pricePerDayAfterDiscount = max(0, $pricePerDay - $discountAmountPerDay);

    // full booking discount amount
    $totalDiscount = $discountAmountPerDay * $days;

    // final total
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
                        <h1 class="text-2xl font-bold flex items-center gap-2">
                            {{ $car->brand->brand_name ?? 'Unknown Brand' }}
                            {{ $car->model->model_name ?? 'Unknown Model' }}
                        </h1>
                        <p class="text-gray-600 text-sm mt-1">
                            {{ $car->carType->name ?? '' }} Category
                        </p>
                    </div>

                    <!-- Supplier -->
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Supplier</p>
                        <p class="font-semibold text-base flex items-center justify-end gap-2">
                            <i class="fa-solid fa-building text-gray-600"></i>
                            {{ $car->company->name ?? 'Supplier' }}
                        </p>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-700">

                    <!-- Seats -->
                    <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border">
                        <i class="fa-solid fa-chair text-blue-600 text-lg"></i>
                        <div>
                            <p class="text-xs text-gray-500">Seats</p>
                            <p class="font-semibold">{{ $car->seats }}</p>
                        </div>
                    </div>

                    <!-- Transmission -->
                    <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border">
                        <i class="fa-solid fa-gears text-blue-600 text-lg"></i>
                        <div>
                            <p class="text-xs text-gray-500">Transmission</p>
                            <p class="font-semibold">{{ ucfirst($car->transmission) }}</p>
                        </div>
                    </div>

                    <!-- Fuel -->
                    <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border">
                        <i class="fa-solid fa-gas-pump text-blue-600 text-lg"></i>
                        <div>
                            <p class="text-xs text-gray-500">Fuel type</p>
                            <p class="font-semibold">{{ ucfirst($car->fuel_type) }}</p>
                        </div>
                    </div>

                </div>
            </div>

           <!-- Included in price (derived) -->
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M16.707 5.293a1 1 0 010 1.414l-7.364 7.364a1 1 0 01-1.414 0L3.293 9.293a1 1 0 011.414-1.414l3.586 3.586 6.657-6.657a1 1 0 011.757.686z"/>
                    </svg>
                    Included in the price
                </h2>

                <ul class="space-y-3">
                    @foreach($included as $item)
                        <li class="flex items-start gap-3 text-gray-700">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-7.364 7.364a1 1 0 01-1.414 0L3.293 9.293a1 1 0 011.414-1.414l3.586 3.586 6.657-6.657a1 1 0 011.757.686z"/>
                            </svg>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach

                    <!-- Always-included extras -->
                    <li class="flex items-start gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-7.364 7.364a1 1 0 01-1.414 0L3.293 9.293a1 1 0 011.414-1.414l3.586 3.586 6.657-6.657a1 1 0 011.757.686z"/>
                        </svg>
                        <span>Basic insurance included</span>
                    </li>

                    <li class="flex items-start gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M16.707 5.293a1 1 0 010 1.414l-7.364 7.364a1 1 0 01-1.414 0L3.293 9.293a1 1 0 011.414-1.414l3.586 3.586 6.657-6.657a1 1 0 011.757.686z"/>
                        </svg>
                        <span>Free cancellation (see policy)</span>
                    </li>
                </ul>
            </div>

            <!-- Pickup & Important Info -->
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 016 6c0 5-6 10-6 10S4 13 4 8a6 6 0 016-6zm0 8a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    Pickup & Important Info
                </h2>

                <div class="space-y-3 text-sm text-gray-700">
                    
                    <!-- Pickup City -->
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.05 4.05a7 7 0 119.9 9.9L10 19l-4.95-4.95a7 7 0 010-9.9zM10 11a3 3 0 100-6 3 3 0 000 6z"/>
                        </svg>
                        <p>Pickup city: <strong>{{ $car->nearest_city ?? '—' }}</strong></p>
                    </div>

                    <!-- Deposit -->
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2C5.589 2 2 5.589 2 10s3.589 8 8 8 8-3.589 8-8-3.589-8-8-8zm1 13H9v-1h2v1zm1.07-5.75l-.9.92C10.45 10.9 10 11.5 10 13H9v-.5c0-.78.45-1.52 1.17-2.22l1.02-1.06a1.5 1.5 0 10-2.13-2.12L8.5 8.5l-.72-.72 1.39-1.39a3 3 0 014.24 4.24z"/>
                        </svg>
                        <p>Deposit: <strong>{{ $car->deposit ? ('$' . number_format($car->deposit,2)) : '—' }}</strong></p>
                    </div>

                    <!-- Driver Option -->
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a4 4 0 014 4v1h-2V6a2 2 0 10-4 0v1H6V6a4 4 0 014-4zm-6 8a2 2 0 012-2h8a2 2 0 012 2v6H4v-6zm2 4h8v-4H6v4z"/>
                        </svg>
                        <p>With driver: <strong>{{ $car->with_driver === 'yes' ? 'Yes' : 'No' }}</strong></p>
                    </div>
                </div>

                <!-- Divider -->
                <div class="mt-5 border-t pt-5">
                    <h3 class="font-semibold text-base mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a3 3 0 013 3v2h-1V5a2 2 0 10-4 0v2H7V5a3 3 0 013-3zm5 6v10H5V8h10zM7 10v6h2v-6H7zm4 0v6h2v-6h-2z"/>
                        </svg>
                        What to carry
                    </h3>

                    <ul class="space-y-2 text-gray-700 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-600 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3a2 2 0 012-2h3v2H5v14h3v2H5a2 2 0 01-2-2V3zm9-2h3a2 2 0 012 2v14a2 2 0 01-2 2h-3v-2h3V3h-3V1zm-2 2a1 1 0 011-1h1v2h-1v14h1v2h-1a1 1 0 01-1-1V3z"/>
                            </svg>
                            Driving licence
                        </li>

                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-600 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4h12v12H4V4zm2 2v2h2V6H6zm0 4v2h2v-2H6zm4-4h4v2h-4V6zm0 4h4v2h-4v-2z"/>
                            </svg>
                            Credit card (for deposit if required)
                        </li>

                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-600 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a5 5 0 015 5v2H5V7a5 5 0 015-5zm-3 9h6a2 2 0 012 2v3H5v-3a2 2 0 012-2z"/>
                            </svg>
                            Passport / ID
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Further Information (Company / Renter) -->
            <div class="bg-white p-6 rounded-xl shadow border relative">

                <!-- Company Logo (top-right) -->
                <div class="absolute top-6 right-6">
                    @if(!empty($car->renter->company_logo))
                        <img src="{{ asset('storage/' . $car->renter->company_logo) }}"
                            alt="Company Logo"
                            class="w-16 h-16 object-cover rounded-xl border shadow-sm bg-white">
                    @else
                        <!-- Fallback -->
                        <div class="w-16 h-16 rounded-xl bg-gray-200 flex items-center justify-center text-xl font-bold text-gray-500 border shadow-sm">
                            <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 016 6v1H4V8a6 6 0 016-6zm6 9v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6h12z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Heading -->
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 016 6v1H4V8a6 6 0 016-6zm6 9v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6h12z"/>
                    </svg>
                    Further Information
                </h2>

                <!-- Business Card Wrapper -->
                <div class="border border-gray-200 rounded-xl p-5 bg-gray-50 shadow-inner mt-3">
                    <div class="space-y-4 text-sm">

                        <!-- Company / Name -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a2 2 0 012 2v1h4v11H4V5h4V4a2 2 0 012-2zM6 9v2h2V9H6zm0 4v2h2v-2H6zm4-4v2h4V9h-4zm0 4v2h4v-2h-4z"/>
                            </svg>
                            <p>
                                <span class="text-gray-600 font-semibold">Company Name:</span>
                                {{ $car->renter->company_name ?? $car->renter->full_name ?? '—' }}
                            </p>
                        </div>

                        <!-- Business Reg No -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-purple-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a2 2 0 012-2h10a2 2 0 012 2v3H3V4zm0 5h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V9zm3 2v2h2v-2H6zm0 3v2h2v-2H6zm4-3v2h4v-2h-4zm0 3v2h4v-2h-4z"/>
                            </svg>
                            <p>
                                <span class="text-gray-600 font-semibold">Business Reg No:</span>
                                {{ $car->renter->business_reg_no ?? '—' }}
                            </p>
                        </div>

                        <!-- TIN -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 012-2h8a2 2 0 012 2v14l-6-3-6 3V3z"/>
                            </svg>
                            <p>
                                <span class="text-gray-600 font-semibold">TIN:</span>
                                {{ $car->renter->tin_number ?? '—' }}
                            </p>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 016 6c0 5-6 10-6 10S4 13 4 8a6 6 0 016-6zm0 9a3 3 0 100-6 3 3 0 000 6z"/>
                            </svg>
                            <p>
                                <span class="text-gray-600 font-semibold">Address:</span>
                                {{ $car->renter->address ?? '—' }}
                            </p>
                        </div>

                    </div>

                    <!-- Notice -->
                    <p class="text-xs text-gray-500 mt-5 border-t pt-3 flex items-start gap-2">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M18 10A8 8 0 11.001 10 8 8 0 0118 10zM9 5h2v2H9V5zm0 4h2v6H9V9z"/>
                        </svg>
                        This partner has self-certified that its vehicles and services comply with local safety and operational standards.
                    </p>
                </div>
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
                <!-- Pick-up and drop-off summary -->
                <div class="bg-white p-6 rounded-xl shadow border">
                    <h2 class="text-lg font-bold mb-4">Pick-up and drop-off</h2>

                    {{-- PICKUP SUMMARY --}}
                    <div class="mb-4">
                        <div class="flex items-start gap-3">
                            <span class="text-blue-600 text-lg">○</span>
                            <div>
                                <p class="font-semibold">
                                    {{ $checkin ? fmt($checkin) : 'Pick-up date not selected' }}
                                </p>

                                <p class="text-gray-600 font-semibold">
                                    {{ $pickup ?: 'Pick-up location not selected' }}
                                </p>

                                <a href="#" class="text-blue-600 text-xs">View pick-up instructions</a>
                            </div>
                        </div>
                    </div>

                    {{-- DROPOFF SUMMARY --}}
                    <div>
                        <div class="flex items-start gap-3">
                            <span class="text-blue-600 text-lg">○</span>
                            <div>
                                <p class="font-semibold">
                                    {{ $checkout ? fmt($checkout) : 'Drop-off date not selected' }}
                                </p>

                                <p class="text-gray-600 font-semibold">
                                    {{ $destination ?: 'Drop-off location not selected' }}
                                </p>

                                <a href="#" class="text-blue-600 text-xs">View drop-off instructions</a>
                            </div>
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
                <form method="GET" action="{{ route('customer.car.book.create', $car->id) }}" class="mt-4">
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
