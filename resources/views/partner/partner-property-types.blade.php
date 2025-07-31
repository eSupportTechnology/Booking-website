

@extends('partner.partner-layout')

@section('title', 'Property Types')

@section('content')
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Main Section -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <h2 class="text-xl sm:text-3xl font-bold text-left mb-2 mt-20">
      List your property on Bookintour.com and start welcoming guests in no time!
    </h2>
    <p class="text-left text-gray-600 text-lg mb-8">
      To get started, choose the type of property you want to list on Bookintour.com
    </p>

    <!-- Responsive Property Cards All in One Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-12">
      @foreach ($properties as $property)
      @php
      $name = $property['name'];
      $image = '';
      $description = '';
      $route = '#';
      $showQuickStart = false;

      switch ($name) {
      case 'Apartment':
      $image = 'images/accomm_one_apt_main@2x.png';
      $description = 'Furnished and self-catering accommodation, where guests rent the entire place.';
      $route = url('/partner/property_subcategory/2');
      $showQuickStart = true;
      break;

      case 'Homes':
      $image = 'images/accomm_single_home@2x (1).png';
      $description = 'Properties like apartments, holiday homes, villas, etc.';
      $route = url('/partner/property_subcategory/1');
      break;

      case 'Hotel, B&Bs, and more':
      $image = 'images/accomm_hotels_main_v2@2x.png';
      $description = 'Properties like hotels, B&Bs, guest houses, hostels, aparthotels, etc.';
      $route = url('/partner/property_subcategory/3');
      break;

      case 'Alternative places':
      $image = 'images/tent-big@2x.png';
      $description = 'Properties like boats, campsites, luxury tents, etc.';
      $route = '#'; // Or provide a real route if available
      break;
      }
      @endphp

      <div class="relative bg-white p-4 rounded-lg shadow border text-center flex flex-col items-center h-full justify-between">
        @if($showQuickStart)
        <span class="absolute -top-2 bg-green-700 text-white text-xs px-2 py-1 rounded-lg font-semibold z-10 inline-flex items-center space-x-1">
          <img src="{{ asset('assets/mdi_playlist-tick.svg') }}" alt="Tick" class="w-4 h-4" />
          <span>Quick start</span>
        </span>
        @endif

        <div class="flex flex-col flex-grow items-center space-y-4 mt-6">
          <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-12 h-12">
          <h2 class="text-base font-semibold">{{ $name }}</h2>
          <p class="text-sm text-gray-600 text-center">{{ $description }}</p>
        </div>

        <a href="{{ $route }}" class="w-[70%] mt-4 mb-2">
          <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white px-4 py-2 rounded text-sm font-semibold w-full">
            List your property
          </button>
        </a>
      </div>
      @endforeach
    </div>
  </main>
@endsection