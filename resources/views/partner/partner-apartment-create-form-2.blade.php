@extends('partner.partner-layout')

@section('title', 'Apartment Create Step 2 | ' . config('domains.app_name'))

@section('content')
<body class="bg-gray-50 text-gray-800">
    <!-- Toast Notification System -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
    
    <script>
    // Toast notification system
    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        // Base classes
        let bgColor = 'bg-blue-500';
        let textColor = 'text-white';
        let icon = 'ℹ️';
        
        // Type-specific styling
        switch(type) {
            case 'success':
                bgColor = 'bg-green-500';
                icon = '✅';
                break;
            case 'error':
                bgColor = 'bg-red-500';
                icon = '❌';
                break;
            case 'warning':
                bgColor = 'bg-orange-500';
                textColor = 'text-white';
                icon = '⚠️';
                break;
        }
        
        toast.className = `${bgColor} ${textColor} px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2 transform transition-all duration-300 translate-x-full`;
        toast.innerHTML = `
            <span class="text-lg">${icon}</span>
            <span class="flex-1">${message}</span>
            <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 text-xl font-bold">&times;</button>
        `;
        
        container.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 5000);
    }
    </script>
    
    <script>
      // Ensure CSRF token is always sent with fetch/AJAX requests
      document.addEventListener('DOMContentLoaded', function () {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (window.fetch) {
          const _fetch = window.fetch;
          window.fetch = function(resource, config = {}) {
            config.headers = config.headers || {};
            // Only add if not already present
            if (!config.headers['X-CSRF-TOKEN'] && !config.headers['x-csrf-token']) {
              config.headers['X-CSRF-TOKEN'] = token;
            }
            return _fetch(resource, config);
          };
        }
      });
    </script>
    
    <!-- Property Data from Backend -->
    @if(isset($propertyData) && $propertyData)
    <script id="property-data" type="application/json">
        {!! json_encode($propertyData) !!}
    </script>
    <script>
        console.log('Property data from backend:', {!! json_encode($propertyData) !!});
    </script>
    @else
    @if(isset($property) && $property)
    <script id="property-data" type="application/json">
        {"id": {{ (int) $property->id }} }
    </script>
    <script>
        console.log('Property id from backend object:', {{ (int) $property->id }});
    </script>
    @else
    <script>
        console.log('No property data found in backend');
    </script>
    @endif
    @endif
    
    <!-- Header -->
    
    
    <!-- Main Alpine.js Application -->
    <div
      x-data="wizardApp()"
      x-init="console.log('Alpine.js initialized'); console.log('testValue:', testValue);"
    >

        <!-- Sticky Top Navbar -->
        <nav class="border-b shadow-sm sticky top-0 z-50 bg-white">
          <div class="max-w-full mx-auto px-4 py-3 overflow-x-auto">
            <!-- Scrollable/Responsive Nav Items -->
            <div
              class="flex flex-nowrap min-w-max space-x-6 sm:space-x-12 md:space-x-8 lg:space-x-24 xl:space-x-24 text-sm font-medium whitespace-nowrap"
            >
              <!-- Loop through nav steps -->
              <template
                x-for="(label, index) in ['Basic information', 'Property setup', 'Photos', 'Pricing and calendar', 'Legal information']"
                :key="index"
              >
                <div class="relative">
                  <!-- Tab Label -->
                  <div
                    @click="navigateToStep(index + 1)"
                    class="flex items-center space-x-1 cursor-pointer transition duration-200"
                    :class="step === index + 1 ? 'text-blue-600' : 'text-gray-700'"
                  >
                    <span x-text="label"></span>
                    <!-- Checkmark for completed steps -->
                    <template x-if="isStepCompleted(index)">
                      <span class="text-green-600 ml-1" title="Step completed">✔️</span>
                    </template>
                  </div>
                  <!-- 🔵 Progress bar only under "Basic information" when active -->
                  <template x-if="index === 0 && step === 1">
                    <div
                      class="flex space-x-1 mt-1 w-35 sm:w-48 md:w-46 lg:w-54 xl:w-62 ml-[-15px] sm:ml-[-25px] md:ml-[-35px]"
                    >
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
                    <div
                      class="flex space-x-1 mt-1 w-15 sm:w-25 md:w-30 lg:w-64 xl:w-72 ml-[-60px] sm:ml-[-80px] md:ml-[-90px]"
                    >
                      <template x-for="i in 6">
                        <div
                          :class="propertyWizardStep >= i ? 'bg-blue-600' : 'bg-gray-300'"
                          class="h-1 flex-1 rounded-full"
                        ></div>
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
        <div>
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
                        <div class="w-full bg-white p-6 rounded shadow-md flex flex-col text-base">
                          <label for="property_name" class="block text-gray-700">Property name</label>
                          <input
                            type="text"
                            id="property_name"
                            name="property_name"
                            x-model="title"
                            @input="logInputChange('title', $event.target.value)"
                            class="w-full h-16 border border-gray-300 rounded p-4 mt-3 text-lg focus:outline-none focus:border-blue-500"
                            placeholder="e.g., Sunset Villa"
                            required
                          />
                        </div>
                      </div>
                      <!-- Tips and Information (1/3 Width) -->
                      <div class="flex flex-col gap-4">
                        <!-- Tip Box 1 -->
                        <div x-data="{ show: true }" x-show="show" class="bg-white p-4 border border-gray-200 rounded">
                          <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2">
                              <img
                                src="{{ asset('assets/ei_like.svg') }}"
                                alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer"
                              />
                              <h3 class="text-gray-700 text-sm">What should I consider when choosing a name?</h3>
                            </div>
                            <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"
                                />
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
                              <img
                                src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}"
                                alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer"
                              />
                              <h3 class="text-gray-700 text-sm">Why do I need to name my property?</h3>
                            </div>
                            <button @click="show = false" class="text-gray-500 hover:text-gray-700">
                              <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                              >
                                <path
                                  fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"
                                />
                              </svg>
                            </button>
                          </div>
                          <p class="text-sm text-gray-700">
                            This is the name that will appear as the title of your listing. Be specific and avoid
                            including private details.
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
                        class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded"
                      >
                        ←
                      </button>
                      <!-- Continue Button -->
                      <!-- Continue Button (inside input field container, aligned right) -->
                      <div class="flex justify-end mt-4">
                        <button
                          type="button"
                          @click="saveName"
                          :disabled="isLoading"
                          :class="isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
                          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded focus:outline-none focus:ring focus:ring-blue-300"
                        >
                          <span x-show="!isLoading">Continue</span>
                          <span x-show="isLoading">Saving...</span>
                        </button>
                      </div>
                    </div>
                  </section>
                </div>
              </template>
              <template x-if="wizardStep === 2">
                <div class="relative w-[1200px] h-auto overflow-hidden rounded-lg shadow mx-auto my-10">
                  <!-- Google Maps iframe full background -->
                  <iframe
                    class="absolute inset-0 w-full h-full"
                    loading="lazy"
                    src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                    allowfullscreen
                  ></iframe>
                  <!-- Optional overlay for readability -->
                  <div class="absolute inset-0"></div>
                  <!-- Form content centered on map -->
                  <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
                    <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                      <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>
                      <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Find your address</label>
                        <input
                          type="text"
                          id="address"
                          name="address"
                          x-model="address"
                          @input="logInputChange('address', $event.target.value)"
                          class="mt-1 p-2 w-full border border-gray-300 rounded"
                        />
                      </div>
                      <div class="mb-4">
                        <label for="apartment" class="block text-sm font-medium text-gray-700"
                          >Apartment or floor number (optional)</label
                        >
                        <input
                          type="text"
                          id="apartment"
                          name="apartment"
                          x-model="apartment"
                          @input="logInputChange('apartment', $event.target.value)"
                          placeholder="Apartment or floor number (optional)"
                          class="mt-1 p-2 w-full border border-gray-300 rounded"
                        />
                      </div>
                      <div class="mb-4">
                        <label for="country" class="block text-sm font-medium text-gray-700">Country/region</label>
                        <select
                          id="country"
                          name="country"
                          x-model="country"
                          @change="logInputChange('country', $event.target.value)"
                          class="mt-1 p-2 w-full border border-gray-300 rounded"
                        >
                          <option value="Sri Lanka">Sri Lanka</option>
                        </select>
                      </div>
                      <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                          <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                          <input
                            type="text"
                            id="city"
                            name="city"
                            x-model="city"
                            @input="logInputChange('city', $event.target.value)"
                            class="mt-1 p-2 w-full border border-gray-300 rounded"
                          />
                        </div>
                        <div class="flex-1">
                          <label for="postcode" class="block text-sm font-medium text-gray-700"
                            >Post code / Zip code</label
                          >
                          <input
                            type="text"
                            id="postcode"
                            name="postcode"
                            x-model="zipcode"
                            @input="logInputChange('zipcode', $event.target.value)"
                            class="mt-1 p-2 w-full border border-gray-300 rounded"
                          />
                        </div>
                      </div>
                      <div class="flex items-center mt-4">
                        <input id="update_address" type="checkbox" name="update_address" checked class="mr-2" />
                        <label for="update_address" class="text-sm text-gray-700"
                          >Update the address when moving the pin on the map.</label
                        >
                      </div>
                      <!-- Dismissible message box -->
                      <div
                        x-data="{ showMessage: true }"
                        x-show="showMessage"
                        class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative"
                        role="alert"
                      >
                        <strong class="font-bold">Note:</strong>
                        <span class="block sm:inline"
                          >Make sure the pin location is accurate before continuing.</span
                        >
                        <span @click="showMessage = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                          <svg
                            class="fill-current h-6 w-6 text-yellow-800"
                            role="button"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                          >
                            <title>Close</title>
                            <path
                              d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"
                            />
                          </svg>
                        </span>
                      </div>
                      <p class="text-sm text-gray-600 mt-2">
                        Is the red pin location incorrect? Uncheck the option above and click or press on the map to
                        move the pin.
                      </p>
                      <div class="flex justify-between mt-6">
                        <!-- Back Button (Left) -->
                        <button
                          type="button"
                          @click="wizardStep--"
                          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded"
                        >
                          ←
                        </button>
                        <!-- Continue Button (Right) -->
                        <button
                          type="submit"
                          @click="saveLocation"
                          :disabled="isLoading"
                          :class="isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
                          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded focus:outline-none focus:ring focus:ring-blue-300"
                        >
                          <span x-show="!isLoading">Continue</span>
                          <span x-show="isLoading">Saving...</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
              <template x-if="wizardStep === 3">
                <section class="mb-12">
                  <div class="max-w-5xl mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a channel manager</h1>
                    <!-- Question Section -->
                    <div class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                      <h2 class="text-lg font-semibold mb-2">
                        Do you want to connect this listing to your channel manager?
                      </h2>
                      <p class="text-gray-700 mb-6">
                        A channel manager is a third-party tool that lets you manage rates and availability across
                        different sites you might list your place on, including Booking.com. If you're already using a
                        channel manager, you can select 'Yes' to connect it to your listing.
                      </p>
                      <!-- Radio Buttons -->
                      <div class="bg-white p-4 border border-gray-200 rounded mb-8 space-y-4">
                        <!-- Yes Option -->
                        <div>
                          <input
                            type="radio"
                            id="yes"
                            name="channel_manager"
                            value="yes"
                            class="mr-2"
                            x-model="channelManager"
                          />
                          <label for="yes" class="text-gray-700">
                            Yes, I will connect this listing to my channel manager
                          </label>
                        </div>
                        <!-- Tooltip only if Yes is selected -->
                        <div x-show="channelManager === 'yes'" x-transition>
                          <div class="bg-red-100 border border-red-300 rounded p-2">
                            <div class="flex items-start text-sm text-red-700 space-x-2">
                              <!-- Inline icon -->
                              <img
                                src="{{ asset('assets/material-symbols-light_info-outline (2).svg') }}"
                                alt="Help"
                                class="w-5 h-5 md:w-6 md:h-6 mt-1"
                              />
                              <!-- Text block -->
                              <p>
                                Select 'Yes' only if you are already using a channel manager. You'll be able to connect
                                your channel manager after your registration is complete – please continue to the next
                                step.
                              </p>
                            </div>
                          </div>
                        </div>
                        <!-- No Option -->
                        <div>
                          <input
                            type="radio"
                            id="no"
                            name="channel_manager"
                            value="no"
                            class="mr-2"
                            x-model="channelManager"
                          />
                          <label for="no" class="text-gray-700">
                            No, I won't be using a channel manager at this time
                          </label>
                        </div>
                      </div>
                      <div class="flex justify-between mt-6">
                        <!-- Back Button (Left) -->
                        <button
                          type="button"
                          @click="wizardStep--"
                          class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded"
                        >
                          ←
                        </button>
                        <!-- Continue Button (Right) -->
                        <button
                          type="button"
                          @click="saveChannelManager"
                          :disabled="isLoading"
                          :class="isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
                          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded focus:outline-none focus:ring focus:ring-blue-300"
                        >
                          <span x-show="!isLoading">Continue</span>
                          <span x-show="isLoading">Saving...</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </section>
              </template>
            </div>
          </section>
          <!-- Property Setup Section -->

          <!-- Property Setup Section -->
<section x-show="step === 2">

  <!-- Property Setup Step 1: Where can people sleep, guests, bathrooms, children, infants, apartment size/unit -->
  <template x-if="propertyWizardStep === 1">
    <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">

      <h2 class="text-2xl font-bold text-gray-900 mt-8">What can guests use at your place?</h2>
              <!-- Where can people sleep -->
        <div class="bg-white p-4 rounded-lg shadow space-y-4">
          <h2 class="text-lg font-semibold">Where can people sleep?</h2>
          <div class="flex flex-col gap-4">
            <!-- Default rooms (bedroom1, livingRoom, otherSpaces) -->
            <!-- Force show default rooms -->
            <!-- Bedroom 1 -->
            <div>
              <a
                @click.prevent="navigateToBedroom('bedroom1')"
                href="#"
                class="block"
              >
                <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer flex justify-between items-center">
                  <div>
                    <p class="text-sm" x-text="rooms.bedroom1?.name || 'Bedroom 1'"></p>
                    <p class="text-sm text-gray-600" x-text="getBedSummary('bedroom1')"></p>
                  </div>
                  <span class="text-xs text-blue-600 hover:underline">Edit</span>
                </div>
              </a>
            </div>
            
            <!-- Living Room -->
            <div>
              <div x-show="hasBedCounts('livingRoom')" class="border border-green-300 bg-green-50 rounded px-3 py-2 w-96 flex justify-between items-center">
                <div>
                  <p class="text-sm font-medium" x-text="rooms.livingRoom?.name || 'Living room'"></p>
                  <p class="text-sm text-gray-600" x-text="getBedSummary('livingRoom')"></p>
                  <p class="text-xs text-green-600">✓ Saved</p>
                </div>
                <span class="text-xs text-blue-600 hover:underline cursor-pointer" @click="navigateToBedroom('livingRoom')">Edit</span>
              </div>
              <a
                x-show="!hasBedCounts('livingRoom')"
                @click.prevent="navigateToBedroom('livingRoom')"
                href="#"
                class="block"
              >
                <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer flex justify-between items-center">
                  <div>
                    <p class="text-sm" x-text="rooms.livingRoom?.name || 'Living room'"></p>
                    <p class="text-sm text-gray-600" x-text="getBedSummary('livingRoom')"></p>
                  </div>
                  <span class="text-xs text-blue-600 hover:underline">Edit</span>
                </div>
              </a>
            </div>
            
            <!-- Other Spaces -->
            <div>
              <div x-show="hasBedCounts('otherSpaces')" class="border border-green-300 bg-green-50 rounded px-3 py-2 w-96 flex justify-between items-center">
                <div>
                  <p class="text-sm font-medium" x-text="rooms.otherSpaces?.name || 'Other spaces'"></p>
                  <p class="text-sm text-gray-600" x-text="getBedSummary('otherSpaces')"></p>
                  <p class="text-xs text-green-600">✓ Saved</p>
                </div>
                <span class="text-xs text-blue-600 hover:underline cursor-pointer" @click="navigateToBedroom('otherSpaces')">Edit</span>
              </div>
              <a
                x-show="!hasBedCounts('otherSpaces')"
                @click.prevent="navigateToBedroom('otherSpaces')"
                href="#"
                class="block"
              >
                <div class="border border-gray-300 rounded px-3 py-2 w-96 cursor-pointer flex justify-between items-center">
                  <div>
                    <p class="text-sm" x-text="rooms.otherSpaces?.name || 'Other spaces'"></p>
                    <p class="text-sm text-gray-600" x-text="getBedSummary('otherSpaces')"></p>
                  </div>
                  <span class="text-xs text-blue-600 hover:underline">Edit</span>
                </div>
              </a>
            </div>
            
            <!-- Additional bedrooms from bedroom page -->
            <template x-for="(room, key) in rooms" :key="key">
              <template x-if="key !== 'bedroom1' && key !== 'livingRoom' && key !== 'otherSpaces'">
                <div class="border border-green-300 bg-green-50 rounded px-3 py-2 w-96 flex justify-between items-center">
                  <div>
                    <p class="text-sm font-medium" x-text="room.name"></p>
                    <p class="text-sm text-gray-600" x-text="getSavedRoomBedSummary(room)"></p>
                    <p class="text-xs text-green-600">✓ Saved</p>
                  </div>
                  <span class="text-xs text-blue-600 hover:underline cursor-pointer" @click="editSavedRoom(key)">Edit</span>
                </div>
              </template>
            </template>
          </div>
          <!-- Add Bedroom Button -->
          <button 
            type="button" 
            @click="navigateToBedroom()" 
            class="text-blue-600 hover:underline text-sm flex items-center space-x-1 mt-2"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4"/>
            </svg>
            <span>Add Bedroom</span>
          </button>
        </div>

      <!-- Guests and Bathrooms -->
      <div class="bg-white p-4 rounded-lg shadow space-y-4 w-full max-w-xl">
        <!-- Guests -->
        <div>
          <label class="block text-sm text-gray-800">How many guests can stay?</label>
          <div class="flex items-center space-x-4 mt-1">
            <button @click="if (guests > 1) guests--" class="border px-3 py-1 rounded text-base">−</button>
            <span class="min-w-[2rem] text-center text-gray-700 text-base" x-text="guests"></span>
            <button @click="guests++" class="border px-3 py-1 rounded text-base">+</button>
          </div>
        </div>
        <!-- Bathrooms -->
        <div>
          <label class="block text-sm text-gray-800">How many bathrooms are there?</label>
          <div class="flex items-center space-x-4 mt-1">
            <button @click="if (bathrooms > 0) bathrooms--" class="border px-3 py-1 rounded text-base">−</button>
            <span class="min-w-[2rem] text-center text-gray-700 text-base" x-text="bathrooms"></span>
            <button @click="bathrooms++" class="border px-3 py-1 rounded text-base">+</button>
          </div>
        </div>
      </div>

      <!-- Children Policy -->
      <div class="bg-white p-4 rounded-lg shadow space-y-4">
        <div>
          <p class="font-medium text-sm">Do you allow children?</p>
          <label class="mr-4 text-sm">
            <input type="radio" name="children" value="yes" x-model="allowChildren"> Yes
          </label>
          <label class="text-sm">
            <input type="radio" name="children" value="no" x-model="allowChildren"> No
          </label>
        </div>
        <div>
          <p class="font-medium text-sm">Do you allow infants?</p>
          <p class="text-xs text-gray-500">cribs sleep most infants 0–3 years old and are available to guests on request.</p>
          <label class="mr-4 text-sm">
            <input type="radio" name="infants" value="yes" x-model="offerCribs"> Yes
          </label>
          <label class="text-sm">
            <input type="radio" name="infants" value="no" x-model="offerCribs"> No
          </label>
        </div>
      </div>

      <!-- Room Size -->
      <div class="lg:col-span-2 bg-white rounded-lg border border-gray-300 p-4 space-y-4 ">
        <div class="flex flex-col lg:flex-row gap-4 items-end">
          <!-- Apartment Size Input -->
          <div class="w-full lg:w-2/4">
            <label class="block text-sm text-gray-700 mb-1">How big is this room?</label>
            <p class="text-xs text-gray-500">Apartment size - optional</p>
            <input
              type="number"
              min="1"
              step="1"
              inputmode="numeric"
              pattern="\d*"
              x-model="apartmentSize"
              name="apartment_size"
              class="w-full border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2"
            >
          </div>
          <!-- Size Unit Dropdown -->
          <div class="w-full lg:w-1/4">
            <label class="block text-sm text-transparent mb-1">Unit</label>
            <select x-model="apartmentUnit" class="w-full bg-gray-300 text-black border border-gray-300 rounded-md shadow-sm text-sm mt-2 px-2 py-2">
              <option value="square meters">square meters</option>
              <option value="square feet">square feet</option>
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
          type="button"
          @click="savePropertyDetails"
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
          @foreach ($groupedAmenities as $category => $items)
            <div class="space-y-3">
              <h3 class="text-base font-semibold text-gray-800">{{ $category }}</h3>
              <div class="flex flex-col space-y-2">
                @foreach ($items as $amenity)
                  <label class="flex items-center space-x-2 text-gray-700 text-sm">
                    <input
                      type="checkbox"
                      :value="{{ $amenity->id }}"
                      x-model="selectedAmenities"
                      class="form-checkbox h-5 w-5 text-blue-600"
                    >
                    <span>{{ $amenity->name }}</span>
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
            class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded mb-16">
            ←
          </button>
          <!-- Continue Button -->
          <div class="flex justify-end">
            <button
              type="button"
              @click="savePropertyDetails"
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
              <label>
                <input type="radio" name="serve_breakfast" value="yes" x-model="breakfastServed" @change="logBreakfastChange('breakfastServed', $event.target.value)" class="mr-2"> Yes
              </label>
              <label>
                <input type="radio" name="serve_breakfast" value="no" x-model="breakfastServed" @change="logBreakfastChange('breakfastServed', $event.target.value)" class="mr-2"> No
              </label>
            </div>
          </div>
          <!-- Is breakfast included -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">Is breakfast included in the price guests pay?</p>
            <div class="flex flex-col text-sm gap-2">
              <label>
                <input type="radio" name="breakfast_included" value="included" x-model="breakfastIncluded" @change="logBreakfastChange('breakfastIncluded', $event.target.value)" class="mr-2"> Yes, it's included
              </label>
              <label>
                <input type="radio" name="breakfast_included" value="extra" x-model="breakfastIncluded" @change="logBreakfastChange('breakfastIncluded', $event.target.value)" class="mr-2"> No, it costs extra
              </label>
            </div>
          </div>
          <hr class="my-6 border-t border-gray-300">
          <!-- Type of breakfast -->
          <div>
            <p class="font-semibold text-sm text-gray-800 mb-2">
              What type of breakfast do you offer?
              <span class="text-sm text-gray-500">(Select all that apply)</span>
            </p>
            <div class="flex flex-wrap gap-2">
              @foreach(['A la carte', 'American', 'Asian', 'Breakfast to go', 'Buffet', 'Continental', 'Full English/Irish', 'Gluten-Free', 'Halal', 'Italian', 'Kosher', 'Vegan', 'Vegetarian'] as $option)
                <label
                  :class="breakfastTypes && breakfastTypes.includes('{{ $option }}')
                    ? 'bg-[#3CC0E9] text-white'
                    : 'border border-gray-300 text-gray-700 hover:bg-gray-200'"
                  class="px-3 py-1 rounded-full text-sm font-medium cursor-pointer transition"
                >
                  <input type="checkbox" class="hidden"
                         :value="'{{ $option }}'"
                         x-model="breakfastTypes"
                         @change="logBreakfastChange('breakfastTypes', breakfastTypes)">
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
              <label>
                <input type="radio" name="parking_available" value="free" x-model="parkingAvailable" @change="logParkingChange('parkingAvailable', $event.target.value)" class="mr-2"> Yes, free
              </label>
              <label>
                <input type="radio" name="parking_available" value="paid" x-model="parkingAvailable" @change="logParkingChange('parkingAvailable', $event.target.value)" class="mr-2"> Yes, paid
              </label>
              <label>
                <input type="radio" name="parking_available" value="no" x-model="parkingAvailable" @change="logParkingChange('parkingAvailable', $event.target.value)" class="mr-2"> No
              </label>
            </div>
          </div>
          <!-- Parking details - only show if parking is available -->
          <div x-show="parkingAvailable !== 'no'" x-transition>
            <hr class="my-6 border-t border-gray-300">
            <!-- Parking cost - only show if parking is paid -->
            <div x-show="parkingAvailable === 'paid'">
              <p class="text-sm font-semibold text-gray-800 mb-2">How much does parking cost?</p>
              <div class="flex flex-col sm:flex-row items-center gap-4">
                <!-- Input + Currency Select Wrapper -->
                <div class="relative w-full max-w-xs">
                  <select x-model="parkingCurrency" @change="logParkingChange('parkingCurrency', $event.target.value)" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 pl-1 focus:outline-none">
                    <option value="usd">US$</option>
                    <option value="eur">€</option>
                    <option value="gbp">£</option>
                    <option value="lkr">Rs</option>
                  </select>
                  <input
                    type="text"
                    x-model="parkingCost"
                  @input="logParkingChange('parkingCost', $event.target.value)"
                    class="w-full border border-gray-400 rounded-md pl-16 pr-2 py-2 text-gray-700 font-semibold focus:ring-2 focus:ring-blue-300 focus:outline-none"
                  />
                </div>
                <!-- Rate Select -->
                                <select x-model="parkingRate" @change="logParkingChange('parkingRate', $event.target.value)" class="border border-gray-300 rounded px-3 py-2 w-32 text-sm text-gray-700">
                  <option value="per_day">Per day</option>
                  <option value="per_stay">Per stay</option>
                </select>
              </div>
            </div>
            <!-- Reservation needed -->
            <div>
              <p class="font-semibold text-sm text-gray-800 mb-2">Do guests need to reserve a parking spot?</p>
              <div class="flex flex-col text-sm gap-2">
                              <label>
                <input type="radio" name="parking_reservation" value="yes" x-model="parkingReservation" @change="logParkingChange('parkingReservation', $event.target.value)" class="mr-2"> Reservation needed
              </label>
              <label>
                <input type="radio" name="parking_reservation" value="no" x-model="parkingReservation" @change="logParkingChange('parkingReservation', $event.target.value)" class="mr-2"> No reservation needed
              </label>
              </div>
            </div>
            <!-- Parking location -->
            <div>
              <p class="font-semibold text-sm text-gray-800 mb-2">Where is the parking located?</p>
              <div class="flex flex-col text-sm gap-2">
                <label>
                  <input type="radio" name="parking_location" value="on_site" x-model="parkingLocation" @change="logParkingChange('parkingLocation', $event.target.value)" class="mr-2"> On site
                </label>
                <label>
                  <input type="radio" name="parking_location" value="off_site" x-model="parkingLocation" @change="logParkingChange('parkingLocation', $event.target.value)" class="mr-2"> Off site
                </label>
              </div>
            </div>
            <!-- Parking type -->
            <div>
              <p class="font-semibold text-sm text-gray-800 mb-2">What type of parking is it?</p>
              <div class="flex flex-col text-sm gap-2">
                <label>
                  <input type="radio" name="parking_type" value="private" x-model="parkingType" @change="logParkingChange('parkingType', $event.target.value)" class="mr-2"> Private
                </label>
                <label>
                  <input type="radio" name="parking_type" value="public" x-model="parkingType" @change="logParkingChange('parkingType', $event.target.value)" class="mr-2"> Public
                </label>
              </div>
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
          <div class="flex justify-end">
            <button
              type="button"
              @click="saveAdditionalDetails"
              class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 mb-16">
              Continue
            </button>
          </div>
        </div>
      </div>
    </template>

    <template x-if="propertyWizardStep === 4">
  <div class="max-w-4xl mx-auto space-y-8 lg:ml-32" x-init="loadLanguages()">
    <div class="container ml-24 px-4 py-8 max-w-2xl">
      <!-- Header -->
      <h2 class="text-2xl font-bold mb-8 text-left">
        What languages do you or your staff speak?
      </h2>
      <!-- Language Selection Section -->
      <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h3 class="text-lg mb-4 font-bold">Select languages</h3>
        
        <!-- Common Languages (hardcoded for quick selection) -->
        <div class="space-y-2 mb-4" x-show="availableLanguages.length > 0">
          <template x-for="commonLang in ['English', 'French', 'German', 'Hindi']" :key="commonLang">
            <label class="flex items-center cursor-pointer">
              <input 
                type="checkbox" 
                class="mr-2" 
                :value="getLanguageIdByName(commonLang)"
                x-model="selectedLanguages" 
                :disabled="!getLanguageIdByName(commonLang)"
              />
              <span x-text="commonLang"></span>
            </label>
          </template>
        </div>
        
        <!-- Loading indicator for languages -->
        <div x-show="availableLanguages.length === 0" class="text-sm text-gray-500 mb-4">
          Loading languages...
        </div>
        
        <!-- Debug: Show available languages -->
        <!-- <div class="text-xs text-gray-500 mb-2">
          Debug - Available languages: <span x-text="JSON.stringify(availableLanguages)"></span>
        </div> -->

        <!-- Selected Languages Display -->
        <template x-if="selectedLanguages.length > 0">
          <div class="mb-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-2">Selected languages:</h4>
            <div class="flex flex-wrap gap-2">
              <template x-for="langId in selectedLanguages" :key="langId">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                  <span x-text="getLanguageName(langId)"></span>
                  <button 
                    @click="removeLanguage(langId)"
                    class="ml-2 text-blue-600 hover:text-blue-800"
                    type="button"
                  >
                    ×
                  </button>
                </span>
              </template>
            </div>
          </div>
        </template>
        
        <!-- Add Additional Languages -->
        <div x-show="showAdditionalLanguages" class="mt-4 relative">
          <h3 class="text-lg font-medium mb-2">Add additional languages</h3>
          <!-- Debug info -->
          <div class="text-xs text-gray-500 mb-2">
            Available languages: <span x-text="availableLanguages.length"></span> | 
            Filtered languages: <span x-text="filteredLanguages.length"></span> | 
            Show dropdown: <span x-text="showDropdown"></span>
          </div>
          <!-- Searchable dropdown container -->
          <div class="relative w-full max-w-md">
            <input
              type="text"
              x-model="searchTerm"
              @input="filterLanguages(); logLanguageChange('searchTerm', $event.target.value)"
              @focus="showDropdown = true"
              @click="showDropdown = true"
              placeholder="Search languages..."
              autocomplete="off"
              class="w-full border rounded p-2 pr-10 cursor-pointer"
            />
            <!-- Dropdown arrow -->
            <button
              type="button"
              @click="showDropdown = !showDropdown; logLanguageChange('showDropdown', !showDropdown)"
              class="absolute right-2 top-2.5 text-gray-600 hover:text-gray-900 focus:outline-none"
              tabindex="-1"
            >
              ▼
            </button>
            <!-- Dropdown list -->
            <ul
              x-show="showDropdown && filteredLanguages.length > 0"
              x-transition
              class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded max-h-40 overflow-auto shadow-lg"
              @click.away="showDropdown = false"
              x-init="console.log('Dropdown languages count:', filteredLanguages.length)"
            >
              <template x-for="language in filteredLanguages" :key="language.id">
                <li 
                  @click="selectLanguage(language.id, language.name)"
                  class="p-2 hover:bg-blue-100 cursor-pointer"
                  :class="{ 'bg-gray-100 text-gray-500': isLanguageSelected(language.id) }"
                  x-text="language.name"
                ></li>
              </template>
            </ul>
          </div>
        </div>
        
        <!-- Toggle Button for Additional Languages -->
        <button
          type="button"
          @click="toggleAdditionalLanguages(); logLanguageChange('showAdditionalLanguages', !showAdditionalLanguages)"
          class="text-blue-500 hover:underline mt-4 block"
        >
          <span x-text="showAdditionalLanguages ? 'Hide additional languages' : 'Add additional languages'"></span>
        </button>
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
          type="button"
          @click="saveAdditionalDetails"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
        >
          Continue
        </button>
      </div>
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
                <input type="checkbox" x-model="smokingAllowed" class="sr-only peer" />
                <div class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition"></div>
                <div class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
              </div>
            </label>

            <label class="flex items-center justify-between cursor-pointer">
              <span>Parties/events allowed</span>
              <div class="relative">
                <input type="checkbox" x-model="partiesAllowed" class="sr-only peer" />
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
                <input type="radio" name="pets" value="yes" x-model="petsAllowed" class="mr-2">
                <span>Yes</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="upon_request" x-model="petsAllowed" class="mr-2">
                <span>Upon request</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets" value="no" x-model="petsAllowed" class="mr-2">
                <span>No</span>
              </label>
            </div>
          </div>

          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Are there additional fees for pets?</h3>
            <div class="space-y-2">
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets_fees" value="free" x-model="petsFees" class="mr-2">
                <span>Pets can stay for free</span>
              </label>
              <label class="flex items-center cursor-pointer">
                <input type="radio" name="pets_fees" value="fees" x-model="petsFees" class="mr-2">
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
                <input type="time" x-model="checkInFrom" ... />
              </div>
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">Until</label>
                <input type="time" x-model="checkInUntil" ... />
              </div>
            </div>
          </div>

          <!-- Check-out -->
          <div class="mt-6">
            <h3 class="text-base font-semibold mb-2">Check out</h3>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">From</label>
                <input type="time" x-model="checkOutFrom" ... />
              </div>
              <div class="w-full">
                <label class="block text-sm font-medium mb-1">Until</label>
                <input type="time" x-model="checkOutUntil" ... />
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
   type="button"  @click="saveHouseRules"
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
                    <input type="checkbox" x-model="hostProfile.show_property" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-sm ">The property</span>
                </label>
                <div class="mt-2" x-show="hostProfile.show_property">
                    <label class="block text-sm font-semibold text-gray-700">About the property</label>
                    <textarea x-model="hostProfile.about_property" rows="4" maxlength="1200" placeholder="What makes your place unique? What can guests expect"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- The Host Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" x-model="hostProfile.show_host" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The host</span>
                </label>
                <div class="mt-2 space-y-2" x-show="hostProfile.show_host">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Host name</label>
                        <input x-model="hostProfile.host_name" type="text" maxlength="80"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <p class="text-right text-xs text-gray-500">0/80</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">About the host</label>
                        <textarea x-model="hostProfile.about_host" rows="4" maxlength="1200" placeholder="What are your interests? What do you like about hosting?"
                            class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                        <p class="text-right text-xs text-gray-500">0/1200</p>
                    </div>
                </div>
            </div>

            <!-- The Neighborhood Section -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" x-model="hostProfile.show_neighborhood" class="form-checkbox text-blue-600">
                    <span class="text-gray-800 font-medium">The neighborhood</span>
                </label>
                <div class="mt-2" x-show="hostProfile.show_neighborhood">
                    <label class="block text-sm font-semibold text-gray-700">About the neighborhood</label>
                    <textarea x-model="hostProfile.about_neighborhood" rows="4" maxlength="1200" placeholder="What's the area like? Are there any attractions nearby?"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
                    <p class="text-right text-xs text-gray-500">0/1200</p>
                </div>
            </div>

            <!-- None of the Above Option -->
            <div>
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" x-model="hostProfile.none_selected" class="form-checkbox text-blue-600">
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
   type="button"  @click="saveHostProfile"
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
<!-- ...rest of the code... -->
<section
  x-show="step === 3"
  class="px-4 py-6 md:px-8 lg:px-16 flex justify-center"
  x-data="{
    uploadedPhotos: [],
    isUploading: false,
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
    },
    async uploadPhotosAndContinue() {
      if (this.uploadedPhotos.length < 1) {
        showToast('Please upload at least 1 photo.', 'warning');
        return;
      }
      this.isUploading = true;
      const formData = new FormData();
      formData.append('property_id', this.propertyId);
      this.uploadedPhotos.forEach(photo => {
        formData.append('photos[]', photo.file);
      });
      try {
        const res = await fetch('/partner/property/upload-photos', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
          },
          body: formData
        });
        const data = await res.json();
        if (data.success) {
          this.step = 4;
        } else {
          showToast(data.message || 'Upload failed', 'error');
        }
      } catch (err) {
        showToast('Upload error: ' + err.message, 'error');
      } finally {
        this.isUploading = false;
      }
    }
  }"
>
  <div class="w-full max-w-6xl">
    <h2 class="text-xl md:text-2xl font-bold text-black mb-6 text-left mt-12">
      What does your place look like?
    </h2>
    <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
              <!-- 📸 Photo Upload Area -->
        <div class="border rounded-lg p-6 bg-white shadow-sm">
          <p class="font-semibold text-gray-800 mb-2">Upload at least 1 photo of your property.</p>
          <p class="text-sm text-gray-600 mb-4">
            The more you upload, the more likely you are to get bookings. You can add more later.
          </p>
          
          <!-- Toast notification for photo requirement -->
          <div 
            x-show="uploadedPhotos.length === 0" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg"
          >
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-800">
                  <strong>Photo requirement:</strong> You need to upload at least 1 photo to continue to the next step.
                </p>
              </div>
            </div>
          </div>
          
          <div 
            x-show="uploadedPhotos.length === 1" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg"
          >
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-yellow-800">
                  <strong>Photo requirement:</strong> You have uploaded 1 photo. You can continue or add more photos for better results.
                </p>
              </div>
            </div>
          </div>
          
          <div 
            x-show="uploadedPhotos.length >= 1" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg"
          >
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-green-800">
                  <strong>Great!</strong> You have uploaded at least 1 photo. You can now continue to the next step.
                </p>
              </div>
            </div>
          </div>
          
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
              <span>Upload photos</span></label
              ><input
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
                            <span class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10"
                              >Main Photo</span
                            >
                          </template>
                          <!-- Remove Button -->
                          <button
                            @click="removePhoto(index)"
                            class="absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75"
                          >
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
                  <div x-show="showTips" x-transition class="bg-white border rounded-none p-4 shadow-sm relative text-sm">
                    <button
                      @click="showTips = false"
                      class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg"
                      aria-label="Close"
                    >
                      &times;
                    </button>
                    <h3 class="font-semibold text-gray-800 mb-2 text-base">
                      What if I don't have professional photos?
                    </h3>
                    <p class="text-gray-600 mb-2">No problem! You can use a smartphone or a digital camera.</p>
                    <a href="#" class="text-blue-600 hover:underline block mb-2">
                      Here are some tips for taking great photos of your property
                    </a>
                    <p class="text-gray-600">
                      If you don't know who took a photo, it's best to avoid using it. Only use photos others have taken
                      if you have permission.
                    </p>
                  </div>
                </div>
                <!-- Navigation Buttons -->
                <div class="mt-6 flex justify-between">
                  <button
                    @click="step--"
                    class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded"
                    :disabled="isUploading"
                    >
                    ←
                  </button>
                  <button
                    @click="uploadPhotosAndContinue"
                    :disabled="uploadedPhotos.length < 1 || isUploading"
                    :class="{
                      'px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700cursor-pointer opacity-100 hover:bg-blue-700':
                        uploadedPhotos.length >= 1,
                      'bg-gray-400 rounded cursor-not-allowed opacity-50': uploadedPhotos.length < 1,
                    }"
                    class="px-6 py-2 text-white rounded"
                  >
                   <span x-show="!isUploading">Continue</span>
                  <span x-show="isUploading">Uploading...</span>
                  </button>
                </div>
              </div>
            </section>



            <section x-show="step === 4">

  <template x-if="pricingWizardStep === 1">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
  <template x-if="pricingWizardStep === 2">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
  <template x-if="pricingWizardStep === 3">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
  <template x-if="pricingWizardStep === 4">
      <div class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  </div>
  </template>
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
        We're here to ensure you can receive bookings safely:
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
          <input type="radio" name="booking_type" class="form-radio text-blue-600" checked value="instant" x-model="pricing.booking_type">
          <span class="text-gray-800">All guests can book instantly <span class="ml-2 px-2 py-0.5 text-xs bg-green-100 text-green-700 rounded">Recommended</span></span>
        </label>
        <label class="flex items-center space-x-3">
          <input type="radio" name="booking_type" value="request" x-model="pricing.booking_type" class="form-radio text-blue-600">
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
  <select x-model="pricing.currency" class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-transparent text-gray-700 text-sm pr-1 focus:outline-none border border-gray-300 rounded-md">
    <option value="usd">US$</option>
    <option value="eur">€</option>
    <option value="gbp">£</option>
    <option value="lkr">Rs</option>
  </select>

  <!-- Input Field -->
  <input
    type="text"
    x-model="pricing.price_per_night"
    name="price_per_night"
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
      <strong>What if I'm not sure about my price?</strong>
    </div>

    <p>Don't worry, you can always change it later. You can even set weekend, midweek, and seasonal prices, giving you more control over what you earn.</p>
  </div>

</div>

      <!-- Discount and Tip 2 -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- Discount card -->
        <div class="md:col-span-2 bg-white border rounded-lg p-6 shadow-sm space-y-3">
          <label class="inline-flex items-center">
            <input type="checkbox" x-model="pricing.discount_enabled" class="form-checkbox text-blue-600 rounded-md" />
            <span class="ml-2 font-medium text-gray-700 font-semibold">Get guests' attention with a 20% discount</span>
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
                @click="savePricing"
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
         <a href="{{ route('partner.apartment.non.refundable.rate') }}">
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
          <span class="text-sm">Yes, I'll import unavailable dates from another website</span>
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
          <span class="text-sm">No, I won't sync my availability</span>
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
  
  <button       @click="savePricing()" class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded hover:bg-sky-500 transition w-full sm:w-auto">
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
        <select x-model="ownershipType" @change="logBusinessChange('ownershipType', $event.target.value)" class="w-full p-2 border rounded text-sm focus:ring focus:ring-sky-200">
          <option value="">Select an option</option>
          <option value="individual">I am an individual running a business</option>
          <option value="business">I represent a business entity</option>
        </select>
      </div>
    </div>

    <!-- Individual Form -->
    <div x-show="ownershipType === 'individual'" x-transition class="bg-white p-6 rounded-lg space-y-4">
      <p class="text-sm text-gray-800">
        Please provide the full names and dates of birth of the individual who owns the accommodation.
      </p>
      <div class="border p-4 rounded-lg space-y-4 bg-white">
        <div>
          <label class="block text-sm font-semibold text-gray-600">First Name</label>
          <input type="text" x-model="individual.firstName" @input="logBusinessChange('individual.firstName', $event.target.value)" placeholder="First Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Last Name</label>
          <input type="text" x-model="individual.lastName" @input="logBusinessChange('individual.lastName', $event.target.value)" placeholder="Last Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
          <input type="date" x-model="individual.dob" @change="logBusinessChange('individual.dob', $event.target.value)" class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
        </div>
        <!-- Alt names if needed -->
        <div>
          <label class="block font-semibold text-sm text-gray-600">
            If the owner goes by an alternative name or names, please provide those details.
            <span class="text-gray-500">- (Optional)</span>
          </label>
          <input type="text" x-model="individual.altNames[0]" class="w-full p-2 border rounded text-sm" />
        </div>
      </div>
    </div>

    <!-- Business Form -->
    <div x-show="ownershipType === 'business'" x-transition class="bg-white p-6 rounded-lg shadow border space-y-4">
      <div class="border p-4 rounded-lg space-y-4 bg-white">
        <div>
          <label class="block text-sm font-semibold text-gray-600">Full name of business entity</label>
          <input type="text" x-model="business.businessName" @input="logBusinessChange('business.businessName', $event.target.value)" placeholder="Business Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Trading Name (optional)</label>
          <input type="text" x-model="business.tradingName" @input="logBusinessChange('business.tradingName', $event.target.value)" placeholder="Trading Name" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Address of business entity</label>
          <input type="text" x-model="business.address" @input="logBusinessChange('business.address', $event.target.value)" placeholder="Address" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Zip Code</label>
          <input type="text" x-model="business.zipCode" @input="logBusinessChange('business.zipCode', $event.target.value)" placeholder="Zip Code" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">City</label>
          <input type="text" x-model="business.city" @input="logBusinessChange('business.city', $event.target.value)" placeholder="City" class="w-full p-2 border rounded text-sm" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600">Country</label>
          <select x-model="business.country" @change="logBusinessChange('business.country', $event.target.value)" class="w-full p-2 border rounded text-sm">
            <option value="">Select a country</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="India">India</option>
            <option value="United States">United States</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Australia">Australia</option>
          </select>
        </div>
        <div>
          <label class="block font-semibold text-sm text-gray-600">
            If the company operates under a different name (e.g. "trading as" name) in relation to the accommodation, please provide those details.
            <span class="text-gray-500">- (Optional)</span>
          </label>
          <input type="text" x-model="business.tradingName" class="w-full p-2 border rounded text-sm" />
        </div>
      </div>
      <p class="text-sm text-gray-800">
        Please provide the full names and dates of birth of all individuals who own 25% or more of the accommodation.
      </p>
      <template x-for="(owner, index) in business.owners" :key="index">
        <div class="border p-4 rounded-lg space-y-4 bg-white">
          <div>
            <label class="block text-sm font-semibold text-gray-600">First Name</label>
            <input type="text" x-model="owner.firstName" placeholder="First Name" class="w-full p-2 border rounded text-sm" />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-600">Last Name</label>
            <input type="text" x-model="owner.lastName" placeholder="Last Name" class="w-full p-2 border rounded text-sm" />
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-600 mb-2">Date of Birth</label>
            <input type="date" x-model="owner.dob" class="w-full p-2 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-sky-200" />
          </div>
          <div>
            <label class="block font-semibold text-sm text-gray-600">
              If any owners go by an alternative name or names, please provide those details.
              <span class="text-gray-500">- (Optional)</span>
            </label>
            <input type="text" x-model="owner.altNames[0]" class="w-full p-2 border rounded text-sm" />
          </div>
          <div x-show="business.owners.length > 1" class="text-right">
            <button @click="business.owners.splice(index, 1)" type="button" class="text-red-600 text-sm hover:underline">Remove</button>
          </div>
        </div>
      </template>
      <div>
        <button @click="business.owners.push({ firstName: '', lastName: '', dob: '', altNames: [] })" type="button" class="text-sky-600 text-sm font-medium hover:underline mt-2">+ Add another owner</button>
      </div>
    </div>

    <!-- Navigation -->
    <div class="flex justify-between pt-4">
      <button @click="step--"
             class="flex items-center border border-[#3CC0E9] rounded text-blue-600 hover:bg-blue-50 font-semibold px-4 h-12">

            ←
      </button>
      <button @click="saveLegalInfo()"
              :disabled="isLoading"
              :class="isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600'"
              class="bg-[#3CC0E9] text-white font-semibold px-6 py-3 rounded transition ">
        <span x-show="!isLoading">Continue</span>
        <span x-show="isLoading">Saving...</span>
      </button>
    </div>
  </div>
</section>

<script>
function wizardApp() {
    return {
        // Debug and logging utilities
        debugMode: true,
        log(message, data = null) {
            if (this.debugMode) {
                console.log('[WIZARD DEBUG] ' + message, data || '');
            }
        },
        logStepChange(oldStep, newStep, context = '') {
            this.log('Step changed from ' + oldStep + ' to ' + newStep + ' ' + context);
        },
        logCurrentState() {
            this.log('Current State:', {
                step: this.step,
                wizardStep: this.wizardStep,
                propertyWizardStep: this.propertyWizardStep,
                pricingWizardStep: this.pricingWizardStep,
                bedroomStep: this.bedroomStep,
                propertyId: this.propertyId,
                totalRooms: Object.keys(this.rooms).length,
                currentEditingRoom: this.currentEditingRoomId
            });
        },

        // Step tracking
        testValue: 'Alpine.js is working',
        currentSubStep: 1,   // 1 = wizardStep, 2 = propertyWizardStep, 3 = pricingWizardStep
        propertyWizardStep: 1,
        step: 1,
        wizardStep: 1,
        pricingWizardStep: 1,
        bedroomStep: 1,
        
        
        // Initialize watchers
        async init() {
            this.log('Alpine.js initialized');
            this.loadLanguages();
            console.log('Before restoreWizardState - step:', this.step);
            this.restoreWizardState();
            console.log('After restoreWizardState - step:', this.step);
            this.handleBedroomReturn();
            console.log('After handleBedroomReturn - step:', this.step);
            await this.loadPropertyData();
            console.log('After loadPropertyData - step:', this.step);
            
            // Check completion status for existing properties
            if (this.propertyId !== 'new') {
                await this.checkBasicInfoCompletion();
            }
            
            this.logCurrentState();
            console.log('Initial rooms state:', this.rooms);
            console.log('Final wizard state after initialization:', {
                step: this.step,
                wizardStep: this.wizardStep,
                propertyWizardStep: this.propertyWizardStep,
                pricingWizardStep: this.pricingWizardStep,
                bedroomStep: this.bedroomStep
            });
            
            // Re-enabled basic watchers without saveWizardState calls
            this.$watch('step', (newVal, oldVal) => {
                if (oldVal !== undefined) {
                    this.logStepChange(oldVal, newVal, 'main step');
                }
            });
            
            this.$watch('wizardStep', (newVal, oldVal) => {
                if (oldVal !== undefined) {
                    this.logStepChange(oldVal, newVal, 'wizard step');
                }
                this.currentSubStep = newVal;
            });
            
            this.$watch('propertyWizardStep', (newVal, oldVal) => {
                if (oldVal !== undefined) {
                    this.logStepChange(oldVal, newVal, 'property wizard step');
                }
                this.currentSubStep = newVal;
            });
            
            this.$watch('pricingWizardStep', (newVal, oldVal) => {
                if (oldVal !== undefined) {
                    this.logStepChange(oldVal, newVal, 'pricing wizard step');
                }
                this.currentSubStep = newVal;
            });
            
            this.$watch('bedroomStep', (newVal, oldVal) => {
                if (oldVal !== undefined) {
                    this.logStepChange(oldVal, newVal, 'bedroom step');
                }
            });
            
            // Watch for step changes to check completion status
            this.$watch('step', async (newStep, oldStep) => {
                if (oldStep !== undefined && newStep === 1 && this.propertyId !== 'new') {
                    // Check completion status when navigating to basic info step
                    await this.checkBasicInfoCompletion();
                }
            });
            
            // Ensure default rooms are always present
            this.$watch('rooms', (newRooms) => {
                if (newRooms) {
                    const defaultRooms = {
                        'bedroom1': { name: 'Bedroom 1', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
                        'livingRoom': { name: 'Living room', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
                        'otherSpaces': { name: 'Other spaces', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 }
                    };
                    
                    // Ensure default rooms are always present
                    this.rooms = { ...defaultRooms, ...newRooms };
                    console.log('Rooms watcher triggered. Current rooms:', this.rooms);
                }
            }, { deep: true });
        },

        // Navigation helpers
        async goToStep(stepNumber, context = '') {
            this.log('Navigating to step ' + stepNumber + ' ' + context);
            this.step = stepNumber;
            
            // Check completion status when navigating to basic info step
            if (stepNumber === 1 && this.propertyId !== 'new') {
                await this.checkBasicInfoCompletion();
            }
            
            this.saveWizardState();
        },

        goToPropertyStep(stepNumber) {
            this.log('Navigating to property step ' + stepNumber);
            this.propertyWizardStep = stepNumber;
            this.saveWizardState();
        },

        goToPricingStep(stepNumber) {
            this.log('Navigating to pricing step ' + stepNumber);
            this.pricingWizardStep = stepNumber;
            this.saveWizardState();
        },

        // Track completion status for each step
        stepCompletionStatus: {
            basicInfo: false,
            propertySetup: false,
            photos: false,
            pricing: false,
            legalInfo: false
        },

        // Helper function to check if a step is completed
        isStepCompleted(stepIndex) {
            switch(stepIndex) {
                case 0: // Basic Information
                    // Check database completion status first, then fallback to wizard step
                    const basicInfoCompleted = this.stepCompletionStatus.basicInfo || this.wizardStep >= 3;
                    console.log('Basic info completion check:', {
                        stepIndex,
                        stepCompletionStatus: this.stepCompletionStatus.basicInfo,
                        wizardStep: this.wizardStep,
                        completed: basicInfoCompleted
                    });
                    return basicInfoCompleted;
                case 1: // Property Setup
                    return this.stepCompletionStatus.propertySetup || this.propertyWizardStep >= 6;
                case 2: // Photos
                    return this.stepCompletionStatus.photos || (this.uploadedPhotos && this.uploadedPhotos.length >= 1);
                case 3: // Pricing and Calendar
                    return this.stepCompletionStatus.pricing || this.pricingWizardStep >= 4;
                case 4: // Legal Information
                    return this.stepCompletionStatus.legalInfo || this.step >= 6 || (this.ownershipType && (this.individual.firstName || this.business.businessName));
                default:
                    return false;
            }
        },

        // Check if basic information is completed in database
        async checkBasicInfoCompletion() {
            if (this.propertyId === 'new') {
                return false;
            }
            
            try {
                const response = await fetch(`/partner/property/${this.propertyId}/check-basic-info`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    this.stepCompletionStatus.basicInfo = data.completed;
                    this.log('Basic info completion status: ' + data.completed);
                } else {
                    this.log('Failed to check basic info completion');
                }
            } catch (error) {
                this.log('Error checking basic info completion: ' + error.message);
            }
        },

        // Property data
        propertyId: 'new',
        title: '',
        address: '',
        city: '',
        country: 'Sri Lanka',
        apartment: '',
        zipcode: '',
        description: '',
        channelManager: 'yes',
        isLoading: false,
        
        // Guest and amenity data
        guests: 4,
        bathrooms: 2,
        allowChildren: 'yes',
        offerCribs: 'no',
        apartmentSize: 100,
        apartmentUnit: 'square_meters',
        selectedAmenities: [],
        
        // Rooms data - using single rooms object for all bedrooms
        rooms: {
            'bedroom1': { name: 'Bedroom 1', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
            'livingRoom': { name: 'Living room', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
            'otherSpaces': { name: 'Other spaces', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 }
        },
        currentEditingRoomId: null,
        tempBedCounts: { twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
        nextRoomIndex: 2,
        showBedTypeSelector: false,
        showAllBedTypesInModal: false,
        
        // Parking data
        parkingAvailable: '',
        parkingCurrency: 'USD',
        parkingCost: '',
        parkingRate: 'per_day',
        parkingReservation: '',
        parkingLocation: '',
        parkingType: '',
        
        // Breakfast data
        breakfastServed: '',
        breakfastIncluded: '',
        breakfastTypes: [],
        
        // Language data
        showAdditionalLanguages: false,
        showLanguageModal: false,
        searchTerm: '',
        showDropdown: false,
        filteredLanguages: [],
        selectedLanguages: [],
        availableLanguages: [
            { id: 1, name: 'English' },
            { id: 2, name: 'Spanish' },
            { id: 3, name: 'French' },
            { id: 4, name: 'German' },
            { id: 5, name: 'Italian' },
            { id: 6, name: 'Portuguese' },
            { id: 7, name: 'Dutch' },
            { id: 8, name: 'Russian' },
            { id: 9, name: 'Chinese' },
            { id: 10, name: 'Japanese' }
        ],
        
        // Business/Individual data
        ownershipType: '',
        individual: {
            firstName: '',
            lastName: '',
            dob: '',
            altNames: ['']
        },
        business: {
            businessName: '',
            tradingName: '',
            address: '',
            zipCode: '',
            city: '',
            country: '',
            owners: [
                {
                    firstName: '',
                    lastName: '',
                    dob: '',
                    altNames: ['']
                }
            ]
        },

        // House rules data
        smokingAllowed: false,
        partiesAllowed: false,
        petsAllowed: 'no',
        petsFees: 'free',
        checkInFrom: '15:00',
        checkInUntil: '18:00',
        checkOutFrom: '08:00',
        checkOutUntil: '11:00',

        // Pricing data
        pricing: {
            booking_type: 'instant',
            price_per_night: '',
            currency: 'usd',
            discount_enabled: false,
            discount_percent: 0
        },

        // Host profile data
        hostProfile: {
            about_property: '',
            about_host: '',
            about_neighborhood: '',
            show_property: false,
            show_host: false,
            show_neighborhood: false,
            none_selected: false,
            host_name: ''
        },

        // Photo upload data
        isUploading: false,
        uploadedPhotos: [],

        // Bedroom management methods
        openBedTypeSelector(roomId) {
            this.log('Opening bed type selector for room: ' + roomId);
            this.currentEditingRoomId = roomId;
            this.tempBedCounts = { ...this.rooms[roomId] };
            this.showAllBedTypesInModal = roomId !== 'livingRoom';
            this.showBedTypeSelector = true;
        },

        saveBedTypes() {
            this.log('Saving bed types');
            if (this.currentEditingRoomId) {
                Object.assign(this.rooms[this.currentEditingRoomId], this.tempBedCounts);
                this.log('Bed types saved for ' + this.currentEditingRoomId + ':', this.rooms[this.currentEditingRoomId]);
            }
            this.showBedTypeSelector = false;
            this.currentEditingRoomId = null;
        },

        cancelBedTypes() {
            this.log('Canceling bed type selection');
            this.showBedTypeSelector = false;
            this.currentEditingRoomId = null;
        },



        getBedSummary(roomId) {
            const beds = this.rooms[roomId];
            console.log(`Getting bed summary for ${roomId}:`, beds);
            if (!beds) return '0 beds';
            const summaryParts = [];
            if (beds.twin > 0) summaryParts.push(beds.twin + ' twin bed' + (beds.twin > 1 ? 's' : ''));
            if (beds.full > 0) summaryParts.push(beds.full + ' full bed' + (beds.full > 1 ? 's' : ''));
            if (beds.queen > 0) summaryParts.push(beds.queen + ' queen bed' + (beds.queen > 1 ? 's' : ''));
            if (beds.king > 0) summaryParts.push(beds.king + ' king bed' + (beds.king > 1 ? 's' : ''));
            if (beds.bunk > 0) summaryParts.push(beds.bunk + ' bunk bed' + (beds.bunk > 1 ? 's' : ''));
            if (beds.sofa > 0) summaryParts.push(beds.sofa + ' sofa bed' + (beds.sofa > 1 ? 's' : ''));
            if (beds.futon > 0) summaryParts.push(beds.futon + ' futon bed' + (beds.futon > 1 ? 's' : ''));
            const summary = summaryParts.length > 0 ? summaryParts.join(', ') : '0 beds';
            console.log(`Bed summary for ${roomId}:`, summary);
            return summary;
        },

        hasBedCounts(roomId) {
            const beds = this.rooms[roomId];
            if (!beds) return false;
            return (beds.twin > 0 || beds.full > 0 || beds.queen > 0 || beds.king > 0 || 
                    beds.bunk > 0 || beds.sofa > 0 || beds.futon > 0);
        },

        // Language management methods
        async loadLanguages() {
            this.log('Loading languages...');
            try {
                const response = await fetch('/partner/languages', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                console.log('Languages API response status:', response.status);
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('Languages API response data:', data);
                    this.availableLanguages = data || [];
                    this.filteredLanguages = this.availableLanguages;
                    this.log('Languages loaded from database: ' + this.availableLanguages.length);
                    console.log('Available languages after loading:', this.availableLanguages);
                    
                    // Clear selected languages to prevent ID mismatches
                    this.selectedLanguages = [];
                    console.log('Cleared selected languages to prevent ID mismatches');
                } else {
                    this.log('Failed to load languages from database, using fallback');
                    console.log('Response not ok, status:', response.status);
                    // Use hardcoded languages as fallback
                    this.availableLanguages = [
                        { id: 1, name: 'English' },
                        { id: 2, name: 'Spanish' },
                        { id: 3, name: 'French' },
                        { id: 4, name: 'German' },
                        { id: 5, name: 'Italian' },
                        { id: 6, name: 'Portuguese' },
                        { id: 7, name: 'Dutch' },
                        { id: 8, name: 'Russian' },
                        { id: 9, name: 'Chinese' },
                        { id: 10, name: 'Japanese' },
                        { id: 11, name: 'Korean' },
                        { id: 12, name: 'Thai' },
                        { id: 13, name: 'Vietnamese' },
                        { id: 14, name: 'Turkish' },
                        { id: 15, name: 'Greek' },
                        { id: 16, name: 'Hebrew' },
                        { id: 17, name: 'Polish' },
                        { id: 18, name: 'Swedish' },
                        { id: 19, name: 'Norwegian' },
                        { id: 20, name: 'Finnish' },
                        { id: 21, name: 'Hungarian' },
                        { id: 22, name: 'Romanian' },
                        { id: 23, name: 'Ukrainian' },
                        { id: 24, name: 'Indonesian' },
                        { id: 25, name: 'Malay' },
                        { id: 26, name: 'Tagalog' },
                        { id: 27, name: 'Swahili' },
                        { id: 28, name: 'Urdu' },
                        { id: 29, name: 'Bengali' },
                        { id: 30, name: 'Tamil' },
                        { id: 31, name: 'Telugu' },
                        { id: 32, name: 'Marathi' },
                        { id: 33, name: 'Gujarati' },
                        { id: 34, name: 'Punjabi' },
                        { id: 35, name: 'Kannada' },
                        { id: 36, name: 'Malayalam' },
                        { id: 37, name: 'Sinhala' },
                        { id: 38, name: 'Hindi' },
                        { id: 39, name: 'Arabic' },
                        { id: 40, name: 'Bulgarian' },
                        { id: 41, name: 'Catalan' },
                        { id: 42, name: 'Croatian' },
                        { id: 43, name: 'Czech' },
                        { id: 44, name: 'Danish' }
                    ];
                    this.filteredLanguages = this.availableLanguages;
                    this.log('Using fallback languages: ' + this.availableLanguages.length);
                    
                    // Clear selected languages to prevent ID mismatches
                    this.selectedLanguages = [];
                    console.log('Cleared selected languages to prevent ID mismatches');
                }
            } catch (error) {
                this.log('Error loading languages: ' + error);
                console.error('Error loading languages:', error);
                // Use hardcoded languages as fallback
                this.availableLanguages = [
                    { id: 1, name: 'English' },
                    { id: 2, name: 'Spanish' },
                    { id: 3, name: 'French' },
                    { id: 4, name: 'German' },
                    { id: 5, name: 'Italian' },
                    { id: 6, name: 'Portuguese' },
                    { id: 7, name: 'Dutch' },
                    { id: 8, name: 'Russian' },
                    { id: 9, name: 'Chinese' },
                    { id: 10, name: 'Japanese' },
                    { id: 11, name: 'Korean' },
                    { id: 12, name: 'Thai' },
                    { id: 13, name: 'Vietnamese' },
                    { id: 14, name: 'Turkish' },
                    { id: 15, name: 'Greek' },
                    { id: 16, name: 'Hebrew' },
                    { id: 17, name: 'Polish' },
                    { id: 18, name: 'Swedish' },
                    { id: 19, name: 'Norwegian' },
                    { id: 20, name: 'Finnish' },
                    { id: 21, name: 'Hungarian' },
                    { id: 22, name: 'Romanian' },
                    { id: 23, name: 'Ukrainian' },
                    { id: 24, name: 'Indonesian' },
                    { id: 25, name: 'Malay' },
                    { id: 26, name: 'Tagalog' },
                    { id: 27, name: 'Swahili' },
                    { id: 28, name: 'Urdu' },
                    { id: 29, name: 'Bengali' },
                    { id: 30, name: 'Tamil' },
                    { id: 31, name: 'Telugu' },
                    { id: 32, name: 'Marathi' },
                    { id: 33, name: 'Gujarati' },
                    { id: 34, name: 'Punjabi' },
                    { id: 35, name: 'Kannada' },
                    { id: 36, name: 'Malayalam' },
                    { id: 37, name: 'Sinhala' },
                    { id: 38, name: 'Hindi' },
                    { id: 39, name: 'Arabic' },
                    { id: 40, name: 'Bulgarian' },
                    { id: 41, name: 'Catalan' },
                    { id: 42, name: 'Croatian' },
                    { id: 43, name: 'Czech' },
                    { id: 44, name: 'Danish' }
                ];
                this.filteredLanguages = this.availableLanguages;
                this.log('Using fallback languages: ' + this.availableLanguages.length);
                
                // Clear selected languages to prevent ID mismatches
                this.selectedLanguages = [];
                console.log('Cleared selected languages to prevent ID mismatches');
            }
        },

        filterLanguages() {
            if (!this.searchTerm.trim()) {
                this.filteredLanguages = this.availableLanguages;
            } else {
                this.filteredLanguages = this.availableLanguages.filter(language =>
                    language.name.toLowerCase().includes(this.searchTerm.toLowerCase())
                );
            }
            this.log('Filtered languages: ' + this.filteredLanguages.length + ' results');
        },

        selectLanguage(languageId, languageName) {
            this.log('Selecting language: ' + languageId + ', ' + languageName);
            
            // Ensure languageId is a number
            const numericId = parseInt(languageId);
            if (isNaN(numericId)) {
                console.error('Invalid language ID:', languageId);
                return;
            }
            
            if (!this.selectedLanguages.includes(numericId)) {
                this.selectedLanguages.push(numericId);
                this.log('Language added with ID: ' + numericId);
            }
            this.showDropdown = false;
        },

        removeLanguage(languageId) {
            this.log('Removing language: ' + languageId);
            
            // Ensure languageId is a number
            const numericId = parseInt(languageId);
            if (isNaN(numericId)) {
                console.error('Invalid language ID for removal:', languageId);
                return;
            }
            
            const index = this.selectedLanguages.indexOf(numericId);
            if (index > -1) {
                this.selectedLanguages.splice(index, 1);
                this.log('Language removed with ID: ' + numericId);
            }
        },

        getLanguageName(languageId) {
            console.log('Getting language name for ID:', languageId);
            console.log('Available languages:', this.availableLanguages);
            
            // Ensure languageId is a number
            const numericId = parseInt(languageId);
            if (isNaN(numericId)) {
                console.error('Invalid language ID for name lookup:', languageId);
                return 'Unknown';
            }
            
            const language = this.availableLanguages.find(l => l.id === numericId);
            console.log('Found language:', language);
            
            if (language) {
                return language.name;
            } else {
                console.warn('Language not found for ID:', numericId);
                return 'Unknown';
            }
        },

        getLanguageIdByName(languageName) {
            console.log('Getting language ID for name:', languageName);
            console.log('Available languages:', this.availableLanguages);
            
            const language = this.availableLanguages.find(l => l.name === languageName);
            console.log('Found language for name:', language);
            
            return language ? language.id : null;
        },

        isLanguageSelected(languageId) {
            // Ensure languageId is a number
            const numericId = parseInt(languageId);
            if (isNaN(numericId)) {
                return false;
            }
            return this.selectedLanguages.includes(numericId);
        },

        toggleAdditionalLanguages() {
            this.showAdditionalLanguages = !this.showAdditionalLanguages;
            this.log('Toggled additional languages: ' + this.showAdditionalLanguages);
        },

        logLanguageChange(field, value) {
            this.log('Language field changed: ' + field + ' = ' + value);
        },

        // Photo upload methods
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
        },

        // Form submission methods
        async ensurePropertyId() {
            try {
                if (this.propertyId && this.propertyId !== 'new') {
                    return true;
                }
                const res = await fetch('/partner/get-latest-property', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                if (!res.ok) {
                    showToast('Could not resolve property. Please complete Step 1 first.', 'error');
                    return false;
                }
                const data = await res.json();
                const latestId = data?.property?.id || data?.id || null;
                if (!latestId) {
                    showToast('No property found. Please complete Step 1 first.', 'error');
                    return false;
                }
                this.propertyId = latestId;
                this.saveWizardState();
                return true;
            } catch (e) {
                showToast('Error resolving property. Please complete Step 1 first.', 'error');
                return false;
            }
        },

        async saveName() {
            this.log('Saving name');
            if (!this.title.trim()) {
                showToast('Please enter a property name', 'warning');
                return;
            }
            if (!(await this.ensurePropertyId())) {
                return;
            }
            
            try {
                const response = await fetch(`/partner/property/${this.propertyId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        title: this.title
                    })
                });
                
                if (response.ok) {
                    this.wizardStep++;
                    this.saveWizardState();
                    console.log('Property name saved successfully');
                    showToast('Property name saved successfully!', 'success');
                    
                    // Mark basic info as completed if all required fields are saved
                    if (this.wizardStep >= 3) {
                        this.stepCompletionStatus.basicInfo = true;
                        this.log('Basic info marked as completed');
                    }
                } else {
                    console.error('Failed to save property name');
                }
            } catch (error) {
                console.error('Error saving property name:', error);
            }
        },

        async saveLocation() {
            this.log('Saving location');
            if (!this.address.trim() || !this.city.trim()) {
                showToast('Please enter both address and city', 'warning');
                return;
            }
            if (!(await this.ensurePropertyId())) {
                return;
            }
            
            try {
                const response = await fetch(`/partner/property/${this.propertyId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        apartment: this.apartment,
                        zipcode: this.zipcode
                    })
                });
                
                if (response.ok) {
                    this.wizardStep++;
                    this.saveWizardState();
                    console.log('Property location saved successfully');
                    showToast('Property location saved successfully!', 'success');
                } else {
                    console.error('Failed to save property location');
                }
            } catch (error) {
                console.error('Error saving property location:', error);
            }
        },

        async saveChannelManager() {
            this.log('Saving channel manager preference');
            
            if (!(await this.ensurePropertyId())) {
                return;
            }
            
            try {
                const response = await fetch(`/partner/property/${this.propertyId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        channel_manager: this.channelManager
                    })
                });
                
                if (response.ok) {
                    this.step++;
                    this.saveWizardState();
                    console.log('Channel manager preference saved successfully');
                } else {
                    console.error('Failed to save channel manager preference');
                }
            } catch (error) {
                console.error('Error saving channel manager preference:', error);
            }
        },

        async savePropertyDetails() {
            this.log('Saving property details');
            
            // Validate required fields
            if (!this.guests || this.guests < 1) {
                showToast('Please set the number of guests (minimum 1)', 'warning');
                return;
            }
            
            if (!this.bathrooms || this.bathrooms < 0) {
                showToast('Please set the number of bathrooms', 'warning');
                return;
            }
            
            if (!this.allowChildren) {
                showToast('Please select whether children are allowed', 'warning');
                return;
            }
            
            if (!this.offerCribs) {
                showToast('Please select whether infants are allowed', 'warning');
                return;
            }
            
            if (!(await this.ensurePropertyId())) {
                return;
            }
            
            try {
                console.log('Saving property details with data:', {
                    guests: this.guests,
                    bathrooms: this.bathrooms,
                    allow_children: this.allowChildren,
                    offer_cribs: this.offerCribs,
                    apartment_size: this.apartmentSize,
                    apartment_unit: this.apartmentUnit
                });
                
                const response = await fetch(`/partner/property/${this.propertyId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        guests: this.guests,
                        bathrooms: this.bathrooms,
                        allow_children: this.allowChildren,
                        offer_cribs: this.offerCribs,
                        apartment_size: this.apartmentSize,
                        apartment_unit: this.apartmentUnit
                    })
                });
                
                if (response.ok) {
                    const result = await response.json();
                    console.log('Property details saved successfully:', result);
                    showToast('Property details saved successfully!', 'success');
                    this.propertyWizardStep++;
                    this.saveWizardState();
                } else {
                    const errorData = await response.json();
                    console.error('Failed to save property details:', errorData);
                    showToast('Failed to save property details: ' + (errorData.message || 'Unknown error'), 'error');
                }
            } catch (error) {
                console.error('Error saving property details:', error);
                showToast('Error saving property details: ' + error.message, 'error');
            }
        },

        async saveHostProfile() {
            this.log('Saving host profile');
            
            if (!(await this.ensurePropertyId())) {
                return;
            }
            
            try {
                const response = await fetch(`/partner/property/${this.propertyId}/host-profile`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        property_id: this.propertyId,
                        about_property: this.hostProfile.about_property,
                        about_host: this.hostProfile.about_host,
                        about_neighborhood: this.hostProfile.about_neighborhood,
                        show_property: this.hostProfile.show_property,
                        show_host: this.hostProfile.show_host,
                        show_neighborhood: this.hostProfile.show_neighborhood,
                        none_selected: this.hostProfile.none_selected,
                        host_name: this.hostProfile.host_name
                    })
                });
                
                if (response.ok) {
                    // Move to pricing section after completing property wizard
                    this.step = 3; // Move to pricing section
                    this.pricingWizardStep = 1; // Start at first pricing step
                    this.saveWizardState();
                    console.log('Host profile saved successfully');
                } else {
                    console.error('Failed to save host profile');
                }
            } catch (error) {
                console.error('Error saving host profile:', error);
            }
        },

        // Logging methods
        logBusinessChange(fieldName, value) {
            this.log('Business field changed: ' + fieldName + ' = ' + value);
        },

        logInputChange(fieldName, value) {
            this.log('Input changed: ' + fieldName + ' = ' + value);
        },

        logBreakfastChange(fieldName, value) {
            this.log('Breakfast field changed: ' + fieldName + ' = ' + value);
        },

        logParkingChange(fieldName, value) {
            this.log('Parking field changed: ' + fieldName + ' = ' + value);
            
            // Clear parking details when "No" is selected
            if (fieldName === 'parkingAvailable' && value === 'no') {
                this.clearParkingDetails();
            }
            
            // Clear parking cost when switching to "free"
            if (fieldName === 'parkingAvailable' && value === 'free') {
                this.clearParkingCost();
            }
        },
        
        clearParkingDetails() {
            this.parkingCost = '';
            this.parkingReservation = '';
            this.parkingLocation = '';
            this.parkingType = '';
            this.log('Parking details cleared');
        },
        
        clearParkingCost() {
            this.parkingCost = '';
            this.log('Parking cost cleared');
        },

        // State persistence
        saveWizardState() {
            console.log('=== SAVING WIZARD STATE ===');
            console.log('Saving step:', this.step);
            console.log('Saving wizardStep:', this.wizardStep);
            console.log('Saving propertyWizardStep:', this.propertyWizardStep);
            console.log('Saving pricingWizardStep:', this.pricingWizardStep);
            console.log('Saving propertyId:', this.propertyId);
            
            const state = {
                propertyId: this.propertyId, // Add property ID to saved state
                currentSubStep: this.currentSubStep,
                step: this.step,
                wizardStep: this.wizardStep,
                propertyWizardStep: this.propertyWizardStep,
                pricingWizardStep: this.pricingWizardStep,
                bedroomStep: this.bedroomStep,
                stepCompletionStatus: this.stepCompletionStatus,
                title: this.title,
                address: this.address,
                city: this.city,
                country: this.country,
                apartment: this.apartment,
                zipcode: this.zipcode,
                description: this.description,
                channelManager: this.channelManager,
                guests: this.guests,
                bathrooms: this.bathrooms,
                allowChildren: this.allowChildren,
                offerCribs: this.offerCribs,
                apartmentSize: this.apartmentSize,
                apartmentUnit: this.apartmentUnit,
                selectedAmenities: this.selectedAmenities,
                rooms: this.rooms,
                parkingAvailable: this.parkingAvailable,
                parkingCurrency: this.parkingCurrency,
                parkingCost: this.parkingCost,
                parkingRate: this.parkingRate,
                parkingReservation: this.parkingReservation,
                parkingLocation: this.parkingLocation,
                parkingType: this.parkingType,
                breakfastServed: this.breakfastServed,
                breakfastIncluded: this.breakfastIncluded,
                breakfastTypes: this.breakfastTypes,
                selectedLanguages: this.selectedLanguages,
                ownershipType: this.ownershipType,
                individual: this.individual,
                business: this.business,
                smokingAllowed: this.smokingAllowed,
                partiesAllowed: this.partiesAllowed,
                petsAllowed: this.petsAllowed,
                petsFees: this.petsFees,
                checkInFrom: this.checkInFrom,
                checkInUntil: this.checkInUntil,
                checkOutFrom: this.checkOutFrom,
                checkOutUntil: this.checkOutUntil,
                pricing: this.pricing,
                hostProfile: this.hostProfile,
                uploadedPhotos: this.uploadedPhotos
            };
            sessionStorage.setItem('wizardState', JSON.stringify(state));
            this.log('Wizard state saved for property: ' + this.propertyId);
            console.log('State saved to sessionStorage:', JSON.stringify(state));
            console.log('SessionStorage after save:', sessionStorage.getItem('wizardState'));
            console.log('=== END SAVING WIZARD STATE ===');
        },

        restoreWizardState() {
            console.log('=== SIMPLE WIZARD STATE RESTORATION ===');
            
            try {
                const savedState = sessionStorage.getItem('wizardState');
                console.log('Saved state from sessionStorage:', savedState);
                
                if (savedState) {
                    const state = JSON.parse(savedState);
                    console.log('Parsed state:', state);
                    
                    // Simple property ID check
                    if (state.propertyId && this.propertyId === 'new' && state.propertyId !== 'new') {
                        this.propertyId = state.propertyId;
                        console.log('Updated propertyId to:', this.propertyId);
                    }
                    
                    // Restore basic wizard state
                    if (state.step) this.step = state.step;
                    if (state.wizardStep) this.wizardStep = state.wizardStep;
                    if (state.propertyWizardStep) this.propertyWizardStep = state.propertyWizardStep;
                    if (state.pricingWizardStep) this.pricingWizardStep = state.pricingWizardStep;
                    if (state.bedroomStep) this.bedroomStep = state.bedroomStep;
                    if (state.currentSubStep) this.currentSubStep = state.currentSubStep;
                    
                    // Restore completion status
                    if (state.stepCompletionStatus) {
                        this.stepCompletionStatus = { ...this.stepCompletionStatus, ...state.stepCompletionStatus };
                        console.log('Restored completion status:', this.stepCompletionStatus);
                    }
                    
                    console.log('Restored state - step:', this.step, 'wizardStep:', this.wizardStep);
                } else {
                    console.log('No saved state found');
                }
            } catch (error) {
                console.error('Error in restoreWizardState:', error);
            }
            
            console.log('=== END SIMPLE RESTORATION ===');
        },



        resetWizardState() {
            console.log('Resetting wizard state to defaults');
            this.step = 1;
            this.wizardStep = 1;
            this.propertyWizardStep = 1;
            this.pricingWizardStep = 1;
            this.bedroomStep = 1;
            this.currentSubStep = 1;
            console.log('Wizard state reset to:', {
                step: this.step,
                wizardStep: this.wizardStep,
                propertyWizardStep: this.propertyWizardStep,
                pricingWizardStep: this.pricingWizardStep,
                bedroomStep: this.bedroomStep,
                currentSubStep: this.currentSubStep
            });
        },

        handleBedroomReturn() {
            this.log('Handling bedroom return');
            
            // Check for bedroom data in sessionStorage (old method)
            const bedroomData = sessionStorage.getItem('bedroomData');
            if (bedroomData) {
                this.handleBedroomData(bedroomData);
                sessionStorage.removeItem('bedroomData');
                return;
            }
            
            // Check for bedroom data in URL parameters (new method)
            const urlParams = new URLSearchParams(window.location.search);
            const returnFromBedroom = urlParams.get('returnFromBedroom');
            const bedroomDataParam = urlParams.get('bedroomData');
            
            console.log('Checking URL parameters for bedroom return');
            console.log('returnFromBedroom:', returnFromBedroom);
            console.log('bedroomData param:', bedroomDataParam);
            
            if (returnFromBedroom === 'true' && bedroomDataParam) {
                try {
                    const bedroomData = JSON.parse(decodeURIComponent(bedroomDataParam));
                    console.log('Parsed bedroom data from URL:', bedroomData);
                    this.handleBedroomData(JSON.stringify(bedroomData));
                    
                    // Clean up URL parameters
                    const newUrl = new URL(window.location);
                    newUrl.searchParams.delete('returnFromBedroom');
                    newUrl.searchParams.delete('bedroomData');
                    window.history.replaceState({}, '', newUrl);
                    
                    console.log('Cleaned up URL parameters');
                } catch (error) {
                    console.error('Error parsing bedroom data from URL:', error);
                }
            }
        },

        handleBedroomData(bedroomDataString) {
            try {
                const bedroomData = JSON.parse(bedroomDataString);
                console.log('Received bedroom data:', bedroomData);
                
                // Convert bed data from the new format to the old format
                const bedCounts = {};
                if (bedroomData.beds && Array.isArray(bedroomData.beds)) {
                    bedroomData.beds.forEach(bed => {
                        bedCounts[bed.name.toLowerCase().replace(' ', '_')] = bed.count;
                    });
                }
                
                const roomName = bedroomData.room_name || bedroomData.name || 'Bedroom 1';
                const roomKey = roomName.toLowerCase().replace(' ', '');
                
                // Add or update the room in the rooms object
                this.rooms[roomKey] = {
                    name: roomName,
                    twin: bedCounts.twin || 0,
                    full: bedCounts.full || 0,
                    queen: bedCounts.queen || 0,
                    king: bedCounts.king || 0,
                    bunk: bedCounts.bunk || 0,
                    sofa: bedCounts.sofa || 0,
                    futon: bedCounts.futon || 0
                };
                
                this.log('Bedroom data saved: ' + roomName);
                console.log('Updated rooms:', this.rooms);
            } catch (error) {
                this.log('Error handling bedroom data: ' + error);
                console.error('Error parsing bedroom data:', error);
            }
        },

        getSavedRoomBedSummary(room) {
            const summaryParts = [];
            if (room.twin > 0) summaryParts.push(room.twin + ' twin bed' + (room.twin > 1 ? 's' : ''));
            if (room.full > 0) summaryParts.push(room.full + ' full bed' + (room.full > 1 ? 's' : ''));
            if (room.queen > 0) summaryParts.push(room.queen + ' queen bed' + (room.queen > 1 ? 's' : ''));
            if (room.king > 0) summaryParts.push(room.king + ' king bed' + (room.king > 1 ? 's' : ''));
            if (room.bunk > 0) summaryParts.push(room.bunk + ' bunk bed' + (room.bunk > 1 ? 's' : ''));
            if (room.sofa > 0) summaryParts.push(room.sofa + ' sofa bed' + (room.sofa > 1 ? 's' : ''));
            if (room.futon > 0) summaryParts.push(room.futon + ' futon bed' + (room.futon > 1 ? 's' : ''));
            return summaryParts.length > 0 ? summaryParts.join(', ') : '0 beds';
        },

        editSavedRoom(roomKey) {
            this.log('Editing room: ' + roomKey);
            const room = this.rooms[roomKey];
            if (room) {
                this.currentEditingRoomId = roomKey;
                this.tempBedCounts = { ...room };
                this.showBedTypeSelector = true;
                this.showAllBedTypesInModal = true;
            }
        },

        // Data loading
        loadPropertyData() {
            this.log('Loading property data');
            const propertyDataElement = document.getElementById('property-data');
            if (propertyDataElement) {
                const propertyDataString = propertyDataElement.textContent;
                try {
                    const propertyData = JSON.parse(propertyDataString);
                    this.propertyId = propertyData.id || 'new';
                    this.title = propertyData.title || '';
                    this.address = propertyData.address || '';
                    this.city = propertyData.city || '';
                    this.country = propertyData.country || 'Sri Lanka';
                    this.apartment = propertyData.apartment || '';
                    this.zipcode = propertyData.zipcode || '';
                    this.description = propertyData.description || '';
                    this.channelManager = propertyData.channel_manager || 'yes';
                    this.guests = propertyData.guests || 4;
                    this.bathrooms = propertyData.bathrooms || 2;
                    this.allowChildren = propertyData.allow_children || 'yes';
                    this.offerCribs = propertyData.offer_cribs || 'no';
                    this.apartmentSize = propertyData.apartment_size || 100;
                    this.apartmentUnit = propertyData.apartment_unit || 'square_meters';
                    this.selectedAmenities = propertyData.selected_amenities || [];
                    console.log('Full propertyData from backend:', propertyData);
                    
                    // Ensure default rooms are always present
                    const defaultRooms = {
                        'bedroom1': { name: 'Bedroom 1', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
                        'livingRoom': { name: 'Living room', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 },
                        'otherSpaces': { name: 'Other spaces', twin: 0, full: 0, queen: 0, king: 0, bunk: 0, sofa: 0, futon: 0 }
                    };
                    
                    // Merge backend rooms with default rooms
                    this.rooms = { ...defaultRooms, ...(propertyData.rooms || {}) };
                    console.log('Loaded rooms from backend:', this.rooms);
                    console.log('Room keys:', Object.keys(this.rooms));
                    console.log('Additional bedrooms found:', Object.keys(this.rooms).filter(key => key !== 'bedroom1' && key !== 'livingRoom' && key !== 'otherSpaces'));
                    this.parkingAvailable = propertyData.parking_available || '';
                    this.parkingCurrency = propertyData.parking_currency || 'USD';
                    this.parkingCost = propertyData.parking_cost || '';
                    this.parkingRate = propertyData.parking_rate || 'per_day';
                    this.parkingReservation = propertyData.parking_reservation || '';
                    this.parkingLocation = propertyData.parking_location || '';
                    this.parkingType = propertyData.parking_type || '';
                    this.breakfastServed = propertyData.breakfast_served || '';
                    this.breakfastIncluded = propertyData.breakfast_included || '';
                    this.breakfastTypes = propertyData.breakfast_types || [];
                    this.selectedLanguages = propertyData.selected_languages || [];
                    this.ownershipType = propertyData.ownership_type || '';
                    this.individual = propertyData.individual || this.individual;
                    this.business = propertyData.business || this.business;
                    this.smokingAllowed = propertyData.smoking_allowed || false;
                    this.partiesAllowed = propertyData.parties_allowed || false;
                    this.petsAllowed = propertyData.pets_allowed || 'no';
                    this.petsFees = propertyData.pets_fees || 'free';
                    this.checkInFrom = propertyData.check_in_from || '15:00';
                    this.checkInUntil = propertyData.check_in_until || '18:00';
                    this.checkOutFrom = propertyData.check_out_from || '08:00';
                    this.checkOutUntil = propertyData.check_out_until || '11:00';
                    this.pricing = propertyData.pricing || this.pricing;
                    this.hostProfile = propertyData.host_profile || this.hostProfile;
                    this.uploadedPhotos = propertyData.uploaded_photos || [];
                    
                    this.log('Updated form fields:', {
                        propertyId: this.propertyId,
                        title: this.title,
                        address: this.address,
                        city: this.city
                    });
                } catch (error) {
                    this.log('Error parsing property data: ' + error);
                }
            } else {
                this.log('No property data element found');
            }
        },

        // Form submission methods
        async saveAdditionalDetails() {
            this.log('Saving additional details');
            
            // Check if propertyId is valid
            if (!this.propertyId || this.propertyId === 'new') {
                this.log('Validation failed: Property ID is missing');
                showToast('Property ID is missing. Please refresh the page.', 'error');
                return;
            }
            
            // For step 4 (languages), use dedicated language route
            if (this.propertyWizardStep === 4) {
                this.log('Saving languages for step 4: ' + this.selectedLanguages);
                const payload = {
                    languages: this.selectedLanguages
                };
                this.isLoading = true;
                
                try {
                    const res = await fetch('/partner/property/' + this.propertyId + '/languages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });
                    
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.log('Languages saved successfully: ' + data);
                    showToast('Languages saved successfully!', 'success');
                        this.log('Moving from propertyWizardStep ' + this.propertyWizardStep + ' to ' + (this.propertyWizardStep + 1));
                        this.propertyWizardStep++;
                        this.logCurrentState();
                    } else {
                        this.log('Language save error: ' + data);
                        showToast('Error: ' + (data.message || 'Could not save languages.'), 'error');
                    }
                } catch (err) {
                    this.log('AJAX error in language save: ' + err);
                    showToast('AJAX error: ' + err.message, 'error');
                } finally {
                    this.isLoading = false;
                }
                return; // Exit early for language step
            }
            
            // For other steps, use the existing logic
            const payload = {
                guests: this.guests,
                bathrooms: this.bathrooms,
                children_allowed: this.allowChildren === 'yes',
                offer_cribs: this.offerCribs,
                apartment_size: this.apartmentSize,
                apartment_unit: this.apartmentUnit,
                serve_breakfast: this.breakfastServed === 'yes',
                breakfast_included: this.breakfastIncluded,
                breakfast_type: this.breakfastTypes,
                parking_available: this.parkingAvailable,
                parking_cost: this.parkingCost,
                parking_reservation: this.parkingReservation,
                parking_location: this.parkingLocation,
                parking_type: this.parkingType,
            };
            
            this.log('Additional details payload: ' + JSON.stringify(payload, null, 2));
            this.isLoading = true;
            
            // If on the services step, POST to /services, otherwise PATCH additional-details
            if (this.propertyWizardStep === 3) {
                this.log('Saving services for step 3');
                
                try {
                    const res = await fetch('/partner/property/' + this.propertyId + '/services', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });
                    
                    let text = await res.text();
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        this.log('Non-JSON response from services POST: ' + text);
                        showToast('Server error (services save):\n' + text.substring(0, 500), 'error');
                        throw new Error('Non-JSON response from services POST');
                    }
                    
                    if (data && data.success) {
                        this.log('Moving from propertyWizardStep ' + this.propertyWizardStep + ' to ' + (this.propertyWizardStep + 1));
                        this.propertyWizardStep++;
                        this.logCurrentState();
                    } else {
                        this.log('Services save error: ' + data);
                        showToast('Error: ' + (data && data.message ? data.message : 'Could not save services.'), 'error');
                    }
                } catch (err) {
                    this.log('AJAX error in services save: ' + err);
                    showToast('AJAX error: ' + err.message, 'error');
                } finally {
                    this.isLoading = false;
                }
            } else {
                // For other steps, use PATCH additional-details
                try {
                    const res = await fetch('/partner/property/' + this.propertyId + '/additional-details', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(payload)
                    });
                    
                    const data = await res.json();
                    if (res.ok && data.success) {
                        this.log('Moving from propertyWizardStep ' + this.propertyWizardStep + ' to ' + (this.propertyWizardStep + 1));
                        this.propertyWizardStep++;
                        this.logCurrentState();
                    } else {
                        this.log('Additional details save error: ' + data);
                        showToast('Error: ' + (data.message || 'Could not save additional details.'), 'error');
                    }
                } catch (err) {
                    this.log('AJAX error in additional details save: ' + err);
                    showToast('AJAX error: ' + err.message, 'error');
                } finally {
                    this.isLoading = false;
                }
            }
        },

        async saveHouseRules() {
            this.log('Saving house rules');
            this.isLoading = true;
            
            if (!(await this.ensurePropertyId())) {
                this.isLoading = false;
                return;
            }
            
            try {
                console.log('Saving house rules with data:', {
                    smoking_allowed: this.smokingAllowed,
                    parties_allowed: this.partiesAllowed,
                    pets_allowed: this.petsAllowed,
                    check_in_from: this.checkInFrom,
                    check_in_until: this.checkInUntil,
                    check_out_from: this.checkOutFrom,
                    check_out_until: this.checkOutUntil
                });
                
                const response = await fetch(`/partner/property/${this.propertyId}/house-rules`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        smoking_allowed: this.smokingAllowed,
                        parties_allowed: this.partiesAllowed,
                        pets_allowed: this.petsAllowed,
                        check_in_from: this.checkInFrom,
                        check_in_until: this.checkInUntil,
                        check_out_from: this.checkOutFrom,
                        check_out_until: this.checkOutUntil
                    })
                });
                
                if (response.ok) {
                    const result = await response.json();
                    console.log('House rules saved successfully:', result);
                    showToast('House rules saved successfully!', 'success');
                    this.propertyWizardStep++;
                    this.saveWizardState();
                } else {
                    const errorData = await response.json();
                    console.error('Failed to save house rules:', errorData);
                    showToast('Failed to save house rules: ' + (errorData.message || 'Unknown error'), 'error');
                }
            } catch (error) {
                console.error('Error saving house rules:', error);
                showToast('Error saving house rules: ' + error.message, 'error');
            } finally {
                this.isLoading = false;
            }
        },

        async savePricing() {
            this.log('Saving pricing');
            console.log('Current pricingWizardStep before saving:', this.pricingWizardStep);
            this.isLoading = true;
            
            if (!(await this.ensurePropertyId())) {
                this.isUploading = false;
                return;
            }
            
            try {
                console.log('Saving pricing with data:', {
                    property_id: this.propertyId,
                    booking_type: this.pricing.booking_type,
                    price_per_night: this.pricing.price_per_night,
                    currency: this.pricing.currency,
                    discount_enabled: this.pricing.discount_enabled,
                    discount_percent: this.pricing.discount_percent
                });
                
                const response = await fetch(`/partner/property/${this.propertyId}/pricing`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        property_id: this.propertyId,
                        booking_type: this.pricing.booking_type,
                        price_per_night: this.pricing.price_per_night,
                        currency: this.pricing.currency,
                        discount_enabled: this.pricing.discount_enabled,
                        discount_percent: this.pricing.discount_percent
                    })
                });
                
                if (response.ok) {
                    const result = await response.json();
                    console.log('Pricing saved successfully:', result);
                    showToast('Pricing saved successfully!', 'success');
                    
                    console.log('Pricing saved successfully, current pricingWizardStep:', this.pricingWizardStep);
                    if (this.pricingWizardStep < 4) {
                        this.pricingWizardStep++;
                        console.log('Incremented pricingWizardStep to:', this.pricingWizardStep);
                    } else {
                        console.log('Moving to step 5 (legal info)');
                        this.step = 5; // Move to legal info
                        this.pricingWizardStep = 1; // Reset for next time
                    }
                    this.saveWizardState();
                } else {
                    const errorData = await response.json();
                    console.error('Failed to save pricing:', errorData);
                    showToast('Failed to save pricing: ' + (errorData.message || 'Unknown error'), 'error');
                }
            } catch (error) {
                console.error('Error saving pricing:', error);
                showToast('Error saving pricing: ' + error.message, 'error');
            } finally {
                this.isLoading = false;
            }
        },

               async saveLegalInfo() {
            this.log('Saving legal information');
            this.isLoading = true;
            try {
                if (!(await this.ensurePropertyId())) {
                    this.isLoading = false;
                    return;
                }
                // Prepare data based on ownership type
                let requestData = {
                    property_id: this.propertyId,
                    ownership_type: this.ownershipType // should be 'individual' or 'business_entity'
                };
        
                if (this.ownershipType === 'individual') {
                    // Basic client-side validation to avoid server 500
                    if (!this.individual?.firstName || !this.individual?.lastName || !this.individual?.dob) {
                        showToast('Please fill first name, last name and date of birth.', 'warning');
                        this.isLoading = false;
                        return;
                    }
                    requestData.individuals = [{
                        first_name: this.individual?.firstName || '',
                        last_name: this.individual?.lastName || '',
                        date_of_birth: this.individual?.dob || '',
                        alt_names: this.individual?.altNames || []
                    }];
                } else if (this.ownershipType === 'business') {
                    requestData.ownership_type = 'business_entity'; // match DTO
                    // Basic client-side validation
                    if (!this.business?.businessName || !this.business?.address || !this.business?.zipCode || !this.business?.city || !this.business?.country) {
                        showToast('Please fill all required business fields (name, address, zip, city, country).', 'warning');
                        this.isLoading = false;
                        return;
                    }
                    requestData.business_entity = {
                        business_name: this.business?.businessName || '',
                        trading_name: this.business?.tradingName || '',
                        address: this.business?.address || '',
                        zip_code: this.business?.zipCode || '',
                        city: this.business?.city || '',
                        country: this.business?.country || ''
                    };
                    // If you want to save business owners as individuals too:
                    requestData.individuals = (this.business?.owners || []).map(owner => ({
                        first_name: owner.firstName || '',
                        last_name: owner.lastName || '',
                        date_of_birth: owner.dob || '',
                        alt_names: owner.altNames || []
                    }));
                }
        
                console.log('Final request data being sent:', requestData);
        
                const response = await fetch(`/accommodation/save-verification/${this.propertyId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(requestData)
                });
        
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
        
                if (response.ok) {
                    const result = await response.json();
                    showToast('🎉 Congratulations! Your property has been successfully listed and is now live on our platform!', 'success');
                    setTimeout(() => {
                        const redirectUrl = '{{ route("partner.list-your-property") }}?registration=success';
                        window.location.href = redirectUrl;
                    }, 2000);
                } else {
                    let errorText = '';
                    try {
                        const errorData = await response.json();
                        errorText = errorData.message || JSON.stringify(errorData.errors || errorData);
                    } catch (e) {
                        errorText = await response.text();
                    }
                    showToast('Failed to save legal info: ' + (errorText || 'Unknown error'), 'error');
                }
            } catch (error) {
                showToast('Error saving legal info: ' + error.message, 'error');
            } finally {
                this.isLoading = false;
            }
        },

        logBusinessChange(field, value) {
            this.log('Business/Individual field changed: ' + field + ' = ' + value);
            console.log('Field changed:', field, 'Value:', value);
        },

        navigateToBedroom(roomId = null) {
            this.log('Navigating to room page for: ' + roomId);
            
            // Save current wizard state
            this.saveWizardState();
            
            // Debug: Log current rooms
            console.log('Current rooms before navigation:', this.rooms);
            console.log('Rooms count:', Object.keys(this.rooms).length);
            console.log('Bedroom keys:', Object.keys(this.rooms).filter(key => key.startsWith('bedroom')));
            
            // Prepare room data if editing
            let roomData = null;
            if (roomId) {
                const room = this.rooms[roomId];
                if (room) {
                    roomData = {
                        name: room.name,
                        twin: room.twin || 0,
                        full: room.full || 0,
                        queen: room.queen || 0,
                        king: room.king || 0,
                        bunk: room.bunk || 0,
                        sofa: room.sofa || 0,
                        futon: room.futon || 0
                    };
                }
            }
            
            // Calculate next bedroom number
            const bedroomKeys = Object.keys(this.rooms).filter(key => key.startsWith('bedroom'));
            const bedroomCount = bedroomKeys.length;
            const nextBedroomNumber = bedroomCount + 1;
            
            console.log('Bedroom calculation debug:');
            console.log('  - All room keys:', Object.keys(this.rooms));
            console.log('  - Bedroom keys:', bedroomKeys);
            console.log('  - Bedroom count:', bedroomCount);
            console.log('  - Next bedroom number:', nextBedroomNumber);
            
            // Prepare wizard state for room page
            const wizardState = {
                step: this.step,
                wizardStep: this.wizardStep,
                propertyWizardStep: this.propertyWizardStep,
                pricingWizardStep: this.pricingWizardStep,
                bedroomStep: this.bedroomStep,
                propertyId: this.propertyId,
                rooms: this.rooms, // Pass existing rooms to calculate next bedroom number
                nextBedroomNumber: nextBedroomNumber
            };
            
            console.log('Wizard state being passed:', wizardState);
            console.log('Next bedroom number:', nextBedroomNumber);
            
            // Build URL with parameters
            const propertyId = this.propertyId || 'new';
            let url = '';
            
            // Route to different pages based on room type
            if (roomId === 'livingRoom') {
                url = `/partner/apartment/livingroom/${propertyId}?source=single`;
            } else if (roomId === 'otherSpaces') {
                url = `/partner/apartment/otherspaces/${propertyId}?source=single`;
            } else {
                // Default to bedrooms page for bedroom1 and other bedrooms
                url = `/partner/apartment/bedrooms/${propertyId}?source=single`;
            }
            
            url += '&step=' + this.step;
            url += '&wizardState=' + encodeURIComponent(JSON.stringify(wizardState));
            
            if (roomData) {
                url += '&roomData=' + encodeURIComponent(JSON.stringify(roomData));
            }
            
            console.log('=== URL DEBUG ===');
            console.log('Room ID:', roomId);
            console.log('Property ID:', propertyId);
            console.log('Step:', this.step);
            console.log('Wizard State JSON:', JSON.stringify(wizardState));
            console.log('Encoded Wizard State:', encodeURIComponent(JSON.stringify(wizardState)));
            console.log('Final URL:', url);
            console.log('=== END URL DEBUG ===');
            
            this.log('Navigating to: ' + url);
            window.location.href = url;
        },

        async navigateToStep(stepNumber) {
            this.log('Navigating to step: ' + stepNumber);
            
            // Set the main step
            this.step = stepNumber;
            
            // Reset the appropriate wizard step based on which section we're going to
            switch (stepNumber) {
                case 1: // Basic information
                    this.wizardStep = 1;
                    break;
                case 2: // Property setup
                    this.propertyWizardStep = 1;
                    break;
                case 3: // Photos
                    // Photos don't have sub-steps, so no reset needed
                    break;
                case 4: // Pricing and calendar
                    this.pricingWizardStep = 1;
                    break;
                case 5: // Legal information
                    // Legal info doesn't have sub-steps, so no reset needed
                    break;
            }
            
            // Check completion status when navigating to basic info step
            if (stepNumber === 1 && this.propertyId !== 'new') {
                await this.checkBasicInfoCompletion();
            }
            
            // Save wizard state after setting the new step
            this.saveWizardState();
            
            this.log('Navigation complete - Step: ' + this.step + ', PropertyWizardStep: ' + this.propertyWizardStep);
        }
    }
}
</script>

</body>
@endsection
