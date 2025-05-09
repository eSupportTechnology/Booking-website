@extends('frontend.master')

@section('title', 'Home')

@section('content')
<div class="w-full bg-white py-6">
    

    <!-- Search Bar -->
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-md px-4 py-4 grid grid-cols-1 md:grid-cols-5 gap-2">
        <div class="flex items-center bg-gray-100 rounded px-3 py-2 col-span-2">
            <img src="images/car.png" class="w-5 h-5 mr-2" alt="Location">
            <input type="text" placeholder="Nuwara Eliya" class="bg-transparent outline-none w-full text-sm" />
        </div>

        <div class="flex items-center bg-gray-100 rounded px-3 py-2">
            <img src="images/calender.png" class="w-5 h-5 mr-2" alt="Calendar">
            <input type="text" placeholder="Tue, May 13 – Tue, May 15" class="bg-transparent outline-none w-full text-sm" />
        </div>

        <div class="flex items-center bg-gray-100 rounded px-3 py-2">
            <img src="images/user.png" class="w-5 h-5 mr-2" alt="Guests">
            <input type="text" placeholder="2 Adults · 0 Children · 1 Room" class="bg-transparent outline-none w-full text-sm" />
        </div>

        <button class="bg-cyan-600 text-white px-4 py-2 rounded-md hover:bg-cyan-700 text-sm">Search</button>
    </div>

    <!-- Search Summary -->
    <div class="max-w-6xl mx-auto mt-6 px-4">
        <h2 class="text-xl font-semibold">Nuwara Eliya: <span class="font-normal">430 properties found</span></h2>
        <div class="mt-2 flex items-center justify-between text-sm">
            <span class="text-gray-500">Sort by: <strong class="text-black">Our top picks</strong></span>
            <div class="flex gap-2">
                <button class="border px-2 py-1 rounded text-sm">List</button>
                <button class="border px-2 py-1 rounded text-sm">Grid</button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto mt-6 px-4 grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Filter Section -->
   <aside class="hidden md:block col-span-1 space-y-4">
    <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
        <h2 class="text-lg font-semibold mb-4">Filter by:</h2>

        <!-- Budget Section -->
        <div class="mb-6">
        <h3 class="font-semibold text-gray-900 mb-4">Your budget (per night)</h3>
            <p class="text-sm text-gray-500 mb-2">LKR 2,000 - LKR 50,000+</p>

            <!-- Budget bar chart placeholder -->
            <div class="w-full h-20 flex items-end space-x-1 mb-2">
                @for ($i = 0; $i < 20; $i++)
                    <div class="bg-gray-300 w-1.5 rounded" style="height: {{ rand(10, 60) }}%;"></div>
                @endfor
            </div>

            <!-- Range slider -->
            <input type="range" min="2000" max="50000" step="500" class="w-full accent-blue-600">
        </div>

        <!-- Divider -->
        <hr class="my-4 border-gray-300">

        <!-- Popular Filters Section -->
        <div>
         <h3 class="font-semibold text-gray-900 mb-4">Deals</h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li><label><input type="checkbox" class="mr-2">All Deals</label></li>
            </ul>
        </div>
         <hr class="my-4 border-gray-300">
         <div>
    <h3 class="font-semibold text-gray-900 mb-4">Popular filters</h3>
 <ul class="space-y-2 text-sm text-gray-600">
    <li class="flex justify-between items-center">
        <label class="flex items-center"><input type="checkbox" class="mr-2">Breakfast included</label>
        <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
        <label class="flex items-center"><input type="checkbox" class="mr-2">Private bathroom</label>
        <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
        <label class="flex items-center"><input type="checkbox" class="mr-2">Parking</label>
        <span class="text-gray-500">200</span>
    </li>
       <li class="flex justify-between items-center">
        <label class="flex items-center"><input type="checkbox" class="mr-2">Breakfast & dinner included</label>
        <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
        <label class="flex items-center"><input type="checkbox" class="mr-2">5 stars</label>
        <span class="text-gray-500">200</span>
    </li>
        <li class="flex justify-between items-center">
        <label class="flex items-center"><input type="checkbox" class="mr-2">Balcony</label>
        <span class="text-gray-500">200</span>
    </li>
</ul>


        </div>
         <hr class="my-4 border-gray-300">
        <div>
<h3 class="font-semibold text-gray-900 mb-4">Facilities</h3>
  <ul class="space-y-2 text-sm text-gray-600">
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Parking</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Restaurant</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Pet Friendly</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Room Service</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">24-hour front desk</label>
      <span class="text-gray-500">200</span>
    </li>
  </ul>
</div>

                 <hr class="my-4 border-gray-300">
       <div>
 <h3 class="font-semibold text-gray-900 mb-4">Property Type</h3>
  <ul class="space-y-2 text-sm text-gray-600">
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Entire homes & apartments</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Hotels</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Guesthouses</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Apartments</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Villas</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Homestays</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Vacation Homes</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Bed and Breakfasts</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Hostels</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Lodges</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Country Houses</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Resorts</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Campgrounds</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Chalets</label>
      <span class="text-gray-500">200</span>
    </li>
  </ul>
</div>

          <hr class="my-4 border-gray-300">
        <div class="mb-6">
  <h3 class="font-semibold text-gray-900 mb-4">Bedrooms and bathrooms</h3>

  <div class="mb-3">
    <label class="block text-sm text-gray-700 mb-1">Bedrooms</label>
    <div class="flex items-center border border-gray-300 rounded w-fit">
      <button class="px-3 py-1 text-gray-600 hover:bg-gray-200">-</button>
      <span class="px-4 py-1 text-gray-800">0</span>
      <button class="px-3 py-1 text-gray-600 hover:bg-gray-200">+</button>
    </div>
  </div>
    
  <div>
    <label class="block text-sm text-gray-700 mb-1">Bathrooms</label>
    <div class="flex items-center border border-gray-300 rounded w-fit">
      <button class="px-3 py-1 text-gray-600 hover:bg-gray-200">-</button>
      <span class="px-4 py-1 text-gray-800">0</span>
      <button class="px-3 py-1 text-gray-600 hover:bg-gray-200">+</button>
    </div>
  </div>
       <hr class="my-4 border-gray-300">
  <div>
<h3 class="font-semibold text-gray-900 mb-4">Meals</h3>
  <ul class="space-y-2 text-sm text-gray-600">
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Kitchen facilities</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Breakfast included</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">All meals included</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">All-inclusive</label>
      <span class="text-gray-500">200</span>
    </li>
  </ul>
</div>

             <hr class="my-4 border-gray-300">
       <div>
  <h3 class="font-semibold text-gray-900 mb-4">Review score</h3>
  <ul class="space-y-2 text-sm text-gray-600">
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Wonderful: 9+</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Very Good: 8+</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Good: 7+</label>
      <span class="text-gray-500">200</span>
    </li>
    <li class="flex justify-between items-center">
      <label class="flex items-center"><input type="checkbox" class="mr-2">Pleasant: 6+</label>
      <span class="text-gray-500">200</span>
    </li>
  </ul>
</div>

</div>

    </div>
</aside>

        <!-- Results Section -->
        <section class="md:col-span-3 space-y-4">
            <!-- Result Card -->
          <div class="border rounded-lg p-4 shadow-sm flex flex-col md:flex-row gap-4 bg-white">
    <!-- Hotel Image -->
    <img src="{{ asset('images/A.png') }}" alt="Hotel Image" class="w-full md:w-48 h-44 object-cover rounded-md">

    <!-- Info Section -->
    <div class="flex-1 flex flex-col justify-between">
        <!-- Title and Location -->
        <div>
            <h3 class="font-semibold text-lg text-blue-700 flex items-center gap-1">
                Sandathenna by Secret Leisure
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.63-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.45 4.73L5.82 21z"/></svg>
            </h3>
            <p class="text-sm text-gray-500">Nuwara Eliya • <a href="#" class="underline text-blue-500">Show on map</a> • 2.3 km from downtown</p>
        </div>

        <!-- Deal Label -->
        <span class="inline-block bg-orange-500 text-white text-xs font-semibold px-2 py-0.5 rounded mt-2 w-max">
            Limited-time Deal
        </span>

        <!-- Room Details -->
        <div class="text-sm text-gray-700 mt-2">
            <p class="font-semibold">Double Room with Lake View</p>
            <p>2 beds (1 twin, 1 queen)</p>
            <ul class="list-disc list-inside mt-1 text-[13px]">
                <li class="text-red-600 font-medium">Breakfast Included</li>
                <li class="text-red-600">Free cancellation</li>
                <li><span class="text-red-600">No prepayment needed</span> - pay at the property</li>
            </ul>
            <p class="text-red-600 text-xs mt-1 font-semibold">Only 5 rooms left at this price on our site</p>
        </div>
    </div>

    <!-- Price and Button Section -->
    <div class="flex flex-col justify-between items-end text-right">
        <div>
            <span class="text-sm text-gray-400 line-through">LKR 71,880</span><br>
            <span class="text-xl font-bold text-red-600">LKR 46,500</span><br>
            <span class="text-xs text-gray-500">+LKR 9,057 taxes and fees</span>
        </div>
        <button class="bg-orange-500 hover:bg-orange-600 text-white text-sm px-4 py-1.5 rounded mt-2">
            See availability
        </button>
    </div>
</div>

        </section>
    </div>
</div>

@endsection