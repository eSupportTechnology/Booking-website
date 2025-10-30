<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Car Listing</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<!-- Header -->
<header class="bg-[#1F8FB2] text-white">
  <div class="max-w-6xl mx-auto px-4 py-6 md:py-8 flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0">
  <!-- Logo -->
  <div class="text-xl md:text-2xl font-bold -mt-6">Booking.com</div>
    <div class="flex items-center gap-3 md:gap-5 flex-wrap justify-center md:justify-end">
      <span class="text-base sm:text-lg -mt-6">LKR</span>
      <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden -mt-6">
        <img src="https://flagcdn.com/gb.svg" alt="UK Flag" class="w-full h-full object-cover" />
      </div>
      <a href="#"
         class="flex items-center justify-center w-5 h-5 sm:w-6 sm:h-6 bg-[#1F8FB2] rounded-full hover:bg-[#29ACD5] text-white border border-white text-xs sm:text-sm font-semibold -mt-6"
         title="Help">?</a>

     <div class="flex items-center gap-1.5 sm:gap-2 flex-shrink-0">
       <div class="bg-yellow-400 text-black rounded-full w-6 h-6 sm:w-7 sm:h-7 flex items-center justify-center text-xs sm:text-sm font-semibold">D</div>
        <div>
          <p class="font-semibold leading-none text-xs sm:text-sm">Dinidu Dananjaya</p>
          <p class="text-[10px] sm:text-xs text-yellow-300">Genius Level 1</p>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Search Box -->
<div class="relative z-10 -mt-7 px-4">
  <form method="GET"
    class="bg-white rounded-lg px-2 py-1 shadow-lg flex flex-col md:flex-row items-stretch md:items-center gap-2 border-4 border-yellow-400 max-w-6xl mx-auto text-xs md:text-sm">

    <!-- Pick-up Location -->
    <div class="flex items-center gap-2 flex-1 border-b md:border-b-0 md:border-r-2 border-yellow-400 px-2 py-2 md:py-0">
      <span class="text-gray-500">🔍</span>
      <div>
        <p class="text-[11px] text-gray-500">Pick-up location</p>
        <p class="text-[14px] text-gray-500">Colombo</p>
      </div>
      <button type="button" class="ml-auto text-gray-400 text-xs">✕</button>
    </div>

    <!-- Pick-up Date -->
    <div class="flex items-center gap-2 border-b md:border-b-0 md:border-r-2 border-yellow-400 px-2 py-2 md:py-0">
      <span class="text-gray-500">📅</span>
      <div>
        <p class="text-[11px] text-gray-500">Pick-up date</p>
        <p class="text-[14px] text-gray-500">Fri, 22 Aug</p>
      </div>
    </div>

    <!-- Pick-up Time -->
    <div class="flex items-center gap-2 border-b md:border-b-0 md:border-r-2 border-yellow-400 px-2 py-2 md:py-0">
      <span class="text-gray-500">⏰</span>
      <div>
        <p class="text-[11px] text-gray-500">Time</p>
        <p class="text-[14px] text-gray-500">16:00</p>
      </div>
    </div>

    <!-- Drop-off Date -->
    <div class="flex items-center gap-2 border-b md:border-b-0 md:border-r-2 border-yellow-400 px-2 py-2 md:py-0">
      <span class="text-gray-500">📅</span>
      <div>
        <p class="text-[11px] text-gray-500">Drop-off date</p>
        <p class="text-[14px] text-gray-500">Sat, 23 Aug</p>
      </div>
    </div>

    <!-- Drop-off Time -->
    <div class="flex items-center gap-2 border-b md:border-b-0 md:border-r-2 border-yellow-400 px-2 py-2 md:py-0">
      <span class="text-gray-500">⏰</span>
      <div>
        <p class="text-[11px] text-gray-500">Time</p>
        <p class="text-[14px] text-gray-500">10:00</p>
      </div>
    </div>

    <!-- Search Button -->
    <div class="px-2 py-2 md:py-0 w-full md:w-auto">
      <button type="submit"
        class="w-full md:w-auto h-full bg-[#0071c2] hover:bg-[#005fa3] text-white font-semibold px-4 py-2 rounded-md text-sm flex items-center justify-center">
        Search
      </button>
    </div>
  </form>

  <!-- Extra Options -->
  <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-6 mt-2 max-w-6xl mx-auto text-xs sm:text-sm text-gray-700">
    <label class="flex items-center gap-2">
      <input type="checkbox" class="w-4 h-4 border-gray-400 rounded">
      Drop car off at different location
    </label>
    <label class="flex items-center gap-2">
      <input type="checkbox" checked class="w-4 h-4 border-gray-400 rounded text-blue-600">
      Driver aged between 30 - 65?
    </label>
  </div>
</div><br>

   {{-- Map --}}
  <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-6 mt-2 max-w-6xl mx-auto text-xs sm:text-sm text-gray-700">
    <div class="relative w-full sm:w-[320px] md:w-[350px] lg:w-[350px]">
        <iframe class="w-full h-28 sm:h-32 md:h-36 rounded-lg"
            loading="lazy"
            src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
            frameborder="0" allowfullscreen aria-hidden="false" tabindex="0">
        </iframe>
        <button
            class="absolute bottom-2 left-2 bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white text-xs px-2 py-1 rounded-md shadow">
            Show on map
        </button>
    </div>
  </div><br>



<!-- Header with available cars -->
<div class="max-w-2xl mx-auto px-0 py-0">
    <!-- Car categories aligned to right, floating higher -->
    <div class="flex flex-wrap gap-12 -mt-20 justify-start md:justify-end md:-translate-x-8">
        <div class="flex flex-col items-center text-center text-sm">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTt1U9d4v4Z5svuEZbRqeRyMxuR-Weq1xDELw&s" alt="Medium car" class="w-8 h-8 mb-1">
            <span>Medium car</span>
        </div>
        <div class="flex flex-col items-center text-center text-sm">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTt1U9d4v4Z5svuEZbRqeRyMxuR-Weq1xDELw&s" alt="Small car" class="w-8 h-8 mb-1">
            <span>Small car</span>
        </div>
        <div class="flex flex-col items-center text-center text-sm">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTt1U9d4v4Z5svuEZbRqeRyMxuR-Weq1xDELw&s" alt="Large car" class="w-8 h-8 mb-1">
            <span>Large car</span>
        </div>
        <div class="flex flex-col items-center text-center text-sm">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTt1U9d4v4Z5svuEZbRqeRyMxuR-Weq1xDELw&s" alt="SUVs" class="w-8 h-8 mb-1">
            <span>SUVs</span>
        </div>
        <div class="flex flex-col items-center text-center text-sm">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTeN_xfDJS_u1IgLRonK_g8Y6cOy5p6_u1qOA&s" alt="People carrier" class="w-8 h-8 mb-1">
            <span>People carrier</span>
        </div>
    </div>
</div>




<div class="max-w-6xl mx-auto px-4 py-6">

    <div class="flex flex-col md:flex-row gap-6">
        {{-- Filters --}}
       <aside class="w-full md:w-[350px] bg-white rounded-lg shadow p-6 md:-ml-4">
           <!-- Header with Clear All -->
           <div class="flex items-center justify-between mb-6">
               <h3 class="font-semibold text-lg">Filter</h3>
               <a href="#" class="text-blue-600 text-sm">Clear all filters</a>
           </div>

           <!-- Location -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Location</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Airport (outside terminal) <span class="ml-auto text-gray-500">13</span></label>
               </div>
           </div>

           <!-- Transmission -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Transmission</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Automatic <span class="ml-auto text-gray-500">13</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Manual <span class="ml-auto text-gray-500">1</span></label>
               </div>
           </div>

           <!-- Supplier -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Supplier</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Europcar <span class="ml-auto text-gray-500">13</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Hertz <span class="ml-auto text-gray-500">10</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> SR Rent A Car <span class="ml-auto text-gray-500">50</span></label>
               </div>
           </div>

           <!-- Mileage / Kilometres -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Mileage/Kilometres</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Limited <span class="ml-auto text-gray-500">13</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Unlimited <span class="ml-auto text-gray-500">13</span></label>
               </div>
           </div>

           <!-- Extras -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Extras</h4>
               <p class="text-xs text-gray-500 mb-2">Only show rental companies with these extras available</p>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Additional driver <span class="ml-auto text-gray-500">13</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Baby seat <span class="ml-auto text-gray-500">13</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Child seat <span class="ml-auto text-gray-500">13</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> GPS <span class="ml-auto text-gray-500">13</span></label>
               </div>
           </div>

           <!-- Car Category -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Car category</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Small car <span class="ml-auto text-gray-500">2</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Medium car <span class="ml-auto text-gray-500">5</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Large car <span class="ml-auto text-gray-500">7</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> People carriers <span class="ml-auto text-gray-500">2</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> SUVs <span class="ml-auto text-gray-500">4</span></label>
               </div>
           </div>

           <!-- Number of Seats -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Number of seats</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> 4 seats <span class="ml-auto text-gray-500">4</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> 5 seats <span class="ml-auto text-gray-500">8</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> 6+ seats <span class="ml-auto text-gray-500">1</span></label>
               </div>
           </div>

           <!-- When to Pay -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">When to pay</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Pay now <span class="ml-auto text-gray-500">13</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Pay at pick-up</label>
               </div>
           </div>

           <!-- Car Specs -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Car specs</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Air Conditioning</label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> 4+ doors <span class="ml-auto text-gray-500">4</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Electric cars</label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Fully electric</label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Hybrid <span class="ml-auto text-gray-500">1</span></label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Plug-in hybrid</label>
               </div>
           </div>

           <!-- Deposit -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Deposit required at pick-up</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox">
                       <x-price :amount="0" /> - <x-price :amount="100000" />
                       <span class="ml-auto text-gray-500">1</span>
                   </label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox">
                       <x-price :amount="100000" /> - <x-price :amount="200000" />
                   </label>
                   <label class="flex items-center gap-2 py-1"><input type="checkbox">
                       <x-price :amount="200000" />+
                       <span class="ml-auto text-gray-500">12</span>
                   </label>
               </div>
           </div>

           <!-- Fuel Policy -->
           <div class="mb-6 pb-4 border-b border-gray-200">
               <h4 class="font-medium mb-2">Fuel policy</h4>
               <div class="flex flex-col gap-2">
                   <label class="flex items-center gap-2 py-1"><input type="checkbox"> Like for like <span class="ml-auto text-gray-500">13</span></label>
               </div>
           </div>
       </aside>


        {{-- Car Listings --}}
        <div class="flex-1 flex flex-col gap-4 md:w-[700px]">



            {{-- Car Card --}}
            <div class="bg-white rounded-lg shadow p-4 flex flex-col md:flex-row gap-4 items-start">
                <img src="https://cdn-icons-png.flaticon.com/512/743/743131.png" alt="Perodua Axia" class="w-32 h-30 object-cover rounded-md">

                <!-- Left side -->
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex gap-2 mb-1">
                            <span class="bg-blue-700 text-white text-xs px-2 py-1 rounded">Top Pick</span>
                            <span class="bg-blue-700 text-white text-xs px-2 py-1 rounded">Genius</span>
                        </div>

                        <h4 class="font-semibold text-lg">
                            Perodua Axia <a href="#" class="text-blue-600 hover:underline text-sm">or similar small car</a>
                        </h4>

                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 mt-2">
                            <div class="flex items-center gap-2"><span class="text-lg">🧍</span> 4 seats</div>
                            <div class="flex items-center gap-2"><span class="text-lg">⚙️</span> Automatic</div>
                            <div class="flex items-center gap-2"><span class="text-lg">🧳</span> 1 Large bag</div>
                            <div class="flex items-center gap-2"><span class="text-lg">🛣️</span> Unlimited</div>
                        </div>

                        <div class="mt-2 text-sm">
                            <span class="text-blue-600 hover:underline">Bandaranaike International Airport</span><br>
                            <span class="text-gray-500 text-xs">Outside of Terminal</span>
                        </div>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex flex-col items-end gap-2">
                    <span class="text-green-600 text-sm bg-green-100 px-2 py-1 rounded">10% off</span>
                    <div class="text-red-500 line-through text-sm">
                        <x-price :amount="16925" />
                    </div>
                    <div class="text-xl font-bold">
                        <x-price :amount="15233" />
                    </div>
                    <div class="text-green-600 text-sm">Free cancellation</div>
                    <button class="bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-2 rounded text-base mt-3">
                        View deal
                    </button>
                </div>


            </div>


            {{-- Another Car Card --}}
            <div class="bg-white rounded-lg shadow p-4 flex flex-col md:flex-row gap-4 items-center md:items-start">
                <img src="{{ asset('images/nissan-kicks.png') }}" alt="Nissan Kicks" class="w-32 h-20 object-cover rounded-md">
                <div class="flex-1">
                    <div class="flex gap-2 mb-1">
                        <span class="bg-blue-700 text-white text-xs px-2 py-1 rounded">Ideal for Families</span>
                    </div>
                    <h4 class="font-semibold text-lg">Nissan Kicks <span class="text-gray-500 text-sm">or similar SUV</span></h4>
                    <div class="flex gap-4 text-sm mt-1">
                        <div class="flex items-center gap-1"><i class="fas fa-user"></i> 5 seats</div>
                        <div class="flex items-center gap-1"><i class="fas fa-cogs"></i> Automatic</div>
                        <div class="flex items-center gap-1"><i class="fas fa-suitcase"></i> 3 Large bags</div>
                        <div class="flex items-center gap-1"><i class="fas fa-road"></i> Unlimited mileage</div>
                    </div>
                    <div class="mt-2 text-blue-600 text-sm">Bandaranaike International Airport <span class="text-gray-500 text-xs">Meet & Greet</span></div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <div class="text-xl font-bold">
                        <x-price :amount="44232" />
                    </div>
                    <div class="text-green-600 text-sm">Free cancellation</div>
                    <button class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-2 rounded">View deal</button>
                </div>
            </div>
        </div>


    </div>


</div>

<!-- Footer -->
<footer class="bg-gray-100 text-gray-700 mt-10">
  <div class="max-w-6xl mx-auto px-4 py-6 md:py-8 flex flex-col gap-4">

    <!-- Links -->
    <div class="flex flex-wrap justify-start gap-4 text-sm">
      <a href="#" class="hover:underline">Customer Service help</a>
      <a href="#" class="hover:underline">Privacy & cookies</a>
      <a href="#" class="hover:underline">Modern Slavery Statement</a>
      <a href="#" class="hover:underline">Human Rights Statement</a>
      <a href="#" class="hover:underline">Terms and conditions</a>
    </div>

    <!-- Copyright -->
    <div class="text-left text-xs text-gray-500 mt-2">
      Copyright © 1996–2025 Booking.com™. All rights reserved.
    </div>

  </div>
</footer>


</body>
</html>
