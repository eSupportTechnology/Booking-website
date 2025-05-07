@extends('frontend.master')

@section('title', 'Home')

@section('content')

<!-- Hero Section -->
<div class="relative bg-cover bg-center" style="background-image: url('{{ asset('images/home.jpg') }}'); height: 700px;">
    <!-- Overlay with 43% black -->
    <div class="absolute inset-0" style="background-color: rgba(0, 72, 105, 0.43);"></div>
    <!-- Content -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-white text-center">
    <!-- Title Section -->

    <h1 class="text-3xl md:text-4xl font-bold leading-snug" style="font-family: 'Lato', sans-serif; font-size:82px;margin-top:-200px;">
    Find Your Perfect Stay <br>
    <div class="mt-8 text-white">
    <img src="{{ asset('images/1.png') }}" alt="Image" class="inline-block  mr-2" style="height:75px;width:75px;">Quick 
        & <img src="{{ asset('images/2.png') }}" alt="Image" class="inline-block  ml-2" style="height:75px;width:75px;"> Easy!
    </div>
</h1>



    <!-- Search Box Section -->
    <div class="mt-4 grid grid-cols-1 md:grid-cols-5 gap-2 bg-white p-4 rounded text-black shadow-lg w-95% md:w-4/5">
        <input type="text" placeholder="Where are you going?" class="p-2 border rounded col-span-1 md:col-span-2">
        <input type="text" placeholder="Check-in date — Check-out date" class="p-2 border rounded col-span-1 md:col-span-1">
        <input type="text" placeholder="2 Adults . 0 Children . 1 Room" class="p-2 border rounded col-span-1 md:col-span-1">
        <button class="bg-cyan-600 text-white px-4 py-2 rounded col-span-1">Search</button>
    </div>
</div>


   
</div>



</div>

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
            <h2 class="text-3xl font-bold mb-2">Quick and easy trip planner</h2>
            <p class="text-sm text-gray-600">Pick a vibe and explore top destinations in Sri Lanka</p>
        </div>

        <!-- Category Buttons -->
        <div class="flex flex-wrap gap-3 mb-6">
            <button id="beaches-btn" class="px-4 py-2 bg-blue-500 text-white rounded-full shadow-md flex items-center space-x-2" onclick="showCategory('beaches')">
                <span class="text-lg">🌊</span><span>Beaches</span>
            </button>
            <button id="mountains-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-2" onclick="showCategory('mountains')">
                <span class="text-lg">⛰️</span><span>Mountains</span>
            </button>
            <button id="waterfalls-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-2" onclick="showCategory('waterfalls')">
                <span class="text-lg">💦</span><span>Waterfalls</span>
            </button>
            <button id="historical-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-2" onclick="showCategory('historical')">
                <span class="text-lg">🏛️</span><span>Historical Sites</span>
            </button>
            <button id="parks-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-2" onclick="showCategory('parks')">
                <span class="text-lg">🌳</span><span>National Parks</span>
            </button>
            <button id="cultural-btn" class="px-4 py-2 bg-white text-gray-800 rounded-full shadow-md flex items-center space-x-2" onclick="showCategory('cultural')">
                <span class="text-lg">🎭</span><span>Cultural Places</span>
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
        <div id="mountains" class="card-container hidden"></div>
        <div id="waterfalls" class="card-container hidden"></div>
        <div id="historical" class="card-container hidden"></div>
        <div id="parks" class="card-container hidden"></div>
        <div id="cultural" class="card-container hidden"></div>
    </div>

    <script>
        function showCategory(id) {
            // Hide all
            document.querySelectorAll('.card-container').forEach(container => {
                container.classList.add('hidden');
            });

            // Deactivate all buttons
            document.querySelectorAll('button').forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-white');
                btn.classList.add('bg-white', 'text-gray-800');
            });

            // Show selected
            document.getElementById(id).classList.remove('hidden');

            // Activate selected button
            const activeButton = document.getElementById(`${id}-btn`);
            activeButton.classList.add('bg-blue-500', 'text-white');
            activeButton.classList.remove('bg-white', 'text-gray-800');
        }
    </script>
</section>



@endsection
