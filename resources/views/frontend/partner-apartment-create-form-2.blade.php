<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>create apartment</title></title>
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
<body class="bg-gray-50 text-gray-800">
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



<div x-data="{ step: 1, wizardStep: 1 , propertyWizardStep: 1, pricingWizardStep:1 }">

 <!-- Sticky Top Navbar -->
  <nav class="border-b shadow-sm sticky top-0 z-50 ">
    <div class="max-w-full mx-auto px-4 py-3">
      
      <!-- Scrollable/Responsive Nav Items -->
<div class="flex flex-wrap sm:flex-nowrap overflow-x-auto space-x-6 sm:space-x-12 md:space-x-8 lg:space-x-24 xl:space-x-24 text-sm font-medium whitespace-nowrap">

        
        <!-- Loop through nav steps -->
        <template x-for="(label, index) in ['Basic information', 'Property setup', 'Photos', 'Pricing and calendar', 'Legal information','Review and complete']" :key="index">
          <div class="relative">
            
            <!-- Tab Label -->
            <div 
              @click="step = index + 1"
              class="flex items-center space-x-1 cursor-pointer transition duration-200"
              :class="step === index + 1 ? 'text-blue-600' : 'text-gray-700'"
            >
              <span x-text="label"></span>

              <!-- Optional checkmark -->
              <template x-if="index === 0 && wizardStep === 3">
                <span class="text-green-600">✔️</span>
              </template>
 <!-- Optional checkmark -->
              <template x-if="index === 1 && propertyWizardStep === 6">
                <span class="text-green-600">✔️</span>
              </template>

              
            </div>

            

            <!-- 🔵 Progress bar only under "Basic information" when active -->
            <template x-if="index === 0 && step === 1">
              <div class="flex space-x-1 mt-1 w-35 sm:w-48 md:w-46 lg:w-54 xl:w-62 ml-[-15px] sm:ml-[-25px] md:ml-[-35px]">
                <template x-for="i in 3">
                  <div 
                    :class="wizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'" 
                    class="h-1 flex-1 rounded-full"
                  ></div>
                </template>
              </div>
            </template>

            <!-- Progress bar under "Property setup" tab -->
<!-- Progress bar under "Property setup" tab -->
<template x-if="index === 1 && step === 2">
  <div class="flex space-x-1 mt-1 w-15 sm:w-25 md:w-30 lg:w-64 xl:w-72 ml-[-60px] sm:ml-[-80px] md:ml-[-90px]">
    <template x-for="i in 6">
      <div 
        :class="propertyWizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'" 
        class="h-1 flex-1 rounded-full">
      </div>
    </template>
  </div>
</template>


<template x-if="index === 3 && step === 4">
  <div class="flex space-x-1 mt-1 w-10 sm:w-16 md:w-24 lg:w-56 xl:w-72 ml-[-40px] sm:ml-[-60px] md:ml-[-70px]">
    <template x-for="i in 4">
      <div 
        :class="pricingWizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'" 
        class="h-1 flex-1 rounded-full">
      </div>
    </template>
  </div>
</template>
            

            

          </div>
        </template>
      </div>

    </div>
  </nav>
  <!-- 🧾 Page Content -->
  <div >

    <!-- ✅ Step 1: Basic Information -->
    <section x-show="step === 1">
      <div>

        <template x-if="wizardStep === 1">
<div class="max-w-5xl mx-auto px-4 py-10 space-y-32">
          <section class="mb-8">
  <h1 class="text-xl text-gray-700 font-bold mb-4">What's the name of your place?</h1>

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
  @click="step--"
  class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
  ←
</button>



    <!-- Continue Button -->
   <!-- Continue Button (inside input field container, aligned right) -->
  <div class="flex justify-end mt-4">
    <button
      type="submit"  @click="wizardStep++"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
      Continue 
    </button>
  </div>

  </div>
</section>

  </div>
</template>

<template x-if="wizardStep === 2"  >
  <div class="relative w-[1200px] h-auto overflow-hidden rounded-lg shadow mx-auto my-10 ">
    <!-- Google Maps iframe full background -->
    <iframe 
        class="absolute inset-0 w-full h-full"
        loading="lazy"
        src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
        allowfullscreen>
    </iframe>

        <!-- Optional overlay for readability -->
        <div class="absolute inset-0 "></div>

        <!-- Form content centered on map -->
        <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
  <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>
                <form action="#" method="POST">
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
                   <div class="flex justify-between mt-6">
  <!-- Back Button (Left) -->
   <button type="button"
          @click="wizardStep--"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>
  

  <!-- Continue Button (Right) -->
  <button   type="submit"
      @click="wizardStep++"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
    Continue
  </button>
</div>

                </form>
            </div>
        </div>
    </div>
</div>
<!--end basic info step 2-->

</template>
        <template x-if="wizardStep === 3"> <section class="mb-12" x-data="{ channelManager: 'yes' }">
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
        <div class="bg-red-100 border border-red-300 rounded p-2">
      <div class="flex items-start text-sm text-red-700 space-x-2">
  <!-- Inline icon -->
  <img src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}" 
       alt="Help" 
       class="w-5 h-5 md:w-6 md:h-6 mt-1" />

  <!-- Text block -->
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
                   <div class="flex justify-between mt-6">
  <!-- Back Button (Left) -->

    <button type="button"   @click="wizardStep--"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>
 

  <!-- Continue Button (Right) -->
  <button type="submit"
          @click="step++"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
    Continue
  </button>
</div>
    </div>
  </section>
  </div></template>
      </div>

      </div>
    </section>



 <!-- Property Setup Section -->
<section x-show="step === 2">
 

  <template x-if="propertyWizardStep === 1">
   {{-- property-setup.blade.php --}}
<div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">

<h2 class="text-2xl font-bold text-gray-900 mt-8">What can guests use at your place?</h2>
    <!-- Where can people sleep -->
    <div class="bg-white p-4 rounded-lg shadow space-y-4">
        <h2 class="text-lg font-semibold">Where can people sleep?</h2>

     <div class="flex flex-col gap-4">
    <a href="{{ route('partner.apartment.bedrooms') }}">
        <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
            <p class="text-sm">Bedroom 1</p>
            <p class="text-sm text-gray-600">1 full bed</p>
        </div>
    </a>

    <a href="{{ route('partner.apartment.livingroom') }}">
        <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
            <p class="text-sm">Living Room</p>
            <p class="text-sm text-gray-600">1 full bed</p>
        </div>
    </a>

    <a href="{{ route('partner.apartment.otherspaces') }}">
        <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
            <p class="text-sm">Other spaces</p>
            <p class="text-sm text-gray-600">1 full bed</p>
        </div>
    </a>
</div>





        <!-- Add Bedroom Button (navigate to 2nd page) -->
        <a href="{{ route('partner.apartment.bedrooms') }}" class="text-blue-600 hover:underline text-sm flex items-center space-x-1 mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            <span>Add Bedroom</span>
        </a>
    </div>

    <!-- Include Alpine.js in your Blade layout if not already -->
<script src="//unpkg.com/alpinejs" defer></script>

<!-- Guests and Bathrooms -->
<div x-data="{ guests: 2, bathrooms: 1 }" class="bg-white p-4 rounded-lg shadow space-y-4 w-full max-w-xl">
    <!-- Guests -->
    <div>
        <label class="block text-sm text-gray-800">How many guests can stay?</label>
        <div class="flex items-center space-x-4 mt-1">
            <button
                @click="if (guests > 1) guests--"
                class="border px-3 py-1 rounded text-base "
            >−</button>
            <span class="min-w-[2rem] text-center text-gray-700  text-base" x-text="guests"></span>
            <button
                @click="guests++"
                class="border px-3 py-1 rounded text-base "
            >+</button>
        </div>
    </div>

    <!-- Bathrooms -->
    <div >
        <label class="block  text-sm text-gray-800">How many bathrooms are there?</label>
        <div class="flex items-center space-x-4 mt-1">
            <button
                @click="if (bathrooms > 0) bathrooms--"
                class="border px-3 py-1 rounded text-base"
            >−</button>
            <span class="min-w-[2rem] text-center text-gray-700  text-base" x-text="bathrooms"></span>
            <button
                @click="bathrooms++"
                class="border px-3 py-1 rounded text-base"
            >+</button>
        </div>
    </div>
</div>


    <!-- Children Policy -->
    <div class="bg-white p-4 rounded-lg shadow space-y-4">
        <div>
            <p class="font-medium text-sm">Do you allow children?</p>
            <label class="mr-4 text-sm"><input type="radio" name="children" checked> Yes</label>
            <label class="text-sm"><input type="radio" name="children"> No</label>
        </div>

        <div>
            <p class="font-medium text-sm">Do you allow infants?</p>
            <p class="text-xs text-gray-500">cribs sleep most infants 0–3 years old and are available to guests on request.</p>
            <label class="mr-4 text-sm"><input type="radio" name="infants" checked> Yes</label>
            <label class="text-sm"><input type="radio" name="infants" > No</label>
        </div>
    </div>

        <!-- Room Size -->
<div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 ">
  <div class="flex flex-col lg:flex-row gap-4 items-end"> <!-- ensure vertical alignment -->
    
    <!-- Apartment Size Dropdown -->
    <div class="w-full lg:w-2/4">
  <label class="block  text-sm text-gray-700 mb-1">How big is this room?</label>
  <p class="text-xs text-gray-500 ">Apartment size - optional</p>
 
<input 
    type="number"
    min="1"
    step="1"
    inputmode="numeric"
    pattern="\d*"
    x-model="propertyCount"
    name="property_count"
    class="w-full border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2"
>

  

</div>

    <!-- Size Unit Dropdown -->
    <div class="w-full lg:w-1/4">
      <label class="block text-sm text-transparent mb-1">Unit</label> <!-- invisible label for spacing -->
      <select class="w-full bg-gray-300 text-black border border-gray-300 rounded-md shadow-sm text-sm mt-2  px-2 py-2">
        <option>square meters</option>
        <option>square feet</option>
      </select>
    </div>
    
  </div>
    </div>

    <div class="mt-8 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="propertyWizardStep--"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="propertyWizardStep++"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
  >
    Continue
  </button>
</div>
</div>

</template>









    <template x-if="propertyWizardStep === 2">
      
 <div class="max-w-2xl mx-auto space-y-8 lg:ml-32">

    <!-- Heading -->
     <h2 class="text-2xl font-bold text-gray-900 mt-8">What can guests use at your place?</h2>

   <!-- Amenities Section Container -->
<div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
  @php
    $amenities = [
      'Highlights' => ['Private bathroom', 'Sea views', 'Family rooms', 'Airport shuttle', 'Spa and wellness center'],
      'General' => ['Air conditioning', 'Heating', 'Free WiFi', 'Electric vehicle charging station'],
      'Cooking and cleaning' => ['Kitchen', 'Microwave', 'Washing machine'],
      'Entertainment' => ['Flat-screen TV', 'Swimming Pool', 'Hot tub', 'Minibar', 'Sauna'],
      'Outside and view' => ['Balcony', 'Garden view', 'Terrace', 'View']
    ];
  @endphp

  @foreach ($amenities as $category => $items)
    <div class="space-y-3">
      <h3 class="text-base font-semibold text-gray-800">{{ $category }}</h3>

      <div class="flex flex-col space-y-2">
        @foreach ($items as $item)
          <label class="flex items-center space-x-2 text-gray-700 text-sm">
            <input type="checkbox" name="amenities[]" value="{{ $item }}" class="form-checkbox h-5 w-5 text-blue-600">
            <span>{{ $item }}</span>
          </label>
        @endforeach
      </div>

      @if (!$loop->last)
        <hr class="border-t border-gray-200 mt-4">
      @endif
    </div>
  @endforeach
</div>


 <div class="flex justify-between mt-6 ">
    <!-- Back Button -->
<button
  type="button"
 @click="propertyWizardStep--"
  class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded mb-16">
  ←
</button>



    <!-- Continue Button -->
   <!-- Continue Button (inside input field container, aligned right) -->
  <div class="flex justify-end ">
    <button
      type="submit"
    @click="propertyWizardStep++"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 mb-16">
      Continue 
    </button>
  </div>

  </div>
  </div>


    </template>




    <template x-if="propertyWizardStep === 3">
    <div class="space-y-8 max-w-2xl mx-auto p-4 lg:ml-32">

        <!-- Services at your property -->
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Services at your property</h2>

        <!-- Breakfast Section -->
        <div class="bg-white shadow rounded-lg p-6 space-y-4 border">
            <h3 class="text-base font-semibold text-gray-700">Breakfast</h3>
 <hr class="my-6 border-t border-gray-300">
            <!-- Do you serve guests breakfast -->
            <div>
                <p class="font-semibold text-sm text-gray-800 mb-2">Do you serve guests breakfast?</p>
                <div class="flex flex-col text-sm gap-2">
    <label><input type="radio" name="serve_breakfast" class="mr-2"> Yes</label>
    <label><input type="radio" name="serve_breakfast" class="mr-2"> No</label>
</div>

            </div>

            <!-- Is breakfast included -->
            <div>
                <p class="font-semibold text-sm  text-gray-800 mb-2">Is breakfast included in the price guests pay?</p>
                <div class="flex flex-col text-sm gap-2">
                    <label><input type="radio" name="breakfast_included" class="mr-2"> Yes, it's included</label>
                    <label><input type="radio" name="breakfast_included" class="mr-2"> No, it costs extra</label>
                </div>
            </div>
<hr class="my-6 border-t border-gray-300">
            <!-- Type of breakfast -->
          <div x-data="{ selected: [] }">
  <p class="font-semibold text-sm text-gray-800 mb-2">
    What type of breakfast do you offer? 
    <span class="text-sm text-gray-500">(Select all that apply)</span>
  </p>

  <div class="flex flex-wrap gap-2">
    @foreach(['A la carte', 'American', 'Asian', 'Breakfast to go', 'Buffet', 'Continental', 'Full English/Irish', 'Gluten-Free', 'Halal', 'Italian', 'Kosher', 'Vegan', 'Vegetarian'] as $option)
      <label
        :class="selected.includes('{{ $option }}') 
                  ? 'bg-[#3CC0E9] text-white' 
                  : 'border border-gray-300 text-gray-700 hover:bg-gray-200'"
        class="px-3 py-1 rounded-full text-sm font-medium cursor-pointer transition"
      >
        <input type="checkbox" class="hidden" 
               :value="'{{ $option }}'"
               x-model="selected"> 
        {{ $option }}
      </label>
    @endforeach
  </div>
</div>

        </div>

        <!-- Parking Section -->
        <div class="bg-white shadow rounded-lg p-6 space-y-4 border">
            <h3 class="text-base font-semibold text-gray-700">Parking</h3>

            <hr class="my-6 border-t border-gray-300">
            <!-- Is parking available -->
            <div>
                <p class="text-sm font-semibold text-gray-800 mb-2">Is parking available to guests?</p>
                               <div class="flex flex-col text-sm gap-2">
    <label><input type="radio" name="parking_available" class="mr-2"> Yes, free</label>
                    <label><input type="radio" name="parking_available" class="mr-2"> Yes, paid</label>
                    <label><input type="radio" name="parking_available" class="mr-2"> No</label>
</div>
               
            </div>
    <hr class="my-6 border-t border-gray-300">
            <!-- Parking cost -->
       <div>
  <p class="text-sm font-semibold text-gray-800 mb-2">How much does parking cost?</p>

  <div class="flex flex-col sm:flex-row items-center gap-4">

    <!-- Input + Currency Select Wrapper -->
    <div class="relative w-full max-w-xs">
  <!-- Currency Select -->
  <select class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 pl-1 focus:outline-none">
    <option value="usd">US$</option>
    <option value="eur">€</option>
    <option value="gbp">£</option>
    <option value="lkr">Rs</option>
  </select>

  <!-- Input Field -->
  <input
    type="text"
    value="120.00"
    class="w-full border border-gray-400 rounded-md pl-16 pr-2 py-2 text-gray-700 font-semibold focus:ring-2 focus:ring-blue-300 focus:outline-none"
  />
</div>


    <!-- Rate Select -->
    <select class="border border-gray-300 rounded px-3 py-2 w-32 text-sm text-gray-700">
      <option>Per day</option>
      <option>Per stay</option>
    </select>

  </div>


            </div>

            <!-- Reservation needed -->
            <div>
                <p class="font-semibold text-sm text-gray-800 mb-2">Do guests need to reserve a parking spot?</p>

                <div class="flex flex-col text-sm gap-2">
    
                    <label><input type="radio" name="parking_reservation" class="mr-2"> Reservation needed</label>
                    <label><input type="radio" name="parking_reservation" class="mr-2">No reservation needed </label>
</div>
                
            </div>

            <!-- Parking location -->
            <div>
                <p class="font-semibold text-sm text-gray-800 mb-2">Where is the parking located?</p>

                <div class="flex flex-col text-sm gap-2">
    
                 <label><input type="radio" name="parking_location" class="mr-2"> On site</label>
                    <label><input type="radio" name="parking_location" class="mr-2"> Off site</label>
</div>
                
            </div>

                <div>
                <p class="font-semibold text-sm text-gray-800 mb-2">What type of parking is it?</p>

                <div class="flex flex-col text-sm gap-2">

                 <label><input type="radio" name="parking_type" class="mr-2">Private</label>
                    <label><input type="radio" name="parking_type" class="mr-2">Public</label>
</div>
                
            </div>

            
        </div>
<div class="flex justify-between mt-6">
    <!-- Back Button -->
<button
  type="button"
 @click="propertyWizardStep--"
  class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded mb-16">
  ←
</button>



    <!-- Continue Button -->
   <!-- Continue Button (inside input field container, aligned right) -->
  <div class="flex justify-end ">
    <button
      type="submit"
    @click="propertyWizardStep++"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 mb-16">
      Continue 
    </button>
  </div>
    </div>
</template>


    <template x-if="propertyWizardStep === 4">
      <div class="max-w-4xl mx-auto space-y-8 lg:ml-32">
         <div class="container ml-24 px-4 py-8 max-w-2xl">
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
   type="button" @click="propertyWizardStep--"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="propertyWizardStep++"
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
      </div>
    </template>

  <template x-if="propertyWizardStep === 5">
  <div class="max-w-4xl mx-auto space-y-8 lg:ml-32">
    <div class="container w-full max-w-4xl ml-4 md:ml-24 px-4 py-8">
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

          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Are there additional fees for pets?</h3>
            <div class="space-y-2">
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets_fees" value="free" class="mr-2">
                <span>Pets can stay for free</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets_fees" value="fees" class="mr-2">
                <span>Fees may apply</span>
              </label>
            </div>
          </div>

          <hr class="my-6 border-t border-gray-300">

          <!-- Check-in -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Check in</h3>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
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
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
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
                 <!-- Navigation Buttons -->
<div class="mt-12 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="propertyWizardStep--"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="propertyWizardStep++"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 "
  >
    Continue
  </button>
</div>
        </div>

        <!-- Right Section: Tip Box -->
        <div x-data="{ show: true }" :class="show ? 'block' : 'invisible opacity-0'" class="bg-white shadow-md rounded-lg p-6 w-full h-[240px] md:w-1/3 relative">
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


    </div>
  </div>
</template>


<template x-if="propertyWizardStep === 6">
    <div class="max-w-2xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8 lg:ml-32 py-6">
       <h2 class="text-2xl font-bold mb-8 text-left">Host Profile</h2>
        <div class="bg-white shadow-md rounded-lg p-4 space-y-6">
            <h2 class="text-base text-gray-800">
                Help your listing stand out by telling potential guests a little more about yourself, your property, and your neighborhood. This info will appear on your property page.
            </h2>

            <!-- The Property Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-sm ">The property</span>
                </label>

                <div class="mt-2">
                    <label class="block text-sm font-semibold text-gray-700">About the property</label>
                    <textarea rows="4" maxlength="1200" placeholder="What makes your place unique? What can guests expect"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- The Host Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The host</span>
                </label>

                <div class="mt-2 space-y-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Host name</label>
                        <input type="text" maxlength="80"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <p class="text-right text-xs text-gray-500">0/80</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">About the host</label>
                        <textarea rows="4" maxlength="1200" placeholder="What are your interests? What do you like about hosting?"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                        <p class="text-right text-xs text-gray-500">0/1200</p>
                    </div>
                </div>
            </div>

            <!-- The Neighborhood Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The neighborhood</span>
                </label>

                <div class="mt-2">
                    <label class="block text-sm font-semibold text-gray-700">About the neighborhood</label>
                    <textarea rows="4" maxlength="1200" placeholder="What’s the area like? Are there any attractions nearby?"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- None of the Above Option -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">None of the above / I’ll add these later</span>
                </label>
            </div>
        </div>
        <div class="mt-12 flex justify-between">
  <!-- Back Button on the left -->
  <button
   type="button" @click="propertyWizardStep--"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
  
      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="propertyWizardStep++"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 "
  >
    Continue
  </button>
</div>
    </div>
</template>


</section>



 <!-- ✅ Step 3: Photos Upload Section -->
<!-- ✅ Step 3: Photos Upload Section -->
<!-- ✅ Step 3: Photos Upload Section -->
<section x-show="step === 3" class="px-4 py-6 md:px-8 lg:px-16 flex justify-center" x-data="{
    uploadedPhotos: [],
    handleUpload(event) {
      const files = Array.from(event.target.files).slice(0, 5 - this.uploadedPhotos.length);
      files.forEach(file => {
        const url = URL.createObjectURL(file);
        this.uploadedPhotos.push({ file, url });
      });
    },
    handleUploadDrop(event) {
      const dt = event.dataTransfer;
      if (!dt) return;
      const files = Array.from(dt.files).slice(0, 5 - this.uploadedPhotos.length);
      files.forEach(file => {
        const url = URL.createObjectURL(file);
        this.uploadedPhotos.push({ file, url });
      });
    },
    removePhoto(index) {
      this.uploadedPhotos.splice(index, 1);
    }
}">
  <div class="w-full max-w-6xl">
    <h2 class="text-xl md:text-2xl font-bold text-black mb-6 text-left mt-12">What does your place look like?</h2>

    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
      <!-- 📸 Photo Upload Area -->
      <div 
        class="border rounded-lg p-6 bg-white shadow-sm"
      >
        <p class="font-semibold text-gray-800 mb-2">Upload at least 5 photos of your property.</p>
        <p class="text-sm text-gray-600 mb-4">The more you upload, the more likely you are to get bookings. You can add more later.</p>

        <!-- Upload box with drag and drop -->
       <div
  class="border border-dashed border-gray-400 rounded-lg p-6 text-center bg-gray-50 mb-6"
  @dragover.prevent
  @drop.prevent="handleUploadDrop($event)"
>
  <div class="mb-4">
    <!-- camera SVG -->
  </div>
  <p class="text-gray-700 font-medium mb-2">Drag and drop or</p>

  <label
  class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 border border-gray-800 rounded cursor-pointer hover:bg-gray-50 hover:text-black transition"
  for="fileInput"
>
  <img src="{{ asset('assets/mdi_camera-outline.svg') }}" alt="Upload" class="w-4 h-4" />
  <span>Upload photos</span>
</label>
<input 
  id="fileInput"
  type="file" 
  multiple 
  accept="image/*" 
  class="hidden" 
  @change="handleUpload"
/>


  <p class="text-xs text-gray-500 mt-2">jpg/jpeg or png, maximum 47MB each, max 5 images</p>
</div>

        <!-- Uploaded photo previews -->
        <template x-if="uploadedPhotos.length > 0">
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <template x-for="(photo, index) in uploadedPhotos" :key="index">
              <div class="relative group border rounded overflow-hidden">
                <!-- Badge for main photo -->
                <template x-if="index === 0">
                  <span class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10">Main Photo</span>
                </template>

                <!-- Remove Button -->
                <button @click="removePhoto(index)"
                        class="absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75">
                  &times;
                </button>

                <img :src="photo.url" alt="Uploaded photo" class="w-full h-32 object-cover" />
              </div>
            </template>
          </div>
        </template>
      </div>

      <!-- ℹ️ Tips Box -->
<div x-data="{ showTips: true }">
  <div x-show="showTips" x-transition
       class="bg-white border rounded-none p-4 shadow-sm relative text-sm">
    
    <button
      @click="showTips = false"
      class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg"
      aria-label="Close"
    >
      &times;
    </button>
    
    <h3 class="font-semibold text-gray-800 mb-2 text-base">What if I don't have professional photos?</h3>
    <p class="text-gray-600 mb-2">
      No problem! You can use a smartphone or a digital camera.
    </p>
    <a href="#" class="text-blue-600 hover:underline block mb-2">
      Here are some tips for taking great photos of your property
    </a>
    <p class="text-gray-600">
      If you don’t know who took a photo, it's best to avoid using it. Only use photos others have taken if you have permission.
    </p>
  </div>
</div>

    <!-- Navigation Buttons -->
    <div class="mt-6 flex justify-between">
      <button @click="step--"   class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">← </button>
      <button
        :disabled="uploadedPhotos.length < 3"
        :class="{
          'px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700cursor-pointer opacity-100 hover:bg-blue-700': uploadedPhotos.length >= 3,
          'bg-gray-400 rounded cursor-not-allowed opacity-50': uploadedPhotos.length < 3
        }"
        class="px-6 py-2 text-white rounded"
      >
        Continue
      </button>
    </div>
  </div>
</section>




<!-- ✅ Step 4: Pricing and Calendar -->
<section x-show="step === 4">

  <template x-if="pricingWizardStep === 1">
  <div class="max-w-2xl mx-auto px-4 py-6 lg:ml-32 space-y-8">
    <!-- Title -->
    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-4">
      How you receive bookings
    </h2>

    <!-- Info Card -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 space-y-4">
      <h3 class="text-base font-semibold text-gray-900">
        We’re here to ensure you can receive bookings safely:
      </h3>
     <ul class="text-gray-700 space-y-1 text-sm">
  @php
    $tickIcon = asset('assets/Vector (42).svg'); // Use consistent and clean SVG
  @endphp

  @foreach([
    'Set house rules guests must agree to before they stay',
    'Request damage deposits for extra security',
    'Report guest misconduct if something goes wrong',
    'Receive protection against liability claims from guests and neighbours up to US$1,000,000 for every reservation'
  ] as $text)
    <li class="flex items-start">
      <span class="text-green-600 mr-2 shrink-0">
        <img src="{{ $tickIcon }}" alt="Tick" class="w-4 h-4" />
      </span>
      <span>{{ $text }}</span>
    </li>
  @endforeach
</ul>


    </div>

    <!-- Booking Options -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 space-y-4">
      <h3 class="text-base font-semibold text-gray-900">
        How can guests book your apartment?
      </h3>
      <div class="space-y-2 text-sm">
        <label class="flex items-center space-x-3">
          <input type="radio" name="booking_type" class="form-radio text-blue-600" checked>
          <span class="text-gray-800">All guests can book instantly <span class="ml-2 px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded">Recommended</span></span>
        </label>
        <label class="flex items-center space-x-3">
          <input type="radio" name="booking_type" class="form-radio text-blue-600">
          <span class="text-gray-800">All guests will need to request to book</span>
        </label>
      </div>
    </div>

    <!-- Continue Button -->
    <div class="flex justify-between items-center">
      <button  @click="pricingWizardStep--"      class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
          ←</button>
      <button  @click="pricingWizardStep++" class="  px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500">Continue</button>
    </div>
  </div>
</template>



  <template x-if="pricingWizardStep === 2">
    <div class="max-w-4xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
        <div class="max-w-4xl mx-auto px-4 py-8 space-y-6" x-data="{ showTip1: true, showTip2: true }">

      <!-- Title -->
      <h2 class="text-2xl font-bold text-gray-800">Set the price per night for this room</h2>

      <!-- Price input and Tip 1 in two separate columns -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
  
  <!-- Price input card (2/3 width) -->
  <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-4">
    <label class="block font-semibold text-base text-gray-700">How much do you want to charge per night?</label>
    <div class="relative">
  <label class="block text-sm text-gray-700 mb-1">Price guests pay</label>

  <!-- Currency Select Dropdown -->
  <select class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 focus:outline-none border border-gray-300 rounded-md">
    <option value="usd">US$</option>
    <option value="eur">€</option>
    <option value="gbp">£</option>
    <option value="lkr">Rs</option>
  </select>

  <!-- Input Field -->
  <input
    type="text"
    value="120.00"
    class="w-full border border-gray-400 rounded-md p-2 pl-16 text-gray-700 font-semibold focus:ring-2 focus:ring-blue-300 focus:outline-none"
  />

  <p class="text-sm text-gray-500 mt-2">Including taxes, commission, and fees</p>
</div>


    <!-- Topic paragraph -->
    <p class="text-sm text-gray-600 pl-4">
      <span class="text-gray-500">15.00%</span> Bookintour.com commission
    </p>

    <!-- Sub-items under topic -->
    <ul class="text-sm text-gray-600 space-y-1 pl-8">
      <li><span class="text-green-600 font-semibold">✓</span> 24/7 help in your language</li>
      <li><span class="text-green-600 font-semibold">✓</span> Save time with automatically confirmed bookings</li>
      <li><span class="text-green-600 font-semibold">✓</span> We promote your place on Google</li>
    </ul>

    <p class="text-sm text-gray-800 font-medium border-t pt-3">US$ 30.00 Your earnings (including taxes)</p>
  </div>

  <!-- Tip Box 1 (1/3 width, independent height) -->
  <div x-show="showTip1" class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
    <button @click="showTip1 = false" class="absolute top-2 right-2 text-gray-500 font-semibold">✕</button>
    
    <div class="flex items-center mb-2">
      <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Tip Icon" class="w-6 h-6 mr-2">
      <strong>What if I’m not sure about my price?</strong>
    </div>

    <p>Don't worry, you can always change it later. You can even set weekend, midweek, and seasonal prices, giving you more control over what you earn.</p>
  </div>

</div>

      <!-- Discount and Tip 2 -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- Discount card -->
        <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-3">
          <label class="inline-flex items-center">
            <input type="checkbox" class="form-checkbox text-blue-600 rounded-md" />
            <span class="ml-2 font-medium text-gray-700 font-semibold">Get guests’ attention with a 20% discount</span>
          </label>
          <p class="text-sm text-gray-600">
            Give 20% off your first 3 bookings or for 90 days, whichever comes first. 
            <a href="#" class="text-blue-600 underline">Learn more</a>
          </p>
          <hr class="my-4">
          <p class="text-sm text-gray-800">
            <del class="text-gray-500">US$ 30.00</del> 
            <span class="text-green-600 font-semibold">US$ 24.00 per night</span>
          </p>
        </div>

        <!-- Tip Box 2 (separate column) -->
        <div x-show="showTip2" class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
          <button @click="showTip2 = false" class="absolute top-2 right-3 text-gray-500 font-semibold mb-2">✕</button>
          <div class="flex items-center mb-2">
            <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Tip Icon" class="w-6 h-6 mr-2">
            <strong>Rules for setting up a promotion</strong>
          </div>
          <p>
            Make sure you're giving a genuine discount. It must represent a real discount in line with consumer protection rules. 
            <a href="#" class="text-blue-600 underline">Learn More</a>
          </p>
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
                @click="pricingWizardStep++"
                class="ml-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[402px]">
          Continue
        </button>
      </div>

    </div>
    </div>
</template>


<template x-if="pricingWizardStep === 3">
    
    <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">

    <!-- Main Title -->
    <h2 class="text-3xl font-bold text-gray-800">Rate plans</h2>

    <!-- Intro Paragraph -->
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <p class="text-sm text-gray-600">
        To attract a wider range of guests, we suggest setting up multiple rate plans.
        The recommended prices and policies for each plan are based on data from properties like yours,
        but they can be edited now or after you complete registration.
      </p>
    </div>

    <h2 class="text-xl font-semibold text-gray-800">Standard rate plan</h2>

    <!-- Rate Plan Card -->
    <div class="bg-white border rounded-lg p-6 shadow-sm space-y-6 w-full max-w-2xl mx-auto">

      <!-- Cancellation Policy Section -->
      <div class="space-y-4">
        <div class="flex justify-between items-start">
          <div>
            <div class="flex items-center gap-2">
              <h3 class="text-base font-semibold text-gray-700">Cancellation policy</h3>
              <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Tip Icon" class="w-5 h-5">
            </div>
            <p class="text-xs text-gray-500">
              This policy is set at the property level – any changes made will be applied to all rooms.
            </p>
          </div>
         <button @click="$refs.section1.scrollIntoView({ behavior: 'smooth' })"
        class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">
  Edit
</button>
        </div>
        <hr class="my-4">
        <ul class="text-gray-900 text-sm space-y-2">
          <li class="flex items-start gap-2">
            <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick" class="w-4 h-4 mt-1">
            <span>Guests can cancel their bookings for free up to 1 day before their arrival</span>
          </li>
          <li class="flex items-start gap-2">
            <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick" class="w-4 h-4 mt-1">
            <span>Guests who cancel within 24 hours will have their cancellation fee waived</span>
          </li>
        </ul>
      </div>

      <hr class="my-4">

      <!-- Price Per Group Size Section -->
      <div class="space-y-4">
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-2">
            <h3 class="text-base font-semibold text-gray-700">Price per group size</h3>
            <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Tip Icon" class="w-5 h-5">
          </div>
          <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button>
        </div>

        <hr class="my-4">
<table class="table-auto border-separate border-spacing-x-2 w-full text-left text-gray-700">
  <tbody>
    <tr>
      <td class="py-2 text-sm font-semibold">Occupancy</td>
      <td class="py-2 text-sm font-semibold">Guests pay</td>
    </tr>
    <tr>
      <td class="py-2">
        <div class="flex items-center gap-1">
          <img src="{{ asset('assets/guidance_user-1 (1).svg') }}" alt="User Icon" class="w-5 h-5">
          <span>x 2</span>
        </div>
      </td>
      <td class="py-2 text-sm">US$ 30.00</td>
    </tr>
    <tr>
      <td class="py-2">
        <div class="flex items-center gap-1">
          <img src="{{ asset('assets/guidance_user-1 (1).svg') }}" alt="User Icon" class="w-5 h-5">
          <span>x 1</span>
        </div>
      </td>
      <td class="py-2 text-sm">US$ 27.00</td>
    </tr>
  </tbody>
</table>


      </div>

   
    </div>

    <h2 class="text-xl font-semibold text-gray-800">Non-refundable rate plan</h2>

    <!-- Second Rate Plan -->
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <h3 class="text-base font-semibold text-gray-700">Price and cancellation policy</h3>
          <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Tip Icon" class="w-5 h-5">
        </div>
        <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button>
      </div>
      <hr class="my-4">
      <ul class="text-gray-900 text-sm space-y-2">
        <li class="flex items-start gap-2">
          <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick" class="w-4 h-4 mt-1">
          <span>Guests will pay 10% less than the standard rate for a non-refundable rate</span>
        </li>
        <li class="flex items-start gap-2">
          <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick" class="w-4 h-4 mt-1">
          <span>Guests can't cancel their bookings for free anytime</span>
        </li>
      </ul>
    </div>

    <h2 class="text-xl font-semibold text-gray-800">Weekly rate plan</h2>

    <!-- Third Rate Plan -->
    <div class="bg-white border rounded-lg p-4 shadow-sm">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <h3 class="text-base font-semibold text-gray-700">Price and cancellation policy</h3>
          <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}" alt="Tip Icon" class="w-5 h-5">
        </div>
        <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button>
      </div>
      <hr class="my-4">
      <ul class="text-gray-900 text-sm space-y-2">
        <li class="flex items-start gap-2">
          <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick" class="w-4 h-4 mt-1">
          <span>Guests will pay 15% less than the standard rate when they book for at least 7 nights</span>
        </li>
        <li class="flex items-start gap-2">
          <img src="{{ asset('assets/teenyicons_tick-circle-outline.svg') }}" alt="Tick" class="w-4 h-4 mt-1">
          <span>Guests can cancel their bookings for free before 18:00 on the day of arrival. The guests will be charged cost of the first night if they cancel after this (based on the standard rate cancellation policy).</span>
        </li>
      </ul>
    </div>

    <!-- Navigation Buttons -->
<div class="flex justify-between items-center mt-4">
  <!-- Back Button -->
  <button type="button"
          @click="step > 1 ? step-- : step"
          :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
    ←
  </button>

  <!-- Continue Button -->
  
  <button       @click="pricingWizardStep++" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-sky-500 transition w-full sm:w-auto">
    Continue
  </button>


  </div>
  </template>

 

  <template x-if="pricingWizardStep === 4">
  <div x-data="{
    checkInOption: 'specific',
    availabilityOption: '365',
    syncOption: 'yes',
    allowLongStay: 'yes',
    showSyncTip: true,
    showLongStayTip: true
}" class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6">

<h2 class="text-3xl font-bold text-gray-800">Availability</h2>
    <!-- Check-in Date Selection -->
<!-- Alpine.js Component -->
<div x-data="calendarComponent()" class="bg-white p-6 rounded-lg shadow-md space-y-4">
    <!-- Title -->
    <p class="text-base font-semibold">When is the first date that guests can check in?</p>

    <!-- Check-in Options -->
    <div class="flex flex-col sm:flex-row gap-4">
        <label class="flex items-center space-x-2" >
            <input type="radio" value="soon" x-model="checkInOption" class="form-radio text-blue-600">
            <span class="text-sm">As soon as possible</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="radio" value="specific" x-model="checkInOption" class="form-radio text-blue-600">
            <span class="text-sm">On a specific date</span>
        </label>
    </div>

    <!-- Calendar UI -->
    <div x-show="checkInOption === 'specific'" class="border rounded-md p-4 bg-white shadow space-y-4">
        <!-- Navigation Arrows -->
        <div class="flex justify-between items-center mb-4">
            <button @click="prevMonthPair"
        class="text-gray-600 hover:text-black font-bold border border-gray-400 rounded-md p-1">
    &larr;
</button>

<button @click="nextMonthPair"
        class="text-gray-600 hover:text-black font-bold border border-gray-400 rounded-md p-1">
    &rarr;
</button>

        </div>

        <!-- Two-Month Calendars Side by Side -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- First Month -->
            <div>
                <p class="text-center font-semibold mb-2" x-text="monthNames[month1] + ' ' + year"></p>
                <div class="grid grid-cols-7 gap-1 text-center text-sm text-gray-700">
                    <template x-for="day in weekDays" :key="day"><div class="font-bold" x-text="day"></div></template>
                    <template x-for="n in getStartDay(month1)" :key="'pad1-' + n"><div></div></template>
                    <template x-for="d in getDaysInMonth(month1)" :key="'d1-' + d">
                        <div
                            class="p-2 rounded cursor-pointer hover:bg-blue-100"
                            :class="(day === d && month1 === selectedMonth) ? 'bg-blue-600 text-white' : ''"
                            x-text="d"
                            @click="selectDate(d, month1)">
                        </div>
                    </template>
                </div>
            </div>

            <!-- Second Month -->
            <div>
                <p class="text-center font-semibold mb-2" x-text="monthNames[month2] + ' ' + year"></p>
                <div class="grid grid-cols-7 gap-1 text-center text-sm text-gray-700">
                    <template x-for="day in weekDays" :key="day"><div class="font-bold" x-text="day"></div></template>
                    <template x-for="n in getStartDay(month2)" :key="'pad2-' + n"><div></div></template>
                    <template x-for="d in getDaysInMonth(month2)" :key="'d2-' + d">
                        <div
                            class="p-2 rounded cursor-pointer hover:bg-blue-100"
                            :class="(day === d && month2 === selectedMonth) ? 'bg-blue-600 text-white' : ''"
                            x-text="d"
                            @click="selectDate(d, month2)">
                        </div>
                    </template>
                </div>
            </div>
        </div>

<hr class="border-t border-gray-300 my-4">

        <!-- Selected Date -->
        <p class="text-sm text-gray-600 mt-4">
            Guests can start booking right away, but the first available check-in date will be
            <strong x-text="formattedSelectedDate()"></strong>.
        </p>
    </div>
</div>

<!-- Alpine.js Script -->
<script>
function calendarComponent() {
    return {
        checkInOption: 'soon',
        year: 2025,
        month1: 6, // July
        month2: 7, // August
        day: null,
        selectedMonth: null,

        weekDays: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],

        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
                     'August', 'September', 'October', 'November', 'December'],

        getDaysInMonth(month) {
            return new Date(this.year, month + 1, 0).getDate();
        },

        getStartDay(month) {
            const date = new Date(this.year, month, 1);
            return (date.getDay() + 6) % 7; // Start from Monday
        },

        selectDate(day, month) {
            this.day = day;
            this.selectedMonth = month;
        },

        formattedSelectedDate() {
            if (this.day !== null && this.selectedMonth !== null) {
                return `${this.day} ${this.monthNames[this.selectedMonth]} ${this.year}`;
            }
            return '';
        },

        nextMonthPair() {
            if (this.month2 === 11) {
                this.month1 = 0;
                this.month2 = 1;
                this.year++;
            } else {
                this.month1++;
                this.month2++;
            }
        },

        prevMonthPair() {
            if (this.month1 === 0) {
                this.month1 = 10;
                this.month2 = 11;
                this.year--;
            } else {
                this.month1--;
                this.month2--;
            }
        }
    }
}
</script>




    <!-- Availability -->
    <div class="border rounded-md p-4 bg-white shadow space-y-4">
        <p class="text-base font-semibold">How would you like to open up dates for booking?</p>
        <div class="flex flex-col sm:flex-row gap-4">
            <label class="flex items-center space-x-2">
                <input type="radio" value="365" x-model="availabilityOption" class="form-radio text-blue-600">
                <span class="text-sm">Continuously extend my availability to:</span>
            </label>
            
        </div>

        <div x-show="availabilityOption === '365'" class="pl-6">
            <select class="border border-gray-300 p-2 rounded w-48 text-sm">
                <option value="365">365 days</option>
                <option value="180">180 days</option>
                <option value="90">90 days</option>
                <option value="60">60 days</option>
            </select>
        </div>
        <label class="flex items-center space-x-2">
                <input type="radio" value="18months" x-model="availabilityOption" class="form-radio text-blue-600">
                <span class="text-sm">Only open up the first 18 months</span>
            </label>
    </div>



 <!-- SYNC SECTION -->
<div class="flex flex-col md:flex-row gap-6">
  <!-- Left: Main Form (Updated width to max-w-2xl) -->
  <div class="flex-1">
    <div class="bg-white p-6 rounded-lg shadow-md space-y-4 max-w-2xl mx-auto"
         x-data="{ showSyncTip: true, syncOption: 'no', icalUrl: '' }">
      <p class="text-base font-semibold">Do you want to sync your availability with TripAdvisor?</p>
      <p class="text-xs text-green-600">
        You will avoid double bookings by syncing calendars. It will also help you get your property listed on Booking.com and open for bookings 80% faster.
      </p>

      <div class="space-y-4">
        <label class="flex items-center space-x-2">
          <input type="radio" value="yes" x-model="syncOption" class="form-radio text-blue-600">
          <span class="text-sm">Yes, I’ll import unavailable dates from another website</span>
        </label>

        <div x-show="syncOption === 'yes'" class="space-y-2 border border-gray-300 rounded p-4">
          <p class="text-sm">Paste your iCal link here</p>
          <input 
              type="text" 
              placeholder="Paste your iCal link here" 
              x-model="icalUrl"
              class="border border-gray-300 p-2 rounded w-full"
          >
          <button 
              class="bg-blue-700 text-white px-4 py-1 rounded mt-2"
              :disabled="!icalUrl.trim()"
              :class="{ 'opacity-50 cursor-not-allowed': !icalUrl.trim() }"
          >
              Import
          </button>
          <a href="#" class="text-sm text-blue-600">Where can I find my iCal link?</a>
        </div>

        <label class="flex items-center space-x-2">
          <input type="radio" value="no" x-model="syncOption" class="form-radio text-blue-600">
          <span class="text-sm">No, I won’t sync my availability</span>
        </label>
      </div>
    </div>
  </div>

  
</div>

<!-- LONG STAY SECTION -->
<div class="flex flex-col md:flex-row gap-6 mt-8">
  <!-- Left: Main Form (Updated width to max-w-2xl) -->
  <div class="flex-1">
    <div class="bg-white p-6 rounded-lg shadow-md space-y-4 max-w-2xl mx-auto"
         x-data="{ allowLongStay: '', showLongStayTip: true }">
      <p class="text-base font-semibold">Do you want to allow 30+ night stays?</p>
      <p class="text-sm text-gray-600">Allowing guests to stay for up to 90 nights can help you fill your calendar and tap into the trend of guests working remotely.</p>


      <p class="text-sm font-semibold">Will you accept reservations for stays over 30 nights?</p>
      <div class="flex flex-col sm:flex-row gap-4">
         
        <label class="flex items-center space-x-2">
          <input type="radio" value="yes" x-model="allowLongStay" class="form-radio text-blue-600">
          <span>Yes</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="radio" value="no" x-model="allowLongStay" class="form-radio text-blue-600">
          <span>No</span>
        </label>
      </div>

      <div>
        <label class="block mb-2 text-sm font-semibold">What's the maximum number of nights you want guests to be able to book?</label>
        <select class="border border-gray-300 p-2 rounded w-48">
          <option value="90">90</option>
          <option value="60">60</option>
          <option value="45">45</option>
          <option value="30">30</option>
        </select>
      </div>
    </div>
  </div>

  
</div>


     <!-- Navigation Buttons -->
<div class="flex justify-between items-center mt-4">
  <!-- Back Button -->
  <button type="button"
          @click="pricingWizardStep--"
          :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
    ←
  </button>

  <!-- Continue Button -->
  
  <button       @click="pricingWizardStep++" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-sky-500 transition w-full sm:w-auto">
    Continue
  </button>


  </div>
</div>


  </template>
</section>












<!-- ✅ Step 5: Legal Information -->
<section x-show="step === 5">
   <div class="px-4 py-8 mt-6 w-full max-w-2xl mx-auto lg:ml-24 space-y-6" x-data="{ ownershipType: '', owners: [{ firstName: '', lastName: '', dob: '' }] }">

    <h2 class="text-3xl font-bold text-gray-800">Partner verification</h2>

    <div class="bg-white p-6 rounded-lg shadow-sm border space-y-4 text-sm text-gray-700">
      <p class="text-sm text-gray-800">
        In order to comply with various legal and regulatory requirements, we need to collect and verify some information about you and your property.
      </p>

      <div>
        <label class="block font-semibold text-gray-900 mb-2">
          Is the accommodation owned by an individual or business entity?
        </label>
        <select x-model="ownershipType" class="w-full p-2 border rounded text-sm focus:ring focus:ring-sky-200">
          <option value="">Select an option</option>
          <option value="individual">I am an individual running a business</option>
          <option value="business">I represent a business entity</option>
        </select>
      </div>
    </div>

    <!-- Individual Form -->
    <div x-show="ownershipType === 'individual'" x-transition class="bg-white p-6 rounded-lg  space-y-4">

 <p class="text-sm text-gray-800">
        Please provide the full names and dates of birth of all individuals who own 25% or more of the accommodation.
      </p>
      <!-- Owner Input Blocks -->
      <template x-for="(owner, index) in owners" :key="index">
        
        <div class="border p-4 rounded-lg space-y-4 bg-white">
          
     
          <div>
            <label class="block  text-sm font-semibold text-gray-600">First Name</label>
            <input type="text" x-model="owner.firstName" placeholder="First Name"
                   class="w-full p-2 border rounded text-sm" />
          </div>

          <div>
            <label class="block  text-sm font-semibold text-gray-600">Last Name</label>
            <input type="text" x-model="owner.lastName" placeholder="Last Name"
                   class="w-full p-2 border rounded text-sm" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
            <input type="date" x-model="owner.dob"
                   class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
          </div>

          <div x-show="owners.length > 1" class="text-right">
            <button @click="owners.splice(index, 1)"
                    class="text-red-600 text-sm hover:underline">
              Remove
            </button>
          </div>
        </div>
      </template>

  <!-- Add Another Owner -->
      <div>
        <button @click="owners.push({ firstName: '', lastName: '', dob: '' })"
                type="button"
                class="text-sky-600 text-sm font-medium hover:underline mt-2">
          + Add another
        </button>
      </div>
      <!-- Single Optional Field Outside Loop -->
      <div>
        <label class="block font-semibold text-sm text-gray-600">
          If any owners go by an alternative name or names, please provide those details.
          <span class="text-gray-500">- (Optional)</span>
        </label>
        <input type="text"
               
               class="w-full p-2 border rounded text-sm" />
      </div>

    
    </div>

    <!-- Business Form -->
    <div x-show="ownershipType === 'business'" x-transition class="bg-white p-6 rounded-lg shadow border space-y-4">


      <div class="border p-4 rounded-lg space-y-4 bg-white">

<div>
            <label class="block  text-sm font-semibold text-gray-600">Full name of business entity</label>
            <input type="text" x-model="owner.firstName" placeholder="First Name"
                   class="w-full p-2 border rounded text-sm" />
          </div>

          <div>
            <label class="block  text-sm font-semibold text-gray-600">Address of business entity</label>
            <input type="text" x-model="owner.address" placeholder="Address"
                   class="w-full p-2 border rounded text-sm" />
          </div>

          <div>
            <label class="block  text-sm font-semibold text-gray-600">Zip Code</label>
            <input type="text" x-model="owner.zipCode" placeholder="Zip Code"
                   class="w-full p-2 border rounded text-sm" />
          </div>
          <div>
            <label class="block  text-sm font-semibold text-gray-600">City</label>
            <input type="text" x-model="owner.city" placeholder="City"
                   class="w-full p-2 border rounded text-sm" />
          </div>
      <div>
  <label class="block text-sm font-semibold text-gray-600">Country</label>
  <select x-model="owner.country"
          class="w-full p-2 border rounded text-sm">
    <option value="" >Select a country</option>
    <option value="Sri Lanka">Sri Lanka</option>
    <option value="India">India</option>
    <option value="United States">United States</option>
    <option value="United Kingdom">United Kingdom</option>
    <option value="Australia">Australia</option>
    <!-- Add more countries as needed -->
  </select>
</div>

          

 <div>
        <label class="block font-semibold text-sm text-gray-600">
        If the company operates under a different name (e.g. "trading as" name) in relation to the accommodation, please provide those details.
          <span class="text-gray-500">- (Optional)</span>
        </label>
        <input type="text"
               
               class="w-full p-2 border rounded text-sm" />
      </div>
          


</div>
 <p class="text-sm text-gray-800">
        Please provide the full names and dates of birth of all individuals who own 25% or more of the accommodation.
      </p>
      <!-- Owner Input Blocks -->
      <template x-for="(owner, index) in owners" :key="index">
        <div class="border p-4 rounded-lg space-y-4 bg-white">
          
          <div>
            <label class="block  text-sm font-semibold text-gray-600">First Name</label>
            <input type="text" x-model="owner.firstName" placeholder="First Name"
                   class="w-full p-2 border rounded text-sm" />
          </div>

          <div>
            <label class="block  text-sm font-semibold text-gray-600">Last Name</label>
            <input type="text" x-model="owner.lastName" placeholder="Last Name"
                   class="w-full p-2 border rounded text-sm" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
            <input type="date" x-model="owner.dob"
                   class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
          </div>

          <div x-show="owners.length > 1" class="text-right">
            <button @click="owners.splice(index, 1)"
                    class="text-red-600 text-sm hover:underline">
              Remove
            </button>
          </div>
        </div>
      </template>

  <!-- Add Another Owner -->
      <div>
        <button @click="owners.push({ firstName: '', lastName: '', dob: '' })"
                type="button"
                class="text-sky-600 text-sm font-medium hover:underline mt-2">
          + Add another
        </button>
      </div>
      <!-- Single Optional Field Outside Loop -->
      <div>
        <label class="block font-semibold text-sm text-gray-600">
          If any owners go by an alternative name or names, please provide those details.
          <span class="text-gray-500">- (Optional)</span>
        </label>
        <input type="text"
               
               class="w-full p-2 border rounded text-sm" />
      </div>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between pt-4">
      <button @click="step--"
             class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">
        
            ←
      </button>
      <button @click="step++"
              class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-blue-600 transition ">
        Continue
      </button>
    </div>
  </div>
</section>

<section x-data="{ businessType: 'individual' }" x-show="step === 6" class="w-full px-4 py-8 max-w-2xl mx-auto lg:ml-32">
    <h2 class="text-2xl font-semibold mb-6">You’re almost there</h2>

    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
        <div>
            <h3 class="text-lg font-semibold mb-2">Are you listing property as a business or individual?</h3>
            <p class="text-sm text-gray-600 mb-4">
                Your answer to this question will help us ensure that we include all of the necessary information in your contract.
            </p>

            <div class="space-y-2">
                <label class="flex items-start space-x-2 mb-4 mt-4">
                    <input type="radio" name="type" value="individual" x-model="businessType" class="mt-1">
                    <div>
                        <span class="font-semibold text-sm">Individual</span>
                        <p class="text-sm text-gray-600">
                            An individual or sole proprietor is a person who owns and operates an unincorporated business on their own.
                        </p>
                    </div>
                </label>

                <label class="flex items-start space-x-2 mb-4">
                    <input type="radio" name="type" value="business" x-model="businessType" class="mt-1">
                    <div>
                        <span class="font-semibold text-sm">Business</span>
                        <p class="text-sm text-gray-600">
                            A business entity can be owned by several individuals, such as a partnership, public or private corporation, non-profit organisation, etc.
                        </p>
                    </div>
                </label>
                <hr class="my-6 border-t border-gray-300 mb-4">

                <p class="text-sm text-gray-700 mb-2 mt-4">
                    In case you choose to list more properties in the future, we will use the information below so that you only need to fill it once.
                </p>
            </div>
        </div>

        <!-- Business Form -->
        <template x-if="businessType === 'business'">
            <div>
               <p class="text-lg font-semibold text-gray-700 ">
                    Legal business name
                </p>
                <hr class="mt-4 border-t border-gray-300 mb-4">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="legal_name">Legal business name <span class="text-red-500">*</span></label>
                        <input type="text" id="legal_name" name="legal_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>


 <p class="text-lg font-semibold text-gray-700 mb-2">
                 Registered business address
                </p>
                <hr class="mt-2 border-t border-gray-300 mb-4">
                  <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                        <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
                            <option selected>Sri Lanka</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 1  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div><div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 2  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="city" class="block text-sm font-medium text-gray-700">City<span class="text-red-500">*</span></label>
                            <input type="text" id="city" name="city" value="a" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                        <div class="flex-1">
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Post code / Zip code</label>
                            <input type="text" id="postcode" name="postcode" value="80400" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                    </div>
                </div>

                 <p class="text-lg font-semibold text-gray-700 mb-2 mt-6">
                    Legal representative’s personal information
                </p>
     <hr class="mt-2 border-t border-gray-300 mb-4">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="full_name">First name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Middle name(s) as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <!-- Phone Number with Country Flag -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
                        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
                            <!-- Flag Image -->
                          <img class="selected-flag w-6 h-4 rounded mr-1" src="https://flagcdn.com/w40/lk.png" alt="Flag">

                            <!-- Country Code Select -->
                         <select class="country-select bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
    <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
    <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
    <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
    <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
</select>


                            <!-- Phone Number Input -->
                            <input type="tel" id="phone" name="phone" placeholder="Enter phone number"
                                class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
                        </div>
                    </div>
            </div>
        </template>

        <!-- Individual Form -->
        <template x-if="businessType === 'individual'">
            <div >
                <p class="text-lg font-semibold text-gray-700 mb-2">
                    Personal information of the contracting party
                </p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1" for="full_name">First name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Middle name(s) as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="last_name">Last name as started on ID <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>

                    <!-- Phone Number with Country Flag -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-800 mb-1">Phone number <span class="text-red-500">*</span></label>
                        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2">
                            <!-- Flag Image -->
                            <img class="selected-flag w-6 h-4 rounded mr-1" src="https://flagcdn.com/w40/lk.png" alt="Flag">

                            <!-- Country Code Select -->
                            <select class="country-select bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
    <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
    <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
    <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
    <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
</select>


                            <!-- Phone Number Input -->
                            <input type="tel" id="phone" name="phone" placeholder="Enter phone number"
                                class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
                        </div>
                    </div>
                    <p class="text-lg font-semibold text-gray-700 mb-2">
                  Primary residence of the contracting party
                </p>
                  <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                        <select id="country" name="country" class="mt-1 p-2 w-full border border-gray-300 rounded">
                            <option selected>Sri Lanka</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 1  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div><div>
                        <label class="block text-sm font-medium mb-1" for="middle_name">Address line 2  <span class="text-red-500">*</span></label>
                        <input type="text" id="middle_name" name="middle_name" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="city" class="block text-sm font-medium text-gray-700">City<span class="text-red-500">*</span></label>
                            <input type="text" id="city" name="city" value="a" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                        <div class="flex-1">
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Post code / Zip code</label>
                            <input type="text" id="postcode" name="postcode" value="80400" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>
                    </div>
                </div>
            </div>
        </template>



    </div>
    <div class="max-w-3xl mx-auto mt-10 p-4 md:p-6 bg-white rounded-md shadow-sm border">
  <h2 class="text-lg font-semibold text-gray-800 mb-4">
    Some important information before you list your hotel on Bookintour.com
  </h2>

 <ul class="space-y-6 text-sm text-gray-700">
  <li>
    <div class="flex items-start gap-4">
      <div class="pt-1">
        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
      </div>
      <div>
        <p class="font-semibold text-sm">Are bookings confirmed straight away?</p>
        <p class="text-sm">Yes. They’re confirmed as soon as a guest makes a booking.</p>
      </div>
    </div>
  </li>

  <li>
    <div class="flex items-start gap-4">
      <div class="pt-1">
        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
      </div>
      <div>
        <p class="font-semibold text-sm">Can I choose who stays at my place?</p>
        <p class="text-sm">No. If a date is open in your calendar, all guests using our site can book it.</p>
      </div>
    </div>
  </li>

  <li>
    <div class="flex items-start gap-4">
      <div class="pt-1">
        <img src="{{ asset('assets/Vector.svg') }}" alt="Help" class="w-6 h-6 min-w-[1.5rem] min-h-[1.5rem]" />
      </div>
      <div>
        <p class="font-semibold text-sm">Can I decide when I get bookings?</p>
        <p class="text-sm">
          Yes. The best way to do this is to keep your calendar up-to-date. Close any dates you don’t want a booking on. If you have bookings on other sites, close those dates as well.
        </p>
      </div>
    </div>
  </li>
</ul>


 
  <div class="mt-6 space-y-4 text-sm text-gray-700">
    <label class="flex items-start gap-2">
      <input type="checkbox" class="mt-1 accent-blue-600">
      <span>
        I certify that this is a legitimate accommodation business with all necessary licenses and permits, which can be shown upon first request. Bookintour.com B.V. reserves the right to verify and investigate any details provided in this registration.
      </span>
    </label>

    <label class="flex items-start gap-2">
      <input type="checkbox" class="mt-1 accent-blue-600">
      <span>
        I have read, accepted, and agreed to the <a href="#" class="text-blue-600 hover:underline">General Delivery Terms</a>.
      </span>
    </label>
  </div>

  
</div>
<!-- Button Row -->
<div class="mt-6">
  <div class="flex gap-4">
    <!-- Back Button -->
    <button  class="border border-[#3CC0E9]  text-blue-600  font-semibold py-2 px-4 rounded">
        ←
    </button>

    <!-- Open for bookings Button (take remaining space) -->
    <button class="flex-1 px-6 py-3 bg-[#3CC0E9]  text-white font-semibold rounded-md hover:bg-[#29ACD5] transition">
      Open for bookings
    </button>
  </div>

  <!-- I'm not ready link -->
  <div class="mt-3 text-center">
    <a href="#" class="text-sky-500 hover:underline text-sm">I'm not ready</a>
  </div>
</div>


</section>
<script>
    const observeFlagDropdowns = () => {
        document.querySelectorAll('.country-select').forEach(select => {
            if (select.dataset.flagAttached) return; // Avoid duplicate listeners

            const wrapper = select.closest('.flex');
            const flag = wrapper?.querySelector('.selected-flag');

            select.addEventListener('change', () => {
                const selectedOption = select.options[select.selectedIndex];
                const newFlag = selectedOption.getAttribute('data-flag');
                if (newFlag && flag) {
                    flag.src = newFlag;
                }
            });

            select.dataset.flagAttached = "true";
        });
    };

    // Initial run
    document.addEventListener('DOMContentLoaded', observeFlagDropdowns);

    // Watch for dynamic DOM changes (e.g., from Alpine x-if)
    const observer = new MutationObserver(() => {
        observeFlagDropdowns();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
</script>


  </div>
</div>

</body>
</html>
