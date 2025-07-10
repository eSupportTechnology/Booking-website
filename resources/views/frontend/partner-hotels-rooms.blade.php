<!DOCTYPE html>
<html lang="en" x-data="{ step: 1 }">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>9-Step Wizard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
 <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <style>
    body { font-family: 'Noto Sans', sans-serif; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
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
  <!-- Progress Bar -->
  <div class="w-full bg-gray-200 h-2">
    <div class="bg-blue-600 h-2 transition-all duration-500"
         :style="'width:' + (step * 100 / 9) + '%'"></div>
  </div>

  <!-- Step Content Wrapper -->
  <div x-data>
    
    <template x-if="step === 1">
   <form class="p-4 space-y-6 mt-8 ml-">


       
 <!-- Section Title -->
        <h2 class="text-2xl font-bold ml-32">Room Details</h2>
       <!-- Unit Type + Count Section -->
<div class="w-full max-w-xl bg-white rounded-lg border border-gray-200 p-4 shadow-sm ml-32">

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    
    <!-- Unit Type -->
  <div class="w-[500px]">
  <label class="block text-sm font-semibold text-gray-700 mb-1">What type of unit is this?</label>
  <select class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 px-3 py-2">
    <option>Double</option>
    <option>Single</option>
    <option>Suite</option>
  </select>
</div>


<br>
    <!-- Room Count -->
    <div>
  <label class="block text-sm font-semibold text-gray-700 mb-1 whitespace-nowrap">
  How many rooms of this type do you have?
</label>

      <input 
        type="number"
        min="1"
        step="1"
        inputmode="numeric"
        pattern="\d*"
        x-model="propertyCount"
        name="property_count"
        class="w-[40%] border border-gray-300 rounded-md shadow-sm px-3 py-2"
      />
    </div>

  </div>
</div>


 <!-- Horizontal Layout Container -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

  <!-- Bed Types Container (2/3 width) -->
<div x-data="{ showMoreBeds: false }" class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ml-32">
  <label class="block font-medium text-gray-700 mb-2">Which beds are available in this room?</label>

 @php
    $mainBeds = [
        ['label' => 'Twin bed(s)', 'desc' => '35–51 inches wide'],
        ['label' => 'Full bed(s)', 'desc' => '52–59 inches wide'],
        ['label' => 'Queen bed(s)', 'desc' => '60–70 inches wide'],
        ['label' => 'King bed(s)', 'desc' => '71–81 inches wide'],
    ];

    $extraBeds = [
        ['label' => 'Bunk bed', 'desc' => 'Varying sizes'],
        ['label' => 'Sofa bed', 'desc' => 'Varying sizes'],
        ['label' => 'Futon bed(s)', 'desc' => 'Varying sizes'],
    ];
@endphp


@foreach ($mainBeds as $bed)
  @php
      $labelLower = strtolower($bed['label']);
      $icon = 'famicons_bed.svg'; // default

      if (str_contains($labelLower, 'sofa')) {
          $icon = 'famicons_sofa.svg';
      } elseif (str_contains($labelLower, 'bunk')) {
          $icon = 'famicons_bunk-bed.svg';
      }
  @endphp

  <div x-data="{ guests: 0 }" class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
    <div class="flex items-start gap-2">
      <img src="{{ asset('assets/' . $icon) }}" alt="Icon" class="w-5 h-5" />

      <div>
        <p class="text-sm font-medium">{{ $bed['label'] }}</p>
        <p class="text-xs text-gray-500">{{ $bed['desc'] }}</p>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <button type="button" @click="if (guests > 0) guests--"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
      <span class="mx-4 text-sm font-semibold" x-text="guests"></span>
      <button type="button" @click="guests++"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
    </div>
  </div>
@endforeach






  <!-- Toggle Link -->
  <button type="button"
          @click="showMoreBeds = !showMoreBeds"
          class="text-sm text-blue-600 hover:underline focus:outline-none">
    <span x-show="!showMoreBeds">More bed options ▼</span>
    <span x-show="showMoreBeds">Fewer bed options ▲</span>
  </button>

  <!-- Extra Beds -->
  <div x-show="showMoreBeds"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 max-h-0"
       x-transition:enter-end="opacity-100 max-h-screen"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100 max-h-screen"
       x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
       class="space-y-4 pt-2">
@foreach ($extraBeds as $bed)
  @php
      $labelLower = strtolower($bed['label']);
      $icon = 'famicons_bed.svg'; // default

      if (str_contains($labelLower, 'sofa')) {
          $icon = 'mdi_sofa.svg';
      } elseif (str_contains($labelLower, 'bunk')) {
          $icon = 'mdi_bunk-bed.svg';
      }
  @endphp

  <div x-data="{ guests: 0 }" class="flex items-center justify-between border rounded-md px-3 py-2 mb-2">
    <div class="flex items-start gap-2">
      <img src="{{ asset('assets/' . $icon) }}" alt="Icon" class="w-5 h-5" />

      <div>
        <p class="text-sm font-medium">{{ $bed['label'] }}</p>
        <p class="text-xs text-gray-500">{{ $bed['desc'] }}</p>
      </div>
    </div>

    <div class="flex items-center gap-2">
      <button type="button" @click="if (guests > 0) guests--"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">−</button>
      <span class="mx-4 text-sm font-semibold" x-text="guests"></span>
      <button type="button" @click="guests++"
              class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
    </div>
  </div>
@endforeach

  </div>
</div>


  
<!-- Tip Box Container (1/3 width) -->
<div x-data="{ showTip: true }" x-show="showTip"
     x-transition:leave="transition ease duration-300"
     x-transition:leave-start="opacity-100 max-h-screen"
     x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
     class="bg-white border border-gray-300 rounded-lg p-4 text-sm text-gray-700 h-fit max-w-[300px] -ml-64">
     
  <!-- Header Row -->
  <div class="flex items-center justify-between mb-2">
    <div class="flex items-center space-x-2">
      <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
           alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
      <h3 class="text-gray-700 text-sm font-bold">Do you offer other sleeping arrangements?</h3>
    </div>
    <button @click="show = false" class="text-gray-500 hover:text-gray-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd" />
      </svg>
    </button>
  </div>

  <!-- Text Content Column -->
  <div class="flex flex-col gap-4">
    <p class="text-xs text-gray-700">
      Right now, you just need to add your basic sleeping arrangements.
      Cots, additional beds and other sleeping arrangements can be added in the extranet, the platform you’ll use to manage your property.
    </p>

    <h3 class="text-gray-700 text-sm font-bold">Do you have specific policies for children?</h3>

    <p class="text-xs text-gray-700">
      You can set up your property’s child policies, including maximum age and price adjustments, in the extranet after you finish registration.
    </p>
  </div>
</div>



<div x-data="{ guests: 2 }" class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ml-32">
  <label class="block font-semibold text-sm text-gray-700 mb-2">How many guests can stay in this room?</label>

  <div class="flex items-center w-20 border rounded-md px-2 py-1">
    <button 
      type="button" 
      @click="if (guests > 1) guests--" 
      class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none"
    >−</button>

    <span class="mx-4 text-lg font-semibold" x-text="guests"></span>

    <button 
      type="button" 
      @click="guests++" 
      class="text-xl text-gray-600 hover:text-gray-800 focus:outline-none"
    >+</button>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>




   

      <!-- Room Size -->
<div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ml-32">
  <div class="flex flex-col lg:flex-row gap-4 items-end"> <!-- ensure vertical alignment -->
    
    <!-- Apartment Size Dropdown -->
    <div class="w-full lg:w-2/4">
  <label class="block font-semibold text-sm text-gray-700 mb-1">How big is this room?</label>
  <p class="text-xs text-gray-500 ">Apartment size - optional</p>
 
      <select class="w-full  border border-gray-300 rounded-md shadow-sm text-sm mt-2">
  <option></option>
  <option></option>
</select>

</div>

    <!-- Size Unit Dropdown -->
    <div class="w-full lg:w-1/4">
      <label class="block text-sm text-transparent mb-1">Unit</label> <!-- invisible label for spacing -->
      <select class="w-full bg-gray-300 text-black border border-gray-300 rounded-md shadow-sm text-sm mt-2">
        <option>square meters</option>
        <option>square feet</option>
      </select>
    </div>
    
  </div>
    </div>
        <!-- Smoking Allowed -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 max-w-xl ml-32">
            <label class="block font-semibold text-sm text-gray-700 mb-1">Is smoking allowed in this room?</label>
            <div class="flex gap-6 mt-1">
                <label class="inline-flex items-center">
                    <input type="radio" name="smoking" class="form-radio text-blue-500" checked>
                    <span class="ml-2">Yes</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="smoking" class="form-radio text-blue-500">
                    <span class="ml-2">No</span>
                </label>
            </div>
        </div>


        
       <!-- Navigation Buttons -->
<div class="lg:col-span-2  max-w-xl ml-32">
  <div class="flex justify-between mt-6">
    
    <!-- Back Button (Left-aligned) -->
    <button type="button"
      @click="step > 1 ? step-- : step"
      :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
      class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded">
      ←
    </button>

    <!-- Continue Button (Right-aligned) -->
    <button type="submit"
      @click="step < 9 ? step++ : step"
      :disabled="step === 9"
      class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
      Continue
    </button>

  </div>
</div>

    </form>
</template>





   <template x-if="step === 2">
  <div class="max-w-3xl ml-32 mt-16">
    <!-- Bathroom Details Wrapper -->
    <div class="max-w-6xl mx-auto p-4 space-y-6">
      
      <!-- Title -->
      <h2 class="text-2xl font-bold">Bathroom details</h2>

      <!-- Two-Column Layout: Main Content + Tip -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Content Container -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg border border-gray-300 space-y-6">

          <!-- Bathroom Privacy -->
          <div>
            <label class="block font-semibold text-gray-700 mb-3">Is the bathroom private?</label>
            <div class="space-y-2">
              <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="bathroom_private" class="form-radio text-blue-500" checked>
                <span class="text-sm">Yes</span>
              </label>
              <label class="flex items-center gap-3 cursor-pointer">
                <input type="radio" name="bathroom_private" class="form-radio text-blue-500">
                <span class="text-sm">No, it's shared</span>
              </label>
            </div>
          </div>

          <!-- Bathroom Amenities -->
          <div>
            <hr class="my-4">
            <label class="block font-semibold text-gray-700 mb-3">Which bathroom items are available in this room?</label>

            @php
              $amenities = [
                  'Toilet paper', 'Shower', 'Toilet', 'Hairdryer',
                  'Bath', 'Free toiletries', 'Bidet',
                  'Slippers', 'Bathrobe', 'Spa bath',
              ];
            @endphp

            <div class="space-y-2">
              @foreach($amenities as $item)
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="checkbox" class="form-checkbox text-blue-500">
                  <span class="text-sm">{{ $item }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Tip Box Outside of Main Box -->
        <div x-data="{ showTip: true }" x-show="showTip"
             x-transition:leave="transition ease duration-300"
             x-transition:leave-start="opacity-100 max-h-screen"
             x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
             class="bg-white border border-gray-300 rounded-lg p-4 text-sm text-gray-700 h-fit">
          <div class="flex justify-between items-start">
            <!-- Icon + Text -->
    <div class="flex items-center gap-2">
      <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Tip Icon" class="w-5 h-5" />
      <strong class="font-semibold">Still deciding?</strong>
    </div>
            <button type="button" @click="showTip = false"
                    class="text-gray-400 hover:text-black text-sm font-bold text-xl leading-none">
              &times;
            </button>
          </div>
          <p class="mt-2">Don’t worry, you can update the bathroom items available at your place later.</p>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex  mt-6">
        <!-- Back Button -->
        <button type="button" @click="step < 9 ? step-- : step"
                class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded hover:bg-blue-50">
          ←
        </button>

        <!-- Continue Button -->
        <button type="submit"  @click="step < 9 ? step++ : step"
                class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[316px]">
          Continue
        </button>
      </div>
    </div>
  </div>
</template>


    <template x-if="step === 3">
    <div class="max-w-3xl ml-32 mt-16">
    <!-- Bathroom Details Wrapper -->
    <div class="max-w-6xl mx-auto p-4 space-y-6">
      
      <!-- Title -->
      <h2 class="text-2xl font-bold">What can guests use in this room?</h2>

      <!-- Two-Column Layout: Main Content + Tip -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Content Container -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg border border-gray-300 space-y-6">

         

          <!-- Bathroom Amenities -->
          <div>
          
            <label class="block font-semibold text-sm text-gray-700 mb-3">General Amenities</label>

            @php
              $amenities = [
                  'Clothes rack', 'Flat-screen TV', 'Air conditioning', 'Linen',
                  'Desk', 'Wake-up service', 'Towels',
                  'Wardrobe or closet','Heating', 'Fan', 'Safety deposit box','Towels/sheets (extra fee)','Entire unit located on ground floor',
              ];
            @endphp

            <div class="space-y-2">
              @foreach($amenities as $item)
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="checkbox" class="form-checkbox text-blue-500">
                  <span class="text-sm">{{ $item }}</span>
                </label>
              @endforeach
            </div>
          </div>

             <div>
           <hr class="my-4">
            <label class="block font-semibold text-sm text-gray-700 mb-3">Outdoors and Views</label>

            @php
              $amenities = [
                  'Balcony', 'Terrace', 'View',
                 
              ];
            @endphp

            <div class="space-y-2">
              @foreach($amenities as $item)
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="checkbox" class="form-checkbox text-blue-500">
                  <span class="text-sm">{{ $item }}</span>
                </label>
              @endforeach
            </div>
          </div>
           <div>
           <hr class="my-4">
            <label class="block font-semibold text-sm text-gray-700 mb-3">Food and Drink</label>

            @php
              $amenities = [
                  'Electric kettle', 'Tea/Coffee maker', 'Dining area','Dining table','Microwave',
                 
              ];
            @endphp

            <div class="space-y-2">
              @foreach($amenities as $item)
                <label class="flex items-center gap-3 cursor-pointer">
                  <input type="checkbox" class="form-checkbox text-blue-500">
                  <span class="text-sm">{{ $item }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Tip Box Outside of Main Box -->
        <div x-data="{ showTip: true }" x-show="showTip"
             x-transition:leave="transition ease duration-300"
             x-transition:leave-start="opacity-100 max-h-screen"
             x-transition:leave-end="opacity-0 max-h-0 overflow-hidden"
             class="bg-white border border-gray-300 rounded-lg p-4 text-sm text-gray-700 h-fit">
          <div class="flex justify-between items-start">
          <div class="flex items-center gap-2">
      <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Tip Icon" class="w-5 h-5" />
      <strong class="font-semibold">Still deciding?</strong>
    </div>
            <button type="button" @click="showTip = false"
                    class="text-gray-400 hover:text-black text-sm font-bold text-xl leading-none">
              &times;
            </button>
          </div>
          <p class="mt-2">Don’t worry, you can update the bathroom items available at your place later.</p>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex  mt-6">
        <!-- Back Button -->
        <button type="button"  @click="step < 9 ? step-- : step"
                class="border border-[#3CC0E9] text-blue-600 font-semibold py-2 px-4 rounded hover:bg-blue-50">
          ←
        </button>

        <!-- Continue Button -->
        <button type="submit"  @click="step < 9 ? step++ : step"
                class="px-6 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[315px]">
          Continue
        </button>
      </div>
    </div>
  </div>
    </template>
<template x-if="step === 4">
  <div class="max-w-3xl ml-40 px-4 py-8 mt-10">
    <section class="mb-8">
      <h1 class="text-2xl text-gray-700 font-bold mb-4">What’s the name of this room?</h1>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

        <!-- Left Box (2/3 width) -->
        <div class="md:col-span-2">
          <div class="bg-white p-6 rounded shadow-md min-h-[450px] flex flex-col justify-start">
            <div class="w-full">
              <p class="text-base mb-4">
              This is the name that guests will see on your property page. Choose a name that most accurately describes this room.
              </p>
              <label class="block text-sm font-semibold text-gray-700 mb-1 mt-6">Room Name</label>
              <select class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 px-3 py-2">
                <option>Double</option>
                <option>Single</option>
                <option>Suite</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Tip Box (1/3 width) -->
        <div class="flex flex-col gap-4">
          <div x-data="{ show: true }" x-show="show"
               class="bg-white p-4 border border-gray-200 rounded w-full md:w-[300px] lg:w-[350px]">
            <div class="flex items-center justify-between mb-2">
              <div class="flex items-center space-x-2">
                <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                     alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                <h3 class="text-gray-700 text-sm font-bold">Why can't I use a custom room name?</h3>
              </div>
              <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
              </button>
            </div>
           <p class="text-sm text-gray-700">
  Standardised room names have a lot of benefits over custom names:
</p>
<ul class="list-disc pl-6 text-sm text-gray-700 mt-2">
  <li>They’re more descriptive</li>
  <li>They're consistent across the site, allowing guests to quickly find and compare rooms</li>
  <li>They’re understood by guests from all backgrounds and nationalities</li>
  <li>They’re translated into 43 languages</li>
</ul>
<p class="text-sm text-gray-700 mt-4">
  After registration, you’ll have the option to add custom room names. Guests won’t see these, but they can be used for your internal reference.
</p>

          </div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex mt-6">
        <button type="button"
                @click="step > 1 ? step-- : step"
                :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
          ←
        </button>
        <button type="button"
                @click="step < 9 ? step++ : step"
                class="ml-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[335px]">
          Continue
        </button>
      </div>
    </section>
  </div>
</template>


  <template x-if="step === 5">
      <div class="max-w-3xl ml-40 px-4 py-8 mt-6">
    <div class="max-w-4xl mx-auto px-4 py-8 space-y-6" x-data="{ showTip1: true, showTip2: true }">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-800">Set the price per night for this room</h2>

        <!-- Price input and info box -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Price input card -->
            <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-4">
                <label class="block font-medium text-gray-700">How much do you want to charge per night?</label>
                <div class="relative">
                    <input type="text" value="US$ 120.00" class="w-full border rounded-md p-3 text-gray-700 font-semibold focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                    <p class="text-sm text-gray-500 mt-2">Including taxes, commission, and fees</p>
                </div>

                <ul class="text-sm text-gray-600 space-y-1">
                    <li><span class="text-green-600 font-semibold">✓</span> 15.00% Booking.com commission</li>
                    <li><span class="text-green-600 font-semibold">✓</span> 24/7 help in your language</li>
                    <li><span class="text-green-600 font-semibold">✓</span> Save time with automatically confirmed bookings</li>
                    <li><span class="text-green-600 font-semibold">✓</span> We promote your place on Google</li>
                </ul>

                <p class="text-sm text-gray-800 font-medium border-t pt-3">US$ 102.00 Your earnings (including taxes)</p>
            </div>

            <!-- Tip Box 1 -->
            <div x-show="showTip1" class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
                <button @click="showTip1 = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                    ✕
                </button>
                <strong class="block mb-2">💡 What if I’m not sure about my price?</strong>
                <p>You can always change it later. You can even set weekend, midweek, and seasonal prices.</p>
            </div>
        </div>

        <!-- Discount section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Discount card -->
            <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" class="form-checkbox text-blue-600 rounded-md" />
                    <span class="ml-2 font-medium text-gray-700">Get guests’ attention with a 20% discount</span>
                </label>
                <p class="text-sm text-gray-600">Give 20% off your first 3 bookings or for 90 days, whichever comes first. <a href="#" class="text-blue-600 underline">Learn more</a></p>
                <p class="text-sm text-gray-800">
                    <del class="text-gray-500">US$ 120.00</del> 
                    <span class="text-green-600 font-semibold">US$ 96.00 per night</span>
                </p>
            </div>

            <!-- Tip Box 2 -->
            <div x-show="showTip2" class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
                <button @click="showTip2 = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                    ✕
                </button>
                <strong class="block ">⚠️ Rules for setting up a promotion</strong>
                <p>Make sure you're giving a genuine discount. It must represent a real discount in line with consumer protection rules. <a href="#" class="text-blue-600 underline">Learn More</a></p>
            </div>
        </div>

       
        
            
</div>
            
      <!-- Navigation Buttons -->
      <div class="flex mt-1">
        <button type="button"
                @click="step > 1 ? step-- : step"
                :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
          ←
        </button>
        <button type="button"
                @click="step < 9 ? step++ : step"
                class="ml-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 ml-[335px]">
          Continue
        </button>
      </div>
    </section>
  </div>
    </div>
</template>


    
      <template x-if="step === 6">
    <div class="bg-white p-4 md:p-8 shadow-md rounded-lg mx-auto max-w-screen-lg">
        <!-- Rate Plans Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2">Rate plans</h2>
            <p class="text-gray-600">
                To attract a wider range of guests, we suggest setting up multiple rate plans. The recommended prices and policies for each plan are based on data from properties like yours, but they can be edited now or after you complete registration.
            </p>
        </div>

        <!-- Standard Rate Plan -->
        <div class="bg-gray-100 p-4 mb-6 rounded-lg">
            <h3 class="text-xl font-bold mb-2">Standard rate plan</h3>
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <div class="w-full md:w-2/3">
                    <label class="block text-sm font-medium text-gray-700">
                        Cancellation policy
                        <span class="text-xs text-gray-500">(This policy is set at the property level – any changes made will be applied to all rooms.)</span>
                    </label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input id="cancellation-policy-1" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                            <label for="cancellation-policy-1" class="ml-2 text-sm text-gray-700">Guests can cancel their bookings for free up to 1 day before their arrival</label>
                        </div>
                        <div class="flex items-center">
                            <input id="cancellation-policy-2" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                            <label for="cancellation-policy-2" class="ml-2 text-sm text-gray-700">Guests who cancel within 24 hours will have their cancellation fee waived</label>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 mt-4 md:mt-0">
                    <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">
                    Price per group size
                </label>
                <div class="mt-2">
                    <table class="w-full table-fixed">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Occupancy</th>
                                <th class="px-4 py-2 text-left">Guests pay</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-b border-gray-200 px-4 py-2">🪑 x 2</td>
                                <td class="border-b border-gray-200 px-4 py-2">US$ 30.00</td>
                            </tr>
                            <tr>
                                <td class="border-b border-gray-200 px-4 py-2">🪑 x 1</td>
                                <td class="border-b border-gray-200 px-4 py-2">US$ 27.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Non-Refundable Rate Plan -->
        <div class="bg-gray-100 p-4 mb-6 rounded-lg">
            <h3 class="text-xl font-bold mb-2">Non-refundable rate plan</h3>
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <div class="w-full md:w-2/3">
                    <label class="block text-sm font-medium text-gray-700">
                        Price and cancellation policy
                    </label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input id="non-refundable-policy-1" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                            <label for="non-refundable-policy-1" class="ml-2 text-sm text-gray-700">Guests will pay 10% less than the standard rate for a non-refundable rate</label>
                        </div>
                        <div class="flex items-center">
                            <input id="non-refundable-policy-2" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                            <label for="non-refundable-policy-2" class="ml-2 text-sm text-gray-700">Guests can't cancel their bookings for free anytime</label>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 mt-4 md:mt-0">
                    <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                </div>
            </div>
        </div>

        <!-- Weekly Rate Plan -->
        <div class="bg-gray-100 p-4 rounded-lg">
            <h3 class="text-xl font-bold mb-2">Weekly rate plan</h3>
            <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <div class="w-full md:w-2/3">
                    <label class="block text-sm font-medium text-gray-700">
                        Price and cancellation policy
                    </label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input id="weekly-policy-1" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                            <label for="weekly-policy-1" class="ml-2 text-sm text-gray-700">Guests will pay 15% less than the standard rate when they book for at least 7 nights</label>
                        </div>
                        <div class="flex items-center">
                            <input id="weekly-policy-2" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                            <label for="weekly-policy-2" class="ml-2 text-sm text-gray-700">Guests can cancel their bookings for free before 18:00 on the day of arrival. The guests will be charged cost of the first night if they cancel after this deadline.</label>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/3 mt-4 md:mt-0">
                    <button class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                </div>
            </div>
        </div>
    </div>
</template>
    </template>

   <template x-if="step === 8">
    <div class="mt-16">
       
    </div>
</template>


    <template x-if="step === 9">
      <div>
        <h2 class="text-xl font-bold mb-4">Step 9: Review & Submit</h2>
        <p class="text-sm text-gray-600 mb-4">Review your details before submission.</p>
        <button class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold">Submit</button>
      </div>
    </template>

   
  </div>

</body>
</html>
