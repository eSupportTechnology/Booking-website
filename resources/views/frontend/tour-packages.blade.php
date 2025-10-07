@extends('frontend.master')
@section('title', 'Tour Packages')
@section('content')
<!--Hero Section-->
<section class="text-white py-8 bg-[#1F8FB2] relative z-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Text -->
    <div class="mb-10 mt-1">
      <h1 class="text-[32px] md:text-[40px] lg:text-[40px] font-bold mb-2">
        Luxury Tours for Discerning Travelers
      </h1>
      <p class="text-[18px] md:text-[20px] mt-1 font-sans">
        Curated luxury journeys to the world’s most beautiful places
      </p>
    </div>
  </div>
</section>


<!-- Search Box: Overlapping both sections -->
<div class="relative z-10 -mt-8 px-4">
  <!-- Alpine.js CDN (Required for Dropdowns) -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <form method="GET"
    class="bg-white rounded-xl px-2 py-2 md:py-1 shadow-lg flex flex-col md:flex-row 
           items-stretch md:items-center gap-2 md:gap-0 border-4 border-yellow-400 
           max-w-6xl mx-auto overflow-visible text-sm">

    <!-- Destination Selector -->
    <div x-data="{ open: false, destination: '' }"
      class="relative flex-1 px-2 py-1 md:border-r border-gray-300">
      
      <button @click="open = !open" type="button"
        class="flex items-center gap-2 w-full text-left text-sm">
        
        <!-- Search Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 2a6 6 0 00-6 6c0 4.25 6 10 6 10s6-5.75 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
        </svg>

        <span x-text="destination || 'Search by destination'"
          class="text-gray-800 truncate text-base"
          style="font-family: 'Noto Sans', sans-serif;">
        </span>
      </button>

      <!-- Dropdown -->
      <div x-show="open" @click.away="open = false"
        class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
        <template x-for="city in ['New York', 'Los Angeles', 'London', 'Paris', 'Tokyo']" :key="city">
          <button type="button"
            @click="destination = city; open = false"
            class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
            <span x-text="city"></span>
          </button>
        </template>
      </div>

      <!-- Hidden field -->
      <input type="hidden" name="destination" :value="destination">
    </div>

    <!-- Search Button -->
    <div class="px-2 py-1 w-full md:w-auto">
      <button type="submit"
        class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 
               text-white font-semibold px-4 py-2 rounded-lg text-sm"
        style="background-color:#3CC0E9;">
        Search
      </button>
    </div>
  </form>
</div>



<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<section class="scroll-section py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Top experiences in Sri Lanka</h2>

    <div class="relative">
      <!-- Scroll Container -->
      <div id="scrollContainer" class="scroll-container flex space-x-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
        @for ($i = 0; $i < 10; $i++) <!-- Adjust count as needed -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative min-w-[250px] max-w-[250px] h-[350px]">
          <!-- Like Button -->
          <button 
            style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;" 
            onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';">
            🤍
          </button>

          <!-- Hotel Image -->
          <img src="{{ asset('images/top.jpg') }}" alt="Hotel Image" class="w-full h-52 object-cover">

          <!-- Hotel Info -->
          <div class="p-3">
            
            <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">Ella Day Trip with Train Ride & Tea Factory - All Inclusive</h3>

            
            <div class="flex items-center mt-2">
              <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Noto Sans', sans-serif;">9.7</span>
              <div style="font-family: 'Noto Sans', sans-serif;">
           <!-- Star Rating -->
<div class="flex ml-2">
  <!-- Filled stars -->
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
</div>

                <span class="text-xs ml-2 block">337 Reviews</span>
              </div>
            </div>

            <div class="mt-2 text-left" style="font-family: 'Noto Sans', sans-serif;">
              <span class="text-xs text-black font-semibold">from $130.00 per adult</span>
            
            </div>
          </div>
        </div>
        @endfor
      </div>

      <!-- Arrow Buttons -->
      <button id="scrollLeft" class="scroll-left absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2" style="margin-left: -20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button id="scrollRight" class="scroll-right absolute top-1/2 right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-2" style="margin-right: -20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</section>


<section class="scroll-section py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Top rated tours</h2>

    <div class="relative">
      <!-- Scroll Container -->
      <div id="scrollContainer" class="scroll-container flex space-x-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
        @for ($i = 0; $i < 10; $i++) <!-- Adjust count as needed -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative min-w-[250px] max-w-[250px] h-[350px]">
          <!-- Like Button -->
          <button 
            style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;" 
            onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';">
            🤍
          </button>

          <!-- Hotel Image -->
          <img src="{{ asset('images/top2.jpg') }}" alt="Hotel Image" class="w-full h-52 object-cover">

          <!-- Hotel Info -->
          <div class="p-3">
            
            <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">Ella Day Trip with Train Ride & Tea Factory - All Inclusive</h3>

            
            <div class="flex items-center mt-2">
              <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Noto Sans', sans-serif;">9.7</span>
              <div style="font-family: 'Noto Sans', sans-serif;">
           <!-- Star Rating -->
<div class="flex ml-2">
  <!-- Filled stars -->
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
</div>

                <span class="text-xs ml-2 block">337 Reviews</span>
              </div>
            </div>

            <div class="mt-2 text-left" style="font-family: 'Noto Sans', sans-serif;">
              <span class="text-xs text-black font-semibold">from $130.00 per adult</span>
            
            </div>
          </div>
        </div>
        @endfor
      </div>

      <!-- Arrow Buttons -->
      <button id="scrollLeft" class="scroll-left absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2" style="margin-left: -20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button id="scrollRight" class="scroll-right absolute top-1/2 right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-2" style="margin-right: -20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</section>

<section class="scroll-section py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Top global attractions</h2>

    <div class="relative">
      <!-- Scroll Container -->
      <div id="scrollContainer" class="scroll-container flex space-x-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
        @for ($i = 0; $i < 10; $i++) <!-- Adjust count as needed -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative min-w-[250px] max-w-[250px] h-[310px]">
          <!-- Like Button -->
          <button 
            style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;" 
            onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';">
            🤍
          </button>

          <!-- Hotel Image -->
          <img src="{{ asset('images/galle.jpg') }}" alt="Hotel Image" class="w-full h-52 object-cover">

          <!-- Hotel Info -->
          <div class="p-3">
            
            <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">Galle Dutch Fort</h3>

            
            <div class="flex items-center mt-2">
              <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Noto Sans', sans-serif;">9.7</span>
              <div style="font-family: 'Noto Sans', sans-serif;">
           <!-- Star Rating -->
<div class="flex ml-2">
  <!-- Filled stars -->
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
  <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
  </svg>
</div>

                <span class="text-xs ml-2 block">337 Reviews</span>
              </div>
            </div>

          </div>
        </div>
        @endfor
      </div>

      <!-- Arrow Buttons -->
      <button id="scrollLeft" class="scroll-left absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2" style="margin-left: -20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button id="scrollRight" class="scroll-right absolute top-1/2 right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-2" style="margin-right: -20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</section>
<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Explore Sri Lanka</h2>
        <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">These popular destination have a lot of tours</p>
    </div>

    <div class="relative">
        <!-- Wrapper for scroll and arrows -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Scrollable container -->
            <div class="scroll-container flex overflow-x-auto scroll-smooth gap-4 no-scrollbar">
                @php
                    $destinations = [
                        ['name' => 'Kandy', 'image' => 'kandy.jpg', 'properties' => '1,166'],
                        ['name' => 'Colombo', 'image' => 'colombo.jpg', 'properties' => '622'],
                        ['name' => 'Nuwara Eliya', 'image' => 'colombo.jpg', 'properties' => '843'],
                        ['name' => 'Ella', 'image' => 'kandy.jpg', 'properties' => '876'],
                        ['name' => 'Galle', 'image' => 'kandy.jpg', 'properties' => '1,118'],
                        ['name' => 'Negombo', 'image' => 'colombo.jpg', 'properties' => '822'],
                        ['name' => 'Anuradhapura', 'image' => 'colombo.jpg', 'properties' => '710'],
                        ['name' => 'Trincomalee', 'image' => 'colombo.jpg', 'properties' => '588'],
                    ];
                @endphp

                @foreach ($destinations as $destination)
 <div class="min-w-[230px]">
  <!-- Container with only image -->
  <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="{{ asset('images/' . $destination['image']) }}" alt="{{ $destination['name'] }}" class="w-full h-40 object-cover">
  </div>

  <!-- Text outside the image container, below it -->
  <div class="mt-2 px-1">
    <h3 class="text-sm font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">
      {{ $destination['name'] }}
    </h3>
    <p class="text-xs text-gray-500" style="font-family: 'Noto Sans', sans-serif;">
      {{ $destination['properties'] }} Properties
    </p>
  </div>
</div>


                @endforeach
            </div>
            

            <!-- Left Arrow -->
            <button class="scroll-left hidden absolute  top-[42%]  left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-4 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Right Arrow -->
            <button class="scroll-right absolute  top-[42%] right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-4 ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Tailwind scroll styling -->
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-8">Get inspiration for your next tour</h2>
    </div>

    <div class="relative">
        <!-- Wrapper for scroll and arrows -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Scrollable container -->
            <div class="scroll-container flex overflow-x-auto scroll-smooth gap-4 no-scrollbar">
                @php
                    $destinations = [
                        ['name' => 'Beautiful Birds Park Hambantota Sri Lanka', 'image' => 'kandy.jpg', 'properties' => 'Step into a world where feathers flutter and nature sings'],
                        ['name' => 'Colombo', 'image' => 'colombo.jpg', 'properties' => '622'],
                        ['name' => 'Nuwara Eliya', 'image' => 'colombo.jpg', 'properties' => '843'],
                        ['name' => 'Ella', 'image' => 'kandy.jpg', 'properties' => '876'],
                        ['name' => 'Yala National Park Tour and Safari Tour Sri Lanka', 'image' => 'kandy.jpg', 'properties' => 'Step into a world where feathers flutter and nature sings'],
                    ];
                @endphp

                {{-- First Card --}}
                <div class="min-w-[300px]">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/top2.jpg') }}"  alt="{{ $destinations[0]['name'] }}" class="w-full h-56 object-cover">
                    </div>
                    <div class="mt-2 px-2">
                        <h3 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">{{ $destinations[0]['name'] }}</h3>
                        <p class="text-sm text-gray-500" style="font-family: 'Noto Sans', sans-serif;">{{ $destinations[0]['properties'] }}</p>
                    </div>
                </div>

                {{-- Middle Card --}}
                <div class="min-w-[570px] bg-white rounded-lg shadow-md overflow-hidden relative">
                    <img src="{{ asset('images/3e.jpg') }}" alt="Middle Destination" class="w-full h-70 object-cover">
                    <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-40 text-white p-4">
                        <h3 class="text-base font-semibold" style="font-family: 'Noto Sans', sans-serif;">Whale Watching Galle with Pickup & Drop</h3>
                        <p class="text-sm" style="font-family: 'Noto Sans', sans-serif;">Safe, patient driver. Safari guide knowledgeable and helpful. Safe, patient driver. Safari guide knowledgeable and helpful.</p>
                    </div>
                </div>

                {{-- Last Card --}}
                <div class="min-w-[300px]">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/top.jpg') }}" alt="{{ $destinations[4]['name'] }}" class="w-full h-56 object-cover">
                    </div>
                    <div class="mt-2 px-2">
                        <h3 class="text-base font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">{{ $destinations[4]['name'] }}</h3>
                        <p class="text-sm text-gray-500"style="font-family: 'Noto Sans', sans-serif;">{{ $destinations[4]['properties'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <p class="text-gray-700 text-left text-sm leading-relaxed">
      Countries . Regions . Cities . Districts . Airports . Hotels . Places of interest . Holiday Homes . Apartments . Resorts . Villas . Hostels . B&Bs . Guest Houses . Unique places to stay . All destinations . All flight destinations . All car hire locations . All holiday destinations . Guides . Discover . Reviews . Discover monthly stays
    </p>
  </div>
</section>



<!-- Scroll Script -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const scrollContainer = document.getElementById('scrollContainer');
    const scrollLeftBtn = document.getElementById('scrollLeft');
    const scrollRightBtn = document.getElementById('scrollRight');

    const scrollAmount = 270; // Scroll by 270px (about 1 card)

    if (scrollLeftBtn && scrollRightBtn && scrollContainer) {
      scrollLeftBtn.addEventListener('click', () => {
        scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      });

      scrollRightBtn.addEventListener('click', () => {
        scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      });
    }
  });
</script>

<!-- Optional: Hide scrollbar CSS -->
<style>
  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>

@endsection