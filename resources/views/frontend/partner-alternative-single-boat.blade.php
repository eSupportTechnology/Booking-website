@extends('frontend.partner-layout')

@section('title', 'Alternative Places One Campsite')

@section('content')



<div x-data="{ step: 1, wizardStep: 1 , propertyWizardStep: 1, pricingWizardStep:1 }">

 <!-- Sticky Top Navbar -->
<nav class="border-b shadow-sm sticky top-0 z-50 bg-white">
  <div class="max-w-full mx-auto px-4 py-3 overflow-x-auto">
    <!-- Scrollable/Responsive Nav Items -->
    <div class="flex flex-nowrap min-w-max space-x-6 sm:space-x-12 md:space-x-8 lg:space-x-24 xl:space-x-24 text-sm font-medium whitespace-nowrap">

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
            <template x-if="index === 1 && propertyWizardStep === 6">
              <span class="text-green-600">✔️</span>
            </template>
            <template x-if="index === 3 && pricingWizardStep === 3">
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

          <!-- Progress bar under "Pricing and calendar" tab -->
          <template x-if="index === 3 && step === 4">
            <div class="flex space-x-1 mt-1 w-35 sm:w-48 md:w-46 lg:w-54 xl:w-62 ml-[-15px] sm:ml-[-25px] md:ml-[-35px]">
              <template x-for="i in 3">
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
          <div class="lg:ml-32">
 <div class="w-full px-4 py-8 md:px-16 lg:px-3 mx-auto ">
        <div class="max-w-5xl ">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-8 mt-4">
                What's the name of your place?
            </h1>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left: Form -->
                <div class="flex-1">
                 <div class="bg-white p-6 rounded-lg shadow-md 
            min-h-[220px] sm:min-h-[250px] md:min-h-[300px] lg:min-h-[350px]">
    <label for="property_name" class="block text-sm font-medium text-gray-700 mb-2">
        Property name
    </label>
    <input id="property_name" name="property_name" type="text" value="ccc"
        class="w-full border border-gray-300 rounded px-4 py-2 text-gray-800"
        placeholder="Enter property name">

    <p class="text-sm text-gray-500 mt-2">
        This name will be seen by guests when they search for a place to stay.
    </p>
</div>

                    <!-- Buttons -->
            <div class="flex justify-between items-center mt-10">
                <button type="button" @click="step--"
                    class="border border-[#3CC0E9] text-blue-600 font-medium px-4 py-2 rounded hover:bg-sky-50">
                    ←
                </button>
                <button type="button"  @click="wizardStep++"
                    class="bg-[#3CC0E9] hover:bg-sky-500 text-white font-semibold px-6 py-3 rounded ">
                    Continue
                </button>
            </div>
                </div>

                

               <!-- Right: Tips -->
<div class="flex-1 flex flex-col gap-4 max-w-md w-full">
    <!-- Tip 1 -->
    <div x-data="{ show: true }" x-show="show"
        class="relative border border-gray-200 rounded-lg p-4 bg-white shadow w-full  max-w-xs">
        <button @click="show = false"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
            ✕
        </button>
        <h2 class="font-semibold text-gray-800 text-sm mb-2">
            What should I consider when choosing a name?
        </h2>
        <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
            <li>Keep it short and catchy</li>
            <li>Avoid abbreviations</li>
            <li>Stick to the facts</li>
        </ul>
    </div>

    <!-- Tip 2 -->
    <div x-data="{ show: true }" x-show="show"
        class="relative border border-gray-200 rounded-lg p-4 bg-white shadow w-full  max-w-xs">
        <button @click="show = false"
            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
            ✕
        </button>
        <h2 class="font-semibold text-gray-800 text-sm mb-2">
            Why do I need to name my property?
        </h2>
        <p class="text-sm text-gray-600">
            This is the name that will appear as the title of your listing on our site. It should tell
            guests something specific about your place, where it is or what you offer.
            This will be visible to anyone visiting our site, so don't include your address in the name.
        </p>
    </div>
</div>


            
        </div>
    </div>
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
          <div class="max-w-5xl mx-auto px-4 py-8 lg:ml-24">
    <h1 class="text-2xl md:text-3xl font-bold mb-4 mt-4">Connect to a channel manager</h1>

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
<div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">

        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-8">Property details</h2>


       
        <!-- Where can people sleep -->
        <div class="bg-white p-4 rounded-lg shadow space-y-4">
            <h2 class="text-sm font-semibold text-gray-700 mb-1">Where can people sleep?</h2>

            <div class="flex flex-col gap-4">
                <!-- Bedroom -->
                <a href="#">
                    <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
                        <p class="text-sm">Bedroom 1</p>
                        <p class="text-sm text-gray-600">No beds added</p>
                    </div>
                </a>

                <!-- Living Room -->
                <a href="#">
                    <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
                        <p class="text-sm">Living Room</p>
                        <p class="text-sm text-gray-600">No beds added</p>
                    </div>
                </a>

                <!-- Other Spaces -->
                <a href="#">
                    <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer">
                        <p class="text-sm">Other spaces</p>
                        <p class="text-sm text-gray-600">No beds added</p>
                    </div>
                </a>
            </div>

            <!-- Add Bedroom Button -->
            <a href="#" class="text-blue-600 hover:underline text-sm flex items-center space-x-1 mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                <span>Add Bedroom</span>
            </a>
        </div>

        <!-- Alpine.js -->
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- Guests and Bathrooms -->
        <div x-data="{ guests: 2, bathrooms: 1 }"
            class="bg-white p-4 rounded-lg shadow space-y-4 w-full max-w-xl">
            <!-- Guests -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">How many guests can stay ?</label>
                <div class="flex items-center space-x-4 mt-1">
                    <button @click="if (guests > 1) guests--"
                        class="border px-3 py-1 rounded text-base">−</button>
                    <span class="min-w-[2rem] text-center text-gray-700 text-base"
                        x-text="guests"></span>
                    <button @click="guests++"
                        class="border px-3 py-1 rounded text-base">+</button>
                </div>
            </div>

            <!-- Bathrooms -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">How many bathrooms are there ?</label>
                <div class="flex items-center space-x-4 mt-1">
                    <button @click="if (bathrooms > 0) bathrooms--"
                        class="border px-3 py-1 rounded text-base">−</button>
                    <span class="min-w-[2rem] text-center text-gray-700 text-base"
                        x-text="bathrooms"></span>
                    <button @click="bathrooms++"
                        class="border px-3 py-1 rounded text-base">+</button>
                </div>
            </div>
        </div>

      <!-- Children Policy -->
<div x-data="{ 
    childrenAllowed: 'yes', 
    offerCots: 'yes', 
    costType: 'Fixed', 
    cotsAvailable: 1 
}" 
class="bg-white p-4 rounded-lg shadow space-y-4">

    <!-- Do you allow children? -->
    <div>
        <p class="text-sm font-semibold text-gray-700 mb-1">Do you allow children?</p>
        <label class="mr-4 text-sm">
            <input type="radio" name="children" value="yes" x-model="childrenAllowed"> Yes
        </label>
        <label class="text-sm">
            <input type="radio" name="children" value="no" x-model="childrenAllowed"> No
        </label>
    </div>

    <!-- Cots Section - only if childrenAllowed === 'yes' -->
    <template x-if="childrenAllowed === 'yes'">
        <div class="space-y-4">

            <!-- Do you offer cots? -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-1">Do you offer cots?</p>
                <p class="text-xs text-gray-500 mb-1">
                    Cots sleep most infants 0–3 years old and can be made available to guests on request.
                </p>
                <label class="mr-4 text-sm">
                    <input type="radio" name="offer_cots" value="yes" x-model="offerCots"> Yes
                </label>
                <label class="text-sm">
                    <input type="radio" name="offer_cots" value="no" x-model="offerCots"> No
                </label>
            </div>

            <!-- Cots details - visible only if offerCots === 'yes' -->
            <template x-if="offerCots === 'yes'">
                <div class="space-y-4">

                    <!-- How many cots are available -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-1">How many cots are available?</p>
                        <div class="flex items-center space-x-4 mt-1">
                            <button @click="if (cotsAvailable > 1) cotsAvailable--"
                                class="border px-3 py-1 rounded text-base">−</button>
                            <span class="min-w-[2rem] text-center text-gray-700 text-base" x-text="cotsAvailable"></span>
                            <button @click="cotsAvailable++"
                                class="border px-3 py-1 rounded text-base">+</button>
                        </div>
                    </div>

                    <!-- Cost per night -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-1">How much does one cot cost per night?</p>
                        <p class="text-xs text-gray-500">
                            This policy is set at the property level – any changes made will be applied to all apartments.
                        </p>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 mt-2 space-y-2 sm:space-y-0">
                            <select x-model="costType" class="w-24 border border-gray-300 rounded-md px-2 py-2 text-sm">
                                <option>Fixed</option>
                                <option>Free</option>
                            </select>

                            <!-- Show input only if costType is Fixed -->
                            <template x-if="costType === 'Fixed'">
                                <div class="flex items-center px-1 py-1 w-full sm:w-auto">
                                    <span class="text-gray-500 mr-1">US$</span>
                                    <input type="number" step="0.01"
                                        class="w-full border rounded-md border-gray-300 text-sm"
                                        placeholder="0.00">
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </template>
        </div>
    </template>
</div>

        <!-- Room Size -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4">
            <div class="flex flex-col lg:flex-row gap-4 items-end">
                <!-- Apartment Size Input -->
                <div class="w-full lg:w-2/4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">How big is this boat?</label>
                    <p class="text-xs text-gray-500">Boat size - optional</p>
                    <input type="number" min="1" step="1" inputmode="numeric" pattern="\d*"
                        class="w-full border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2">
                </div>

                <!-- Size Unit Dropdown -->
                <div class="w-full lg:w-1/4">
                    <label class="block text-sm text-transparent mb-1">Unit</label>
                    <select
                        class="w-full bg-gray-300 text-black border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2">
                        <option>square meters</option>
                        <option>square feet</option>
                    </select>

                    
                </div>
                
            </div>
          
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between">
            <!-- Back Button -->
            <button type="button" @click="propertyWizardStep--"
                :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                ←
            </button>

            <!-- Continue Button -->
            <button type="button"   @click="propertyWizardStep++"
                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                Continue
            </button>
        </div>
    </div>

</template>









    <template x-if="propertyWizardStep === 2">
      
 <div class="max-w-2xl mx-auto space-y-8 lg:ml-32">

    <!-- Heading -->
     <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-8">What can guests use at your place?</h2>

   <!-- Amenities Section Container -->
<div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
  @php
    $amenities = [
      'Highlights' => ['Private bathroom', 'BBQ facilities', 'Washing machine', 'Bath', 'Balcony'],
      'General' => ['Non-smoking rooms', 'Towels', 'Linen', 'Air conditioning','Family rooms','Tea/Coffee maker','Electric kettle','Free WiFi','Electric vehicle charging station'],
     
      'Entertainment' => ['Bar', 'Flat-screen TV', 'Swimming Pool', 'Hot tub', 'Sauna'],
      'Outside and view' => ['Terrace', 'Beach', 'View', 'Garden']
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
    <div class="space-y-8 max-w-2xl mx-auto p-4 lg:ml-32 mt-6">

        <!-- Services at your property -->
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Services at your property</h2>

  <!-- Breakfast Section -->
<div x-data="{ 
    serveBreakfast: '', 
    breakfastIncluded: '', 
    selectedBreakfastTypes: [], 
    breakfastPrice: '',

    breakfastOptions: [
        'À la carte', 'American', 'Asian', 'Breakfast to go', 'Buffet', 'Continental',
        'Full English/Irish', 'Gluten-free', 'Halal', 'Italian', 'Kosher', 'Vegan', 'Vegetarian'
    ],

    toggleBreakfastOption(option) {
        if (this.selectedBreakfastTypes.includes(option)) {
            this.selectedBreakfastTypes = this.selectedBreakfastTypes.filter(o => o !== option);
        } else {
            this.selectedBreakfastTypes.push(option);
        }
    }
}" 
class="bg-white shadow rounded-lg p-6 space-y-4 border">

    <!-- Section Title -->
    <h3 class="text-lg mb-4 font-bold">Breakfast</h3>
    <hr class="my-6 border-t border-gray-300">

    <!-- Do you serve guests breakfast -->
    <div>
        <p class="text-gray-700 mb-2 font-bold text-base">Do you serve guests breakfast?</p>
        <div class="flex flex-col text-sm gap-2">
            <label>
                <input type="radio" name="serve_breakfast" value="yes" x-model="serveBreakfast" class="mr-2"> Yes
            </label>
            <label>
                <input type="radio" name="serve_breakfast" value="no" x-model="serveBreakfast" class="mr-2"> No
            </label>
        </div>
    </div>

    <!-- Show this section only if serveBreakfast === 'yes' -->
    <template x-if="serveBreakfast === 'yes'">
        <div class="space-y-6">

            <!-- Is breakfast included -->
            <div>
                <p class="text-gray-700 mb-2 font-bold text-base">Is breakfast included in the price guests pay?</p>
                <div class="flex flex-col text-sm gap-2">
                    <label>
                        <input type="radio" name="breakfast_included" value="yes" x-model="breakfastIncluded" class="mr-2"> Yes, it's included
                    </label>
                    <label>
                        <input type="radio" name="breakfast_included" value="no" x-model="breakfastIncluded" class="mr-2"> No, it costs extra
                    </label>
                </div>
            </div>

            <!-- Show price input if breakfastIncluded === 'no' -->
            <template x-if="breakfastIncluded === 'no'">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Breakfast price per person (US$)</label>
                    <input type="number" min="0" step="0.01" x-model="breakfastPrice"
                           class="border border-gray-300 rounded-md px-3 py-2 text-sm w-40"
                           placeholder="0.00">
                </div>
            </template>

            <hr class="my-6 border-t border-gray-300">

            <!-- Type of breakfast -->
            <div>
                <p class="text-gray-700 mb-2 font-bold text-base">What type of breakfast do you offer?</p>
                <p class="text-sm text-gray-500 mb-2">Select all that apply</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="option in breakfastOptions" :key="option">
                        <button type="button"
                                @click="toggleBreakfastOption(option)"
                                :class="selectedBreakfastTypes.includes(option) 
                                    ? 'bg-blue-100 border-blue-500 text-blue-700' 
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                class="border px-3 py-1 rounded-full text-sm flex items-center space-x-1 transition">
                            <span x-text="option"></span>
                            <template x-if="selectedBreakfastTypes.includes(option)">
                                <span class="ml-1 font-bold text-lg leading-none">×</span>
                            </template>
                        </button>
                    </template>
                </div>
            </div>

        </div>
    </template>
</div>



       <!-- Parking Section -->
<div x-data="{ parking: 'no' }" class="container bg-white shadow rounded-lg mx-auto p-6 max-w-6xl mb-8">
    <h3 class="text-lg mb-4 font-bold">Parking</h3>
    <hr class="border-gray-300 mb-4" />

    <!-- Main Question -->
    <p class="text-gray-700 mb-2 font-bold">
        Is parking available to guests?
    </p>
    <div class="space-y-2 mb-4">
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="free" x-model="parking" class="mr-2" />
            <span>Yes, free</span>
        </label>
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="paid" x-model="parking" class="mr-2" />
            <span>Yes, paid</span>
        </label>
        <label class="flex items-center cursor-pointer">
            <input type="radio" name="parking" value="no" x-model="parking" class="mr-2" />
            <span>No</span>
        </label>
    </div>

    <!-- Extra Fields for Free or Paid Parking -->
    <div x-show="parking === 'free' || parking === 'paid'" x-transition class="space-y-4">
        <!-- Reservation Needed -->
        <div>
            <p class="text-gray-700 font-semibold mb-1">Do they need to reserve a parking spot?</p>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="reservation_needed" value="yes" class="mr-2" />
                    <span>Reservation needed</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="reservation_needed" value="no" class="mr-2" />
                    <span>No reservation needed</span>
                </label>
            </div>
        </div>

        <!-- Parking Location -->
        <div>
            <p class="text-gray-700 font-semibold mb-1">Where is the parking located?</p>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="location" value="on_site" class="mr-2" />
                    <span>On site</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="location" value="off_site" class="mr-2" />
                    <span>Off site</span>
                </label>
            </div>
        </div>

        <!-- Parking Type -->
        <div>
            <p class="text-gray-700 font-semibold mb-1">What type of parking is it?</p>
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="radio" name="type" value="private" class="mr-2" />
                    <span>Private</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="type" value="public" class="mr-2" />
                    <span>Public</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Paid Parking - Cost Input -->
   <div x-show="parking === 'paid'" x-transition class="mt-4">
    <label class="block text-gray-700 font-semibold mb-1">How much does parking cost?</label>
    
    <div class="flex gap-2">
        <!-- Cost Input -->
        <input type="text" name="cost" placeholder="e.g., 10$" 
               class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
        
        <!-- Unit Selection -->
        <select name="cost_unit" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="per_day">per day</option>
            <option value="per_hour">per hour</option>
            <option value="per_stay">per stay</option>
        </select>
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
      <div class="max-w-4xl mx-auto space-y-8 lg:ml-24">
         <div class="container ml-24 px-4 py-8 max-w-2xl">
    <!-- Header -->
    <h2 class="text-2xl md:text-3xl font-bold mb-8 text-left">
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
 <div class="max-w-4xl mx-auto space-y-8 lg:ml-24" x-data="{ pets: 'no' }">
  <div class="container w-full max-w-4xl ml-4 md:ml-24 px-4 py-8">
    <!-- Header -->
    <h2 class="text-2xl md:text-3xl font-bold mb-8 text-left">House rules</h2>

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
              <input type="radio" name="pets" value="yes" class="mr-2" x-model="pets">
              <span>Yes</span>
            </label>
            <label class="flex items-center cursor-pointer">
              <input type="radio" name="pets" value="upon_request" class="mr-2" x-model="pets">
              <span>Upon request</span>
            </label>
            <label class="flex items-center cursor-pointer">
              <input type="radio" name="pets" value="no" class="mr-2" x-model="pets">
              <span>No</span>
            </label>
          </div>
        </div>

        <!-- Conditional: Pet Fees -->
        <div class="mt-6" x-show="pets === 'yes' || pets === 'upon_request'" x-transition>
          <h3 class="text-base font-semibold mb-2">Are there additional fees for pets?</h3>
          <div class="space-y-2">
            <label class="flex items-center cursor-pointer">
              <input type="radio" name="pets_fees" value="free" class="mr-2">
              <span>Pets can stay for free</span>
            </label>
            <label class="flex items-center cursor-pointer">
              <input type="radio" name="pets_fees" value="fees" class="mr-2">
              <span>Charges may apply</span>
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
  <div class="max-w-2xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8 lg:ml-32 py-6" x-data="{ showProperty: false, showHost: false, showNeighborhood: false, noneSelected: false }">
  <h2 class="text-2xl md:text-3xl font-bold mb-8 text-left">Host Profile</h2>

  <div class="bg-white shadow-md rounded-lg p-4 space-y-6">
    <h2 class="text-base text-gray-800">
      Help your listing stand out by telling potential guests a little more about yourself, your property, and your neighborhood. This info will appear on your property page.
    </h2>

    <!-- Property Section Toggle -->
    <div>
      <label class="inline-flex items-center space-x-2">
        <input type="checkbox" class="form-checkbox text-blue-600"
               @change="showProperty = !showProperty; noneSelected = false">
        <span class="text-gray-800 font-sm">The property</span>
      </label>

      <!-- Property Section Content -->
      <div class="mt-2" x-show="showProperty && !noneSelected" x-transition>
        <label class="block text-sm font-semibold text-gray-700">About the property</label>
        <textarea rows="4" maxlength="1200" placeholder="What makes your place unique? What can guests expect"
          class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
        <p class="text-right text-xs text-gray-500">0/1200</p>
      </div>
    </div>

    <!-- Host Section Toggle -->
    <div>
      <label class="inline-flex items-center space-x-2">
        <input type="checkbox" class="form-checkbox text-blue-600"
               @change="showHost = !showHost; noneSelected = false">
        <span class="text-gray-800 font-medium">The host</span>
      </label>

      <!-- Host Section Content -->
      <div class="mt-2 space-y-2" x-show="showHost && !noneSelected" x-transition>
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

    <!-- Neighborhood Section Toggle -->
    <div>
      <label class="inline-flex items-center space-x-2">
        <input type="checkbox" class="form-checkbox text-blue-600"
               @change="showNeighborhood = !showNeighborhood; noneSelected = false">
        <span class="text-gray-800 font-medium">The neighborhood</span>
      </label>

      <!-- Neighborhood Section Content -->
      <div class="mt-2" x-show="showNeighborhood && !noneSelected" x-transition>
        <label class="block text-sm font-semibold text-gray-700">About the neighborhood</label>
        <textarea rows="4" maxlength="1200" placeholder="What's the area like? Are there any attractions nearby?"
          class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
        <p class="text-right text-xs text-gray-500">0/1200</p>
      </div>
    </div>

    <!-- None of the Above Option -->
    <div>
      <label class="inline-flex items-center space-x-2">
        <input type="checkbox" class="form-checkbox text-blue-600"
               @change="noneSelected = !noneSelected; if(noneSelected){ showProperty = false; showHost = false; showNeighborhood = false }">
        <span class="text-gray-800 font-medium">None of the above / I'll add these later</span>
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
   type="button"  @click="step++"
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
<section x-show="step === 3">
 <div >


    <!-- ✅ Single Step Section (no condition needed) -->
    <div class="px-4 py-8  w-full max-w-6xl mx-auto lg:ml-24 space-y-6">

        <section class="px-4 py-6 md:px-8 lg:px-16 flex justify-center" x-data="{
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
                <h2 class="text-2xl md:text-3xl font-bold text-black mb-6 text-left mt-4">What does your place look
                    like?</h2>

                <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
                    <!-- 📸 Photo Upload Area -->
                    <div class="border rounded-lg p-6 bg-white shadow-sm">
                        <p class="font-semibold text-gray-800 mb-2">Upload at least 5 photos of your property.</p>
                        <p class="text-sm text-gray-600 mb-4">The more you upload, the more likely you are to get
                            bookings. You can add more later.</p>

                        <!-- Upload box with drag and drop -->
                        <div class="border border-dashed border-gray-400 rounded-lg p-6 text-center bg-gray-50 mb-6"
                            @dragover.prevent @drop.prevent="handleUploadDrop($event)">
                            <div class="mb-4">
                                <!-- camera SVG -->
                            </div>
                            <p class="text-gray-700 font-medium mb-2">Drag and drop or</p>

                            <label
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 border border-gray-800 rounded cursor-pointer hover:bg-gray-50 hover:text-black transition"
                                for="fileInput">
                                <img src="{{ asset('assets/mdi_camera-outline.svg') }}" alt="Upload"
                                    class="w-4 h-4" />
                                <span>Upload photos</span>
                            </label>
                            <input id="fileInput" type="file" multiple accept="image/*" class="hidden"
                                @change="handleUpload" />


                            <p class="text-xs text-gray-500 mt-2">jpg/jpeg or png, maximum 47MB each, max 5 images</p>
                        </div>

                        <!-- Uploaded photo previews -->
                        <!-- Uploaded photo previews -->
                        <template x-if="uploadedPhotos.length > 0">
                            <div>
                                <!-- 📝 Instructions placed properly above the grid -->
                                <p class="text-sm font-semibold text-gray-700 mb-1">Choose a main photo that will give a
                                    good first impression</p>
                                <p class="text-sm font-semibold text-gray-700 mb-4">Click and drag the photos to arrange
                                    them in the order you would like the guests to see them</p>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    <template x-for="(photo, index) in uploadedPhotos" :key="index">
                                        <div class="relative group border rounded overflow-hidden" draggable="true"
                                            @dragstart="event.dataTransfer.setData('text/plain', index)"
                                            @dragover.prevent
                                            @drop="const from = Number(event.dataTransfer.getData('text/plain'));
                    const to = index;
                    if (from !== to) {
                      const moved = uploadedPhotos.splice(from, 1)[0];
                      uploadedPhotos.splice(to, 0, moved);
                    }">
                                            <!-- Badge for main photo -->
                                            <template x-if="index === 0">
                                                <span
                                                    class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10">Main
                                                    Photo</span>
                                            </template>

                                            <!-- Remove Button -->
                                            <button @click="removePhoto(index)"
                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75">
                                                &times;
                                            </button>

                                            <img :src="photo.url" alt="Uploaded photo"
                                                class="w-full h-32 object-cover" />
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>


                    </div>

                    <!-- ℹ️ Tips Box -->
                    <div x-data="{ showTips: true }">
                        <div x-show="showTips" x-transition
                            class="bg-white border rounded-none p-4 shadow-sm relative text-sm">

                            <button @click="showTips = false"
                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg"
                                aria-label="Close">
                                &times;
                            </button>

                            <h3 class="font-semibold text-gray-800 mb-2 text-base">What if I don't have professional
                                photos?</h3>
                            <p class="text-gray-600 mb-2">
                                No problem! You can use a smartphone or a digital camera.Here are some tips for taking
                                great photos of your property
                            </p>
                            <a href="#" class="text-[#3CC0E9] hover:underline block mb-2">
                                Here are some tips for taking great photos of your property
                            </a>
                            <p class="text-gray-600">
                                If you don’t know who took a photo, it's best not to use it. Only use photos others have
                                taken if you have permission.
                            </p>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="mt-6 flex justify-between">

                   
                            <button @click="step--"
                                class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">←
                            </button>
                       
                            <button :disabled="uploadedPhotos.length < 3" @click="step++"
                                :class="{
                                    'px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700cursor-pointer opacity-100 hover:bg-blue-700': uploadedPhotos
                                        .length >= 3,
                                    'bg-gray-400 rounded cursor-not-allowed opacity-50': uploadedPhotos.length < 3
                                }"
                                class="px-6 py-2 text-white rounded">
                                Continue
                            </button>
                    </div>
                </div>
        </section>


    </div>

</div>
</section>





<!-- ✅ Step 4: Pricing and Calendar -->
<section x-show="step === 4">

   <template x-if="pricingWizardStep === 1">
   <div class="max-w-4xl ml-40 px-4 py-8  lg:ml-32">
        <div class="max-w-4xl mx-auto px-4 py-8 space-y-6" x-data="{ showTip1: true, showTip2: true }">

            <!-- Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Price per night</h2>

            <!-- Grid layout: Pricing insight + Tip box -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">

                <!-- Pricing insight card (2/3 width) -->
                <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-4">
                    <h3 class="font-semibold text-gray-800 text-base">
                        Make your price competitive to increase your chances of getting more bookings.
                    </h3>
                   <p class="text-xs text-gray-600 mt-4 mb-10">
    This is the price range for properties similar to yours.
    <a href="#" class="text-blue-600 underline hover:text-blue-800">Learn more</a>
</p>

<!-- Price Range Display -->
<div class="relative h-2 bg-gray-200 rounded-full mb-10">
    <!-- Active Bar Range (optional highlight bar if needed) -->
    <div class="absolute left-[15%] right-[15%] h-2 bg-blue-600 rounded-full"></div>

    <!-- Median Tag -->
    <div class="absolute left-1/2 transform -translate-x-1/2 -top-4 bg-blue-600 text-white text-xs px-1 py-1 rounded shadow">
        Median: US$1.16
    </div>

    <!-- Min Price -->
    <div class="absolute left-8 -bottom-6 text-sm bg-blue-600 text-white px-2 py-0.5 rounded font-medium shadow">
        US$3.48
    </div>

    <!-- Max Price -->
    <div class="absolute right-8 -bottom-6 text-sm bg-blue-600 text-white px-2 py-0.5 rounded font-medium shadow">
        US$10.46
    </div>
</div>

<div x-data="{ feedback: null }" class="pt-2 text-sm text-gray-700">
  <span>Did this help you decide on a price?</span>

  <!-- Like (Thumbs Up) -->
   <button @click="feedback = 'like'" class="ml-2 focus:outline-none">
    <img 
      :src="feedback === 'like' 
              ? '{{ asset('assets/iconamoon_like-thin (1).svg') }}' 
              : '{{ asset('assets/iconamoon_like-thin.svg') }}'" 
      alt="Like" class="w-5 h-5"
    />
  </button>

  <!-- Dislike (Thumbs Down) -->
    <!-- Dislike -->
  <button @click="feedback = 'dislike'" class="ml-1 focus:outline-none">
    <img 
      :src="feedback === 'dislike' 
              ? '{{ asset('assets/iconamoon_dislike-thin (1).svg') }}' 
              : '{{ asset('assets/iconamoon_dislike-thin.svg') }}'" 
      alt="Dislike" class="w-5 h-5"
    />
  </button>
</div>


                </div>

                <!-- Tip Box 1 (unchanged) -->
                <div x-show="showTip1"
                    class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
                    <button @click="showTip1 = false"
                        class="absolute top-2 right-2 text-gray-500 font-semibold">✕</button>

                    <div class="flex items-center mb-2">
                        <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Tip Icon"
                            class="w-6 h-6 mr-2">
                        <strong>What if I’m not sure about my price?</strong>
                    </div>

                    <p>Don't worry, you can always change it later. You can even set weekend, midweek, and
                        seasonal prices, giving you more control over what you earn.</p>
                </div>
            </div>

            <!-- Price input and Tip 2 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">

                <!-- Price input card (2/3 width) -->
                <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-4">
                    <label class="block font-semibold text-base text-gray-700">How much do you want to charge
                        per night?</label>
                    <div class="relative">
                        <label class="block text-sm text-gray-700 mb-1">Price guests pay</label>

                        <!-- Currency Select Dropdown -->
                        <select
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 focus:outline-none border border-gray-300 rounded-md">
                            <option value="usd">US$</option>
                            <option value="eur">€</option>
                            <option value="gbp">£</option>
                            <option value="lkr">Rs</option>
                        </select>

                        <!-- Input Field -->
                        <input type="text" value="120.00"
                            class="w-full border border-gray-400 rounded-md p-2 pl-16 text-gray-700 font-semibold focus:ring-2 focus:ring-blue-300 focus:outline-none" />

                        <p class="text-sm text-gray-500 mt-2">Including taxes, commission, and fees</p>
                    </div>

                    <!-- Topic paragraph -->
                    <p class="text-sm text-gray-600 pl-4">
                        <span class="text-gray-500">15.00%</span> {{ config('domains.subdomain') }} commission
                    </p>

                    <!-- Sub-items under topic -->
                    <ul class="text-sm text-gray-600 space-y-1 pl-8">
                        <li><span class="text-green-600 font-semibold">✓</span> 24/7 help in your language</li>
                        <li><span class="text-green-600 font-semibold">✓</span> Save time with automatically
                            confirmed bookings</li>
                        <li><span class="text-green-600 font-semibold">✓</span> We promote your place on Google
                        </li>
                    </ul>

                    <p class="text-sm text-gray-800 font-medium border-t pt-3">US$ 102.00 Your earnings
                        (including taxes)</p>
                </div>

            
            </div>

            <!-- Discount and Tip 2 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

               <!-- Discount card -->
<div x-data="{ showDiscount: false }" class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-3">

  <!-- Checkbox -->
  <label class="inline-flex items-center">
    <input type="checkbox" class="form-checkbox text-blue-600 rounded-md"
           @change="showDiscount = !showDiscount" />
    <span class="ml-2 font-medium text-gray-700 font-semibold">
      Get guests’ attention with a 20% discount
    </span>
  </label>

  <!-- Description -->
  <p class="text-sm text-gray-600">
    Give 20% off your first 3 bookings or for 90 days, whichever comes first.
    <a href="#" class="text-blue-600 underline">Learn more</a>
  </p>

  <!-- Conditional discount section -->
  <template x-if="showDiscount">
    <div>
      <hr class="my-4">
      <p class="text-sm text-gray-800">
        <del class="text-gray-500">US$ 120.00</del>
        <span class="text-green-600 font-semibold">US$ 96.00 per night</span>
      </p>
    </div>
  </template>
</div>


                <!-- Tip Box 2 (separate column) -->
                <div x-show="showTip2"
                    class="relative bg-white border rounded-lg p-4 shadow-sm text-sm text-gray-700">
                    <button @click="showTip2 = false"
                        class="absolute top-2 right-3 text-gray-500 font-semibold mb-2">✕</button>
                    <div class="flex items-center mb-2">
                        <img src="{{ asset('assets/material-symbols-light_info-outline.svg') }}"
                            alt="Tip Icon" class="w-6 h-6 mr-2">
                        <strong>Rules for setting up a promotion</strong>
                    </div>
                    <p>
                        Make sure you're giving a genuine discount. It must represent a real discount in line
                        with consumer protection rules.
                        <a href="#" class="text-blue-600 underline">Learn More</a>
                    </p>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex mt-1">
                <button type="button"  @click="pricingWizardStep--"
                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                    ←
                </button>
                <button type="button"  @click="pricingWizardStep++"
                    class="ml-auto px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[402px]">
                    Continue
                </button>
            </div>

        </div>
    </div>
</template>


<template x-if="pricingWizardStep === 2">
    
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
          <a href="{{ route('partner.apartment.pricing.policies') }}">
         <button @click="$refs.section1.scrollIntoView({ behavior: 'smooth' })"
        class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">
  Edit
</button></a>
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
           <a href="{{ route('partner.apartment.price.group') }}">
          <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button></a>
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
         <a href="{{ route('partner.apartment.refundable.rate') }}">
        <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button></a>
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
         <a href="{{ route('partner.apartment.weekly.rate') }}">
        <button class="text-[#3CC0E9] border border-[#3CC0E9] rounded px-3 py-1 text-sm hover:bg-blue-50 transition">Edit</button></a>
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
  </template>

 

  <template x-if="pricingWizardStep === 3">
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
    <div class="border rounded-md p-6 bg-white shadow space-y-4">
        <p class="text-sm text-gray-600">To help you start earning, we automatically make your property available for bookings for up to 18 months – excluding days you import that are marked as unavailable. You can manage your availability and make dates unavailable for bookings after registration.</p>
    </div>




<!-- LONG STAY SECTION -->
<!-- LONG STAY SECTION -->
<div class="flex flex-col md:flex-row gap-6 mt-8">
  <!-- Left: Main Form (Updated width to max-w-2xl) -->
  <div class="flex-1">
    <div class="bg-white p-6 rounded-lg shadow-md space-y-4 max-w-2xl mx-auto"
         x-data="{ allowLongStay: '', showLongStayTip: true }">
      <p class="text-base font-semibold">Do you want to allow 30+ night stays?</p>
      <p class="text-sm text-gray-600">
        Allowing guests to stay for up to 90 nights can help you fill your calendar and tap into the trend of guests working remotely.
      </p>

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

      <!-- Conditionally shown field -->
      <div x-show="allowLongStay === 'yes'" x-transition>
        <label class="block mb-2 text-sm font-semibold">
          What's the maximum number of nights you want guests to be able to book?
        </label>
        <select class="border border-gray-300 p-2 rounded w-48">
          <option value="90">90</option>
          <option value="60">60</option>
          <option value="45">45</option>
          <option value="30">30</option>
        </select>
      </div>
      <div class="w-full">
  <div class="bg-gray-50 border border-gray-200 p-2 rounded-lg shadow-sm">
    <h3 class="text-xs font-semibold mb-1">What if I want to change my selection later on?</h3>
    <p class="text-xs text-gray-700 leading-snug">
      Your selection here isn’t final. You can always change it by heading to the Policies section after you’ve registered.
    </p>
    <a href="#" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
      Read more about 30+ night stays
    </a>
  </div>
</div>


    </div>
    
  </div>

  <!-- Right: Message Box -->
 
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
  
  <button       @click="step++" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-sky-500 transition w-full sm:w-auto">
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
    <h2 class="text-2xl md:text-3xl font-semibold mb-6">You're almost there</h2>

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
                    Legal representative's personal information
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
        <p class="text-sm">Yes. They're confirmed as soon as a guest makes a booking.</p>
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
          Yes. The best way to do this is to keep your calendar up-to-date. Close any dates you don't want a booking on. If you have bookings on other sites, close those dates as well.
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
    <button  @click="step--" class="border border-[#3CC0E9]  text-blue-600  font-semibold py-2 px-4 rounded">
        ←
    </button>

    <!-- Open for bookings Button (take remaining space) -->
   <a href="#"
   class="flex-1 px-6 py-3 bg-[#3CC0E9] text-white text-center font-semibold rounded-md hover:bg-[#29ACD5] transition">
   Open for bookings
</a>

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

@endsection