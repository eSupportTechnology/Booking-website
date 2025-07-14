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



<div x-data="{ step: 1, wizardStep: 1 , propertyWizardStep: 1 }">

 <!-- Sticky Top Navbar -->
  <nav class="border-b shadow-sm sticky top-0 z-50 ">
    <div class="max-w-full mx-auto px-4 py-3">
      
      <!-- Scrollable/Responsive Nav Items -->
      <div class="flex flex-wrap sm:flex-nowrap overflow-x-auto space-x-6 sm:space-x-10 md:space-x-14 lg:space-x-20 xl:space-x-24 text-sm font-medium whitespace-nowrap">
        
        <!-- Loop through nav steps -->
        <template x-for="(label, index) in ['Basic information', 'Property setup', 'Photos', 'Pricing and calendar', 'Legal information', 'Review and complete']" :key="index">
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
  <div class="flex space-x-1 mt-1 w-35 sm:w-48 md:w-56 lg:w-64 xl:w-72 ml-[-15px] sm:ml-[-25px] md:ml-[-35px]">
    <template x-for="i in 6">
      <div 
        :class="propertyWizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'" 
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
      type="submit"
     @click="wizardStep++"
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
  <div x-data="{ showBedTypeSelector: false }">
    
    <!-- Header -->
    <h2 class="text-2xl font-bold mb-6">Property details</h2>
    <p class="text-gray-600 mb-4">Where can people sleep?</p>

    <!-- Bedroom Cards -->
    <div class="space-y-4">
      <!-- Bedroom 1 -->
      <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
        <div>
          <h3 class="text-lg font-medium">Bedroom 1</h3>
          <p class="text-sm text-gray-600">1 double bed</p>
        </div>
        <button class="bg-gray-200 hover:bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded-full focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Living Room -->
      <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
        <div>
          <h3 class="text-lg font-medium">Living room</h3>
          <p class="text-sm text-gray-600">0 beds</p>
        </div>
        <button class="bg-gray-200 hover:bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded-full focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Other Spaces -->
      <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
        <div>
          <h3 class="text-lg font-medium">Other spaces</h3>
          <p class="text-sm text-gray-600">0 beds</p>
        </div>
        <button class="bg-gray-200 hover:bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded-full focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Add Bedroom Button -->
    <div class="flex items-center mt-6">
      <button 
        @click="showBedTypeSelector = true"
        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add bedroom
      </button>
    </div>

    <!-- Bed Type Selector (Only this toggles visibility) -->
    <div x-show="showBedTypeSelector" class="mt-6 bg-white border border-gray-300 p-6 rounded shadow-md">
      <h3 class="text-xl font-semibold mb-4">Select bed types for new bedroom</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="h-4 w-4 text-blue-600">
          <span>Double bed</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="h-4 w-4 text-blue-600">
          <span>Single bed</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="h-4 w-4 text-blue-600">
          <span>Queen bed</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="checkbox" class="h-4 w-4 text-blue-600">
          <span>Sofa bed</span>
        </label>
      </div>

      <!-- Save and Cancel -->
      <div class="flex justify-end mt-6 space-x-4">
        <button 
          @click="showBedTypeSelector = false"
          class="text-gray-600 hover:underline text-sm">
          Cancel
        </button>
        <button 
          @click="showBedTypeSelector = false"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm font-medium">
          Save Bedroom
        </button>
      </div>
    </div>
 <div class="flex justify-between mt-4">
          <button @click="propertyWizardStep--"
            class="text-blue-600 border border-blue-600 px-4 py-2 rounded hover:bg-blue-50">
            Back
          </button>
          <button @click="propertyWizardStep++"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Next
          </button>
        </div>
  </div>
</template>








    <template x-if="propertyWizardStep === 2">
      
  <div class="max-w-2xl mx-auto space-y-8">
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


 <div class="flex justify-between mt-6">
    <!-- Back Button -->
<button
  type="button"
 @click="propertyWizardStep--"
  class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
  ←
</button>



    <!-- Continue Button -->
   <!-- Continue Button (inside input field container, aligned right) -->
  <div class="flex justify-end ">
    <button
      type="submit"
    @click="propertyWizardStep++"
      class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
      Continue 
    </button>
  </div>

  </div>
  </div>


    </template>




    <template x-if="propertyWizardStep === 3">
    <div class="space-y-8 max-w-2xl mx-auto p-4">

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
            <div>
                <p class="font-semibold text-sm text-gray-800 mb-2">What type of breakfast do you offer? <span class="text-sm text-gray-500">(Select all that apply)</span></p>
                <div class="flex flex-wrap gap-2">
                    @foreach(['A la carte', 'American', 'Asian', 'Breakfast to go', 'Buffet', 'Continental', 'Full English/Irish', 'Gluten-Free', 'Halal', 'Italian', 'Kosher', 'Vegan', 'Vegetarian'] as $option)
                        <label class="bg-gray-100 px-3 py-1 rounded-full text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-200">
                            <input type="checkbox" class="hidden"> {{ $option }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Parking Section -->
        <div class="bg-white shadow rounded-lg p-6 space-y-4 border">
            <h3 class="text-xl font-semibold text-gray-700">Parking</h3>

            <!-- Is parking available -->
            <div>
                <p class="font-medium text-gray-800 mb-2">Is parking available to guests?</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <label><input type="radio" name="parking_available" class="mr-2"> Yes, free</label>
                    <label><input type="radio" name="parking_available" class="mr-2"> Yes, paid</label>
                    <label><input type="radio" name="parking_available" class="mr-2"> No</label>
                </div>
            </div>

            <!-- Parking cost -->
            <div>
                <p class="font-medium text-gray-800 mb-2">How much does parking cost?</p>
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <select class="border rounded px-3 py-2 w-40">
                        <option>USD</option>
                        <option>LKR</option>
                    </select>
                    <input type="text" placeholder="Amount" class="border rounded px-3 py-2 w-32">
                    <select class="border rounded px-3 py-2 w-32">
                        <option>Per day</option>
                        <option>Per stay</option>
                    </select>
                </div>
            </div>

            <!-- Reservation needed -->
            <div>
                <p class="font-medium text-gray-800 mb-2">Do guests need to reserve a parking spot?</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <label><input type="radio" name="parking_reservation" class="mr-2"> Reservation needed</label>
                    <label><input type="radio" name="parking_reservation" class="mr-2"> No reservation needed</label>
                </div>
            </div>

            <!-- Parking location -->
            <div>
                <p class="font-medium text-gray-800 mb-2">Where is the parking located?</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <label><input type="radio" name="parking_location" class="mr-2"> On site</label>
                    <label><input type="radio" name="parking_location" class="mr-2"> Off site</label>
                </div>
            </div>
        </div>

    </div>
</template>


    <template x-if="propertyWizardStep === 4">
      <div class="max-w-4xl mx-auto space-y-8">
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
  <div class="max-w-4xl mx-auto space-y-8">
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
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
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
    <div class="space-y-6 max-w-4xl mx-auto p-4">

        <!-- Section Heading -->
        <p class="text-lg text-gray-800 font-medium">
            Help your listing stand out by telling potential guests a little more about yourself, your property, and your neighborhood.
            <br class="hidden sm:block" />
            This info will appear on your property page.
        </p>

        <!-- The Property -->
        <div class="space-y-2">
            <label class="flex items-start space-x-2">
                <input type="checkbox" class="mt-1">
                <span class="text-gray-800 font-medium">The property</span>
            </label>
            <div>
                <label class="block text-sm text-gray-600 mb-1">About the property</label>
                <textarea rows="4" maxlength="1200" placeholder="What makes your place unique? What can guests expect"
                    class="w-full border rounded px-4 py-2 resize-none"></textarea>
                <div class="text-right text-sm text-gray-500">0/1200</div>
            </div>
        </div>

        <!-- The Host -->
        <div class="space-y-2">
            <label class="flex items-start space-x-2">
                <input type="checkbox" class="mt-1">
                <span class="text-gray-800 font-medium">The host</span>
            </label>

            <!-- Host name -->
            <div>
                <label class="block text-sm text-gray-600 mb-1">Host name</label>
                <input type="text" maxlength="80" class="w-full border rounded px-4 py-2" />
                <div class="text-right text-sm text-gray-500">0/80</div>
            </div>

            <!-- About host -->
            <div>
                <label class="block text-sm text-gray-600 mb-1">About the host</label>
                <textarea rows="4" maxlength="1200" placeholder="What are your interests? What do you like about hosting?"
                    class="w-full border rounded px-4 py-2 resize-none"></textarea>
                <div class="text-right text-sm text-gray-500">0/1200</div>
            </div>
        </div>

        <!-- The Neighborhood -->
        <div class="space-y-2">
            <label class="flex items-start space-x-2">
                <input type="checkbox" class="mt-1">
                <span class="text-gray-800 font-medium">The neighborhood</span>
            </label>
            <div>
                <label class="block text-sm text-gray-600 mb-1">About the neighborhood</label>
                <textarea rows="4" maxlength="1200" placeholder="What’s the area like? Are there any attractions nearby?"
                    class="w-full border rounded px-4 py-2 resize-none"></textarea>
                <div class="text-right text-sm text-gray-500">0/1200</div>
            </div>
        </div>

        <!-- None of the above -->
        <div>
            <label class="flex items-start space-x-2">
                <input type="checkbox" class="mt-1">
                <span class="text-gray-800 font-medium">None of the above / I'll add these later</span>
            </label>
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
  <h2 class="text-2xl font-bold text-blue-700 mb-4">Pricing and calendar</h2>
  <p class="text-gray-600">Set your nightly rates, availability, and booking rules.</p>
  <!-- Add your pricing and calendar form here -->
</section>

<!-- ✅ Step 5: Legal Information -->
<section x-show="step === 5">
  <h2 class="text-2xl font-bold text-blue-700 mb-4">Legal information</h2>
  <p class="text-gray-600">Provide required legal documents and compliance information.</p>
  <!-- Add your legal details form here -->
</section>

<!-- ✅ Step 6: Review and Complete -->
<section x-show="step === 6">
  <h2 class="text-2xl font-bold text-blue-700 mb-4">Review and complete</h2>
  <p class="text-gray-600">Review all details you’ve entered before publishing your property listing.</p>
  <!-- Add summary and submit button here -->
</section>


  </div>
</div>

</body>
</html>
