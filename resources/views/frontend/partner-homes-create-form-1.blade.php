<!DOCTYPE html>
<html lang="en" x-data="{ step: 1, selectedBox: null }" xmlns:x-bind="http://www.w3.org/1999/xlink">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>create homes</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
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

  <!-- Start Form -->
  <div class="max-w-6xl p-4 ml-14 bg-gray-100">

    <!-- Step 1: Main Form Step -->
    <form class="p-6 rounded-lg space-y-6" @submit.prevent>
    <div class="flex justify-between mb-6 text-sm font-medium hidden">
  <template x-for="n in 10" :key="n">
    <div :class="step === n ? 'text-blue-600 font-bold' : 'text-gray-400'" class="flex-1 text-center">
      Step <span x-text="n"></span>
    </div>
  </template>
</div>


      <!-- Main Step 1 Content -->
<div x-show="step === 1" x-cloak>
  
    <h2 class="text-2xl font-bold text-left mb-6">What can guests book?</h2>
<div class="bg-white max-w-xl w-full p-6 rounded-lg shadow " x-data="{ selected: '' }">
    <!-- Option 1 -->
    <label
      :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
      class="relative block rounded p-4 cursor-pointer transition bg-white mb-4"
      @click="selected = 'one'"
    >
      <!-- ✔ Tick -->
      <template x-if="selected === 'one'">
        <div class="absolute top-2 right-2 text-blue-600 text-xl font-bold">✔</div>
      </template>

      <div class="flex items-center space-x-4">
        <img src="{{ asset('images/accomm_single_home@2x (1).png') }}" alt="One Apartment" class="w-8 h-8" />
        <div>
          <span class="text-base font-bold text-gray-800">Entire place</span>
          <p class="text-xs text-gray-800">
            Guests are able to use the entire place and do not have to share this with the host or other guests.
          </p>
        </div>
      </div>
      <input type="radio" name="apartment_type" value="one" x-model="selected" class="hidden" />
    </label>

    <!-- Option 2 -->
    <label
      :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
      class="relative block rounded p-4 cursor-pointer transition bg-white"
      @click="selected = 'multiple'"
    >
      <!-- ✔ Tick -->
      <template x-if="selected === 'multiple'">
        <div class="absolute top-2 right-2 text-blue-600 text-xl font-bold">✔</div>
      </template>

      <div class="flex items-center space-x-4">
        <img src="{{ asset('images/accomm_private_room@2x.png') }}" alt="Multiple Apartments" class="w-8 h-8" />
        <div>
          <span class="text-base font-bold text-gray-800">A private room</span>
          <p class="text-xs text-gray-800">
            Guests rent a room within the property. There are common areas that are either shared with the host or other guests.
          </p>
        </div>
      </div>
      <input type="radio" name="apartment_type" value="multiple" x-model="selected" class="hidden" />
    </label>

    <!-- Navigation Buttons -->
    <div class="flex items-center justify-between pt-4">
      <button
        type="button"
        @click="if(step > 1) step--"
        class="border border-[#3CC0E9] text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded"
        :disabled="step === 1"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : ''"
      >
        ←
      </button>
      <button
        type="button"
        @click="if(selected !== '') step = 2"
        class="font-semibold py-3 px-8 rounded bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"
        :disabled="selected === ''"
        :class="selected === '' ? 'opacity-50 cursor-not-allowed' : ''"
      >
        Continue
      </button>
    </div>
  </div>
</div>


      <!-- Step 2: Selection Container -->
      <div id="selection-container" x-show="step === 2" x-cloak class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-2xl font-bold mb-8 text-left">
          From the list below, which property category is most similar to your place?
        </h2>

        <div class="bg-white p-6 rounded-lg shadow">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Cards -->
            <template x-for="(property, index) in [
              { id: 'section-apartment', title: 'Apartment', desc: 'Furnished and self-catering accommodation available for short- and long-term rental' },
              { id: 'section-holiday-home', title: 'Holiday home', desc: 'Free-standing home with private, external entrance and rented specifically for holidays' },
              { id: 'section-villa', title: 'Villa', desc: 'Private self-standing and self-catering home with luxury feel' },
              { id: 'section-chalet', title: 'Chalet', desc: 'Free-standing home characterised by sloped roof and rented specifically for holidays' },
              { id: 'section-holiday-park', title: 'Holiday park', desc: 'Private self-catering residences located on shared grounds with shared facilities or recreational activities' },
              { id: 'section-aparthotel', title: 'Aparthotel', desc: 'A self-catering apartment with some hotel facilities like a reception desk' }
            ]" :key="index">
              <div
                @click="selectedBox = property.id"
                :class="selectedBox === property.id ? 'border-blue-500 bg-gray-100' : 'border border-gray-300'"
                class="relative rounded p-4 cursor-pointer transition-all duration-200"
              >
                <h3 class="text-base font-bold text-gray-800 mb-4" x-text="property.title"></h3>
                <p class="text-sm text-gray-800" x-text="property.desc"></p>

                <div
  class="tick-box absolute top-2 right-2"
  x-show="selectedBox === property.id"
>
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
  </svg>
</div>

              </div>
            </template>
          </div>
        </div>

        <!-- Help Link -->
        <div class="mt-8 text-left">
       <a href="#" class="flex items-center space-x-2 text-sm text-blue-500 hover:underline">
  <img src="{{ asset('assets/iconoir_question-mark-circle.svg') }}" class="w-5 h-5" />
  <span class="text-base">I don't see my property type on the list</span>
</a>

        </div>

             <template x-if="step === 2">
  <div class="flex items-center justify-between pt-4">
    <button type="button"
            @click="step = 1"
            class="border border-[#3CC0E9] text-blue-600  font-semibold py-2 px-4 rounded">
      ← 
    </button>
    <button id="continueBtn"
            @click="if(selectedBox) { step = 3; }"
            :disabled="!selectedBox"
            :class="!selectedBox ? 'bg-blue-300 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-blue-600 cursor-pointer'"
            class="py-3 px-8   rounded transition-all duration-200 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold"
            type="button">
      Continue 
    </button>
  </div>
</template>

     
      </div>

      <!-- Step 3+: Property Details Sections -->
      <template x-if="step === 3">
        <div>
          <!-- Apartment -->
          <section x-show="selectedBox === 'section-apartment'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Apartment Details</h3>
            <p>Details related to apartment...</p>
            <button
              type="button"
              @click="step = 2"
              class="mt-4 bg-gray-300 px-4 py-2 rounded"
            >
              Back
            </button>
          </section>

 <section x-data="wizard()" x-show="selectedBox === 'section-holiday-home'" x-cloak>
  <form class="p-6 rounded-lg" enctype="multipart/form-data" @submit.prevent>
    <!-- Step 1: Choose one or multiple -->
    <template x-if="step === 1">
      <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow space-y-6 ">
        <h2 class="text-xl font-bold text-left">How many holiday homes are you listing?</h2>

        <div class="space-y-4">
          <label :class="selected === 'one' ? 'border-blue-600 border-2' : 'border border-gray-300'"
            class="block rounded p-4 cursor-pointer bg-white"
            @click="selectOption('one')">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <img src="{{ asset('images/aprt-b.png') }}" class="w-14 h-10" />
                <span class="text-lg">One holiday home</span>
              </div>
              <template x-if="selected === 'one'">
                <div class="text-blue-600 text-xl font-bold">✔</div>
              </template>
            </div>
          </label>

          <label :class="selected === 'multiple' ? 'border-blue-600 border-2' : 'border border-gray-300'"
            class="block rounded p-4 cursor-pointer bg-white"
            @click="selectOption('multiple')">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <img src="{{ asset('images/aprt-a.png') }}" class="w-14 h-10" />
                <span class="text-lg">Multiple holiday homes</span>
              </div>
              <template x-if="selected === 'multiple'">
                <div class="text-blue-600 text-xl font-bold">✔</div>
              </template>
            </div>
          </label>
        </div>

        <div x-show="selected === 'multiple'" class="mt-6 space-y-4 bg-gray-50 p-4 rounded">
          <h3 class="text-lg font-semibold">Are these properties in the same address?</h3>

          <label :class="sameAddress === 'yes' ? 'border-blue-600 border-2' : 'border border-gray-300'"
            class="block rounded p-4 cursor-pointer bg-white" @click="sameAddress = 'yes'">
            <div class="flex items-center space-x-4">
              <img src="{{ asset('images/accomm_single_address@2x.png') }}" class="w-10 h-10" />
              <span>Yes, same address or building</span>
            </div>
          </label>

          <label :class="sameAddress === 'no' ? 'border-blue-600 border-2' : 'border border-gray-300'"
            class="block rounded p-4 cursor-pointer bg-white" @click="sameAddress = 'no'">
            <div class="flex items-center space-x-4">
              <img src="{{ asset('images/accomm_multiple_address@2x.png') }}" class="w-14 h-10" />
              <span>No, different addresses or buildings</span>
            </div>
          </label>

          <div>
            <label class="block font-medium mb-1">Number of properties</label>
            <input type="number" min="2" x-model.number="propertyCount" class="border rounded w-24 p-2" />
          </div>
        </div>

        <div class="text-right pt-4">
          <button type="button"
                  @click="nextStep"
                  :disabled="selected === ''"
                  :class="selected === '' ? 'opacity-50 cursor-not-allowed' : ''"
                  class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-3 px-8 rounded">
            Continue 
          </button>
        </div>
      </div>
    </template>

    <!-- Steps 2+ -->
    <template x-if="step > 1">
      <div class=" max-w-2xl">
       

        <div>
          <!-- Steps for 'one' -->
          <template x-if="step === 2 && selected === 'one'">
            <div>
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
            <button  type="button" @click="nextStep" class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
                Continue
            </button>
            <button   type="button" @click="prevStep" class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5]font-semibold py-2 px-4 rounded mb-6">
                No, I need to make a change
            </button>
        </div>
   </template>
     
    </div>
            </div>
          </template>

          <template x-if="step === 3 && selected === 'one'">
            <div>
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
      <button type="button" @click="prevStep" 
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
          </template>

          <template x-if="step === 4 && selected === 'one'">
            <div>
              <h3 class="text-lg font-bold mb-2">Upload Photos</h3>
              <input type="file" multiple class="border p-2 rounded w-full" />
            </div>
          </template>

          <template x-if="step === 5 && selected === 'one'">
            <div>
              <h3 class="text-lg font-bold mb-2">Pricing</h3>
              <input type="number" placeholder="Price per night" class="border p-2 rounded w-full" />
            </div>
          </template>

  <!-- Steps for 'multiple' -->
<template x-if="selected === 'multiple'">
  <div>
   

    <!-- Step 1 -->
    <template x-if="step === 1">
      <div>
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
          <div class="space-y-2">
            <button type="button" @click="nextStep" class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
              Continue
            </button>
            <button type="button" @click="prevStep" class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded mb-6">
              No, I need to make a change
            </button>
          </div>
        </div>
      </div>
    </template>

    <!-- Step 2 -->
    <template x-if="step === 2">
       <div class="bg-white max-w-2xl w-full p-6 rounded-lg shadow text-center">
          <p class="text-base text-gray-600 mb-8">You're listing:</p>

          <!-- Icon -->
          <div class="flex justify-center mb-8">
            <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Multiple Apartments" class="w-16 h-16" />
          </div>

          <!-- Heading -->
          <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-8">
         Multiple holiday homes in the same location where guests can book an entire home
          </h2>

          <!-- Description -->
          <p class="text-gray-700 mb-8">Does this sound like your property?</p>

          <!-- Buttons -->
          <div class="space-y-2">
            <button type="button" @click="nextStep" class="w-full bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded">
              Continue
            </button>
            <button type="button" @click="prevStep" class="w-full border border-[#3CC0E9] text-[#3CC0E9]  font-semibold py-2 px-4 rounded mb-6">
              No, I need to make a change
            </button>
          </div>
        </div>
    </template>

    <!-- Step 3 -->
    <template x-if="step === 3">
      <div>
       <!-- Main Content -->
  <div class="max-w-xl ml-4 mr-auto">
    <!-- White Box -->
    <div class="bg-white shadow-md  p-6 text-left">
      <p class=" text-base text-gray-700">
        Great, since your holiday homes are located at the same address there should be some things that apply to all of them. Let's start filling in those general settings.
      </p>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-6 flex justify-between">
      <button type="button" @click="prevStep" class= "border border-[#3CC0E9]  text-blue-600 hover:bg-[#29ACD5] font-semibold py-2 px-4 rounded">
        ← 
      </button>
      <button type="button" @click="nextStep" class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white">
        Continue 
      </button>
    </div>
  </div>
      </div>
    </template>

    <!-- Step 4 -->
    <template x-if="step === 4">
      <div>
        <div class="relative w-[1400px] h-auto overflow-hidden rounded-lg shadow mx-auto -mt-14 -ml-16">

    <!-- Google Maps iframe full background -->
    <iframe 
      class="absolute inset-0 w-full h-full"
      loading="lazy"
      src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
      allowfullscreen>
    </iframe>

    <!-- Optional overlay for readability -->
    <div class="absolute inset-0"></div>

    <!-- Form content centered on map -->
    <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
      <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>
        <form>
          <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Find your address</label>
            <input type="text" id="address" name="address" value="Sri Lanka" class="mt-1 p-2 w-full border border-gray-300 rounded">
          </div>
          <div class="mb-4">
            <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment or floor number (optional)</label>
            <input type="text" id="apartment" name="apartment" value="aaa" class="mt-1 p-2 w-full border border-gray-300 rounded">
          </div>
          <div class="mb-4">
            <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
            <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
              <option selected>Sri Lanka</option>
            </select>
          </div>
          <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
              <label for="city" class="block text-sm font-medium text-gray-700">City</label>
              <input type="text" id="city" name="city" value="a" class="mt-1 p-2 w-full border border-gray-300 rounded">
            </div>
            <div class="flex-1">
              <label for="postcode" class="block text-sm font-medium text-gray-700">Post code / Zip code</label>
              <input type="text" id="postcode" name="postcode" value="80400" class="mt-1 p-2 w-full border border-gray-300 rounded">
            </div>
          </div>
          <div class="flex items-center mt-4">
            <input id="update_address" type="checkbox" name="update_address" checked class="mr-2">
            <label for="update_address" class="text-sm text-gray-700">Update the address when moving the pin on the map.</label>
          </div>

          <!-- Dismissible message box -->
          <div x-data="{ showMessage: true }" x-show="showMessage" class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Note:</strong>
            <span class="block sm:inline">Make sure the pin location is accurate before continuing.</span>
            <span @click="showMessage = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
              <svg class="fill-current h-6 w-6 text-yellow-800" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"><title>Close</title><path
                  d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/></svg>
            </span>
          </div>

          <p class="text-sm text-gray-600 mt-2">
            Is the red pin location incorrect? Uncheck the option above and click or press on the map to move the pin.
          </p>

         <!-- Buttons -->
<div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
  <button type="button" @click="prevStep"
    class="w-full sm:w-auto border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
    ←
  </button>
  <button type="button" @click="nextStep"
    class="w-full sm:w-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
    Continue
  </button>
</div>


        </form>
      </div>
    </div>
  </div>
      </div>
    </template>

    <!-- Step 5 -->
    <template x-if="step === 5">
      <div>
       <div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a channel manager</h1>

    <!-- Question Section -->
    <div class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
      <h2 class="text-lg font-semibold mb-2">
        Do you want to connect this listing to your channel manager?
      </h2>
      <p class="text-gray-700 mb-6">
        A channel manager is a third-party tool that lets you manage rates and availability across different sites you might list your place on, including Booking.com. If you're already using a channel manager, you can select 'Yes' to connect it to your listing.
      </p>

      <!-- Radio Buttons -->
      <div class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
        <!-- Yes Option -->
        <div>
          <input type="radio" id="yes" name="channel_manager" value="yes"
                 class="mr-2" x-model="channelManager">
          <label for="yes" class="text-gray-700">
            Yes, I will connect this listing to my channel manager
          </label>
        </div>

        <!-- Tooltip only if Yes is selected -->
        <div x-show="channelManager === 'yes'" x-transition>
          <div class="bg-red-100 border border-red-300 rounded p-2 mt-2">
            <div class="flex items-start text-sm text-red-700 space-x-2">
              <img src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}" 
                   alt="Help" 
                   class="w-5 h-5 md:w-6 md:h-6 mt-1" />
              <p>
                Select 'Yes' only if you are already using a channel manager.  
                You'll be able to connect your channel manager after your registration is complete – please continue to the next step.
              </p>
            </div>
          </div>
        </div>

        <!-- No Option -->
        <div>
          <input type="radio" id="no" name="channel_manager" value="no"
                 class="mr-2" x-model="channelManager">
          <label for="no" class="text-gray-700">
            No, I won't be using a channel manager at this time
          </label>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex justify-between mt-6">
        <button type="button" @click="prevStep"
          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
          ←
        </button>
        <button type="button" @click="nextStep"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
          Continue
        </button>
      </div>
    </div>
  </div>
      </div>
    </template>


    <!-- Step 5 -->
    <template x-if="step === 6">
      <div>
         <section class="mb-8">
  <h1 class="text-xl text-gray-700 font-bold mb-4">What can guests use at your place?</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Property Name Input + Checkboxes (2/3 Width) -->
    <div class="md:col-span-2 flex">
      <div class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">
       

        <!-- 9 Checkboxes Section -->
         
        <div class="mt-2">
          <h3 class="text-gray-700 font-semibold mb-2">Select property type(s)</h3>
          <div class="grid grid-cols-1 sm:grid-cols-1 gap-2 text-sm text-gray-700">
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Apartment" class="text-blue-500" />
              <span>Bar</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Villa" class="text-blue-500" />
              <span>Sauna</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Holiday Home" class="text-blue-500" />
              <span>Garden</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Chalet" class="text-blue-500" />
              <span>Terrace</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Cottage" class="text-blue-500" />
              <span>Hot tub/Jacuzzi</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Cabin" class="text-blue-500" />
              <span>Heating</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Bungalow" class="text-blue-500" />
              <span>Free WiFi</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Farm Stay" class="text-blue-500" />
              <span>Air conditioning</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Swimming pool</span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- Tips and Information (1/3 Width) -->
    <div class="flex flex-col gap-4">

      <!-- Tip Box 1 -->
     <div x-data="{ show: true }" x-show="show" class="bg-white p-4 border border-gray-200 rounded w-full md:w-[350px] lg:w-[400px]">

        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center space-x-2">
            <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
            <h3 class="text-gray-700 text-sm text-bold">What if I don’t see a facility I offer?</h3>
          </div>
          <button @click="show = false" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        <p class="text-sm text-gray-700">
          The facilities listed here are the ones most searched for by guests. After you complete your registration, you can add more facilities from a larger list in the extranet, the platform you'll use to manage your property.
          <br>
          The ones selected here will apply to all of your holiday homes.
        </p>
      </div>

    </div>
  </div>

  <!-- Buttons Row (Outside grid, full width) -->
  <!-- Buttons Row aligned with Checkbox Section -->
<div class="flex  mt-6">
        <button type="button" @click="prevStep"
          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
          ←
        </button>
        <button type="button" @click="nextStep"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold  text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[290px]">
          Continue
        </button>
      </div>

</section>
      </div>
    </template>
    <!-- Step 5 -->
    <template x-if="step === 7">
      <div>
      <div class="container mx-auto px-4 py-4 max-w-6xl mb-8">

    <!-- Header -->
    <h2 class="text-2xl font-bold mb-4 text-left ml-6 max-w-xl">
      Services at your property
    </h2>

    <!-- Sections stacked vertically, aligned with header -->
    <div class="max-w-xl ml-6 flex flex-col space-y-8">
      <!-- Breakfast Section -->
      <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg  mb-4 font-bold">Breakfast</h3>
        <hr class="border-gray-300 mb-4" />
        <p class="text-gray-700 mb-2 font-bold text-base">
          Do you serve guests breakfast?
        </p>
        <div class="space-y-2">
          <label class="flex items-center cursor-pointer">
            <input type="radio" name="breakfast" value="yes" class="mr-2" />
            <span>Yes</span>
          </label>
          <label class="flex items-center cursor-pointer">
            <input type="radio" name="breakfast" value="no" class="mr-2" checked />
            <span>No</span>
          </label>
        </div>
      </div>

      <!-- Parking Section -->
      <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-lg  mb-4 font-bold">Parking</h3>
        <hr class="border-gray-300 mb-4" />
        <p class="text-gray-700 mb-2 font-bold">
          Is parking available to guests?
        </p>
        <div class="space-y-2">
          <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="free" class="mr-2" />
            <span>Yes, free</span>
          </label>
          <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="paid" class="mr-2" />
            <span>Yes, paid</span>
          </label>
          <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="no" class="mr-2" checked />
            <span>No</span>
          </label>
        </div>
      </div>
    </div>

    <!-- Navigation Buttons below sections -->
    <div class="mt-8 flex justify-between max-w-xl ml-6">
      <button
       type="button" @click="prevStep"
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
      </button>
      <button
      type="button" @click="nextStep"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
      Continue
      </button>
    </div>
  </div>
      </div>
    </template>
    <!-- Step 5 -->
    <template x-if="step === 8">
      <div>
        <div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <h2 class="text-2xl font-bold mb-8 text-left">
      What languages do you or your staff speak?
    </h2>

    <!-- Language Selection Section -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
      <h3 class="text-lg  mb-4 font-bold">Select languages</h3>
      <div class="space-y-2">
        <label class="flex items-center cursor-pointer">
          <input type="checkbox" class="mr-2" />
          <span>English</span>
        </label>
        <label class="flex items-center cursor-pointer">
          <input type="checkbox" class="mr-2" />
          <span>French</span>
        </label>
        <label class="flex items-center cursor-pointer">
          <input type="checkbox" class="mr-2" />
          <span>German</span>
        </label>
        <label class="flex items-center cursor-pointer">
          <input type="checkbox" class="mr-2" />
          <span>Hindi</span>
        </label>
      </div>

      <!-- Add Additional Languages -->
      <div id="additionalLanguagesSection" class="mt-4 hidden relative">
        <h3 class="text-lg font-medium mb-2 ">Add additional languages</h3>
        
        <!-- Searchable dropdown container -->
        <div class="relative w-full max-w-md">
          <input
            type="text"
            id="languageInput"
            oninput="filterDropdown()"
            onclick="toggleDropdown()"
            placeholder="Search languages..."
            autocomplete="off"
            class="w-full border rounded p-2 pr-10 cursor-pointer"
            readonly
          />
          <!-- Dropdown arrow -->
          <button
            type="button"
            onclick="toggleDropdown()"
            class="absolute right-2 top-2.5 text-gray-600 hover:text-gray-900 focus:outline-none"
            tabindex="-1"
          >
            ▼
          </button>

          <!-- Dropdown list -->
          <ul
            id="languageDropdown"
            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded max-h-40 overflow-auto shadow-lg hidden"
          >
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Arabic</li>
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Bulgarian</li>
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Catalan</li>
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Chinese</li>
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Croatian</li>
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Czech</li>
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Danish</li>
            <li
              class="p-2 hover:bg-blue-100 cursor-pointer"
              onclick="selectLanguage(this)"
            >Dutch</li>
          </ul>
        </div>
      </div>

      <!-- Toggle Button for Additional Languages -->
      <a
        href="#"
        onclick="event.preventDefault(); toggleAdditionalLanguages();"
        class="text-blue-500 hover:underline mt-4 block"
      >
        Add additional languages
      </a>
    </div>

   <!-- Navigation Buttons -->
<div class="mt-8 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="prevStep"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button" @click="nextStep"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
  >
    Continue
  </button>
</div>

  </div>

  <script>
    function toggleAdditionalLanguages() {
      const section = document.getElementById("additionalLanguagesSection");
      section.classList.toggle("hidden");
      if (!section.classList.contains("hidden")) {
        document.getElementById("languageInput").focus();
        showDropdown();
      } else {
        hideDropdown();
      }
    }

    function toggleDropdown() {
      const dropdown = document.getElementById("languageDropdown");
      dropdown.classList.toggle("hidden");
    }

    function showDropdown() {
      document.getElementById("languageDropdown").classList.remove("hidden");
    }

    function hideDropdown() {
      document.getElementById("languageDropdown").classList.add("hidden");
    }

    function filterDropdown() {
      const input = document.getElementById("languageInput");
      const filter = input.value.toLowerCase();
      const ul = document.getElementById("languageDropdown");
      const items = ul.getElementsByTagName("li");
      ul.classList.remove("hidden");
      let visibleCount = 0;
      for (let i = 0; i < items.length; i++) {
        const txtValue = items[i].textContent || items[i].innerText;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
          items[i].style.display = "";
          visibleCount++;
        } else {
          items[i].style.display = "none";
        }
      }
      // Hide dropdown if no matches
      if (visibleCount === 0) {
        ul.classList.add("hidden");
      }
    }

    function selectLanguage(element) {
      const input = document.getElementById("languageInput");
      input.value = element.textContent;
      hideDropdown();
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
      const dropdown = document.getElementById("languageDropdown");
      const input = document.getElementById("languageInput");
      const container = document.getElementById("additionalLanguagesSection");
      if (
        !container.contains(event.target)
      ) {
        hideDropdown();
      }
    });
  </script>
      </div>
    </template>
  <!-- Step 5 -->
<template x-if="step === 9">
  <div>
    <div class="container mx-auto px-4 py-8 max-w-6xl">
      <!-- Header -->
      <h2 class="text-2xl font-bold mb-8 text-left">House rules</h2>

      <div class="flex flex-col md:flex-row gap-6">
        <!-- Left Section -->
        <div class="bg-white shadow-md rounded-lg p-6 w-full md:w-2/3">
          <!-- Toggle Switches -->
          <div class="space-y-4">
            <label class="flex items-center justify-between cursor-pointer">
              <span>Smoking allowed</span>
              <div class="relative">
                <input type="checkbox" class="sr-only peer" />
                <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
              </div>
            </label>

            <label class="flex items-center justify-between cursor-pointer">
              <span>Children allowed</span>
              <div class="relative">
                <input type="checkbox" class="sr-only peer" checked />
                <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
              </div>
            </label>

            <label class="flex items-center justify-between cursor-pointer">
              <span>Parties/events allowed</span>
              <div class="relative">
                <input type="checkbox" class="sr-only peer" />
                <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
              </div>
            </label>
          </div>

 <hr class="my-6 border-t border-gray-300">
          <!-- Pet Policy -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Do you allow pets?</h3>
            <div class="space-y-2">
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="yes" class="mr-2">
                <span>Yes</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="upon_request" class="mr-2">
                <span>Upon request</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="no" class="mr-2" checked>
                <span>No</span>
              </label>
            </div>
          </div>

          <hr class="my-6 border-t border-gray-300">

          <!-- Check-in -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Check in</h3>
            <div class="flex space-x-4">
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">From</label>
                <input type="time" value="15:00" class="w-full border rounded p-2" />
              </div>
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">Until</label>
                <input type="time" value="18:00" class="w-full border rounded p-2" />
              </div>
            </div>
          </div>

          <!-- Check-out -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Check out</h3>
            <div class="flex space-x-4">
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">From</label>
                <input type="time" value="08:00" class="w-full border rounded p-2" />
              </div>
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">Until</label>
                <input type="time" value="11:00" class="w-full border rounded p-2" />
              </div>
            </div>
          </div>
        </div>

        <!-- Right Section: Tip Box -->
        <div x-data="{ show: true }" x-show="show" class="bg-white shadow-md rounded-lg p-6 w-full h-[300px] md:w-1/3 relative">
          <div class="flex justify-between items-start">
            <div class="flex items-center space-x-2">
              <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
              <h3 class="text-gray-800 font-semibold text-base">What if my house rules change?</h3>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <p class="text-sm text-gray-700 mt-3">
            You can easily customise these house rules later and additional house rules can be set on the Policies page of the extranet after you complete registration.
          </p>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="mt-8 flex ">
        <button type="button" @click="prevStep"
          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
          ←
        </button>
        <button type="button" @click="nextStep"
          class="px-6 h-12 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[250px]">
          Continue 
        </button>
      </div>
    </div>
  </div>
</template>


     <template x-if="step === 10">
      <div>
        <!-- Main Content -->
<main class="container mx-auto px-4 py-8 max-w-4xl">
  <h2 class="text-2xl md:text-3xl font-bold mb-6 text-left">
    Host profile
  </h2>

  <div class="bg-white shadow-md rounded-lg p-6 md:p-8">
    <p class="text-gray-700 mb-4 text-sm md:text-base">
      Help your listing stand out by telling potential guests a bit more about yourself, your property and your neighbourhood. This information will be shown on your property page.
    </p>

    <div class="space-y-3">
      <label class="flex items-start sm:items-center cursor-pointer">
        <input type="radio" name="profile-info" value="property" class="mr-3 mt-1 sm:mt-0">
        <span class="text-sm sm:text-base">The property</span>
      </label>

      <label class="flex items-start sm:items-center cursor-pointer">
        <input type="radio" name="profile-info" value="host" class="mr-3 mt-1 sm:mt-0">
        <span class="text-sm sm:text-base">The host</span>
      </label>

      <label class="flex items-start sm:items-center cursor-pointer">
        <input type="radio" name="profile-info" value="neighbourhood" class="mr-3 mt-1 sm:mt-0">
        <span class="text-sm sm:text-base">The neighbourhood</span>
      </label>

      <label class="flex items-start sm:items-center cursor-pointer">
        <input type="radio" name="profile-info" value="later" class="mr-3 mt-1 sm:mt-0" checked>
        <span class="text-sm sm:text-base">None of the above/I'll add these later</span>
      </label>
    </div>
  </div>

  <!-- Navigation Buttons -->
  <div class="mt-8 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="prevStep"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button" @click="nextStep"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
  >
    Continue
  </button>
</div>

</main>
      </div>
    </template>
     <template x-if="step === 11">
      <div>
      <div class="max-w-5xl mx-auto px-4 py-10 space-y-32">
          <section class="mb-8">
  <h1 class="text-2xl text-gray-700 font-bold mb-4">What's the name of your place?</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Property Name Input (2/3 Width) -->
    <div class="md:col-span-2 flex">
      <div class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base ">
        <label for="property_name" class="block text-gray-700">Property name</label>
        <input
          type="text"
          id="property_name"
          name="property_name"
          value="ccc"
          class="w-full h-16 border border-gray-300 rounded p-4 mt-3 text-lg focus:outline-none focus:border-blue-500"
          placeholder="e.g., Sunset Villa"
          required>
      </div>
    </div>

    <!-- Tips and Information (1/3 Width) -->
    <div class="flex flex-col gap-4">

      <!-- Tip Box 1 -->
      <div x-data="{ show: true }" x-show="show" class="bg-white p-4 border border-gray-200 rounded">
        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center space-x-2">
          <img src="{{ asset('assets/ei_like.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
            <h3 class="text-gray-700 text-sm">What should I consider when choosing a name?</h3>
          </div>
          <button @click="show = false" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        <ul class="list-disc pl-5 text-sm text-gray-700">
          <li>Keep it short and catchy</li>
          <li>Avoid abbreviations</li>
          <li>Stick to the facts</li>
        </ul>
      </div>

      <!-- Tip Box 2 -->
      <div x-data="{ show: true }" x-show="show" class="bg-white p-4 border border-gray-200 rounded flex-1">
        <div class="flex items-center justify-between mb-2">
          <div class="flex items-center space-x-2">
      <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
            <h3 class="text-gray-700 text-sm">Why do I need to name my property?</h3>
          </div>
          <button @click="show = false" class="text-gray-500 hover:text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        <p class="text-sm text-gray-700">
          This is the name that will appear as the title of your listing. Be specific and avoid including private details.
        </p>
      </div>

    </div>
  </div>

  <!-- Buttons Row (Outside grid, full width) -->
  <div class="flex justify-between mt-6">
    <!-- Back Button -->
<button
  type="button"
  @click="prevStep"
  class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
  ←
</button>



    <!-- Continue Button -->
   <!-- Continue Button (inside input field container, aligned right) -->
  <div class="flex justify-end mt-4">
    <button
      type="submit"
     @click="nextStep"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
      Continue 
    </button>
  </div>

  </div>
</section>

  </div>
      </div>
      
    </template>
     <template x-if="step === 12">
      <div>
        <!-- AlpineJS is required -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="{ bookingOption: 'instant' }" class="px-4 py-8 max-w-4xl mx-auto space-y-6">

    <h1 class="text-2xl sm:text-3xl font-semibold">How you receive bookings</h1>

    <!-- Safety Info Box -->
    <div class="bg-white border rounded-lg p-6 shadow-sm">
        <h2 class="font-semibold mb-4">We’re here to ensure you can receive bookings safely:</h2>
        <ul class="space-y-2 text-gray-700">
            <li class="flex items-start"><span class="text-green-600 font-bold mr-2">✓</span> Set house rules guest must agree to before they stay</li>
            <li class="flex items-start"><span class="text-green-600 font-bold mr-2">✓</span> Request damage deposits for extra security</li>
            <li class="flex items-start"><span class="text-green-600 font-bold mr-2">✓</span> Report guest misconduct if something goes wrong</li>
            <li class="flex items-start"><span class="text-green-600 font-bold mr-2">✓</span> Receive protection against liability claims from guests and neighbours up to US$1,000,000 for every reservation</li>
        </ul>
    </div>

    <!-- Booking Option Box -->
    <div class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
        <h2 class="font-semibold">How can guests book your holiday home?</h2>

        <div class="space-y-3 text-sm sm:text-base text-gray-700">
            <label class="flex items-start space-x-2">
                <input type="radio" name="booking_option" value="instant" x-model="bookingOption" class="mt-1 accent-blue-600">
                <div>
                    <span>All guests can book instantly</span>
                    <span class="text-green-600 text-sm ml-2 font-medium bg-green-50 px-2 py-0.5 rounded">Recommended</span>
                </div>
            </label>

            <label class="flex items-start space-x-2">
                <input type="radio" name="booking_option" value="request" x-model="bookingOption" class="mt-1 accent-blue-600">
                <span>All guests will need to request to book</span>
            </label>
        </div>

        <!-- Conditional Info Box -->
        <div x-show="bookingOption === 'request'" x-transition class="mt-4 space-y-4 text-sm sm:text-base">
            <div class="border border-gray-300 bg-gray-50 p-4 rounded-lg">
                <div class="flex items-start space-x-2">
                    <span class="text-gray-600 mt-0.5">ℹ️</span>
                    <div class="text-gray-700">
                        <p class="mb-2 font-medium">When using request to book, the booking process will be as follows:</p>
                        <ol class="list-decimal ml-6 space-y-1">
                            <li>Guests who want to make a booking with a check-in that is more than 48 hours in the future will be able to find your holiday home and send a booking request</li>
                            <li>You’ll have 24 hours to accept or decline the request</li>
                            <li>Guests will have 24 hours to finish their booking and confirm their stay</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="border border-orange-300 bg-orange-50 p-4 rounded-lg">
                <p class="text-orange-800 font-semibold">Are you sure you want to require your guests to request to book?</p>
                <p class="text-orange-800 mt-1">
                    Properties that require Request to book have fewer confirmed bookings and a longer time until their first booking. They also require more operational workload, as you’ll need to respond to each request.
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-8 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="prevStep"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button" @click="nextStep"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
  >
    Continue
  </button>
</div>

</div>

      </div>
    </template>
       <template x-if="step === 13">
      <div>
        <!-- Include Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="{ type: '' }" class="px-4 py-8 max-w-3xl mx-auto space-y-6">

    <h1 class="text-2xl sm:text-3xl font-semibold">Partner verification</h1>

    <!-- Instruction + Select Box -->
    <div class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
        <p class="text-gray-700">
            In order to comply with various legal and regulatory requirements, we need to collect and verify some information about you and your property.
        </p>

        <label class="block font-medium text-gray-800">
            Is the accommodation owned by an individual or a business entity?
        </label>
        <select x-model="type" class="mt-2 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select an option</option>
            <option value="individual">I am an individual running a business</option>
            <option value="business">I represent a business entity</option>
        </select>
    </div>

    <!-- Individual Form -->
    <div x-show="type === 'individual'" x-transition class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-semibold text-gray-800">Individual Details</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm text-gray-700">Full Name</label>
                <input type="text" class="w-full mt-1 border rounded px-3 py-2" placeholder="Enter your full name">
            </div>
            <div>
                <label class="block text-sm text-gray-700">National ID or Passport</label>
                <input type="text" class="w-full mt-1 border rounded px-3 py-2" placeholder="Enter ID number">
            </div>
        </div>
    </div>

    <!-- Business Form -->
    <div x-show="type === 'business'" x-transition class="bg-white border rounded-lg p-6 shadow-sm space-y-4">
        <h2 class="text-lg font-semibold text-gray-800">Business Entity Details</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm text-gray-700">Company Name</label>
                <input type="text" class="w-full mt-1 border rounded px-3 py-2" placeholder="Enter company name">
            </div>
            <div>
                <label class="block text-sm text-gray-700">Business Registration Number</label>
                <input type="text" class="w-full mt-1 border rounded px-3 py-2" placeholder="Enter registration number">
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-8 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="prevStep"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button" @click="nextStep"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
  >
    Continue
  </button>
</div>

</div>

      </div>
    </template>
       <template x-if="step === 14">
      <div>
        <h3 class="text-lg font-bold mb-2">Upload Additional Documents</h3>
        <input type="file" multiple class="border p-2 rounded w-full" />
      </div>
    </template>
  </div>
</template>




 
        </div>

       
      </div>
    </template>
  </form>

  <script>
    function wizard() {
      return {
        step: 1,
        selectedBox: 'section-holiday-home', // Ensure this matches to show this section
        selected: '',
        sameAddress: '',
        propertyCount: 2,
        totalSteps: 14, // Adjust total steps as needed

        selectOption(option) {
          this.selected = option;
          // Reset step if needed
          this.step = 1;
        },

        nextStep() {
          // Simple validation: only proceed if selected is set
          if (this.step === 1 && this.selected === '') return;

          if (this.step < this.totalSteps) {
            this.step++;
          }
        },

        prevStep() {
          if (this.step > 1) {
            this.step--;
          }
        }
      }
    }
  </script>
</section>



          <!-- Villa -->
          <section x-show="selectedBox === 'section-villa'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Villa Details</h3>
            <p>Details related to villa...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>

          <!-- Chalet -->
          <section x-show="selectedBox === 'section-chalet'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Chalet Details</h3>
            <p>Details related to chalet...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>

          <!-- Holiday Park -->
          <section x-show="selectedBox === 'section-holiday-park'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Holiday Park Details</h3>
            <p>Details related to holiday park...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>

          <!-- Aparthotel -->
          <section x-show="selectedBox === 'section-aparthotel'" class="mt-20 p-8 bg-gray-100 rounded shadow-lg">
            <h3 class="text-xl font-bold mb-4">Aparthotel Details</h3>
            <p>Details related to aparthotel...</p>
            <button type="button" @click="step = 2" class="mt-4 bg-gray-300 px-4 py-2 rounded">Back</button>
          </section>
        </div>
      </template>
    </form>
  </div>

</body>
</html>
