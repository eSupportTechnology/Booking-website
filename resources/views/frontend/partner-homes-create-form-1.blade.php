<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>create homes</title></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <!-- Vite assets (optional for Laravel Mix setup) -->
  @vite(['resources/js/app.js'])
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
  <!-- Header -->
  <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
          <!-- Logo -->
          <div class="w-full md:w-auto md:ml-6">
            <a href="/" class="text-2xl font-bold font-poppins">Bookintour.com</a>
          </div>

          <!-- Right Section -->
          <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto font-sans">
            <!-- Help Icon -->
            <a href="/help" title="Help">
              <img src="{{ asset('assets/question.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
            </a>

            <!-- Language Button -->
            <button
              id="language-button"
              type="button"
              class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
              title="Change Language"
            >
              <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
            </button>

            <!-- Language Modal -->
            <div
              id="language-modal"
              class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50"
            >
              <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                <!-- Modal Header -->
                <div class="flex items-start justify-between">
                  <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                  <button
                    type="button"
                    class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                  >
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path
                        fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>

                <!-- Modal Body -->
                <div class="mt-4">
                  <p class="mb-4 text-base text-gray-500">Suggested for you</p>
                  <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                      <img src="https://flagcdn.com/w40/gb.png" alt="English (UK)" class="h-5 w-5" />
                      <span>English (UK)</span>
                    </button>
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                      <img src="https://flagcdn.com/w40/de.png" alt="Deutsch" class="h-5 w-5" />
                      <span>Deutsch</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </header>

  <!--Start Form-->
  <div class="max-w-6xl p-4 ml-14  bg-gray-100" x-data="{ step: 1 }">
  <form method="POST" action="#" class=" p-6 rounded-lg  space-y-6" enctype="multipart/form-data">
      @csrf
    <!-- Progress bar -->
  <div x-show="showProgress" class="flex justify-between mb-6 text-sm font-medium">
    <template x-for="n in 10" :key="n">
      <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
        Step <span x-text="n"></span>
      </div>
    </template>
  </div>

      
<!-- Main Step 1 (How many apartments)-->
<div x-show="step === 1" x-cloak>
   <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow ">
  <div x-data="{ selected: '', sameAddress: 'yes', propertyCount: 2 }" class="max-w-xl mx-auto p-4 space-y-6">
    
    <h2 class="text-2xl font-bold text-center">What can guests book?</h2>

    <!-- Apartment type options -->
    <div class="space-y-4">
      <!-- One apartment -->
      <label
        :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
        class="block rounded p-4 cursor-pointer transition bg-white"
        @click="selected = 'one'"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('images/accomm_single_home@2x (1).png') }}" alt="One Apartment" class="w-8 h-8" />
           <div class="flex flex-col justify-center items-left">
             <span class="text-base font-bold text-gray-800">Entire place</span>
  <span class="text-xs text-gray-800">Guests are able to use the entire place and do not have to share this with the host or other guests.</span>
 
</div>

          </div>
          <template x-if="selected === 'one'">
            <div class="text-blue-600 text-xl font-bold">✔</div>
          </template>
        </div>
        <input type="radio" name="apartment_type" value="one" x-model="selected" class="hidden" />
      </label>

      <!-- Multiple apartments -->
      <label
        :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
        class="block rounded p-4 cursor-pointer transition bg-white"
        @click="selected = 'multiple'"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('images/accomm_private_room@2x.png') }}" alt="Multiple Apartments" class="w-8 h-8" />
           <div class="flex flex-col justify-center items-left">
             <span class="text-base font-bold text-gray-800">A private room</span>
  <span class="text-xs text-gray-800">Guests rent a room within the property. There are common areas that are either shared with the host or other guests.


</span>
 
</div>
          </div>
          <template x-if="selected === 'multiple'">
            <div class="text-blue-600 text-xl font-bold">✔</div>
          </template>
        </div>
        <input type="radio" name="apartment_type" value="multiple" x-model="selected" class="hidden" />
      </label>
    </div>

    
 <!-- Navigation Buttons -->
       <template x-if="step === 1">
    <div class="flex items-center justify-between pt-4">
      <button type="button" @click="step--"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
        ←
      </button>
      <button type="button"
      @click="step = step + 1"
              
              class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"> 
        Continue
      </button>
    </div>
  </template>
  </div>
</div>
  </div>
<!--Main Step 1 End-->

     <!-- Main Step 2 Start -->
<div id="selection-container" x-show="step === 2" x-cloak>
  <div class="container mx-auto px-4 py-8 max-w-6xl">
    <h2 class="text-2xl font-bold mb-8 text-center">
      From the list below, which property category is most similar to your place?
    </h2>

    <div class="bg-white p-6 rounded-lg shadow">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Cards -->
        <div onclick="selectBox(this)" class="relative border rounded p-4 cursor-pointer transition-all duration-200" data-target="section-apartment">
          <div>
            <h3 class="text-base font-bold text-gray-800 mb-4">Apartment</h3>
            <p class="text-sm text-gray-800">
              Furnished and self-catering accommodation available for short- and long-term rental
            </p>
          </div>
          <div class="tick-box hidden absolute top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>

        <div onclick="selectBox(this)" class="relative border rounded p-4 cursor-pointer transition-all duration-200" data-target="section-holiday-home">
          <div>
            <h3 class="text-base font-bold text-gray-800 mb-4">Holiday home</h3>
            <p class="text-sm text-gray-800">
              Free-standing home with private, external entrance and rented specifically for holidays
            </p>
          </div>
          <div class="tick-box hidden absolute top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>

        <div onclick="selectBox(this)" class="relative border rounded p-4 cursor-pointer transition-all duration-200" data-target="section-villa">
          <div>
            <h3 class="text-base font-bold text-gray-800 mb-4">Villa</h3>
            <p class="text-sm text-gray-800">
              Private self-standing and self-catering home with luxury feel
            </p>
          </div>
          <div class="tick-box hidden absolute top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>

         <div onclick="selectBox(this)" class="relative border rounded p-4 cursor-pointer transition-all duration-200" data-target="section-chalet">
          <div>
            <h3 class="text-base font-bold text-gray-800 mb-4">Chalet</h3>
            <p class="text-sm text-gray-800">
   Free-standing home characterised by sloped roof and rented specifically for holidays
            </p>
          </div>
          <div class="tick-box hidden absolute top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>

           <div onclick="selectBox(this)" class="relative border rounded p-4 cursor-pointer transition-all duration-200" data-target="section-holiday-park">
          <div>
            <h3 class="text-base font-bold text-gray-800 mb-4">Holiday park</h3>
            <p class="text-sm text-gray-800">
              Private self-catering residences located on a shared grounds with shared facilities or recreational activities
            </p>
          </div>
          <div class="tick-box hidden absolute top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
           <div onclick="selectBox(this)" class="relative border rounded p-4 cursor-pointer transition-all duration-200" data-target="section-aparthotel">
          <div>
            <h3 class="text-base font-bold text-gray-800 mb-4">Aparthotel</h3>
            <p class="text-sm text-gray-800">
          A self-catering apartment with some hotel facilities like a reception desk
            </p>
          </div>
          <div class="tick-box hidden absolute top-2 right-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>

      </div>
    </div>

    <!-- Help Link -->
    <div class="mt-8 text-left">
      <a href="#" class="text-sm text-blue-500 hover:underline ">
        <i class="fas fa-question-circle mr-1"></i> I don't see my property type on the list
      </a>
    </div>

    <!-- Continue Button -->
    <div class="mt-8 flex justify-end">
      <button id="continueBtn" disabled onclick="navigateToSection()"
        class="px-4 py-2 bg-blue-300 text-white rounded cursor-not-allowed transition-all duration-200">
        Continue
      </button>
    </div>
  </div>
</div>

<!-- Sections to scroll to -->
<div id="section-apartment" class="mt-20 p-8 bg-gray-100 rounded shadow-lg hidden">
  <h3 class="text-xl font-bold mb-4">Apartment Details</h3>
  <p>Details related to apartment...</p>
</div>

<div id="section-holiday-home" class="mt-20 p-8 bg-gray-100 rounded shadow-lg hidden">
  <h3 class="text-xl font-bold mb-4">Holiday Home Details</h3>
  <!-- Main Step 1 (How many apartments)-->
<div x-show="step === 1" x-cloak>
   <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow ">
  <div x-data="{ selected: '', sameAddress: 'yes', propertyCount: 2 }" class="max-w-xl mx-auto p-4 space-y-6">
    
    <h2 class="text-2xl font-bold text-center">How many apartments are you listing?</h2>

    <!-- Apartment type options -->
    <div class="space-y-4">
      <!-- One apartment -->
      <label
        :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
        class="block rounded p-4 cursor-pointer transition bg-white"
        @click="selected = 'one'"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('images/aprt-b.png') }}" alt="One Apartment" class="w-14 h-10" />
            <span class="text-lg text-gray-800">One apartment</span>
          </div>
          <template x-if="selected === 'one'">
            <div class="text-blue-600 text-xl font-bold">✔</div>
          </template>
        </div>
        <input type="radio" name="apartment_type" value="one" x-model="selected" class="hidden" />
      </label>

      <!-- Multiple apartments -->
      <label
        :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
        class="block rounded p-4 cursor-pointer transition bg-white"
        @click="selected = 'multiple'"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <img src="{{ asset('images/aprt-a.png') }}" alt="Multiple Apartments" class="w-14 h-10" />
            <span class="text-lg text-gray-800">Multiple apartments</span>
          </div>
          <template x-if="selected === 'multiple'">
            <div class="text-blue-600 text-xl font-bold">✔</div>
          </template>
        </div>
        <input type="radio" name="apartment_type" value="multiple" x-model="selected" class="hidden" />
      </label>
    </div>

    <!-- Conditional fields for multiple apartments -->
    <div x-show="selected === 'multiple'" x-transition class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
      <h3 class="text-lg font-semibold">Are these properties in the same address or building?</h3>

      <!-- Same address option -->
      <label
        :class="sameAddress === 'yes' ? 'border-blue-600 border-2' : 'border border-gray-300'"
        class="block rounded p-4 cursor-pointer bg-white"
        @click="sameAddress = 'yes'"
      >
        <div class="flex items-center space-x-4">
             <img src="{{ asset('images/accomm_single_address@2x.png') }}" alt="Multiple Apartments" class="w-10 h-10" />
          <span>Yes, these apartments are at the same address or building</span>
        </div>
      </label>

      <!-- Different addresses option -->
      <label
        :class="sameAddress === 'no' ? 'border-blue-600 border-2' : 'border border-gray-300'"
        class="block rounded p-4 cursor-pointer bg-white"
        @click="sameAddress = 'no'"
      >
        <div class="flex items-center space-x-4">
          <img src="{{ asset('images/accomm_multiple_address@2x.png') }}" alt="Multiple Apartments" class="w-14 h-10" />
          <span>No, these apartments are at different addresses or buildings</span>
        </div>
      </label>

      <!-- Number of properties -->
      <div>
        <label class="block font-medium mb-1">Number of properties</label>
        <input
          type="number"
          min="2"
          x-model="propertyCount"
          name="property_count"
          class="border rounded w-24 p-2"
        />
      </div>
    </div>
 <!-- Navigation Buttons -->
       <template x-if="step === 1">
    <div class="flex items-center justify-between pt-4">
      <button type="button" @click="step--"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
        ←
      </button>
      <button type="button"
      @click="step = step + 1"
              
              class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"> 
        Continue
      </button>
    </div>
  </template>
  </div>
</div>
  </div>
<!--Main Step 1 End-->

     <!-- Main Step 2 Start -->
<div x-show="step === 2" x-cloak >
    <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
        <p class="text-base text-gray-600 mb-8">You're listing:</p>

        <!-- Icon -->
        <div class="flex justify-center mb-8">
             <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments" class="w-16 h-16" />
        </div>

        <!-- Heading -->
        <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
            Multiple apartments in the same location where guests can book an entire apartment
        </h2>

        <!-- Description -->
        <p class="text-gray-700 mb-8">Does this sound like your property?</p>

        <!-- Buttons -->
          <template x-if="step === 2">
        <div class="space-y-2">
            <button   @click="step++" class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                Continue
            </button>
            <button   @click="step--" class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                No, I need to make a change
            </button>
        </div>
   </template>
     
    </div>
</div>
<!--Main Step 2 -End-->
    
<!-- Main Step 3 (Where else is your property listed?)-->
<div x-show="step === 3" x-cloak >
  <div x-data="{
      selectedChannels: [],
      get showImportSection() {
        return this.selectedChannels.includes('Airbnb') || this.selectedChannels.includes('Vrbo');
      }
    }"
    class="bg-white max-w-xl w-full p-6 rounded-lg shadow space-y-6">

    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-900">Where else is your property listed?</h2>

    <!-- Info -->
    <p class="text-sm text-gray-700">
      If your property is listed on Airbnb or Vrbo, you can speed up registration by importing it directly to Booking.com.
    </p>

    <!-- Checkboxes -->
    <div class="space-y-4 text-left">
      <label class="flex items-center space-x-3">
        <input type="checkbox" value="Airbnb" x-model="selectedChannels"
               class="form-checkbox h-5 w-5 text-blue-600">
        <span>Airbnb</span>
      </label>
      <label class="flex items-center space-x-3">
        <input type="checkbox" value="TripAdvisor" x-model="selectedChannels"
               class="form-checkbox h-5 w-5 text-blue-600">
        <span>TripAdvisor</span>
      </label>
      <label class="flex items-center space-x-3">
        <input type="checkbox" value="Vrbo" x-model="selectedChannels"
               class="form-checkbox h-5 w-5 text-blue-600">
        <span>Vrbo</span>
      </label>
      <label class="flex items-center space-x-3">
        <input type="checkbox" value="Another" x-model="selectedChannels"
               class="form-checkbox h-5 w-5 text-blue-600">
        <span>Another website</span>
      </label>
      <label class="flex items-center space-x-3 text-gray-400" :class="{ 'text-gray-900': !selectedChannels.length }">
        <input type="checkbox" value="None" x-model="selectedChannels"
               class="form-checkbox h-5 w-5 text-blue-600"
               :disabled="selectedChannels.length > 0">
        <span>My property isn't listed on any other websites</span>
      </label>
    </div>

    <!-- Conditional Airbnb/Vrbo import section -->
    <div x-show="showImportSection" x-transition class="border-t pt-6 space-y-4">
      <h3 class="font-semibold text-gray-800">Import property details from Airbnb or Vrbo</h3>

      <label class="block text-sm font-medium text-gray-700">Paste the link to your Airbnb or Vrbo listing</label>
     <div x-data="{ url: '' }" class="flex gap-2">
    <input 
        type="url" 
        name="import_url"
        x-model="url"
        class="w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
        placeholder="https://www.airbnb.com/rooms/xxxxx or https://www.vrbo.com/xxxxx"
        required
    >
    <button 
        type="button" 
        class="px-4 py-2 rounded" 
        :class="url ? 'bg-blue-500 text-white cursor-pointer hover:bg-[#29ACD5]' : 'bg-gray-300 text-gray-600 cursor-not-allowed'" 
        :disabled="!url"
    >
        Apply
    </button>
</div>

      <p class="text-xs text-gray-600">
        Example links:<br>
        https://www.airbnb.com/rooms/xxxxxxx<br>
        https://www.vrbo.com/xxxxxx
      </p>
      <a href="#" class="text-blue-600 text-sm hover:underline">Where can I find this link?</a>
    </div>

    <!-- Navigation Buttons -->
       <template x-if="step === 3">
    <div class="flex items-center justify-between pt-4">
      <button type="button" @click="step--"
              class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded  ">
        ←
      </button>
<button 
  type="button"
  @click="if(selectedChannels.length > 0) window.location.href='{{ route('partner.apartment.create.2') }}'"
  :disabled="selectedChannels.length === 0"
  :class="selectedChannels.length === 0 
    ? 'bg-gray-300 text-gray-600 cursor-not-allowed' 
    : 'bg-[#3CC0E9] hover:bg-[#29ACD5] text-white cursor-pointer'"
  class="font-semibold py-3 px-6 rounded transition duration-200">
  Continue
</button>

    </div>
  </template>
  </div>
</div>
<!--Main Step 3 End-->


</div>

<div id="section-villa" class="mt-20 p-8 bg-gray-100 rounded shadow-lg hidden">
  <h3 class="text-xl font-bold mb-4">Villa Details</h3>
  <p>Details related to villa...</p>
</div>

<script>
  let selectedBox = null;

  function selectBox(box) {
    if (selectedBox) {
      selectedBox.classList.remove('border-blue-500', 'bg-gray-100');
      selectedBox.querySelector('.tick-box').classList.add('hidden');
    }

    box.classList.add('border-blue-500', 'bg-gray-100');
    box.querySelector('.tick-box').classList.remove('hidden');

    selectedBox = box;

    // Enable Continue button
    const continueBtn = document.getElementById('continueBtn');
    continueBtn.disabled = false;
    continueBtn.classList.remove('bg-blue-300', 'cursor-not-allowed');
    continueBtn.classList.add('bg-blue-500', 'hover:bg-blue-600', 'cursor-pointer');
  }

  function navigateToSection() {
    if (!selectedBox) return;

    // Hide selection container
    document.getElementById('selection-container').style.display = 'none';

    // Hide all sections first
    document.querySelectorAll('[id^="section-"]').forEach(section => {
      section.classList.add('hidden');
    });

    // Show the target section
    const targetId = selectedBox.getAttribute('data-target');
    const targetSection = document.getElementById(targetId);

    if (targetSection) {
      targetSection.classList.remove('hidden');
      targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }
</script>

<!--Main Step 2 -End-->



      




     

     

    
    
    
        


      
       


            

      
      
      </div>
    </form>
  </div>
</body>
</html>
