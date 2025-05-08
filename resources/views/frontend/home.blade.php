@extends('frontend.master')

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


<!-- Offers Section-->
<section class="p-6 max-w-6xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Offers</h2>
    <div class="bg-blue-50 p-4 rounded flex items-center justify-between">
        <div>
            <p class="font-medium">Quick escape, quality time</p>
            <p class="text-sm text-gray-600">Save up to 20% with a Gateway Deal!</p>
        </div>
        <button class="bg-cyan-600 text-white px-4 py-2 rounded">Save on stays</button>
    </div>
</section>


<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6" style="font-family: 'Lato', sans-serif;">Trending destinations</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

            <!-- Large Destination Card -->
            <div class="sm:col-span-2 row-span-2 relative rounded-[10px] overflow-hidden">
                <img src="{{ asset('images/nuwara.jpg') }}" alt="Nuwara Eliya" class="w-full h-48 object-cover"  style="border-radius: 10px;">
                <div class="absolute top-0 left-0 w-full p-4 text-white bg-gradient-to-b from-black/60 to-transparent">
                    <h3 class="text-lg font-semibold">Nuwara Eliya</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>

            <!-- Other Destination Cards -->
            <div class="relative rounded-[10px] overflow-hidden">
                <img src="{{ asset('images/colombo.jpg') }}" alt="Colombo" class="w-full h-full object-cover"  style="border-radius: 10px;">
                <div class="absolute top-0 left-0 w-full p-4 text-white bg-gradient-to-b from-black/60 to-transparent">
                    <h3 class="text-base font-semibold">Colombo</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>

            <div class="relative rounded-[10px] overflow-hidden">
                <img src="{{ asset('images/sigiriya.jpg') }}" alt="Sigiriya" class="w-full h-full object-cover"  style="border-radius: 10px;">
                <div class="absolute top-0 left-0 w-full p-4 text-white bg-gradient-to-b from-black/60 to-transparent">
                    <h3 class="text-base font-semibold">Sigiriya</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>

            <div class="relative rounded-[10px] overflow-hidden">
                <img src="{{ asset('images/ella.png') }}" alt="Ella" class="w-full h-full object-cover"  style="border-radius: 10px;">
                <div class="absolute top-0 left-0 w-full p-4 text-white bg-gradient-to-b from-black/60 to-transparent">
                    <h3 class="text-base font-semibold">Ella</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>

            <div class="relative rounded-[10px] overflow-hidden">
                <img src="{{ asset('images/dambulla.jpg') }}" alt="Dambulla" class="w-full h-full object-cover"  style="border-radius: 10px;">
                <div class="absolute top-0 left-0 p-4 text-white bg-gradient-to-t from-black/60 to-transparent w-full">

                    <h3 class="text-base font-semibold">Dambulla</h3>
                    <p class="text-sm">Sri Lanka</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Second Section: Browse by Property Type -->
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


<!-- Third Section: Browse by Popular Destinations -->
<!-- Third Section: Browse by Popular Destinations -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Browse by property type</h2>
        <p class="mb-4 text-gray-600" style="font-family: 'Lato', sans-serif;">These popular destinations have a lot to offer</p>
        <div class="flex space-x-4 overflow-x-auto pb-2">
            <!-- Kandy -->
            <div class="min-w-[220px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/kandy.jpg') }}" alt="Kandy" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Kandy</h3>
                    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">1,102 properties</p>
                </div>
            </div>

            <!-- Colombo -->
            <div class="min-w-[220px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/colombo.jpg') }}" alt="Colombo" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Colombo</h3>
                    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">520 properties</p>
                </div>
            </div>

            <!-- Nuwara Eliya -->
            <div class="min-w-[220px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/nuwaraelliya.jpg') }}" alt="Nuwara Eliya" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Nuwara Eliya</h3>
                    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">900 properties</p>
                </div>
            </div>

            <!-- Ella -->
            <div class="min-w-[220px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/ella.png') }}" alt="Ella" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Ella</h3>
                    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">841 properties</p>
                </div>
            </div>

            <!-- Galle -->
            <div class="min-w-[220px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/galle.png') }}" alt="Galle" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Galle</h3>
                    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">1,200 properties</p>
                </div>
            </div>

            <!-- Negombo -->
            <div class="min-w-[220px]">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('images/negambo.png') }}" alt="Negombo" class="w-full h-48 object-cover">
                </div>
                <div class="mt-2">
                    <h3 class="text-base font-bold text-gray-800" style="font-family: 'Lato', sans-serif;">Negombo</h3>
                    <p class="text-gray-600" style="font-family: 'Lato', sans-serif;">965 properties</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="container mx-auto px-4 py-8">
        <!-- Section Header -->
        <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Browse by property type</h2>
            <p class="text-sm text-gray-600" style="font-family: 'Lato', sans-serif;">Pick a vibe and explore top destinations in Sri Lanka</p>
        </div>
<!-- Category Buttons -->
<div class="flex flex-wrap gap-3 mb-6">
    <button id="beaches-btn" class="px-4 py-2 bg-blue-500 text-white rounded-full shadow-md flex items-center space-x-3" onclick="showCategory('beaches')">
        <img src="{{ asset('images/city.png') }}" alt="City" class="w-6 h-6" /> <!-- Add the small image here -->
        <span style="font-family: 'Lato', sans-serif;">City</span>
    </button>

    <button id="mountains-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-3" onclick="showCategory('mountains')">
        <img src="{{ asset('images/beach.png') }}" alt="Beach" class="w-6 h-6" />
        <span style="font-family: 'Lato', sans-serif;">Beach</span>
    </button>

    <button id="waterfalls-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-3" onclick="showCategory('waterfalls')">
        <img src="{{ asset('images/outsides.png') }}" alt="Outdoors" class="w-6 h-6" />
        <span style="font-family: 'Lato', sans-serif;">Outdoors</span>
    </button>

    <button id="historical-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-3" onclick="showCategory('historical')">
        <img src="{{ asset('images/relax.png') }}" alt="Relax" class="w-6 h-6" />
        <span style="font-family: 'Lato', sans-serif;">Relax</span>
    </button>

    <button id="parks-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-3" onclick="showCategory('parks')">
        <img src="{{ asset('images/romance.png') }}" alt="Romance" class="w-6 h-6" />
        <span style="font-family: 'Lato', sans-serif;">Romance</span>
    </button>

    <button id="cultural-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-3" onclick="showCategory('cultural')">
        <img src="{{ asset('images/food.png') }}" alt="Food" class="w-6 h-6" />
        <span style="font-family: 'Lato', sans-serif;">Food</span>
    </button>
</div>


        <!-- Card Container Example for Beaches -->
        <div id="beaches" class="card-container hidden">
            <!-- Mobile: horizontal scroll; Large screen: grid -->
            <div class="flex lg:grid lg:grid-cols-6 gap-4 overflow-x-auto pb-2">
                <!-- Repeat this block for each card -->
                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Kandy" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Kandy</h3>
                        <p class="text-gray-600">1,102 properties</p>
                    </div>
                </div>

                <!-- Repeat for other cities -->
                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Colombo" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Colombo</h3>
                        <p class="text-gray-600">520 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Nuwara Eliya" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Nuwara Eliya</h3>
                        <p class="text-gray-600">900 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Ella" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Ella</h3>
                        <p class="text-gray-600">841 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Galle" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Galle</h3>
                        <p class="text-gray-600">1,200 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Negombo" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Negombo</h3>
                        <p class="text-gray-600">965 properties</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other category containers -->
        <div id="mountains" class="card-container hidden"> <!-- Mobile: horizontal scroll; Large screen: grid -->
            <div class="flex lg:grid lg:grid-cols-6 gap-4 overflow-x-auto pb-2">
                <!-- Repeat this block for each card -->
                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Kandy" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Kandy</h3>
                        <p class="text-gray-600">1,102 properties</p>
                    </div>
                </div>

                <!-- Repeat for other cities -->
                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Colombo" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Colombo</h3>
                        <p class="text-gray-600">520 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Nuwara Eliya" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Nuwara Eliya</h3>
                        <p class="text-gray-600">900 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Ella" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Ella</h3>
                        <p class="text-gray-600">841 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Galle" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Galle</h3>
                        <p class="text-gray-600">1,200 properties</p>
                    </div>
                </div>

                <div class="min-w-[220px] flex-shrink-0">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img src="{{ asset('images/ella.png') }}" alt="Negombo" class="w-full h-48 object-cover">
                    </div>
                    <div class="mt-2">
                        <h3 class="text-xl font-bold text-gray-800">Negombo</h3>
                        <p class="text-gray-600">965 properties</p>
                    </div>
                </div>
            </div></div>
        <div id="waterfalls" class="card-container hidden"></div>
        <div id="historical" class="card-container hidden"></div>
        <div id="parks" class="card-container hidden"></div>
        <div id="cultural" class="card-container hidden"></div>
    </div>

   
<script>
    function showCategory(categoryId) {
        // Hide all category containers
        const categories = document.querySelectorAll('.card-container');
        categories.forEach(container => container.classList.add('hidden'));

        // Show the selected category
        const selected = document.getElementById(categoryId);
        if (selected) {
            selected.classList.remove('hidden');
        }

        // Optional: Update button styles (active/inactive)
        const buttons = document.querySelectorAll('button[id$="-btn"]');
        buttons.forEach(btn => btn.classList.remove('bg-blue-500', 'text-white'));
        buttons.forEach(btn => btn.classList.add('bg-white', 'text-gray-800'));

        const activeButton = document.getElementById(categoryId + '-btn');
        if (activeButton) {
            activeButton.classList.remove('bg-white', 'text-gray-800');
            activeButton.classList.add('bg-blue-500', 'text-blue');
        }
    }
</script>


</section>
<!-- Section 1: Deals for the weekend -->
<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Browse by property type</h2>
    <p class="text-gray-600 mb-6" style="font-family: 'Lato', sans-serif;">Save on stays for May 2 - May 4</p>

    <!-- Responsive container: scroll on small screens, grid on large screens -->
    <div class="flex gap-4 overflow-x-auto lg:grid lg:grid-cols-4 lg:gap-6">
      
      <!-- Hotel Card 1 -->
      <div class="min-w-[300px] max-w-[300px] bg-white rounded-lg overflow-hidden flex-shrink-0 lg:min-w-0"
     style="box-shadow: 0 10px 25px rgba(0, 0, 0, 0.7);">
  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover">
  <div class="p-4">
    <span class="text-white px-2 py-1 rounded-full text-s" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
    <h3 class="text-xl font-bold mt-2">Eagle Regency Hotel</h3>
    <p class="text-gray-600">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">8</span>
      <span class="ml-2">Very Good</span>
      <span class="ml-2">337 Reviews</span>
    </div>
    <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Getaway Deal</button>
    <p class="text-gray-600 mt-2">2 nights | LKR 26,844</p>
  </div>
</div>



      <!-- Hotel Card 2 -->
      <div class="min-w-[250px] max-w-[250px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
        <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover">
        <div class="p-4">
          <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Genius</span>
          <h3 class="text-xl font-bold mt-2">Royal Grand Resort</h3>
          <p class="text-gray-600">Colombo, Sri Lanka</p>
          <div class="flex items-center mt-2">
            <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">9</span>
            <span class="ml-2">Superb</span>
            <span class="ml-2">514 Reviews</span>
          </div>
          <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Getaway Deal</button>
          <p class="text-gray-600 mt-2">2 nights | LKR 32,500</p>
        </div>
      </div>

      <!-- Hotel Card 3 -->
      <div class="min-w-[250px] max-w-[250px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
        <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover">
        <div class="p-4">
          <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Genius</span>
          <h3 class="text-xl font-bold mt-2">Hill View Resort</h3>
          <p class="text-gray-600">Nuwara Eliya, Sri Lanka</p>
          <div class="flex items-center mt-2">
            <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">7.5</span>
            <span class="ml-2">Good</span>
            <span class="ml-2">210 Reviews</span>
          </div>
          <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Getaway Deal</button>
          <p class="text-gray-600 mt-2">2 nights | LKR 21,000</p>
        </div>
      </div>

      <!-- Hotel Card 4 -->
      <div class="min-w-[250px] max-w-[250px] bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0 lg:min-w-0">
        <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-[300px] object-cover">
        <div class="p-4">
          <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Genius</span>
          <h3 class="text-xl font-bold mt-2">Sunset Bay Hotel</h3>
          <p class="text-gray-600">Galle, Sri Lanka</p>
          <div class="flex items-center mt-2">
            <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">8.5</span>
            <span class="ml-2">Very Good</span>
            <span class="ml-2">450 Reviews</span>
          </div>
          <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Getaway Deal</button>
          <p class="text-gray-600 mt-2">2 nights | LKR 29,990</p>
        </div>
      </div>

    </div>
  </div>
</section>

  <!-- Section 2: Stay at our top unique properties -->
 <!-- Section 2: Stay at our top unique properties -->
 <section class="py-12 bg-white">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Stay at our top unique properties</h2>
    <p class="text-gray-600 mb-4">From castles and villas to boats and igloos, we have it all</p>

    <div class="flex space-x-4 overflow-x-auto pb-2">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
            <div class="p-4">
                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Genius</span>
                <h3 class="text-xl font-bold mt-2">Eagle Regency Hotel</h3>
                <p class="text-gray-600">Kandy, Sri Lanka</p>
                <div class="flex items-center mt-2">
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">8</span>
                    <span class="ml-2">Very Good</span>
                    <span class="ml-2">337 Reviews</span>
                </div>
                <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Book Now</button>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
            <div class="p-4">
                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Genius</span>
                <h3 class="text-xl font-bold mt-2">Eagle Regency Hotel</h3>
                <p class="text-gray-600">Kandy, Sri Lanka</p>
                <div class="flex items-center mt-2">
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">8</span>
                    <span class="ml-2">Very Good</span>
                    <span class="ml-2">337 Reviews</span>
                </div>
                <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Book Now</button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden relative">
  <!-- Heart Button in the Top-Right Corner with Inline CSS -->
  <button 
    style="position: absolute; top: 12px; right: 12px; background-color: white; border-radius: 50%; padding: 8px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s;"
    onclick="this.classList.toggle('filled'); this.classList.contains('filled') ? this.innerHTML = '❤️' : this.innerHTML = '🤍';"
  >
    🤍
  </button>

  <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
  <div class="p-4">
    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Genius</span>
    <h3 class="text-xl font-bold mt-2">Eagle Regency Hotel</h3>
    <p class="text-gray-600">Kandy, Sri Lanka</p>
    <div class="flex items-center mt-2">
      <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">8</span>
      <span class="ml-2">Very Good</span>
      <span class="ml-2">337 Reviews</span>
    </div>
    <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Book Now</button>
  </div>
</div>



        <!-- Card 4 -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <img src="{{ asset('images/property.png') }}" alt="Hotel Image" class="w-full h-48 object-cover">
            <div class="p-4">
                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Genius</span>
                <h3 class="text-xl font-bold mt-2">Eagle Regency Hotel</h3>
                <p class="text-gray-600">Kandy, Sri Lanka</p>
                <div class="flex items-center mt-2">
                    <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs">8</span>
                    <span class="ml-2">Very Good</span>
                    <span class="ml-2">337 Reviews</span>
                </div>
                <button class="bg-orange-500 text-white px-4 py-1 rounded mt-2">Book Now</button>
            </div>
        </div>
    </div>
</div>
</section>

<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-2" style="font-family: 'Lato', sans-serif;">Stay at our top unique properties</h2>
    <div class="container mx-auto px-4 py-10" style="border: 2px solid black; border-radius: 8px;">
      <!-- Travel More, Spend Less Section -->
      <div class="mb-10">
     
        <p class="text-gray-600 mb-6">
          Sign in, save money<br />
          Save 10% or more at participating properties
        </p>
        <div class="flex space-x-4">
          <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
            Sign in
          </a>
          <a href="#" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
            Register
          </a>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="container mx-auto px-4 py-10">
    <!-- Title -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Popular with travelers from Sri Lanka</h2>

        <!-- Tabs -->
        <div class="flex space-x-4 overflow-x-auto mb-4">
            <button id="tab-domestic" class="tab-button active-tab" onclick="toggleTab('domestic')">Domestic cities</button>
            <button id="tab-international" class="tab-button" onclick="toggleTab('international')">International cities</button>
            <button id="tab-regions" class="tab-button" onclick="toggleTab('regions')">Regions</button>
            <button id="tab-countries" class="tab-button" onclick="toggleTab('countries')">Countries</button>
            <button id="tab-places" class="tab-button" onclick="toggleTab('places')">Places to stay</button>
        </div>

        <!-- Content Panels -->
        <div id="tab-content" class="mt-4">
            <!-- Domestic -->
            <div id="content-domestic" class="grid grid-cols-5 gap-4">
              
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

<!-- Tailwind Styling for Tab Buttons -->
<style>
    .tab-button {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: 2px solid transparent;
        background-color: #E5E7EB; /* gray-200 */
        color: #4B5563; /* gray-600 */
        transition: all 0.2s;
    }

    .active-tab {
        background-color: #3B82F6; /* blue-500 */
        color: white;
        border-color: #3B82F6;
    }
</style>

<!-- JavaScript for Tab Switching -->
<script>
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
</script>



@endsection
