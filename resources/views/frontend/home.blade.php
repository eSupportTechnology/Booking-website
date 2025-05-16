@extends('frontend.master')
<style>


    .tab-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: 2px solid transparent;
        background-color: white; /* gray-200 */
        color: #4B5563; /* gray-600 */
        transition: all 0.2s;
    }

    .active-tab {
        background-color: white; /* blue-500 */
        color: rgb(31, 143, 178);;
        border-color: rgb(31, 143, 178);;
    }

</style>
@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="container mx-auto px-4 md:px-8">
        <!-- Hero Text -->
        <div class="text-left mb-10 mt-2">
            <h1 class="text-4xl md:text-3xl font-bold mb-2" style="font-size:50px;">Find your next stay</h1>
            <p class="text-base md:text-lg" style="font-family: 'Noto Sans', sans-serif;font-size:20px;margin-top:20px;">
                Search low prices on hotels, homes and much more...
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
    <div x-data="{ open: false, destination: '' }" class="relative px-2 py-1 flex-1 border-r md:border-r border-gray-300">
        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
           <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-6 h-6" style="filter: brightness(0) saturate(100%);" />

                <path d="M10 2a6 6 0 00-6 6c0 4.25 6 10 6 10s6-5.75 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
            </svg>
            <span x-text="destination || 'Where are you going?'" class="text-gray-800 truncate"></span>
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
<div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }" class="relative flex-1 border-t md:border-t-0 md:border-r border-gray-300 px-2 py-1">
  
  <!-- Dropdown Trigger Button -->
  <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
    <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
    <span class="text-gray-800 truncate">
      <template x-if="activeTab === 'check'">
        <span><span x-text="checkIn ? checkIn : 'Check-in'"></span> — <span x-text="checkOut ? checkOut : 'Check-out'"></span></span>
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
            <span x-text="`${adults} adults · ${children} children · ${rooms} room${rooms > 1 ? 's' : ''}`" class="text-gray-800 truncate"></span>
        </button>

        <!-- Guest Dropdown -->
        <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-4 text-sm">
            <!-- Adults -->
            <div class="flex items-center justify-between">
                <span>Adults</span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="if(adults > 1) adults--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                    <span x-text="adults"></span>
                    <button type="button" @click="adults++" class="px-2 py-1 bg-gray-200 rounded">+</button>
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




<!-- Offers Section -->
<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Title -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6" style="font-family: 'Lato', sans-serif;">Offers</h2>

    <!-- Offer Card -->
    <div class="bg-white-50 p-2 rounded flex items-center justify-between border border-solid border-gray-300">
      <!-- Text Content -->
      <div class="ml-4">
  <p class="font-medium font-semibold" style="font-family: 'Lato', sans-serif;">Quick escape, quality time</p>
  <p class="text-sm text-gray-600" style="font-family: 'Lato', sans-serif;">Save up to 20% with a Gateway Deal!</p>
  <button class="bg-cyan-600 text-white px-4 py-1 rounded mt-2 w-auto" style="font-family: 'Lato', sans-serif;">Save on stays</button>
</div>


      

      <!-- Image -->
      <img src="{{ asset('images/offers.png') }}" alt="Offer Image" class="w-32 h-32 rounded ml-4">
    </div>
  </div>
</section>
<!--End Offers Section-->

<!-- Trending Destinations Section -->
<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Title -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6" style="font-family: 'Lato', sans-serif;">Trending destinations</h2>

    <!-- First Row: 2 Columns -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
     
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/colombo.jpg') }}" alt="Colombo" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white">
          <h3 class="text-lg font-semibold">Colombo</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>

     
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/nuwara.jpg') }}" alt="Nuwara Eliya" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white ">
          <h3 class="text-lg font-semibold">Nuwara Eliya</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>
    </div>

    <!-- Second Row: 3 Columns -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
  
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/sigiriya.jpg') }}" alt="Sigiriya" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white ">
          <h3 class="text-lg font-semibold">Sigiriya</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>

   
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/ella.png') }}" alt="Ella" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white ">
          <h3 class="text-lg font-semibold">Ella</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>

    
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/dambulla.jpg') }}" alt="Dambulla" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white ">
          <h3 class="text-lg font-semibold">Dambulla</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Trending Destination Section-->

<!-- Browse by Property Type Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6" style="font-family: 'Lato', sans-serif;">Browse by property type</h2>
        <div class="flex space-x-4 overflow-x-auto pb-2">
            <!-- Resorts -->
            <div class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/resorts.jpg') }}" alt="Resorts" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Resorts</h3>
                </div>
            </div>

            <!-- Apartments -->
            <div class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/apartments.jpg') }}" alt="Apartments" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Apartments</h3>
                </div>
            </div>

            <!-- Hotels -->
            <div class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/hotels.jpg') }}" alt="Apartments" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Hotels</h3>
                </div>
            </div>

            <!-- Villas -->
            <div class="min-w-[250px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/villas.jpg') }}" alt="Villas" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h6 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Villas</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Section-->


<!-- Browse by Popular Destinations Section-->
<section class="py-12 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Browse by property type</h2>
        <p class="mb-4 text-gray-600" style="font-family: 'Lato', sans-serif;">These popular destinations have a lot to offer</p>
        
        <!-- Arrow buttons -->
        <button id="scrollLeft" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-white p-2 shadow rounded-full hidden sm:block">
            &#8592;
        </button>
        <button id="scrollRight" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-white p-2 shadow rounded-full hidden sm:block">
            &#8594;
        </button>

        <!-- Scrollable container -->
        <div id="scrollContainer" class="flex space-x-4 overflow-x-hidden pb-2 transition-all duration-300">
            <!-- Example card: Kandy -->
            <div class="min-w-[220px] shrink-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/kandy.jpg') }}" alt="Kandy" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800">Kandy</h3>
                    <p class="text-gray-600">1,102 properties</p>
                </div>
            </div>
             <div class="min-w-[220px] shrink-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/kandy.jpg') }}" alt="Kandy" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800">Kandy</h3>
                    <p class="text-gray-600">1,102 properties</p>
                </div>
            </div> <div class="min-w-[220px] shrink-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/kandy.jpg') }}" alt="Kandy" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800">Kandy</h3>
                    <p class="text-gray-600">1,102 properties</p>
                </div>
            </div> <div class="min-w-[220px] shrink-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/kandy.jpg') }}" alt="Kandy" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800">Kandy</h3>
                    <p class="text-gray-600">1,102 properties</p>
                </div>
            </div> <div class="min-w-[220px] shrink-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/kandy.jpg') }}" alt="Kandy" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800">Kandy</h3>
                    <p class="text-gray-600">1,102 properties</p>
                </div>
            </div> <div class="min-w-[220px] shrink-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/kandy.jpg') }}" alt="Kandy" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800">Kandy</h3>
                    <p class="text-gray-600">1,102 properties</p>
                </div>
            </div>
            <!-- Repeat other cities (Colombo, Nuwara Eliya, etc.) here... -->
            <!-- Just like your original HTML content -->
            <!-- Make sure all cards have class: `min-w-[220px] shrink-0` -->
        </div>
    </div>

    <!-- JavaScript for scrolling -->
   <!-- <script>
        const container = document.getElementById('scrollContainer');
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');

        scrollLeftBtn.addEventListener('click', () => {
            container.scrollBy({ left: -250, behavior: 'smooth' });
        });

        scrollRightBtn.addEventListener('click', () => {
            container.scrollBy({ left: 250, behavior: 'smooth' });
        });
    </script>-->
</section>

<!--End Popular Destination Section-->




<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">
                Browse by property type
            </h2>
            <p class="text-sm text-gray-600" style="font-family: 'Lato', sans-serif;">
                Pick a vibe and explore top destinations in Sri Lanka
            </p>
        </div>

        <!-- Tab Buttons -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button id="ptype-tab-beach"
                class="rounded-full ptype-tab-button active-ptype-tab flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700"
                onclick="togglePtypeTab('beach')">
                <img src="{{ asset('images/beach.png') }}" alt="Beach" class="w-6 h-6" />
                <span>Beach</span>
            </button>

            <button id="ptype-tab-outdoors"
                class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('outdoors')">
                <img src="{{ asset('images/outsides.png') }}" alt="Outdoors" class="w-6 h-6" />
                <span>Outdoors</span>
            </button>

            <button id="ptype-tab-relax"
                class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('relax')">
                <img src="{{ asset('images/relax.png') }}" alt="Relax" class="w-6 h-6" />
                <span>Relax</span>
            </button>

            <button id="ptype-tab-romance"
                class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('romance')">
                <img src="{{ asset('images/romance.png') }}" alt="Romance" class="w-6 h-6" />
                <span>Romance</span>
            </button>

            <button id="ptype-tab-food"
                class="rounded-full ptype-tab-button flex items-center gap-2 px-4 py-2"
                onclick="togglePtypeTab('food')">
                <img src="{{ asset('images/food.png') }}" alt="Food" class="w-6 h-6" />
                <span>Food</span>
            </button>
        </div>

        <!-- Tab Contents -->
        <div id="ptype-tab-content">
            <!-- Beach Tab -->
            <div id="ptype-content-beach" class="relative px-2 py-6">
                <!-- Left Arrow -->
              <!-- Left Arrow Button -->
    <button id="scrollLeftBeach"
        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow-md rounded-full p-2 hover:bg-gray-100 transition hidden lg:flex items-center justify-center w-10 h-10">
        &#8592;
    </button>

    <!-- Scrollable Content -->
    <div id="scrollBeach"
        class="flex overflow-x-auto scroll-smooth gap-4 px-12 pb-2 no-scrollbar">
        @foreach ([
            ['name' => 'Kandy', 'properties' => 1102],
            ['name' => 'Colombo', 'properties' => 520],
            ['name' => 'Nuwara Eliya', 'properties' => 900],
            ['name' => 'Ella', 'properties' => 841],
            ['name' => 'Galle', 'properties' => 1200],
        ] as $city)
            <div class="min-w-[220px] flex-shrink-0">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/ella.png') }}"
                         alt="{{ $city['name'] }}"
                         class="w-full h-48 object-cover" style="width:220px;">
                </div>
                <div class="mt-2">
                    <h3 class="text-xl font-bold text-gray-800">{{ $city['name'] }}</h3>
                    <p class="text-gray-600">{{ number_format($city['properties']) }} properties</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Right Arrow Button -->
    <button id="scrollRightBeach"
        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow-md rounded-full p-2 hover:bg-gray-100 transition hidden lg:flex items-center justify-center w-10 h-10">
        &#8594;
    </button>
</div>

            <!-- Other Tabs -->
            <div id="ptype-content-outdoors" class="hidden px-2 py-6">Outdoors content here...</div>
            <div id="ptype-content-relax" class="hidden px-2 py-6">Relax content here...</div>
            <div id="ptype-content-romance" class="hidden px-2 py-6">Romance content here...</div>
            <div id="ptype-content-food" class="hidden px-2 py-6">Food content here...</div>
        </div>
    </div>

    <!-- Tailwind utility to hide scrollbar -->
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <!-- JavaScript Scroll + Tab Switching -->
    <!--<script>
        // Scroll buttons
        const scrollContainer = document.getElementById('scrollBeach');
        const scrollLeftBtn = document.getElementById('scrollLeftBeach');
        const scrollRightBtn = document.getElementById('scrollRightBeach');

        scrollRightBtn.addEventListener('click', () => {
            scrollContainer.scrollBy({ left: 300, behavior: 'smooth' });
        });

        scrollLeftBtn.addEventListener('click', () => {
            scrollContainer.scrollBy({ left: -300, behavior: 'smooth' });
        });

        // Tabs
        function togglePtypeTab(tabName) {
            const tabButtons = document.querySelectorAll('.ptype-tab-button');
            const tabContents = document.querySelectorAll('#ptype-tab-content > div');

            tabButtons.forEach(btn => {
                btn.classList.remove('bg-blue-100', 'text-blue-700', 'active-ptype-tab');
            });

            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            document.getElementById(`ptype-tab-${tabName}`).classList.add('bg-blue-100', 'text-blue-700', 'active-ptype-tab');
            document.getElementById(`ptype-content-${tabName}`).classList.remove('hidden');
        }

        // Activate default tab
        document.addEventListener('DOMContentLoaded', () => {
            togglePtypeTab('beach');
        });
    </script>-->
</section>


<!--  Deals for the weekend Section -->
<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Browse by property type</h2>
    <p class="text-gray-600 mb-6" style="font-family: 'Lato', sans-serif;">Save on stays for May 2 - May 4</p>

   
    <div class="flex gap-4 overflow-x-auto lg:grid lg:grid-cols-4 lg:gap-6">
      
      <!-- Hotel Card 1 -->
      <div class="min-w-[250px] max-w-[250px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover" >
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class=" text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178);">8</span>
      <div style="font-family: 'Lato', sans-serif;">
  <span class="text-xs ml-2 block">Very Good</span>
  <span class="text-xs ml-2 block">337 Reviews</span>
</div>


    </div>
    <button class="text-xs text-white px-2 py-1 rounded mt-2" style="background-color:#FF5206;font-family: 'Lato', sans-serif;">Getaway Deal</button>
    <p class="text-gray-600 mt-2;font-family: 'Lato', sans-serif;">2 nights  <span class="text-sm text-gray-500 line-through" style="font-family: 'Lato', sans-serif;color:#FF0004;">LKR 72,000</span> <span style="color:black;font-weight:bold;"> LKR 26,844</span></p>
  </div>
</div>



      <!-- Hotel Card 2 -->
      <div class="min-w-[250px] max-w-[250px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class=" text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178);">8</span>
      <div style="font-family: 'Lato', sans-serif;">
  <span class="text-xs ml-2 block">Very Good</span>
  <span class="text-xs ml-2 block">337 Reviews</span>
</div>


    </div>
    <button class="text-xs text-white px-2 py-1 rounded mt-2" style="background-color:#FF5206;font-family: 'Lato', sans-serif;">Getaway Deal</button>
    <p class="text-gray-600 mt-2;font-family: 'Lato', sans-serif;">2 nights  <span class="text-sm text-gray-500 line-through" style="font-family: 'Lato', sans-serif;color:#FF0004;">LKR 72,000</span> <span style="color:black;font-weight:bold;"> LKR 26,844</span></p>
  </div>
</div>

      <!-- Hotel Card 3 -->
      <div class="min-w-[250px] max-w-[250px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178);">8</span>
      <div style="font-family: 'Lato', sans-serif;">
  <span class="text-xs ml-2 block">Very Good</span>
  <span class="text-xs ml-2 block">337 Reviews</span>
</div>


    </div>
    <button class="text-xs text-white px-2 py-1 rounded mt-2" style="background-color:#FF5206;font-family: 'Lato', sans-serif;">Getaway Deal</button>
    <p class="text-gray-600 mt-2;font-family: 'Lato', sans-serif;">2 nights  <span class="text-sm text-gray-500 line-through" style="font-family: 'Lato', sans-serif;color:#FF0004;">LKR 72,000</span> <span style="color:black;font-weight:bold;"> LKR 26,844</span></p>
  </div>
</div>

      <!-- Hotel Card 4 -->
      <div class="min-w-[250px] max-w-[250px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class=" text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178);">8</span>
      <div style="font-family: 'Lato', sans-serif;">
  <span class="text-xs ml-2 block">Very Good</span>
  <span class="text-xs ml-2 block">337 Reviews</span>
</div>


    </div>
    <button class="text-xs text-white px-2 py-1 rounded mt-2" style="background-color:#FF5206;font-family: 'Lato', sans-serif;">Getaway Deal</button>
    <p class="text-gray-600 mt-2;font-family: 'Lato', sans-serif;">2 nights  <span class="text-sm text-gray-500 line-through" style="font-family: 'Lato', sans-serif;color:#FF0004;">LKR 72,000</span> <span style="color:black;font-weight:bold;"> LKR 26,844</span></p>
  </div>
</div>

    </div>
  </div>
</section>
<!--End Section-->

 <!-- Section 2: Stay at our top unique properties -->
 <section class="py-12 bg-white">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Stay at our top unique properties</h2>
    <p class="text-gray-600 mb-4">From castles and villas to boats and igloos, we have it all</p>

    <div class="flex space-x-4 overflow-x-auto pb-2">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
  <button 
    style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;"
    onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';"
  >
    🤍
  </button>
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">8</span>
      <div style="font-family: 'Lato', sans-serif;">
        <span class="text-xs ml-2 block">Very Good</span>
        <span class="text-xs ml-2 block">337 Reviews</span>
      </div>
    </div>
  </div>
</div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
  <button 
    style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;"
    onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';"
  >
    🤍
  </button>
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">8</span>
      <div style="font-family: 'Lato', sans-serif;">
        <span class="text-xs ml-2 block">Very Good</span>
        <span class="text-xs ml-2 block">337 Reviews</span>
      </div>
    </div>
  </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden relative">
  <button 
    style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;"
    onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';"
  >
    🤍
  </button>
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">8</span>
      <div style="font-family: 'Lato', sans-serif;">
        <span class="text-xs ml-2 block">Very Good</span>
        <span class="text-xs ml-2 block">337 Reviews</span>
      </div>
    </div>
  </div>
</div>




        <!-- Card 4 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
  <button 
    style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;"
    onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';"
  >
    🤍
  </button>
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2" style="font-family: 'Lato', sans-serif;">Eagle Regency Hotel</h3>
    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">8</span>
      <div style="font-family: 'Lato', sans-serif;">
        <span class="text-xs ml-2 block">Very Good</span>
        <span class="text-xs ml-2 block">337 Reviews</span>
      </div>
    </div>
  </div>
</div>

</div>
</section>

<!--End Section-->

<!--Travel More Section-->
<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  
    <h2 class="text-2xl font-semibold text-gray-800 mb-6" style="font-family: 'Lato', sans-serif;">Travel More, Spend Less</h2>

    <!-- Offer Card -->
    <div class="bg-white-50 p-3 rounded flex items-center justify-between border border-solid border-gray-300">
  
      <div class="ml-4">
  <p class="font-medium font-semibold" style="font-family: 'Lato', sans-serif;">Sign in, save money</p>
  <p class="text-sm text-gray-600" style="font-family: 'Lato', sans-serif;">Save 10% of more at particpating properties</p>
  <button class="bg-cyan-600 text-white px-4 py-1 rounded mt-2 w-auto text-s" style="font-family: 'Lato', sans-serif;">Sign in</button>
  <button class=" px-4 py-1 rounded mt-2 w-auto" style="font-family: 'Lato', sans-serif;background-color:white;color: rgb(31, 143, 178);">Register</button>
</div>
</div>
  </div>
</section>
<!-- End Section-->


<!--Popular with Travellers-->
<section class="py-12 bg-white" style="margin-bottom:60px;">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6" style="font-family: 'Lato', sans-serif;">Popular with travelers from Sri Lanka</h2>

        <!-- Tabs -->
        <div class="flex space-x-4 overflow-x-auto mb-4">
            <button id="tab-domestic" class="rounded-full tab-button active-tab" onclick="toggleTab('domestic')">Domestic cities</button>
            <button id="tab-international" class="rounded-full tab-button" onclick="toggleTab('international')">International cities</button>
            <button id="tab-regions" class="rounded-full tab-button" onclick="toggleTab('regions')">Regions</button>
            <button id="tab-countries" class="rounded-full tab-button" onclick="toggleTab('countries')">Countries</button>
            <button id="tab-places" class="rounded-full tab-button" onclick="toggleTab('places')">Places to stay</button>
        </div>

        <!-- Content Panels -->
        <div id="tab-content" class="mt-4">
            <!-- Domestic -->
     
            <div  id="content-domestic" class="grid grid-cols-5 gap-y-2 w-full text-sm" style="font-family: 'Lato', sans-serif;">
      <span>Kandy hotels</span>
      <span>Nuwara Eliya hotels</span>
      <span>Colombo hotels</span>
      <span>Ella hotels</span>
      <span>Anuradhapura hotels</span>

      <span>Kandy hotels</span>
      <span>Nuwara Eliya hotels</span>
      <span>Colombo hotels</span>
      <span>Ella hotels</span>
      <span>Anuradhapura hotels</span>

      <span>Kandy hotels</span>
      <span>Nuwara Eliya hotels</span>
      <span>Colombo hotels</span>
      <span>Ella hotels</span>
      <span>Anuradhapura hotels</span>

      <span>Kandy hotels</span>
      <span>Nuwara Eliya hotels</span>
      <span>Colombo hotels</span>
      <span>Ella hotels</span>
      <span>Anuradhapura hotels</span>

      <!-- Show more button aligned to the left -->
<div class="col-span-full w-full text-left mt-2" style="margin-bottom:60px;">
  <button class="text-blue-600" style="color:rgb(31, 143, 178);">+ Show more</button>
</div>

    </div>
           

            <!-- International -->
            <div id="content-international" class="grid grid-cols-5 gap-4 hidden">
             
            </div>

            <!-- Regions -->
            <div id="content-regions" class="grid grid-cols-5 gap-4 hidden">
               
               
            </div>

            <!-- Countries -->
            <div id="content-countries" class="grid grid-cols-5 gap-4 hidden">
               
                
               
               
            </div>
            <div id="content-international" class="grid grid-cols-5 gap-4 hidden">
              
            </div>

        </div>
    </div>
</div>



<!-- JavaScript for Tab Switching -->
<!--<script>
    function toggleTab(tabName) {
        // Hide all panels
        const panels = document.querySelectorAll('#tab-content > div');
        panels.forEach(panel => panel.classList.add('hidden'));

        // Show selected panel
        const selectedPanel = document.getElementById(`content-${tabName}`);
        if (selectedPanel) selectedPanel.classList.remove('hidden');

        // Update tab button styles
        const tabs = document.querySelectorAll('.tab-button');
        tabs.forEach(tab => tab.classList.remove('active-tab'));

        const selectedTab = document.getElementById(`tab-${tabName}`);
        if (selectedTab) selectedTab.classList.add('active-tab');
    }
</script>-->
</section>




<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Scroll: Beach
        const scrollBeachContainer = document.getElementById('scrollBeach');
        const scrollLeftBeachBtn = document.getElementById('scrollLeftBeach');
        const scrollRightBeachBtn = document.getElementById('scrollRightBeach');

        if (scrollLeftBeachBtn && scrollRightBeachBtn && scrollBeachContainer) {
            scrollRightBeachBtn.addEventListener('click', () => {
                scrollBeachContainer.scrollBy({ left: 300, behavior: 'smooth' });
            });

            scrollLeftBeachBtn.addEventListener('click', () => {
                scrollBeachContainer.scrollBy({ left: -300, behavior: 'smooth' });
            });
        }

        // Scroll: General Container
        const scrollContainer = document.getElementById('scrollContainer');
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');

        if (scrollLeftBtn && scrollRightBtn && scrollContainer) {
            scrollLeftBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: -250, behavior: 'smooth' });
            });

            scrollRightBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: 250, behavior: 'smooth' });
            });
        }

        // Tabs: Property Type
        function togglePtypeTab(tabName) {
            const tabButtons = document.querySelectorAll('.ptype-tab-button');
            const tabContents = document.querySelectorAll('#ptype-tab-content > div');

            tabButtons.forEach(btn => {
                btn.classList.remove('bg-blue-100', 'text-blue-700', 'active-ptype-tab');
            });

            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            document.getElementById(`ptype-tab-${tabName}`).classList.add('bg-blue-100', 'text-blue-700', 'active-ptype-tab');
            document.getElementById(`ptype-content-${tabName}`).classList.remove('hidden');
        }

        // Activate default tab
        togglePtypeTab('beach');

        // Tabs: General Tabs
        window.toggleTab = function (tabName) {
            const panels = document.querySelectorAll('#tab-content > div');
            panels.forEach(panel => panel.classList.add('hidden'));

            const selectedPanel = document.getElementById(`content-${tabName}`);
            if (selectedPanel) selectedPanel.classList.remove('hidden');

            const tabs = document.querySelectorAll('.tab-button');
            tabs.forEach(tab => tab.classList.remove('active-tab'));

            const selectedTab = document.getElementById(`tab-${tabName}`);
            if (selectedTab) selectedTab.classList.add('active-tab');
        };

        // Make togglePtypeTab globally available too (if used inline)
        window.togglePtypeTab = togglePtypeTab;
    });
</script>

@endsection
