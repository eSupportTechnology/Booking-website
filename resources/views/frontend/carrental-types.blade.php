@extends('frontend.carrental-layout')

@section('title', ' Car Types | ' . config('domains.app_name'))

@section('content')

  <!-- Main Section -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
  <h2 class="text-xl sm:text-3xl font-bold text-left mb-2 mt-20">
 List your vehicles and start earning from daily and long-term rentals.
</h2>

  <p class="text-left text-gray-600 text-lg mb-8">
    To get started, choose the type of vehicle you want to list on {{ config('domains.domain') }}
  </p>

  <!-- Responsive Property Cards All in One Row -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-12">

   <!-- Car Rental Card -->
<div class="relative bg-white p-4 rounded-lg shadow border text-center flex flex-col items-center h-full justify-between">
  <div class="flex flex-col flex-grow items-center space-y-4 mt-6">
    <img src="{{ asset('images/rent.png') }}" alt="Car Rental" class="w-20 h-20">
    <h2 class="text-base font-semibold">Car Rental</h2>
    <p class="text-sm text-gray-600 text-center">
      List your cars and start earning from daily and long-term rentals.
    </p>
  </div>
  <a href="{{ url('/partner/category/car-rental') }}" class="w-[70%] mt-4 mb-2">
    <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white px-4 py-2 rounded text-sm font-semibold w-full">
      List your Cars
    </button>
  </a>
</div>

<!-- Airport Taxi Card -->
<div class="bg-white p-4 rounded-lg shadow border text-center flex flex-col w-full h-full justify-between">
  <div class="flex flex-col flex-grow items-center space-y-4 mt-6">
    <img src="{{ asset('images/texi.png') }}" alt="Airport Taxi" class="w-20 h-20">
    <h2 class="text-base font-semibold">Airport Taxi</h2>
    <p class="text-sm text-gray-600 text-center">
      Offer safe and reliable airport transfer services to travelers.
    </p>
  </div>
  <a href="{{ url('/airport-taxi/registration') }}"
     class="mt-4 mb-2 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white px-4 py-2 rounded text-sm font-semibold mx-auto w-[70%] text-center block">
      List your Taxi
  </a>
</div>

    

    </div>

    </div>

  </main>

@endsection