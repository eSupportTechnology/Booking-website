@extends('frontend.master')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="flex flex-col lg:flex-row gap-8">

    <!-- Left Column: Swiper Carousel -->
    <div class="flex-1 relative">
      <div class="swiper taxi-swiper h-48 sm:h-64 md:h-80">
        <div class="swiper-wrapper">
          @if($taxi->front_image)
            <div class="swiper-slide">
              <img src="{{ asset('storage/'.$taxi->front_image) }}" alt="Front View"
                   class="w-full h-48 sm:h-64 md:h-80 object-cover rounded-lg">
            </div>
          @endif
          @if($taxi->back_image)
            <div class="swiper-slide">
              <img src="{{ asset('storage/'.$taxi->back_image) }}" alt="Back View"
                   class="w-full h-48 sm:h-64 md:h-80 object-cover rounded-lg">
            </div>
          @endif
          @if($taxi->inside_image)
            <div class="swiper-slide">
              <img src="{{ asset('storage/'.$taxi->inside_image) }}" alt="Inside View"
                   class="w-full h-48 sm:h-64 md:h-80 object-cover rounded-lg">
            </div>
          @endif
          @if(!$taxi->front_image && !$taxi->back_image && !$taxi->inside_image)
            <div class="swiper-slide">
              <img src="{{ asset('images/placeholder-car.jpg') }}" alt="No Image"
                   class="w-full h-48 sm:h-64 md:h-80 object-cover rounded-lg">
            </div>
          @endif
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination"></div>

        <!-- Navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </div>

    <!-- Right Column: Car Details & Booking -->
    <div class="flex-1 space-y-6">

      <!-- Car Info -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-2">{{ $taxi->brand }} {{ $taxi->model }}</h1>
        <p class="text-green-600 font-semibold text-xl mb-4">
          €{{ number_format($taxi->desired_price, 2) }} 
          <span class="text-gray-500 text-sm">(Minimum price €{{ number_format($taxi->min_price, 2) }})</span>
        </p>
        <ul class="text-gray-700 space-y-1 text-sm">
          <li><strong>Advertisement number:</strong> {{ $taxi->ad_number }}</li>
          <li><strong>Location:</strong> {{ $taxi->location }}</li>
          <li><strong>Desired price:</strong> €{{ number_format($taxi->desired_price, 2) }}</li>
          <li><strong>Minimum price:</strong> €{{ number_format($taxi->min_price, 2) }}</li>
          <li><strong>Advertised on:</strong> {{ $taxi->advertised_on }}</li>
          <li><strong>Planned sale:</strong> {{ $taxi->planned_sale }}</li>
        </ul>
      </div>

      <!-- Booking Form -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Book This Car</h2>
        <form class="space-y-4">
          <input type="text" placeholder="Your Name" class="w-full border rounded p-2">
          <input type="email" placeholder="Email" class="w-full border rounded p-2">
          <input type="tel" placeholder="Phone" class="w-full border rounded p-2">
          <input type="date" class="w-full border rounded p-2">
          <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
            Book Now
          </button>
        </form>
      </div>

      <!-- Vehicle Details -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Vehicle Details</h2>
        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
          <div><strong>Brand:</strong> {{ $taxi->brand }}</div>
          <div><strong>Model:</strong> {{ $taxi->model }}</div>
          <div><strong>First Registration:</strong> {{ $taxi->first_registration }}</div>
          <div><strong>KM:</strong> {{ $taxi->km }}</div>
          <div><strong>Transmission:</strong> {{ $taxi->transmission }}</div>
          <div><strong>Fuel:</strong> {{ $taxi->fuel }}</div>
          <div><strong>Engine Damage:</strong> {{ $taxi->engine_damage ? 'Yes' : 'No' }}</div>
          <div><strong>Accident Free:</strong> {{ $taxi->accident_free ? 'Yes' : 'No' }}</div>
          <div><strong>Roadworthy:</strong> {{ $taxi->roadworthy ? 'Yes' : 'No' }}</div>
          <div><strong>MOT until:</strong> {{ $taxi->mot_until }}</div>
        </div>
      </div>

      <!-- Extras -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Extras</h2>
        <div class="flex flex-wrap gap-2">
          @if(!empty($taxi->extras))
            @foreach($taxi->extras as $extra)
              <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">{{ $extra }}</span>
            @endforeach
          @else
            <span class="text-gray-500 text-sm">No extras listed.</span>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

<!-- Swiper CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.taxi-swiper', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });
});
</script>
@endsection
