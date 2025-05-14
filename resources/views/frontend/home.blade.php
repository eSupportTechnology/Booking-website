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
<div class="relative bg-cover bg-center" style="background-image: url('{{ asset('images/home.jpg') }}'); height: 700px;">
  <div class="absolute inset-0" style="background-color: rgba(0, 72, 105, 0.43);"></div>

  <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">

    <!-- Heading Section -->
    <h1 class="text-3xl md:text-4xl font-bold leading-snug" style="font-family: 'Lato', sans-serif; font-size:82px; margin-top:-130px;">
      Find Your Perfect Stay <br>
      <div class="mt-8 text-white">
        <img src="{{ asset('images/1.png') }}" alt="Image" class="inline-block mr-2" style="height:75px;width:75px;">Quick 
        & 
        <img src="{{ asset('images/2.png') }}" alt="Image" class="inline-block ml-2" style="height:75px;width:75px;"> Easy!
      </div>
    </h1>

   <!-- Search Box Section -->

<div class="mt-20 grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded text-black shadow-lg w-9/12 md:w-4/5 mx-auto">

  <!-- Location Button -->
  <div class="flex">
    <button class="flex items-center gap-2 p-2 rounded-md w-full" style="font-family: 'Lato', sans-serif; background-color: #D6ECFF;">
      <img src="{{ asset('images/car.png') }}" alt="Search" class="h-7 w-7">
      <span>Where are you going?</span>
    </button>
  </div>

  <!-- Date Button -->
  <div class="flex">
    <button class="flex items-center gap-2 p-2 rounded-md w-full" style="font-family: 'Lato', sans-serif; background-color: #D6ECFF;">
      <img src="{{ asset('images/calender.png') }}" alt="Search" class="h-6 w-6">
      <span>Check-in date – Check-out date</span>
    </button>
  </div>

  <!-- Guest Button -->
  <div class="flex">
    <button class="flex items-center gap-2 p-2 rounded-md w-full" style="font-family: 'Lato', sans-serif; background-color: #D6ECFF;">
      <img src="{{ asset('images/user.png') }}" alt="Search" class="h-6 w-6">
      <span>2 Adults · 0 Children · 1 Room</span>
    </button>
  </div>

  <!-- Search Button -->
  <div class="flex justify-end items-center">
    <button class="bg-cyan-600 text-white px-6 py-2 rounded" style="width:60%;">
      Search
    </button>
  </div>

</div>


</div>



  </div>

</div>
</div>
</div>
<!--End Hero Section-->



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
        <div class="absolute bottom-0 left-0 w-full p-4 text-white bg-gradient-to-b from-black/60 to-transparent">
          <h3 class="text-base font-semibold">Colombo</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>

     
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/nuwara.jpg') }}" alt="Nuwara Eliya" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white bg-gradient-to-b from-black/60 to-transparent">
          <h3 class="text-base font-semibold">Nuwara Eliya</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>
    </div>

    <!-- Second Row: 3 Columns -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
  
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/sigiriya.jpg') }}" alt="Sigiriya" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white bg-gradient-to-b from-black/60 to-transparent">
          <h3 class="text-base font-semibold">Sigiriya</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>

   
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/ella.png') }}" alt="Ella" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white bg-gradient-to-t from-black/60 to-transparent">
          <h3 class="text-base font-semibold">Ella</h3>
          <p class="text-sm">Sri Lanka</p>
        </div>
      </div>

    
      <div class="relative rounded-[10px] overflow-hidden">
        <img src="{{ asset('images/dambulla.jpg') }}" alt="Dambulla" class="w-full h-64 object-cover" style="border-radius: 10px;">
        <div class="absolute bottom-0 left-0 w-full p-4 text-white bg-gradient-to-t from-black/60 to-transparent">
          <h3 class="text-base font-semibold">Dambulla</h3>
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
    <div class="container mx-auto px-4 py-8">

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
                <button id="scrollLeftBeach"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-md rounded-full p-2 hidden lg:block">
                    &#8592;
                </button>

                <!-- Scrollable Content -->
                <div id="scrollBeach"
                    class="flex overflow-x-auto scroll-smooth gap-4 pb-2 no-scrollbar">
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
                                    class="w-full h-48 object-cover">
                            </div>
                            <div class="mt-2">
                                <h3 class="text-xl font-bold text-gray-800">{{ $city['name'] }}</h3>
                                <p class="text-gray-600">{{ number_format($city['properties']) }} properties</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right Arrow -->
                <button id="scrollRightBeach"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 z-10 bg-white shadow-md rounded-full p-2 hidden lg:block">
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
