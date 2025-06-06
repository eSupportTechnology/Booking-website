@extends('frontend.user-master')

@section('content')
<!--Hero Section-->
<section class="text-white py-8 bg-[#1F8FB2] relative z-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Text -->
    <div class="mb-10 mt-1">
      <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-2">
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

<form method="GET" class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-1 md:gap-0 border-4 border-yellow-400 max-w-6xl mx-auto overflow-visible text-sm">

    <!-- Destination Selector (Styled Like Guests) -->
    <div x-data="{ open: false, destination: '' }" class="relative px-2 py-1 flex-1 border-r md:border-r border-gray-500">
        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
           <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-6 h-6" style="filter: brightness(0) saturate(100%);" />

                <path d="M10 2a6 6 0 00-6 6c0 4.25 6 10 6 10s6-5.75 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
            <span x-text="destination || 'Where are you going?'" style="font-family: 'Noto Sans', sans-serif;" class="text-gray-800 truncate text-base"></span>
        </button>

        <!-- Dropdown Box -->
        <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
            <template x-for="city in ['New York', 'Los Angeles', 'London', 'Paris', 'Tokyo']" :key="city">
                <button type="button" @click="destination = city; open = false" class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                    <span x-text="city"></span>
                </button>
            </template>
        </div>

        <!-- Hidden field to submit the selected destination -->
        <input type="hidden" name="destination" :value="destination">
    </div>

   <!-- Dates Selector -->
<!-- Include Alpine.js if not already -->
<!-- Include Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Dropdown with two sections: Check-in/out & Flexible -->
<div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }" class="relative flex-1 border-t md:border-t-0 md:border-r border-gray-500 px-2 py-1">
  
  <!-- Dropdown Trigger Button -->
  <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
    <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
    <span class="text-gray-800 truncate">
      <template x-if="activeTab === 'check'">
        <span><span x-text="checkIn ? checkIn : 'Check-in'" style="font-family: 'Noto Sans', sans-serif;" class="text-base"></span> — <span x-text="checkOut ? checkOut : 'Check-out'" style="font-family: 'Noto Sans', sans-serif;" class="text-base"></span></span>
      </template>
      <template x-if="activeTab === 'flexible'">
        <span x-text="flexibleOption ? flexibleOption : 'Flexible dates'"></span>
      </template>
    </span>
  </button>

  <!-- Dropdown Content -->
  <div
    x-show="open"
    @click.away="open = false"
    class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-96 right-0 text-gray-800 text-sm"
    x-transition
  >
    <!-- Tabs -->
    <nav class="flex border-b border-gray-200 mb-4">
      <button
        @click.prevent="activeTab = 'check'"
        :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
        class="px-4 py-2 border-b-2 font-semibold focus:outline-none"
      >
        Check-in / Check-out
      </button>
      <button
        @click.prevent="activeTab = 'flexible'"
        :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
        class="px-4 py-2 border-b-2 font-semibold focus:outline-none"
      >
        Flexible dates
      </button>
    </nav>

    <!-- Check-in / Check-out Section -->
    <div x-show="activeTab === 'check'" x-transition>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs text-gray-500 font-semibold mb-1">Check-in Date</label>
          <input
            type="date"
            x-model="checkIn"
            class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
            placeholder="Check-in"
          />
        </div>
        <div>
          <label class="block text-xs text-gray-500 font-semibold mb-1">Check-out Date</label>
          <input
            type="date"
            x-model="checkOut"
            class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
            placeholder="Check-out"
          />
        </div>
      </div>
    </div>

    <!-- Flexible Dates Section -->
    <div x-show="activeTab === 'flexible'" x-transition>
      <label class="block text-xs text-gray-500 font-semibold mb-1">Select Flexible Dates</label>
      <select
        x-model="flexibleOption"
        class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none"
      >
        <option value="" disabled>Select option</option>
        <option value="Weekend Getaway">Weekend Getaway</option>
        <option value="Next Month">Next Month</option>
        <option value="Anytime">Anytime</option>
        <option value="Custom Range">Custom Range</option>
      </select>
    </div>

    <!-- Done Button -->
    <div class="mt-4 text-right">
      <button
        @click="open = false"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm"
      >
        Done
      </button>
    </div>
  </div>
</div>




    <!-- Guests Selector -->
    <div x-data="{ open: false, adults: 2, children: 0, rooms: 1, pets: false }" class="relative px-2 py-1 flex-1 border-t md:border-t-0 md:border-r border-gray-500">
        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/user.svg') }}" alt="Calendar" class="w-5 h-5" />
            <span x-text="`${adults} adults · ${children} children · ${rooms} room${rooms > 1 ? 's' : ''}`" class="text-gray-800 text-base truncate" style="font-family: 'Noto Sans', sans-serif;"></span>
        </button>

        <!-- Guest Dropdown -->
        <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-4 text-sm">
            <!-- Adults -->
            <div class="flex items-center justify-between">
                <span style="font-family: 'Noto Sans', sans-serif;">Adults</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(adults > 1) adults--" class="px-2 py-1 bg-gray-200 rounded" style="font-family: 'Noto Sans', sans-serif;">−</button>
                    <span x-text="adults"></span>
                    <button type="button" @click="adults++" class="px-2 py-1 bg-gray-200 rounded" style="font-family: 'Noto Sans', sans-serif;">+</button>
                </div>
            </div>

            <!-- Children -->
            <div class="flex items-center justify-between">
                <span>Children</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(children > 0) children--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                    <span x-text="children"></span>
                    <button type="button" @click="children++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                </div>
            </div>

            <!-- Rooms -->
            <div class="flex items-center justify-between">
                <span>Rooms</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(rooms > 1) rooms--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                    <span x-text="rooms"></span>
                    <button type="button" @click="rooms++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                </div>
            </div>

            <!-- Pets Toggle -->
            <div class="flex items-center justify-between">
                <span>Travelling with pets?</span>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" x-model="pets" class="sr-only peer">
                    <div class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                    </div>
                </label>
            </div>

            <p class="text-xs text-gray-500">
                Assistance animals aren’t considered pets.<br>
                <a href="#" class="text-blue-600 underline">Read more about travelling with assistance animals</a>
            </p>

            <!-- Done Button -->
            <button type="button" @click="open = false" class="block w-full text-center bg-white border border-blue-600 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50">
                Done
            </button>
        </div>
    </div>

    <!-- Search Button -->
    <div class="px-2 py-1">
        <button type="submit" class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm" style="background-color:#3CC0E9;">
            Search
        </button>
    </div>
</form>


</div>



<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<section class="scroll-section py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
   <h2 class="text-2xl font-semibold text-gray-800 mb-4">Homes guests love</h2>
   

    <div class="relative">
      <div class="scroll-container flex space-x-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
        @for ($i = 0; $i < 5; $i++)
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative min-w-[250px]">
          <button style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;" onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';">🤍</button>
          <img src="{{ asset('images/AAAA.jpg') }}" alt="Hotel Image" class="w-full h-64 object-cover">
          <div class="p-4">
            <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
            <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">Eagle Regency Hotel</h3>
            <p class="text-xs text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Kandy, Sri Lanka</p>
            <div class="flex items-center mt-2">
              <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Noto Sans', sans-serif;">8</span>
              <div style="font-family: 'Noto Sans', sans-serif;">
                <span class="text-xs ml-2 block">Very Good</span>
                <span class="text-xs ml-2 block">337 Reviews</span>
              </div>
            </div>
              <div class="mt-1 text-right" style="font-family: 'Noto Sans', sans-serif;">
              <span class="text-xs text-gray-700 font-semibold">Starting from</span>
              <span class="text-sm text-black font-bold"> LKR 82,896</span>
            </div>
          </div>
        </div>
        @endfor
      </div>

      <!-- Arrows -->
      <button class="scroll-left hidden absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-2"style="margin-left:-20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>
      <button class="scroll-right absolute top-1/2 right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-2" style="margin-right:-20px;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
</section>


@endsection