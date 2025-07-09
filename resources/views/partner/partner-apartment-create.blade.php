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
  <div class="max-w-6xl p-4 ml-14 mt-1 bg-gray-100" x-data="{ step: 1 }">
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
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>
      <button type="button"
      @click="step = step + 1"
              
              class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] text-white"> 
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
            <button   @click="step++" class="w-full bg-[#3CC0E9] hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Continue
            </button>
            <button   @click="step--" class="w-full border border-[#3CC0E9] text-[#3CC0E9] hover:bg-blue-50 font-semibold py-2 px-4 rounded mb-6">
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
        :class="url ? 'bg-blue-500 text-white cursor-pointer hover:bg-blue-600' : 'bg-gray-300 text-gray-600 cursor-not-allowed'" 
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
              class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded  ">
        ←
      </button>
      <button type="button" @click="step++"
              :disabled="selectedChannels.length === 0"
              :class="selectedChannels.length === 0 
                ? 'bg-gray-300 text-gray-600 cursor-not-allowed' 
                : 'bg-[#3CC0E9] hover:bg-blue-700 text-white cursor-pointer'"
              class="font-semibold py-3 px-6 rounded transition duration-200  ">
        Continue
      </button>
    </div>
  </template>
  </div>
</div>
<!--Main Step 3 End-->



      
<!-- Main Step 4  -->
<div x-show="step === 4" x-cloak>
  <div x-data="{ substep: 1 }" >

    <!-- 🧭 Wizard Top Navigation -->
    <div class="flex flex-wrap justify-between items-center border-b pb-4 mb-6 text-sm font-medium text-gray-700 mt-2">
      <template x-for="(label, index) in ['Basic Info', 'Property', 'Photos', 'Pricing', 'Legal Info', 'Review']">
        <button
          class="py-1 px-3 rounded hover:bg-blue-100 transition"
          :class="substep === index + 1 ? ' text-blue-600' : 'text-gray-700'"
          @click="substep = index + 1"
          x-text="label">
        </button>
      </template>
    </div>

    <!-- Main Step 4- Substep 1: Basic Info -->
<div x-show="substep === 1" x-cloak x-data="{ sub1step: 1 }">
<!-- Wizard Progress for Basic Info (Compact Height) -->
<div class="flex items-center justify-between mb-4 mx-auto max-w-md">
  <template x-for="n in 3">
    <div class="w-1/3 text-center">
      <!-- Step Number Circle -->
      <div :class="sub1step >= n ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700'"
           class="rounded-full w-6 h-6 mx-auto flex items-center justify-center text-sm"
           x-text="n"></div>

      <!-- Line Connector -->
      <template x-if="n < 3">
        <div class="flex-1 border-t-2 mt-3 mx-2"
             :class="sub1step > n ? 'border-blue-600' : 'border-gray-300'"></div>
      </template>
    </div>
  </template>
</div>

  <!-- Basin info-Step 1 -->
  <div x-show="sub1step === 1" x-cloak>
<section class="mb-8">
  <h1 class="text-2xl font-bold mb-4">What's the name of your place?</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Property Name Input (2/3 Width) -->
    <div class="md:col-span-2 flex">
      <div class="w-full bg-white p-6 rounded shadow-md flex flex-col">
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
      type="submit"
      @click="sub1step++"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
      Continue 
    </button>
  </div>

  </div>
</section>


  </div>

<!--end basic infor step 1-->

  <!-- Basic info-step2 -->


<div x-show="sub1step === 2" x-cloak>
    <div class="relative w-[1300px] h-[800px] overflow-hidden rounded-lg shadow mx-auto">

        <!-- Google Maps iframe full background -->
        <iframe 
            class="absolute inset-0 w-full h-full"
            loading="lazy"
            src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
            allowfullscreen
        ></iframe>

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
          @click="sub1step--"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>
  

  <!-- Continue Button (Right) -->
  <button type="submit"
          @click="sub1step++"
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



  
  <!--Basic info step 3 start -->
<div x-show="sub1step === 3" x-cloak>
  <section class="mb-12" x-data="{ channelManager: 'yes' }">
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

    <button type="button"   @click="sub1step--"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>
 

  <!-- Continue Button (Right) -->
  <button type="submit"
          @click="substep++"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
    Continue
  </button>
</div>
    </div>
  </section>
</div>


</div>
<!--basic infor end-->

    <!-- Substep 2: Property -->
    <div x-show="substep === 2" x-cloak>
      <h2 class="text-xl font-semibold mb-4">Where is your property located?</h2>
      <label class="block mb-2">Address</label>
      <input
        type="text"
        name="address"
        class="w-full border p-2 rounded mb-4"
        placeholder="Enter your address"
        required
      />
    </div>

    <!-- Substep 3: Photos -->
    <div x-show="substep === 3" x-cloak>
      <h2 class="text-xl font-semibold mb-4">Upload Photos</h2>
      <input
        type="file"
        name="property_photos"
        multiple
        class="w-full border p-2 rounded"
      />
    </div>

    <!-- Substep 4: Pricing -->
    <div x-show="substep === 4" x-cloak>
      <h2 class="text-xl font-semibold mb-4">Set Your Pricing</h2>
      <label class="block mb-2">Nightly Rate</label>
      <input
        type="number"
        name="nightly_rate"
        class="w-full border p-2 rounded"
        placeholder="e.g., 100"
      />
    </div>

    <!-- Substep 5: Legal Info -->
    <div x-show="substep === 5" x-cloak>
      <h2 class="text-xl font-semibold mb-4">Legal Information</h2>
      <label class="block mb-2">Tax ID / Business Registration</label>
      <input
        type="text"
        name="legal_info"
        class="w-full border p-2 rounded"
        placeholder="Enter your tax ID or license"
      />
    </div>

    <!-- Substep 6: Review -->
    <div x-show="substep === 6" x-cloak>
      <h2 class="text-xl font-semibold mb-4">Review Your Details</h2>
      <p class="text-gray-600">Please check all information before submitting your listing.</p>
    </div>

    <!-- Substep Navigation -->
    <div class="flex justify-between mt-6">
      <button type="button"
              class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-200"
              x-show="substep > 1"
              @click="substep--">
        Back
      </button>
      <button type="button"
              class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
             x-show="substep > 1 && substep < 6"
              @click="substep++">
        Next
      </button>
      <button type="submit"
              class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700"
              x-show="substep === 6">
        Submit
      </button>
    </div>

  </div>
</div>



      <!-- Step 5 -->
      <div x-show="step === 5" x-cloak>
        <label class="block mb-2">Date of Birth</label>
        <input type="date" name="dob" class="w-full border p-2 rounded" required />
      </div>

      <!-- Step 6 -->
      <div x-show="step === 6" x-cloak>
        <label class="block mb-2">Gender</label>
        <select name="gender" class="w-full border p-2 rounded" required>
          <option value="">Select</option>
          <option>Male</option>
          <option>Female</option>
          <option>Other</option>
        </select>
      </div>

      <!-- Step 7 -->
      <div x-show="step === 7" x-cloak>
        <label class="block mb-2">Education Level</label>
        <input
          type="text"
          name="education"
          class="w-full border p-2 rounded"
          placeholder="Enter your highest education level"
          required
        />
      </div>

      <!-- Step 8 -->
      <div x-show="step === 8" x-cloak>
        <label class="block mb-2">Skills</label>
        <textarea
          name="skills"
          rows="3"
          class="w-full border p-2 rounded"
          placeholder="List your skills"
          required
        ></textarea>
      </div>

      <!-- Step 9 -->
      <div x-show="step === 9" x-cloak>
        <label class="block mb-2">Upload Resume</label>
        <input
          type="file"
          name="resume"
          class="w-full border p-2 rounded"
          accept=".pdf,.doc,.docx"
          required
        />
      </div>

      <!-- Step 10 -->
      <div x-show="step === 10" x-cloak>
        <label class="block mb-2">Comments</label>
        <textarea
          name="comments"
          rows="4"
          class="w-full border p-2 rounded"
          placeholder="Additional comments..."
        ></textarea>
      </div>

      <!-- Buttons with unique styles per step -->
      <div class="flex justify-between pt-4">
     

        


      
        <!-- Step 5 -->
        <template x-if="step === 5">
          <div class="flex justify-between w-full space-x-2">
            <button
              type="button"
              @click="step--"
              class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600"
            >
              Back
            </button>
            <button
              type="button"
              @click="step++"
              class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700"
            >
              Next
            </button>
          </div>
        </template>

        <!-- Step 6 -->
        <template x-if="step === 6">
          <div class="flex justify-between w-full space-x-2">
            <button
              type="button"
              @click="step--"
              class="px-4 py-2 bg-indigo-500 text-white rounded hover:bg-indigo-600"
            >
              Back
            </button>
            <button
              type="button"
              @click="step++"
              class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700"
            >
              Next
            </button>
          </div>
        </template>

        <!-- Step 7 -->
        <template x-if="step === 7">
          <div class="flex justify-between w-full space-x-2">
            <button
              type="button"
              @click="step--"
              class="px-4 py-2 bg-cyan-500 text-white rounded hover:bg-cyan-600"
            >
              Back
            </button>
            <button
              type="button"
              @click="step++"
              class="px-4 py-2 bg-amber-600 text-white rounded hover:bg-amber-700"
            >
              Next
            </button>
          </div>
        </template>

        <!-- Step 8 -->
        <template x-if="step === 8">
          <div class="flex justify-between w-full space-x-2">
            <button
              type="button"
              @click="step--"
              class="px-4 py-2 bg-lime-600 text-white rounded hover:bg-lime-700"
            >
              Back
            </button>
            <button
              type="button"
              @click="step++"
              class="px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700"
            >
              Next
            </button>
          </div>
        </template>

        <!-- Step 9 -->
        <template x-if="step === 9">
          <div class="flex justify-between w-full space-x-2">
            <button
              type="button"
              @click="step--"
              class="px-4 py-2 bg-blue-400 text-white rounded hover:bg-blue-500"
            >
              Back
            </button>
            <button
              type="button"
              @click="step++"
              class="px-4 py-2 bg-green-400 text-white rounded hover:bg-green-500"
            >
              Next
            </button>
          </div>
        </template>

        <!-- Step 10 -->
        <template x-if="step === 10">
          <div class="flex justify-between w-full space-x-2">
            <button
              type="button"
              @click="step--"
              class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
            >
              Back
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-green-700 text-white rounded hover:bg-green-800"
            >
              Submit
            </button>
          </div>
        </template>
      </div>
    </form>
  </div>
</body>
</html>