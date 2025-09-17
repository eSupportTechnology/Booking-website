@extends('frontend.master')

@section('content')
<!-- resources/views/components/airport-taxi-booking.blade.php -->
<section class="py-12 bg-white" 
    x-data="{ isReturnTrip: false, checkin: '', returnDate: '' }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">Book your airport taxi</h1>
        <p class="text-gray-600 mb-6">Easy airport transfers to and from your accommodation</p>

        <!-- Trip type toggle -->
        <div class="flex flex-wrap gap-6 mb-4">
            <label class="inline-flex items-center">
                <input type="radio" name="trip_type" value="one-way" class="form-radio text-blue-500"
                    @click="isReturnTrip = false" checked>
                <span class="ml-2">One-way</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="trip_type" value="return" class="form-radio text-blue-500"
                    @click="isReturnTrip = true">
                <span class="ml-2">Return</span>
            </label>
        </div>

        <!-- Booking form -->
        <form method="GET"
            class="bg-white rounded-xl px-3 py-3 shadow-lg border-4 border-yellow-400 
                   w-full mx-auto text-sm">

            <div class="flex flex-col md:flex-row md:items-center w-full gap-3 md:gap-4">
                

                <!-- Pickup -->
                <div x-data="{ openPickup: false, pickupLocation: '' }" 
                     class="relative flex-1 min-w-0">
                    <button @click="openPickup = !openPickup" type="button"
                        class="flex items-center gap-2 w-full text-left border p-2 rounded">
                        <span x-text="pickupLocation ? pickupLocation : 'Enter pick-up location'"
                            class="text-gray-800 truncate text-base"></span>
                    </button>
                    <div x-show="openPickup" @click.away="openPickup = false"
                        class="absolute z-10 bg-white shadow-lg rounded mt-1 w-full border">
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

                <!-- Arrow -->
                <div class="hidden md:flex items-center justify-center w-auto">
                    <img src="{{ asset('assets/arrows.svg') }}" alt="Arrow" class="w-5 h-5" />
                </div>

                <!-- Destination -->
                <div x-data="{ openDestination: false, destinationLocation: '' }" 
                     class="relative flex-1 min-w-0">
                    <button @click="openDestination = !openDestination" type="button"
                        class="flex items-center gap-2 w-full text-left border p-2 rounded">
                        <span x-text="destinationLocation ? destinationLocation : 'Enter destination'"
                            class="text-gray-800 truncate text-base"></span>
                    </button>
                    <div x-show="openDestination" @click.away="openDestination = false"
                        class="absolute z-10 bg-white shadow-lg rounded mt-1 w-full border">
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

                <!-- Date & Time -->
                <div x-data="{ open: false, checkin: null }" class="relative flex-1 min-w-0">
                    <button @click="open = !open" type="button"
                        class="flex items-center gap-2 w-full text-left border p-2 rounded">
                        <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
                        <span x-text="checkin ? new Date(checkin).toLocaleString() : ' Date & Time'"
                            class="text-gray-800 truncate text-base"></span>
                    </button>
                    <div x-show="open" @click.away="open = false"
                        class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
                        <label for="checkin-date" class="block text-sm font-medium text-gray-700 mb-1">Pick Date & Time</label>
                        <input type="datetime-local" id="checkin-date" x-model="checkin"
                            class="w-full border p-2 rounded outline-none" />
                    </div>
                    <input type="hidden" name="checkin" :value="checkin" />
                </div>

                <!-- Return Date -->
                <div x-data="{ open: false }" 
                     class="relative flex-1 min-w-0"
                     :class="{ 'opacity-50 pointer-events-none': !isReturnTrip }">
                    <button @click="if (isReturnTrip) open = !open" type="button"
                        class="flex items-center gap-2 w-full text-left border p-2 rounded">
                        <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
                        <span x-text="returnDate ? new Date(returnDate).toLocaleString() : 'Return Date and Time'"
                            class="text-gray-800 truncate text-base"></span>
                    </button>
                    <div x-show="open && isReturnTrip" @click.away="open = false"
                        class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
                        <label for="return-date" class="block text-sm font-medium text-gray-700 mb-1">Pick Date & Time</label>
                        <input type="datetime-local" id="return-date" x-model="returnDate"
                            class="w-full border p-2 rounded outline-none" />
                    </div>
                    <input type="hidden" name="return_date" :value="returnDate" />
                </div>

                <!-- Passengers -->
                <div x-data="{ open: false, destination: '' }" class="relative flex-1 min-w-0">
                    <button @click="open = !open" type="button" 
                        class="flex items-center justify-between gap-2 w-full text-left border p-2 rounded">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/user.svg') }}" alt="User" class="w-5 h-5" />
                            <span x-text="destination || '0'" 
                                class="text-gray-800 truncate text-base"></span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-48 right-0 text-gray-800 space-y-2 text-sm">
                        <template x-for="count in [1, 2, 3, 4, 5]" :key="count">
                            <button type="button" 
                                @click="destination = count; open = false"
                                class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                                <span x-text="count"></span>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="users" :value="destination">
                </div>

                <!-- Submit Button -->
                <div class="flex-shrink-0 w-full md:w-auto">
                    <button type="submit"
                        class="w-full h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm"
                        style="background-color:#3CC0E9;">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>



<section class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center sm:text-left">
            
            <!-- Item 1 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <img src="{{ asset('images/aeroplane.png') }}" alt="Support Icon" class="w-14 h-14">
                <div>
                    <h3 class="text-base font-semibold text-gray-900"  style="font-family: 'Noto Sans', sans-serif;">Flight tracking</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Your driver tracks your flight and 
waits for you if it's delayed</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <img src="{{ asset('images/coin.png') }}" alt="Cancellation Icon" class="w-14 h-14">
                <div>
                    <h3 class="text-base font-semibold text-gray-900"  style="font-family: 'Noto Sans', sans-serif;">One clear price</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">Your price is confirmed upfront – no 
extra costs, no cash required
</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <img src="{{ asset('images/profile.png') }}" alt="Reviews Icon" class="w-14 h-14">
                <div>
                    <h3 class="text-base font-semibold text-gray-900"  style="font-family: 'Noto Sans', sans-serif;">Tried and trusted</h3>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">We work with professional drivers 
and have 24/7 customer care</p>
                </div>
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

<section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Title -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Register Your Airport Taxi Service</h2>


            <!-- Offer Card -->
            <div class="bg-white-50 p-2 rounded flex items-center justify-between border border-solid border-gray-300">
                <!-- Text Content -->
                <div class="ml-4">
                    
                    <p class="font-medium font-semibold" style="font-family: 'Noto Sans', sans-serif;"> Join our platform to showcase your airport taxis and connect with thousands of travelers searching for reliable rides.</p>
                   <!-- Get Started Now Button -->
                   <a href="/carrentals/register/details">
                       <button class="text-white px-4 py-1 rounded mt-2 w-auto font-semibold" 
                               style="font-family: 'Noto Sans', sans-serif; background-color:#3CC0E9;">
                           Get Started Now  
                       </button>
                   </a>

<!-- Already Registered Sign In Link -->
<p class="mt-2 text-sm" style="font-family: 'Noto Sans', sans-serif;">
  Already registered? 
  <a href="/car-renter/login/email" class="text-blue-600 hover:underline">
    Sign In
  </a>
</p>

                </div>




                <!-- Image -->
                <img src="{{ asset('images/taxi-airport.jpg') }}" alt="Offer Image" class="w-38 h-32 rounded ml-4">
            </div>
        </div>
    </section>

<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-center mb-12">Airport transfers made easy</h2>

        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-12">
           <!-- Left Column: Steps -->
<div class="flex-1 space-y-10">
    <!-- Step 1 -->
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0 w-[64px] h-[64px] flex items-center justify-center rounded-full">
            <img src="{{ asset('assets/blue-car.svg') }}" alt="Car Icon" class="w-[64px] h-[64px]">
        </div>
        <div class="flex flex-col justify-center">
            <h3 class="text-base font-semibold" style="font-family: 'Noto Sans', sans-serif;">Booking your airport taxi</h3>
            <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                Confirmation is immediate. If your plans change, you can cancel for free up to 24 hours before your scheduled pick-up time.
            </p>
        </div>
    </div>

    <!-- Step 2 -->
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0 w-[64px] h-[64px] flex items-center justify-center rounded-full">
            <img src="{{ asset('assets/yellow-user.svg') }}" alt="Driver Icon" class="w-[64px] h-[64px]">
        </div>
        <div class="flex flex-col justify-center">
            <h3 class="text-base font-semibold" style="font-family: 'Noto Sans', sans-serif;">Meeting your driver</h3>
            <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                You'll be met on arrival and taken to your vehicle. Your driver will track your flight, so they'll wait for you even if it's delayed.
            </p>
        </div>
    </div>

    <!-- Step 3 -->
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0 w-[64px] h-[64px] flex items-center justify-center rounded-full">
            <img src="{{ asset('assets/net.svg') }}" alt="Destination Icon" class="w-[64px] h-[64px]">
        </div>
        <div class="flex flex-col justify-center">
            <h3 class="text-base font-semibold" style="font-family: 'Noto Sans', sans-serif;">Arriving at your destination</h3>
            <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                Get to your destination quickly and safely – no waiting in line for a taxi, no figuring out public transport.
            </p>
        </div>
    </div>
</div>

            <!-- Right Column: Image Map -->
            <div class="flex-1">
                <!-- "How does it work?" Image -->
                <div class="mb-4 text-center">
                    <img src="{{ asset('assets/group320.svg') }}"  alt="How does it work?" class="mx-auto w-40 md:w-28" style="margin-left:90px;">
                </div>

                <!-- Flowchart Image -->
<div class="mb-4 flex justify-center">
    <img src="{{ asset('assets/Page-1.svg') }}" alt="Airport Transfer Map" class="w-[350px] h-[350px] object-contain">
</div>


                <!-- "Enjoy your trip!" Image -->
                <div class="text-center">
                    <img src="{{ asset('assets/Enjoy.svg') }}" alt="Enjoy your trip!" class="mx-auto mt-4 w-40 md:w-24" style="margin-left:90px;margin-top:-12px;">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular with Travellers -->
<section class="py-12 bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-6">Airport taxis for any kind of trip</h1>
       

    <!-- Tabs -->
    <div class="inline-flex mb-6 border border-gray-700 rounded-full overflow-hidden">
  <button id="tab-1-3"
          class="tab-button active-tab px-4 py-2 text-base text-gray-800 bg-white border-r border-gray-300"
          onclick="toggleTab('1-3')">
    1 - 3 passengers
  </button>
  <button id="tab-4-7"
          class="tab-button px-4 py-2 text-base text-gray-800 bg-gray-100 border-r border-gray-300"
          onclick="toggleTab('4-7')">
    4 - 7 passengers
  </button>
  <button id="tab-all"
          class="tab-button px-4 py-2 text-base text-gray-800 bg-gray-100"
          onclick="toggleTab('all')">
    All taxis
  </button>
</div>


    <!-- Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- 1 - 3 passengers -->
 <!-- Content -->
<div id="content-1-3" class="w-full mt-6">
  <div class="flex flex-col md:flex-row gap-6 w-full">
    
    <div class="flex-1 border rounded-lg p-6 shadow-sm bg-white">
      <h3 class="text-lg font-bold mb-2">Standard</h3>
      <p class="text-gray-600 mb-2">Skoda Octavia or similar</p>
      <ul class="text-sm mb-4 space-y-1">
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/vector-user.svg') }}" alt="Passengers" class="w-4 h-4" />
    3 passengers
  </li>
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/bag.svg') }}"alt="Bags" class="w-4 h-4" />
    2 standard bags
  </li>
  <li class="flex items-center gap-2 text-blue-600">
    <img src="{{ asset('assets/border-tick.svg') }}" alt="Check" class="w-4 h-4" />
    Meet &amp; Greet included
  </li>
  <li class="flex items-center gap-2 text-green-600">
    <img src="{{ asset('assets/tick.svg') }}" alt="Check" class="w-4 h-4" />
    Free cancellation
  </li>
</ul>

      <button class="px-4 py-2 bg-sky-500 text-white rounded">Search</button>
    </div>

    <div class="flex-1 border rounded-lg p-6 shadow-sm bg-white">
      <h3 class="text-lg font-bold mb-2">Executive</h3>
      <p class="text-gray-600 mb-2">Mercedes-Benz E-Class or similar</p>
        <ul class="text-sm mb-4 space-y-1">
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/vector-user.svg') }}" alt="Passengers" class="w-4 h-4" />
    3 passengers
  </li>
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/bag.svg') }}"alt="Bags" class="w-4 h-4" />
    2 standard bags
  </li>
  <li class="flex items-center gap-2 text-blue-600">
    <img src="{{ asset('assets/border-tick.svg') }}" alt="Check" class="w-4 h-4" />
    Meet &amp; Greet included
  </li>
  <li class="flex items-center gap-2 text-green-600">
    <img src="{{ asset('assets/tick.svg') }}" alt="Check" class="w-4 h-4" />
    Free cancellation
  </li>
</ul>


      <button class="px-4 py-2 bg-sky-500 text-white rounded">Search</button>
    </div>

  </div>
</div>



      <!-- 4 - 7 passengers -->
      <div id="content-4-7" class="hidden">
        <div class="border rounded-lg p-6 shadow-sm bg-white">
          <h3 class="text-lg font-bold mb-2">Minivan</h3>
          <p class="text-gray-600 mb-2">Toyota Hiace or similar</p>
           <ul class="text-sm mb-4 space-y-1">
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/vector-user.svg') }}" alt="Passengers" class="w-4 h-4" />
    3 passengers
  </li>
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/bag.svg') }}"alt="Bags" class="w-4 h-4" />
    2 standard bags
  </li>
  <li class="flex items-center gap-2 text-blue-600">
    <img src="{{ asset('assets/border-tick.svg') }}" alt="Check" class="w-4 h-4" />
    Meet &amp; Greet included
  </li>
  <li class="flex items-center gap-2 text-green-600">
    <img src="{{ asset('assets/tick.svg') }}" alt="Check" class="w-4 h-4" />
    Free cancellation
  </li>
</ul>


          <button class="px-4 py-2 bg-sky-500 text-white rounded">Search</button>
        </div>
      </div>

      <!-- All taxis -->
<div id="content-all" class="hidden flex flex-row gap-6">
  <div class="border rounded-lg p-6 shadow-sm bg-white flex-1">
    <h3 class="text-lg font-bold mb-2">Standard</h3>
    <p class="text-gray-600 mb-2">Skoda Octavia or similar</p>
     <ul class="text-sm mb-4 space-y-1">
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/vector-user.svg') }}" alt="Passengers" class="w-4 h-4" />
    3 passengers
  </li>
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/bag.svg') }}"alt="Bags" class="w-4 h-4" />
    2 standard bags
  </li>
  <li class="flex items-center gap-2 text-blue-600">
    <img src="{{ asset('assets/border-tick.svg') }}" alt="Check" class="w-4 h-4" />
    Meet &amp; Greet included
  </li>
  <li class="flex items-center gap-2 text-green-600">
    <img src="{{ asset('assets/tick.svg') }}" alt="Check" class="w-4 h-4" />
    Free cancellation
  </li>
</ul>


    <button class="px-4 py-2 bg-sky-500 text-white rounded">Search</button>
  </div>
  <div class="border rounded-lg p-6 shadow-sm bg-white flex-1">
    <h3 class="text-lg font-bold mb-2">Minivan</h3>
    <p class="text-gray-600 mb-2">Toyota Hiace or similar</p>
      <ul class="text-sm mb-4 space-y-1">
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/vector-user.svg') }}" alt="Passengers" class="w-4 h-4" />
    3 passengers
  </li>
  <li class="flex items-center gap-2">
    <img src="{{ asset('assets/bag.svg') }}"alt="Bags" class="w-4 h-4" />
    2 standard bags
  </li>
  <li class="flex items-center gap-2 text-blue-600">
    <img src="{{ asset('assets/border-tick.svg') }}" alt="Check" class="w-4 h-4" />
    Meet &amp; Greet included
  </li>
  <li class="flex items-center gap-2 text-green-600">
    <img src="{{ asset('assets/tick.svg') }}" alt="Check" class="w-4 h-4" />
    Free cancellation
  </li>
</ul>


    <button class="px-4 py-2 bg-sky-500 text-white rounded">Search</button>
  </div>
</div>

    </div>
  </div>
</section>

<script>
  function toggleTab(tabId) {
    const tabs = ['1-3', '4-7', 'all'];
    tabs.forEach(id => {
      const tabButton = document.getElementById('tab-' + id);
      const content = document.getElementById('content-' + id);

      if (tabId === id) {
        tabButton.classList.add('bg-white', 'text-gray-800', 'border', 'border-gray-300', 'border-b-0');
        tabButton.classList.remove('bg-gray-100', 'text-gray-800');
        content.classList.remove('hidden');
      } else {
        tabButton.classList.remove('bg-white', 'border', 'border-gray-300', 'border-b-0');
        tabButton.classList.add('bg-gray-100', 'text-gray-800');
        content.classList.add('hidden');
      }
    });
  }
</script>




<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
<h2 class="text-2xl font-semibold text-gray-800 mb-2">Airport taxis for any kind of trip</h2>
<p class="mb-6 text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
  See more FAQs on our 
  <a href="/help" class="text-sky-500  hover:text-sky-600">help page</a>
</p>
</div>

          
       
    

        <!-- Two column layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>
 <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div> 
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>
                  <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full text-base text-bold flex justify-between items-center text-left  text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        Yes, we offer a 7-day free trial with access to all features.
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

<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <p class="text-gray-700 text-left text-sm leading-relaxed">
      Countries . Regions . Cities . Districts . Airports . Hotels . Places of interest . Holiday Homes . Apartments . Resorts . Villas . Hostels . B&Bs . Guest Houses . Unique places to stay . All destinations . All flight destinations . All car hire locations . All holiday destinations . Guides . Discover . Reviews . Discover monthly stays
    </p>
  </div>
</section>



@endsection