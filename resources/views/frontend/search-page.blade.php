<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Booking.com</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="bg-gray-100">
<header class="bg-blue-800 text-white">
  <div class="max-w-6xl mx-auto px-4 py-3">
    <!-- Top bar: Logo + Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-center sm:items-center gap-3 sm:gap-0">
      <a class="text-2xl font-bold" href="#">Booking.com</a>
      
      <div class="flex flex-wrap justify-center sm:justify-end items-center gap-2 sm:gap-4">
        <button class="text-sm">LKR</button>
        <button>
          <img alt="Country flag" class="h-6 w-6 rounded-full"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuARmgfwP_UgUAsFDm_eFr30gwQT0mBCqf556hDi3xu0n7rn7ec0hBWn0VmdNJmoJVJ80HgmGw0QeZg7rwG-XtBDG4tQJou_T9I4nX-qz5vuYMzcPLHkn2QzYBqGCr3tDn67y6UDX7_7sQVluKWNF0HBc2edNhAcwJAULoqDvCXbb2cOYOR8vJqpkEfxO_oL7OhiZ0f6wXm5pmFXRKl9tQzYdaxbEERY_iWrPli4OKofiH37O_C8YsQZBrkhmKiq95ezkPA-pHUP6ow" />
        </button>
        <button><span class="material-icons">help_outline</span></button>
        <button class="text-sm">List your property</button>
        <button class="bg-white text-blue-700 px-3 py-1 rounded-sm text-sm font-medium">Register</button>
        <button class="bg-white text-blue-700 px-3 py-1 rounded-sm text-sm font-medium">Sign in</button>
      </div>
    </div>

    <!-- Navigation tabs -->
    <nav class="mt-4 overflow-x-auto">
      <ul class="flex flex-nowrap space-x-2">
        <li><a class="flex items-center space-x-1 px-3 py-2 bg-blue-900 rounded-full text-sm whitespace-nowrap" href="#"><span class="material-icons text-base">hotel</span><span>Stays</span></a></li>
        <li><a class="flex items-center space-x-1 px-3 py-2 rounded-full text-sm hover:bg-blue-700 whitespace-nowrap" href="#"><span class="material-icons text-base">flight</span><span>Flights</span></a></li>
        <li><a class="flex items-center space-x-1 px-3 py-2 rounded-full text-sm hover:bg-blue-700 whitespace-nowrap" href="#"><span class="material-icons text-base">directions_car</span><span>Car rental</span></a></li>
        <li><a class="flex items-center space-x-1 px-3 py-2 rounded-full text-sm hover:bg-blue-700 whitespace-nowrap" href="#"><span class="material-icons text-base">attractions</span><span>Attractions</span></a></li>
        <li><a class="flex items-center space-x-1 px-3 py-2 rounded-full text-sm hover:bg-blue-700 whitespace-nowrap" href="#"><span class="material-icons text-base">local_taxi</span><span>Airport taxis</span></a></li>
      </ul>
    </nav>

    <!-- Search Bar -->
    <div class="mt-6 bg-yellow-400 p-1 rounded-sm grid grid-cols-1 sm:grid-cols-4 gap-px">
      <div class="bg-white flex items-center px-3 py-2 rounded-t-sm sm:rounded-l-sm">
        <span class="material-icons text-gray-500">search</span>
        <input class="w-full ml-2 focus:outline-none text-sm" type="text" value="Kandy" />
        <button class="text-gray-500"><span class="material-icons">close</span></button>
      </div>
      <div class="bg-white flex items-center px-3 py-2">
        <span class="material-icons text-gray-500">calendar_today</span>
        <input class="w-full ml-2 focus:outline-none text-sm" type="text" value="Thu, Sep 18 — Thu, Sep 25" />
      </div>
      <div class="bg-white flex items-center px-3 py-2">
        <span class="material-icons text-gray-500">person</span>
        <input class="w-full ml-2 focus:outline-none text-sm" type="text" value="2 adults · 1 child · 1 room" />
        <span class="material-icons text-gray-500">expand_more</span>
      </div>
      <button class="bg-blue-600 text-white font-bold py-3 rounded-b-sm sm:rounded-r-sm text-lg hover:bg-blue-700">Search</button>
    </div>
  </div>
</header>


<main class="max-w-6xl mx-auto px-4 py-6">
<div class="text-xs text-gray-600 mb-4">
<a class="text-blue-600 hover:underline" href="#">Home</a> &gt;
            <a class="text-blue-600 hover:underline" href="#">Sri Lanka</a> &gt;
            <a class="text-blue-600 hover:underline" href="#">Kandy District</a> &gt;
            <a class="text-blue-600 hover:underline" href="#">Kandy</a> &gt;
            Search results
        </div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
<aside class="md:col-span-1 space-y-6">
<div class="bg-white rounded-lg shadow">
<div class="relative">
<img alt="Map of Kandy" class="w-full h-48 object-cover rounded-t-lg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuddg7rCLC79feIgnu4nMUbXooIzYO2YSLUaH85qDOcuDI5Q71jM47j5WTTQrtAPcT_pZeKdEB8N7umYeGhhlVwmXxh3K7liqU30SzldD5l1EgHKEQSRKEz_TtnAD4DGGg6C2v_C7IJplulanSsGPlFOd-ylNowKJD3cpAseC299HB4GO2rjiPhAxHwSFD8AojVCWelBCLO4vfGsVgrRnDBIwiWRkOI7utS1cvPAsxywj7xr7rnk1x0f8t2JnlvHBqOfUvF53tXgk"/>
<button class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4 py-2 rounded-full shadow-md flex items-center space-x-2 text-sm">
<span class="material-icons">map</span>
<span>Show on map</span>
</button>
</div>
</div>
<div class="bg-white p-4 rounded-lg shadow">
<h3 class="font-bold mb-2">Filter by:</h3>
<div class="border-t pt-4">
<h4 class="font-bold mb-2">Your budget (per night)</h4>
<p class="text-sm text-gray-600">LKR 1,000 – LKR 50,000+</p>
<div class="mt-4">
<input class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" max="50000" min="1000" type="range"/>
</div>
</div>
</div>
<div class="bg-white p-4 rounded-lg shadow">
<h3 class="font-bold mb-2">Deals</h3>
<div class="flex items-center justify-between text-sm">
<label class="flex items-center space-x-2" for="all-deals">
<input class="rounded" id="all-deals" type="checkbox"/>
<span>All deals</span>
</label>
<span>2</span>
</div>
</div>
<div class="bg-white p-4 rounded-lg shadow">
<h3 class="font-bold mb-2">Popular filters</h3>
<div class="space-y-2 text-sm">
<div class="flex items-center justify-between">
<label class="flex items-center space-x-2" for="no-prepayment">
<input class="rounded" id="no-prepayment" type="checkbox"/>
<span>No prepayment</span>
</label>
<span>595</span>
</div>
<div class="flex items-center justify-between">
<label class="flex items-center space-x-2" for="breakfast-included">
<input class="rounded" id="breakfast-included" type="checkbox"/>
<span>Breakfast included</span>
</label>
<span>341</span>
</div>
<div class="flex items-center justify-between">
<label class="flex items-center space-x-2" for="hotels">
<input class="rounded" id="hotels" type="checkbox"/>
<span>Hotels</span>
</label>
<span>237</span>
</div>
<div class="flex items-center justify-between">
<label class="flex items-center space-x-2" for="free-cancellation">
<input class="rounded" id="free-cancellation" type="checkbox"/>
<span>Free cancellation</span>
</label>
<span>580</span>
</div>
<div class="flex items-center justify-between">
<label class="flex items-center space-x-2" for="swimming-pool">
<input class="rounded" id="swimming-pool" type="checkbox"/>
<span>Swimming pool</span>
</label>
<span>134</span>
</div>
<div class="flex items-center justify-between">
<label class="flex items-center space-x-2" for="wonderful">
<input class="rounded" id="wonderful" type="checkbox"/>
<span>Wonderful: 9+</span>
</label>
<span>227</span>
</div>
<p class="text-xs text-gray-500 ml-6">Based on guest reviews</p>
</div>
</div>
</aside>
<div class="md:col-span-3 space-y-6">
<div class="flex justify-between items-center">
<h2 class="text-2xl font-bold">Kandy: 688 properties found</h2>
<div class="flex items-center space-x-2">
<div class="flex items-center justify-between">
  <label class="relative inline-flex items-center cursor-pointer w-32 h-8">
    <input type="checkbox" id="view-toggle" class="sr-only peer">
    
    <!-- Track -->
    <div class="absolute inset-0 bg-gray-200 rounded-full peer-checked:bg-[] transition-all"></div>
    
    <!-- Labels -->
    <div class="absolute inset-0 flex justify-between items-center px-2 text-xs font-semibold text-gray-700">
      <span>List</span>
      <span>Grid</span>
    </div>
    
    <!-- Knob -->
    <div class="absolute left-1 top-1 w-14 h-6 bg-white rounded-full border-2 border-gray-400 transition-all peer-checked:translate-x-16 shadow-md"></div>

  </label>
</div>



</div>
</div>
<div class="flex items-center space-x-2">
<button class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full flex items-center">
                        Sort by: Top picks for long stays
                        <span class="material-icons text-base ml-1">expand_more</span>
</button>
</div>
<div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row">
<div class="relative md:w-1/3">
<img alt="Eagle Regency Hotel" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDGO11nIDMNlYzU-a_3O80mXQ5F36gR--gsjE128IiJtT-uhZwNseO4KydWzaVFUJcd-JM-4WJlmhDTyyFOOFF3IZUkfKQb5UhWBZQlskl8oxnJCevz8cmXK30ualM6Ft6JpVY59mWnZS7ihRjuDPQDJeTFB52uEpUOQxkU8QFYn2rKcDUA2pNe_dYCAw_Ll_JjcIgGuFSLaVkLVGvaAqj2LCX3eTc5MbJaFxvI7bvPUElfi9AP_3sGLnkXZbloJCqrMK6yd2nekIQ"/>
<button class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md">
<span class="material-icons text-red-500">favorite_border</span>
</button>
</div>
<div class="p-4 flex-grow flex flex-col md:flex-row justify-between">
<div class="md:w-2/3">
<h3 class="text-xl font-bold text-blue-600">Eagle Regency Hotel</h3>
<div class="flex items-center text-yellow-500 my-1">
<span class="material-icons text-base">star</span>
<span class="material-icons text-base">star</span>
<span class="material-icons text-base">star</span>
<span class="material-icons text-base">star</span>
</div>
<a class="text-sm text-blue-600 hover:underline" href="#">Show on map</a>
<span class="text-sm text-gray-600 ml-2">5 km from downtown</span>
<div class="mt-2">
<span class="bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded">Getaway Deal</span>
</div>
<div class="mt-4 text-sm space-y-2">
<p><strong>Super Deluxe</strong></p>
<p>2 beds (1 twin, 1 queen)</p>
<p class="text-green-600 font-medium flex items-center"><span class="material-icons text-base mr-1">check</span>Free cancellation</p>
<p class="text-green-600 font-medium flex items-center"><span class="material-icons text-base mr-1">check</span>No prepayment needed - pay at the property</p>
</div>
</div>
<div class="mt-4 md:mt-0 md:w-1/3 text-right flex flex-col justify-between">
<div class="flex items-center justify-end">
<div class="text-right mr-2">
<p class="font-bold">Good</p>
<p class="text-xs text-gray-500">450 reviews</p>
<p class="text-xs text-gray-500 mt-1">Comfort 8.1</p>
</div>
<div class="bg-blue-800 text-white font-bold text-lg p-2 rounded-md">9.6</div>
</div>
<div class="mt-4">
<p class="text-xs text-gray-500">1 week, 2 adults, 1 child</p>
<p class="text-sm text-red-500 line-through">LKR 145,978</p>
<p class="text-2xl font-bold">LKR 116,885</p>
<p class="text-xs text-gray-500">+LKR 34,832 taxes and fees</p>
<button class="bg-blue-600 text-white font-bold py-2 px-4 rounded mt-2 w-full hover:bg-blue-700">See availability</button>
</div>
</div>
</div>
</div>
<div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row">
<div class="relative md:w-1/3">
<img alt="Hillcrest Villa Kandy" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCqfQKAogDN_KnoKXNFnFkF29tS1doFS_tPZvwxUWoU67d7p1YDB4BC1-T4d1fbZtQoe74Y1l9hum1ZR8-UPDe-DrFLcLpV9mXhPdbtwSO6hEALFbN37M6_zyYeHovyL1iip_q5FGQghUGCiuUZqYbcleTf7umjosmQIRsNeAAUzUGRKPuA0wRjKc4siFdsbSVXL1LV83YzSYZ7flB_2YCzxjTqV4zjnkHaqU9_UPWIbr_kY-vT7EzM_0DU7hHtjyKU5341zKtTyxY"/>
<button class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md">
<span class="material-icons text-red-500">favorite_border</span>
</button>
</div>
<div class="p-4 flex-grow flex flex-col md:flex-row justify-between">
<div class="md:w-2/3">
<h3 class="text-xl font-bold text-blue-600">Hillcrest Villa Kandy</h3>
<div class="flex items-center text-yellow-500 my-1">
<span class="material-icons text-base">star</span>
<span class="material-icons text-base">star</span>
<span class="material-icons text-base">star</span>
<span class="material-icons text-base">star</span>
</div>
<a class="text-sm text-blue-600 hover:underline" href="#">Kandy</a>
<span class="text-sm text-gray-600 ml-2">Show on map</span>
<span class="text-sm text-gray-600 ml-2">4.4 km from downtown</span>
<div class="mt-2">
<span class="bg-yellow-400 text-yellow-900 text-xs font-semibold px-2 py-1 rounded">New to Booking.com</span>
</div>
<div class="mt-4 text-sm space-y-2">
<p><strong>Deluxe Suite</strong></p>
<p>Private suite • 1 bedroom • 1 living room</p>
<p>2 beds (1 king, 1 sofa bed)</p>
<p class="text-green-600 font-medium flex items-center"><span class="material-icons text-base mr-1">check</span>Free cancellation</p>
<p class="text-green-600 font-medium flex items-center"><span class="material-icons text-base mr-1">check</span>No prepayment needed - pay at the property</p>
</div>
</div>
<div class="mt-4 md:mt-0 md:w-1/3 text-right flex flex-col justify-end">
<div>
<p class="text-xs text-gray-500">1 week, 2 adults, 1 child</p>
<p class="text-2xl font-bold">LKR 274,774</p>
<p class="text-xs text-gray-500">+LKR 38,225 taxes and fees</p>
<button class="bg-blue-600 text-white font-bold py-2 px-4 rounded mt-2 w-full hover:bg-blue-700">See availability</button>
</div>
</div>
</div>
</div>
</div>
</div>
</main>



</body>
<script>
const listBtn = document.getElementById('list-btn');
const gridBtn = document.getElementById('grid-btn');
const container = document.getElementById('properties-container');

listBtn.addEventListener('click', () => {
    container.classList.remove('grid');
    container.classList.add('flex', 'flex-col', 'space-y-6');
    listBtn.classList.add('bg-gray-200');
    gridBtn.classList.remove('bg-gray-200');
});

gridBtn.addEventListener('click', () => {
    container.classList.remove('flex', 'flex-col', 'space-y-6');
    container.classList.add('grid', 'grid-cols-1', 'gap-6');
    gridBtn.classList.add('bg-gray-200');
    listBtn.classList.remove('bg-gray-200');
});

</script>
</html>
