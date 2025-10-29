@extends('frontend.master')
@section('title', 'Car Rentals')
@section('content')
<section class="text-white py-8 bg-[#1F8FB2] relative z-0">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Text -->
    <div class="mb-10 mt-1">
      <h1 class="text-[28px] md:text-[36px] lg:text-[46px] font-bold mb-2">
     Car hire for any kind of trip
      </h1>
      <p class="text-[18px] md:text-[20px] mt-1 font-sans">
      Great cars at great prices, from the biggest car rental companies
      </p>
    </div>
  </div>
</section>
<!-- Font Awesome (for icons) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<div class="relative z-10 -mt-8 px-4">
  <!-- Booking form -->
  <form method="GET" action="{{ route('customer.carsearch') }}"
    class="bg-white rounded-xl px-3 py-2 shadow-lg flex flex-col md:flex-row 
           items-stretch md:items-center gap-3 md:gap-0 
           border-2 sm:border-4 border-yellow-400 
           w-full max-w-6xl mx-auto overflow-visible text-sm">

    <div class="flex flex-col md:flex-row flex-wrap md:flex-nowrap items-stretch w-full gap-3 md:gap-x-4">

      <!-- Pickup -->
      <div x-data="{ openPickup: false, pickupLocation: '' }" class="relative flex-1 min-w-[200px]">
        <button @click="openPickup = !openPickup" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded">
          <i class="fas fa-search text-lg"></i>
          <span x-text="pickupLocation ? pickupLocation : 'Pick-up location'"
            class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="openPickup" @click.outside="openPickup = false"
          class="absolute z-50 bg-white shadow-lg rounded mt-1 w-full sm:max-w-xs border">
          <ul class="max-h-48 overflow-y-auto">
            <li @click="pickupLocation = 'Colombo'; openPickup = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Colombo</li>
            <li @click="pickupLocation = 'Negombo'; openPickup = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Negombo</li>
            <li @click="pickupLocation = 'Kandy'; openPickup = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Kandy</li>
          </ul>
        </div>
        <input type="hidden" name="pickup" :value="pickupLocation" />
      </div>

      <!-- Divider (desktop only) -->
      <div class="hidden md:flex justify-center items-center">
        <div class="border-r border-black h-8"></div>
      </div>

      <!-- Drop-off -->
      <div x-data="{ openDestination: false, destinationLocation: '' }" id="dropoffField"
        class="relative flex-1 min-w-[200px] opacity-50 pointer-events-none">
        <button @click="openDestination = !openDestination" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded bg-gray-100">
          <i class="fas fa-search text-lg"></i>
          <span x-text="destinationLocation ? destinationLocation : 'Drop-off location'"
            class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="openDestination" @click.outside="openDestination = false"
          class="absolute z-50 bg-white shadow-lg rounded mt-1 w-full sm:max-w-xs border">
          <ul class="max-h-48 overflow-y-auto">
            <li @click="destinationLocation = 'Airport'; openDestination = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Airport</li>
            <li @click="destinationLocation = 'Galle'; openDestination = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Galle</li>
            <li @click="destinationLocation = 'Matara'; openDestination = false"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Matara</li>
          </ul>
        </div>
        <input type="hidden" name="destination" :value="destinationLocation" />
      </div>

      <!-- Divider (desktop only) -->
      <div class="hidden md:flex justify-center items-center">
        <div class="border-r border-black h-8"></div>
      </div>

      <!-- Pickup Date -->
      <div x-data="{ open: false, checkin: null }" class="relative flex-1 min-w-[200px]">
        <button @click="open = !open" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded">
          <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
          <span x-text="checkin ? new Date(checkin).toLocaleString() : 'Pick-up Date & Time'"
            class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="open" @click.outside="open = false"
          class="absolute z-50 bg-white shadow-xl rounded-xl p-4 mt-2 w-full sm:w-72 max-w-xs right-0 text-gray-800 space-y-2 text-sm">
          <label for="checkin-date" class="block text-sm font-medium text-gray-700 mb-1">Pick Date & Time</label>
          <input type="datetime-local" id="checkin-date" x-model="checkin"
            class="w-full border p-2 rounded outline-none" />
        </div>
        <input type="hidden" name="checkin" :value="checkin" />
      </div>

      <!-- Divider (desktop only) -->
      <div class="hidden md:flex justify-center items-center">
        <div class="border-r border-black h-8"></div>
      </div>

      <!-- Drop-off Date -->
      <div x-data="{ open: false, checkout: null }" class="relative flex-1 min-w-[200px]">
        <button @click="open = !open" type="button"
          class="flex items-center gap-2 w-full text-left border p-2 rounded">
          <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
          <span x-text="checkout ? new Date(checkout).toLocaleString() : 'Drop-off Date & Time'"
            class="text-gray-800 truncate text-base font-sans"></span>
        </button>
        <div x-show="open" @click.outside="open = false"
          class="absolute z-50 bg-white shadow-xl rounded-xl p-4 mt-2 w-full sm:w-72 max-w-xs right-0 text-gray-800 space-y-2 text-sm">
          <label for="checkout-date" class="block text-sm font-medium text-gray-700 mb-1">Drop Date & Time</label>
          <input type="datetime-local" id="checkout-date" x-model="checkout"
            class="w-full border p-2 rounded outline-none" />
        </div>
        <input type="hidden" name="checkout" :value="checkout" />
      </div>

      <!-- Divider (desktop only) -->
      <div class="hidden md:flex justify-center items-center">
        <div class="border-r border-black h-8"></div>
      </div>

      
      <!-- Submit Button -->
        <div class="flex-shrink-0 w-full md:w-auto md:self-center">
        <button type="submit"
            class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-[10px] rounded-lg text-sm"
            style="background-color:#3CC0E9;">
            Search
        </button>
        </div>

    </div>
  </form>

  <!-- Options below -->
  <div class="relative z-10 mt-4 px-4 max-w-6xl mx-auto text-sm">
    <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
      <label class="flex items-center gap-2">
        <input type="checkbox" id="toggleDropoff" /> Drop car off at different location
      </label>

      <label class="flex items-center gap-2">
        <input type="checkbox" id="toggleAge" /> Driver aged between 30 - 65?
      </label>

      <div id="driverAgeBox" class="hidden flex items-center gap-2">
        <label for="driverAge">Driver’s Age:</label>
        <input type="number" id="driverAge" class="border px-2 py-1 rounded text-sm w-24" placeholder="Age" />
      </div>
    </div>
  </div>
</div>

<!-- Script -->
<script>
  document.getElementById("toggleAge").addEventListener("change", function () {
    const ageBox = document.getElementById("driverAgeBox");
    ageBox.classList.toggle("hidden", !this.checked);
  });

  document.getElementById("toggleDropoff").addEventListener("change", function () {
    const dropoffField = document.getElementById("dropoffField");
    if (this.checked) {
      dropoffField.classList.remove("opacity-50", "pointer-events-none");
      dropoffField.querySelector("button").classList.remove("bg-gray-100");
    } else {
      dropoffField.classList.add("opacity-50", "pointer-events-none");
      dropoffField.querySelector("button").classList.add("bg-gray-100");
    }
  });
</script>



<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Popular car hire brands</h2>

        <!-- Container limited to 50% width with 4 images and gap -->
        <div class="flex gap-x-2 w-[40%]">
            <!-- SR Rent A Car -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/sr.png') }}" alt="SR Rent A Car" class="h-16 w-full object-cover">
            </div>

            <!-- Europcar -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/uro.png') }}" alt="Europcar" class="h-16 w-full object-cover">
            </div>

            <!-- Sixt -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/siz.png') }}" alt="Sixt" class="h-16 w-full object-cover">
            </div>

            <!-- Hertz -->
            <div class="w-1/2 overflow-hidden rounded-md">
                <img src="{{ asset('images/her.png') }}" alt="Hertz" class="h-16 w-full object-cover">
            </div>
        </div>
    </div>
</section>
<section class="scroll-section py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Latest Airport Taxis</h2>
   <p class="mb-8 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Check out our newly added, comfortable, and reliable airport taxis ready for your next ride. <a href="/customer/car-rentals/listing" class="text-blue-500 hover:underline">Show All Car Rentals</a></p>

    <div class="relative">
      <!-- Scroll Container -->
      <div id="scrollContainer" class="scroll-container flex space-x-4 overflow-x-auto pb-2 scroll-smooth no-scrollbar">
    @foreach ($latestActiveCars as $car)
    <div class="bg-white rounded-lg shadow-md overflow-hidden relative min-w-[250px] max-w-[250px] h-[350px]">
        
        <!-- Car Image -->
        <img src="{{ $car->image ? asset('storage/' . $car->image) : asset('images/taxi.jpg') }}" 
             alt="{{ $car->name }}" 
             class="w-full h-48 object-cover">

        <!-- Taxi Info -->
        <div class="p-3">
            <!-- Rating (you can replace with real average rating if available) -->
            <div class="flex items-center mt-2">
                <div class="flex ml-2">
                    @for ($i = 0; $i < 4; $i++)
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 
                            1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 
                            1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-
                            1.538-1.118l1.07-3.293a1 1 0 00-.364-1.118L2.98 
                            8.719c-.783-.57-.38-1.81.588-1.81h3.461a1 1 
                            0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 
                        00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 
                        2.034a1 1 0 00-.364 1.118l1.07 3.293c.3.921-.755 
                        1.688-1.538 1.118l-2.8-2.034a1 1 0 
                        00-1.175 0l-2.8 2.034c-.782.57-1.837-.197-
                        1.538-1.118l1.07-3.293a1 1 
                        0 00-.364-1.118L2.98 
                        8.719c-.783-.57-.38-1.81.588-
                        1.81h3.461a1 1 
                        0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-xs ml-2 block">122 Rides</span>
                </div>
            </div>
  
                           
            <!-- Taxi Name -->
            <h3 class="text-sm font-bold mt-2" style="font-family: 'Noto Sans', sans-serif;">
                {{ $car->brand->brand_name ?? 'Brand' }} {{ $car->model->model_name ?? 'Model' }}
            </h3>
              <h5 class="text-xs font-bold mt-1" style="font-family: 'Noto Sans', sans-serif;">
                {{ $car->number_plate ?? 'Unnamed Car' }} 
            </h5>

            <!-- Capacity Info -->
            <div class="mt-2 text-left flex space-x-4" style="font-family: 'Noto Sans', sans-serif;">
                <p class="text-xs text-gray-500"> {{ $car->fuel_type ?? 'Fuel' }}</p>
                <p class="text-xs text-gray-500">{{ $car->seats ?? 0 }} seats</p>
               
            </div>

            <!-- Book Now Button -->
            <div class="mt-2 text-left">
                <a href="{{ route('customer.car-rentals.show', $car->id) }}"
                   class="bg-[#3CC0E9] text-white text-xs font-semibold px-3 py-1 rounded hover:bg-blue-700">
                    Book Now
                </a>
            </div>
        </div>
    </div>
    @endforeach
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


<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Title -->
        <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 text-center sm:text-left">
            Register Your Car Rental Brand
        </h2>

        <!-- Offer Card -->
        <div class="bg-white p-4 rounded-lg border border-gray-300 flex flex-col sm:flex-row items-center sm:items-start sm:justify-between">
            
            <!-- Text Content -->
            <div class="sm:ml-4 text-center sm:text-left">
                <p class="font-semibold text-gray-800" style="font-family: 'Noto Sans', sans-serif;">
                    Join our platform to showcase your cars and connect with thousands of customers searching for rentals.
                </p>

                <!-- Get Started Now Button -->
                <a href="/choose-option-2">
                    <button class="text-white px-6 py-2 rounded mt-4 font-semibold w-full sm:w-auto"
                            style="font-family: 'Noto Sans', sans-serif; background-color:#3CC0E9;">
                        Get Started Now
                    </button>
                </a>

                <!-- Already Registered Sign In Link -->
                <p class="mt-3 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                    Already registered? 
                    <a href="/choose-option" class="text-blue-600 hover:underline">
                        Sign In
                    </a>
                </p>
            </div>

            <!-- Image -->
            <div class="mt-6 sm:mt-0 sm:ml-6">
                <img src="{{ asset('images/rental.jpg') }}" alt="Offer Image"
                     class="w-full max-w-[250px] h-auto rounded-lg object-cover">
            </div>
        </div>
    </div>
</section>


<section class="scroll-section py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Heading and link -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Travel more, spend less</h2>
            <a href="#" class="text-sm text-[#1F8FB2] hover:underline">Learn more about your rewards</a>
        </div>
    </div>

   <!-- Relative container for arrows and scrolling -->
<div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Scrollable container -->
    <div class="scroll-container flex overflow-x-auto scroll-smooth gap-4 no-scrollbar">
        <!-- Card 1 -->
      <div class="min-w-[260px]">
    <div class="bg-[#1F8FB2] border border-gray-200 rounded-lg shadow-md p-4 h-[9rem] flex flex-col justify-start items-start">
        <span class="text-lg font-bold text-white mb-2" style="font-family: 'Noto Sans', sans-serif;">Genius</span>
        <span class="text-sm text-white mt-1" style="font-family: 'Noto Sans', sans-serif;">
            Dinidu, you’re at <span class="font-bold text-white">Genius Level 1</span> in our loyalty programme
        </span>
    </div>
</div>

      <div class="min-w-[260px]">
    <div class="bg-white border border-[#1F8FB2] rounded-lg shadow-md p-4 h-[9rem] flex flex-col justify-start items-start">
        <!-- Flex container for title and icon -->
        <div class="w-full flex items-center justify-between mb-2">
            <span class="text-base font-bold text-black" style="font-family: 'Noto Sans', sans-serif;">
                10% discounts on stays
            </span>
            <!-- Example SVG icon (e.g., info icon) -->
           <img src="{{ asset('assets/discount.svg') }}" alt="Car" class="w-4 h-4" />
        </div>
        <span class="text-sm text-black mt-1" style="font-family: 'Noto Sans', sans-serif;">
            Enjoy discounts at participating properties worldwide
        </span>
    </div>
</div>


    <div class="min-w-[260px]">
    <div class="bg-white border border-[#1F8FB2] rounded-lg shadow-md p-4 h-[9rem] flex flex-col justify-start items-start">
        <!-- Flex container for title and icon -->
        <div class="w-full flex items-start justify-between mb-2">
            <span class="text-base font-bold text-black leading-snug" style="font-family: 'Noto Sans', sans-serif;">
                10% discounts on rental <br /> cars
            </span>
            <!-- Make sure the SVG is inline or color is set in the SVG file -->
            <img src="{{ asset('assets/car-blue.svg') }}" alt="Car" class="w-4 h-4 mt-1" />
        </div>
        <span class="text-sm text-black mt-1" style="font-family: 'Noto Sans', sans-serif;">
    Enjoy discounts at participating 
properties worldwide
        </span>
    </div>
</div>

   <div class="min-w-[260px]">
    <div class="bg-white border border-[#1F8FB2] rounded-lg shadow-md p-4 h-[9rem] flex flex-col justify-start items-start">
        <!-- Flex container for title and icon -->
        <div class="w-full flex items-start justify-between mb-2">
            <span class="text-base font-bold text-black leading-snug" style="font-family: 'Noto Sans', sans-serif;">
       10% - 15% discounts on 
<br /> stays
            </span>
            <!-- Make sure the SVG is inline or color is set in the SVG file -->
            <img src="{{ asset('assets/lock.svg') }}" alt="Car" class="w-4 h-4 mt-1" />
        </div>
        <span class="text-sm text-black mt-1" style="font-family: 'Noto Sans', sans-serif;">
Enjoy discounts at participating 
properties worldwide
        </span>
    </div>
</div>

  <div class="min-w-[260px]">
    <div class="bg-white border border-[#1F8FB2] rounded-lg shadow-md p-4 h-[9rem] flex flex-col justify-start items-start">
        <!-- Flex container for title and icon -->
        <div class="w-full flex items-start justify-between mb-2">
            <span class="text-base font-bold text-black leading-snug" style="font-family: 'Noto Sans', sans-serif;">
       10% - 15% discounts on 
<br /> stays
            </span>
            <!-- Make sure the SVG is inline or color is set in the SVG file -->
            <img src="{{ asset('assets/lock.svg') }}" alt="Car" class="w-4 h-4 mt-1" />
        </div>
        <span class="text-sm text-black mt-1" style="font-family: 'Noto Sans', sans-serif;">
Enjoy discounts at participating 
properties worldwide
        </span>
    </div>
</div>

    <div class="min-w-[260px]">
    <div class="bg-white border border-[#1F8FB2] rounded-lg shadow-md p-4 h-[9rem] flex flex-col justify-start items-start">
        <!-- Flex container for title and icon -->
        <div class="w-full flex items-start justify-between mb-2">
            <span class="text-base font-bold text-black leading-snug" style="font-family: 'Noto Sans', sans-serif;">
       10% - 15% discounts on 
<br /> stays
            </span>
            <!-- Make sure the SVG is inline or color is set in the SVG file -->
            <img src="{{ asset('assets/lock.svg') }}" alt="Car" class="w-4 h-4 mt-1" />
        </div>
        <span class="text-sm text-black mt-1" style="font-family: 'Noto Sans', sans-serif;">
Enjoy discounts at participating 
properties worldwide
        </span>
    </div>
</div>
    <!-- Left Arrow -->
    <button class="scroll-left hidden absolute top-[42%] left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 ml-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Right Arrow -->
    <button class="scroll-right absolute top-[42%] right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100 mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>
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

<section class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center sm:text-left">
            
            <!-- Item 1 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                <img src="{{ asset('images/profile.png') }}" alt="Support Icon" class="w-12 h-12">
                <div>
                    <h3 class="text-base font-semibold text-gray-900"  style="font-family: 'Noto Sans', sans-serif;">We’re here for you</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Customer support in over 30 languages</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                <img src="{{ asset('images/booking.png') }}" alt="Cancellation Icon" class="w-12 h-12">
                <div>
                    <h3 class="text-base font-semibold text-gray-900"  style="font-family: 'Noto Sans', sans-serif;">Free cancellation</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Up to 48 hours before pick-up, on most bookings</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                <img src="{{ asset('images/hand.png') }}" alt="Reviews Icon" class="w-12 h-12">
                <div>
                    <h3 class="text-base font-semibold text-gray-900"  style="font-family: 'Noto Sans', sans-serif;">5 million+ reviews</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">By real, verified customers</p>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Travel more, spend less</h2>
          
        </div>
    

        <!-- Two column layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>
 <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div> <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div> <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div> <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div> <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div> <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div> <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        How can I contact support?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        You can contact our support team via email at support@example.com.
                    </p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>
                  <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>  <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>  <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                        Can I upgrade my plan later?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer">
                        Absolutely! You can upgrade your plan at any time from your dashboard.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggles = document.querySelectorAll('.toggle-answer');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const answer = toggle.nextElementSibling;
                const icon = toggle.querySelector('svg');
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollSections = document.querySelectorAll('.scroll-section');
        const scrollAmount = 648;

        scrollSections.forEach(section => {
            const scrollContainer = section.querySelector('.scroll-container');
            const scrollLeftBtn = section.querySelector('.scroll-left');
            const scrollRightBtn = section.querySelector('.scroll-right');

            function toggleArrows() {
                const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                scrollLeftBtn.classList.toggle('hidden', scrollContainer.scrollLeft <= 0);
                scrollRightBtn.classList.toggle('hidden', scrollContainer.scrollLeft >= maxScrollLeft - 10);
            }

            scrollLeftBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                setTimeout(toggleArrows, 400);
            });

            scrollRightBtn.addEventListener('click', () => {
                scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                setTimeout(toggleArrows, 400);
            });

            scrollContainer.addEventListener('scroll', toggleArrows);

            toggleArrows();
        });
    });
</script>

<!-- Popular with Travellers -->
<section class="py-12 bg-white" style="margin-bottom: 60px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Popular with travelers from Sri Lanka</h2>

        <!-- Tabs -->
        <div class="flex space-x-4 overflow-x-auto mb-4">
            <button id="tab-domestic" class="rounded-full tab-button active-tab px-4 py-2 bg-blue-600 text-white" onclick="toggleTab('domestic')">Domestic cities</button>
            <button id="tab-international" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('international')">International cities</button>
            <button id="tab-regions" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('regions')">Regions</button>
            <button id="tab-countries" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('countries')">Countries</button>
            <button id="tab-places" class="rounded-full tab-button px-4 py-2 bg-gray-100 text-gray-800" onclick="toggleTab('places')">Places to stay</button>
        </div>

        <!-- Tab Content -->
        <div id="tab-content" class="mt-4 text-sm font-lato">
            <!-- Domestic -->
            <div id="content-domestic" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                @for ($i = 0; $i < 4; $i++)
                    <span>Kandy hotels</span>
                    <span>Nuwara Eliya hotels</span>
                    <span>Colombo hotels</span>
                    <span>Ella hotels</span>
                    <span>Anuradhapura hotels</span>
                @endfor
                <div class="col-span-full text-left mt-2">
                    <button class="text-blue-600">+ Show more</button>
                </div>
            </div>

            <!-- International -->
            <div id="content-international" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Singapore hotels</span>
                <span>Bangkok hotels</span>
                <span>London hotels</span>
                <span>New York hotels</span>
                <span>Dubai hotels</span>
            </div>

            <!-- Regions -->
            <div id="content-regions" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Southern Province</span>
                <span>Central Province</span>
                <span>Western Province</span>
                <span>Eastern Province</span>
                <span>Northern Province</span>
            </div>

            <!-- Countries -->
            <div id="content-countries" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Japan</span>
                <span>United Kingdom</span>
                <span>India</span>
                <span>France</span>
                <span>Germany</span>
            </div>

            <!-- Places -->
            <div id="content-places" class="hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                <span>Luxury Villas</span>
                <span>Hostels</span>
                <span>Budget hotels</span>
                <span>Resorts</span>
                <span>Homestays</span>
            </div>
        </div>
    </div>
</section>
<style>
    .tab-button {
        transition: all 0.2s;
    }

    .active-tab {
        background-color: rgb(37, 99, 235);
        color: white;
    }
</style>
<script>
    function toggleTab(tabName) {
        const panels = document.querySelectorAll('#tab-content > div');
        panels.forEach(panel => panel.classList.add('hidden'));

        const selectedPanel = document.getElementById(`content-${tabName}`);
        if (selectedPanel) selectedPanel.classList.remove('hidden');

        const tabs = document.querySelectorAll('.tab-button');
        tabs.forEach(tab => tab.classList.remove('active-tab', 'bg-blue-600', 'text-white'));
        tabs.forEach(tab => tab.classList.add('bg-gray-100', 'text-gray-800'));

        const selectedTab = document.getElementById(`tab-${tabName}`);
        if (selectedTab) {
            selectedTab.classList.remove('bg-gray-100', 'text-gray-800');
            selectedTab.classList.add('active-tab', 'bg-blue-600', 'text-white');
        }
    }

    // Set default tab
    document.addEventListener('DOMContentLoaded', () => {
        toggleTab('domestic');
    });
</script>


@endsection