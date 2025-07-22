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
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <!-- Logo -->
                    <div class="w-full md:w-auto md:ml-6">
                        <!-- Logo -->
                        @php
                            $host = config('domains.app_name');

                        @endphp

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
    <div class="bg-[#3CC0E9] h-2 transition-all duration-500"
         :style="'width:' + (step * 100 / 8) + '%'"></div>
  </div>

  <!-- Step Content Wrapper -->
  <div x-data>

    <template x-if="step === 1">
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

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto font-sans">
                        <!-- Help Icon -->
                        <a href="/help" title="Help">
                            <img src="{{ asset('assets/question.svg') }}" alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                        </a>

                        <!-- Language Button -->
                        <button id="language-button" type="button"
                            class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
                            title="Change Language">
                            <img src="{{ asset('images/uk.png') }}" alt="UK Flag"
                                class="w-full h-full object-cover rounded-full" />
                        </button>

                        <!-- Language Modal -->
                        <div id="language-modal"
                            class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                                <!-- Modal Header -->
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                                    <button type="button"
                                        class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mt-4">
                                    <p class="mb-4 text-base text-gray-500">Suggested for you</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                            <img src="https://flagcdn.com/w40/gb.png" alt="English (UK)"
                                                class="h-5 w-5" />
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
           @click="step > 1 ? step-- : step"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>


  <!-- Continue Button (Right) -->
  <button   type="submit"
      @click="step < 8 ? step++ : step"
        :class="step === 8 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"

        :disabled="step === 8"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
    Continue
  </button>
</div>

                </form>
            </div>
        </section>
    </header>
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9] h-2 transition-all duration-500" :style="'width:' + (step * 100 / 8) + '%'"></div>
    </div>

    <!-- Step Content Wrapper -->
    <div x-data>

        <template x-if="step === 1">
            <div class="relative w-[1200px] h-auto overflow-hidden rounded-lg shadow mx-auto my-10 ">
                <!-- Google Maps iframe full background -->
                <iframe class="absolute inset-0 w-full h-full" loading="lazy"
                    src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed" allowfullscreen>
                </iframe>

                <!-- Optional overlay for readability -->
                <div class="absolute inset-0 "></div>

                <!-- Form content centered on map -->
                <div class="relative z-10 flex items-center justify-start h-auto p-4 mt-[110px]">
                    <div class="bg-white bg-opacity-95 rounded-lg shadow-lg w-full max-w-md p-6 md:p-8 h-auto mb-4">
                        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Where is your property?</h2>
                        <form action="#" method="POST">
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Find your
                                    address</label>
                                <input type="text" id="address" name="address" value="Sri Lanka"
                                    class="mt-1 p-2 w-full border border-gray-300 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment or
                                    floor number (optional)</label>
                                <input type="text" id="apartment" name="apartment" value="aaa"
                                    class="mt-1 p-2 w-full border border-gray-300 rounded">
                            </div>
                            <div class="mb-4">
                                <label for="country"
                                    class="block text-sm font-medium text-gray-700">Country/region</label>
                                <select id="country" name="country"
                                    class="mt-1 p-2 w-full border border-gray-300 rounded">
                                    <option selected>Sri Lanka</option>
                                </select>
                            </div>
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" id="city" name="city" value="a"
                                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                                </div>
                                <div class="flex-1">
                                    <label for="postcode" class="block text-sm font-medium text-gray-700">Post code /
                                        Zip code</label>
                                    <input type="text" id="postcode" name="postcode" value="80400"
                                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                                </div>
                            </div>
                            <div class="flex items-center mt-4">
                                <input id="update_address" type="checkbox" name="update_address" checked
                                    class="mr-2">
                                <label for="update_address" class="text-sm text-gray-700">Update the address when
                                    moving the pin on the map.</label>
                            </div>
                            <!-- Dismissible message box -->
                            <div x-data="{ showMessage: true }" x-show="showMessage"
                                class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Note:</strong>
                                <span class="block sm:inline">Make sure the pin location is accurate before
                                    continuing.</span>
                                <span @click="showMessage = false"
                                    class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">
                                    <svg class="fill-current h-6 w-6 text-yellow-800" role="button"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <title>Close</title>
                                        <path
                                            d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
                                    </svg>
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 mt-2">
                                Is the red pin location incorrect? Uncheck the option above and click or press on the
                                map to move the pin.
                            </p>
                            <div class="flex justify-between mt-6">
                                <!-- Back Button (Left) -->
                                <button type="button" @click="step > 1 ? step-- : step"
                                    :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                    class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                    ←
                                </button>


                                <!-- Continue Button (Right) -->
                                <button type="submit" @click="step < 8 ? step++ : step"
                                    :class="step === 8 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"
                                    :disabled="step === 8"
                                    class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
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




    <template x-if="step === 2">
        <div>
            <section class="mb-12" x-data="{ channelManager: 'yes' }">
                <div class="max-w-5xl mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold mb-4 mt-4">Connect to a channel manager</h1>

                    <!-- Question Section -->
                    <div class="bg-white p-4 max-w-2xl border border-gray-200 rounded mb-8">
                        <h2 class="text-lg font-semibold mb-2">
                            Do you want to connect this listing to your channel manager?
                        </h2>
                        <p class="text-gray-700 mb-6">
                            A channel manager is a third-party tool that lets you manage rates and availability across
                            different sites you might list your place on, including {{ config('domains.subdomain') }}. If you're already using
                            a channel manager, you can select 'Yes' to connect it to your listing.
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
                                            alt="Help" class="w-5 h-5 md:w-6 md:h-6 mt-1" />

                                        <!-- Text block -->
                                        <p>
                                            Select 'Yes' only if you are already using a channel manager.
                                            You'll be able to connect your channel manager after your registration is
                                            complete – please continue to the next step.
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

                            <button type="button" @click="step > 1 ? step-- : step"
                                :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                                class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                ←
                            </button>


                            <!-- Continue Button (Right) -->
                            <button type="submit" @click="step < 9 ? step++ : step"
                                :class="step === 9 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"
                                :disabled="step === 9"
                                class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
                                Continue
                            </button>
                        </div>
                    </div>
            </section>
        </div>
    </template>
    </div>

    <button type="button"    @click="step > 1 ? step-- : step"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
              class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
        ←
      </button>


  <!-- Continue Button (Right) -->
  <button type="submit"
          @click="step < 9 ? step++ : step"
        :class="step === 9 ? 'opacity-50 cursor-not-allowed' : 'bg-[#3CC0E9] hover:bg-sky-500'"

        :disabled="step === 9"
          class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
    Continue
  </button>
</div>
    </div>
    </section>

    </div>
    </template>

    <template x-if="step === 3">
        <div>
            <div class="max-w-2xl ml-40 px-4 py-8  bg-white  rounded shadow mt-10">
                <h1 class="text-2xl font-bold mb-6">Tell us about your hotel</h1>

                <!-- Hotel Name -->
                <div class="mb-6">
                    <label class="block font-medium text-gray-800 mb-1" for="hotelName">What's the name of your
                        hotel?</label>
                    <input type="text" id="hotelName" placeholder="Property name"
                        class="w-full border rounded px-4 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200" />
                    <p class="text-xs text-gray-500 mt-1">This name will be seen by guests when they search for a place
                        to stay.</p>
                </div>

                <hr class="my-6" />

                <!-- Star Rating -->
                <div class="mb-6">
                    <label class="block font-medium text-gray-800 mb-2">What is the star rating of your hotel?</label>
                    <div class="space-y-2 text-sm text-gray-700">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="stars" checked />
                            N/A
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="stars" />
                            1 star <span class="text-yellow-400">★</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="stars" />
                            2 stars <span class="text-yellow-400">★★</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="stars" />
                            3 stars <span class="text-yellow-400">★★★</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="stars" />
                            4 stars <span class="text-yellow-400">★★★★</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="stars" />
                            5 stars <span class="text-yellow-400">★★★★★</span>
                        </label>
                    </div>
                </div>

                <hr class="my-6" />

                <!-- Management Question -->
                <div class="mb-6">
                    <label class="block font-medium text-gray-800 mb-2">Are you a property management company or part
                        of a group or chain?</label>
                    <div class="space-y-2 text-sm text-gray-700">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="group" />
                            Yes
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="group" checked />
                            No
                        </label>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between items-center mt-8">
                    <button type="submit" @click="step < 9 ? step-- : step"
                        class="border border-[#3CC0E9]  text-blue-600  hover:bg-blue-50 font-semibold py-2 px-4 rounded">←</button>
                    <button type="submit" @click="step < 9 ? step++ : step"
                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">Continue</button>
                </div>
            </div>

        </div>
    </template>

    <template x-if="step === 4">
        <div class="max-w-4xl ml-40 px-4 py-8    mt-10">
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
              <span>Restaurant</span>
            </label>
             <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Apartment" class="text-blue-500" />
              <span>Room service</span>
            </label>
             <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Apartment" class="text-blue-500" />
              <span>Bar</span>
            </label>
             <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Apartment" class="text-blue-500" />
              <span>24-hour front desk</span>
            </label>
             <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Apartment" class="text-blue-500" />
              <span>Sauna</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Villa" class="text-blue-500" />
              <span>Fitness centre</span>
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
              <span>Non-smoking rooms</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Cabin" class="text-blue-500" />
              <span>Airport shuttle</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Bungalow" class="text-blue-500" />
              <span>Family rooms</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Farm Stay" class="text-blue-500" />
              <span>Spa and wellness centre</span>
            </label>
            <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Hot tub/Jacuzzi</span>
            </label>
              <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Free WiFi</span>
            </label>
              <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Air conditioning</span>
            </label>
              <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Water park</span>
            </label>
              <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Electric vehicle charging station</span>
            </label>
                 <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Swimming pool</span>
            </label>
              <label class="flex items-center space-x-2">
              <input type="checkbox" name="property_types[]" value="Houseboat" class="text-blue-500" />
              <span>Beach</span>
            </label>
          </div>
        </div>
    </template>

    <template x-if="step === 5">
        <div>
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
                        <button type="button" @click="step > 1 ? step-- : step"
                            :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                            class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                            ←
                        </button>
                        <button type="button" @click="step > 1 ? step++ : step"
                            class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template x-if="step === 6">
        <div>
            <div class="container ml-32 px-4 py-8 max-w-2xl">
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

                        <!-- Searchable dropdown container -->
                        <div class="relative w-full max-w-md">
                            <input type="text" id="languageInput" oninput="filterDropdown()"
                                onclick="toggleDropdown()" placeholder="Search languages..." autocomplete="off"
                                class="w-full border rounded p-2 pr-10 cursor-pointer" readonly />
                            <!-- Dropdown arrow -->
                            <button type="button" onclick="toggleDropdown()"
                                class="absolute right-2 top-2.5 text-gray-600 hover:text-gray-900 focus:outline-none"
                                tabindex="-1">
                                ▼
                            </button>

                            <!-- Dropdown list -->
                            <ul id="languageDropdown"
                                class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded max-h-40 overflow-auto shadow-lg hidden">
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Arabic
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">
                                    Bulgarian</li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">
                                    Catalan</li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">
                                    Chinese</li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">
                                    Croatian</li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Czech
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Danish
                                </li>
                                <li class="p-2 hover:bg-blue-100 cursor-pointer" onclick="selectLanguage(this)">Dutch
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Toggle Button for Additional Languages -->
                    <a href="#" onclick="event.preventDefault(); toggleAdditionalLanguages();"
                        class="text-blue-500 hover:underline mt-4 block">
                        Add additional languages
                    </a>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <!-- Back Button on the left -->
                    <button type="button" @click="step > 1 ? step-- : step"
                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                        class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                        ←
                    </button>

                    <!-- Continue Button on the right -->
                    <button type="button" @click="step > 1 ? step++ : step"
                        class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300">
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
                document.addEventListener("click", function(event) {
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
   type="button"  @click="step > 1 ? step-- : step"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"

      class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
      ←
  </button>

  <!-- Continue Button on the right -->
  <button
   type="button"  @click="step > 1 ? step++ : step"
     class="px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300"
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

    <template x-if="step === 7">
        <div>
            <div class="container ml-32 px-4 py-8 max-w-4xl">
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
                                    <div
                                        class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                    </div>
                                    <div
                                        class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center justify-between cursor-pointer">
                                <span>Children allowed</span>
                                <div class="relative">
                                    <input type="checkbox" class="sr-only peer" checked />
                                    <div
                                        class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                    </div>
                                    <div
                                        class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center justify-between cursor-pointer">
                                <span>Parties/events allowed</span>
                                <div class="relative">
                                    <input type="checkbox" class="sr-only peer" />
                                    <div
                                        class="w-8 h-4 bg-gray-300 rounded-full peer-focus:outline-none peer-checked:bg-blue-500 transition">
                                    </div>
                                    <div
                                        class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                    </div>
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
                    <div x-data="{ show: true }" x-show="show"
                        class="bg-white shadow-md rounded-lg p-6 w-full h-[300px] md:w-1/3 relative">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center space-x-2">
                                <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help"
                                    class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                                <h3 class="text-gray-800 font-semibold text-base">What if my house rules change?</h3>
                            </div>
                            <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-700 mt-3">
                            You can easily customise these house rules later and additional house rules can be set on
                            the Policies page of the extranet after you complete registration.
                        </p>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex ">
                    <button type="button" @click="step > 1 ? step-- : step"
                        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
                        class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
                        ←
                    </button>
                    <button type="button" @click="step > 1 ? step++ : step"
                        class="px-6 h-12 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[395px]">
                        Continue
                    </button>
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
        <button type="button" @click="step > 1 ? step-- : step"
        :class="step === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100'"
          class="border border-[#3CC0E9] text-blue-600  hover:bg-blue-50 font-semibold px-4 h-12 flex items-center justify-center rounded">
          ←
        </button>
        <button   type="button"  @click="step > 1 ? step++ : step"
          class="px-6 h-12 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 focus:outline-none focus:ring focus:ring-blue-300 ml-[395px]">
          Continue
        </button>
      </div>
    </div>
  </div>
    </template>

    <template x-if="step === 8">
        <div class="mt-16">
            <div class="max-w-3xl mx-auto p-4 space-y-4 ">

                <!-- Step 1 - Completed -->
                <div class="border border-gray-300 border rounded-lg p-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/flat-color-icons_ok.svg') }}" alt="Icon"
                            class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 1</p>
                            <h2 class="text-base font-semibold">Property details</h2>
                            <p class="text-xs text-gray-600">The basics, Add your property name, address, facilities
                                and more</p>
                        </div>
                    </div>
                    <a href="#" class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
                </div>

                <!-- Step 2 -->
                <div class="border border-gray-300  rounded-lg p-4 flex justify-between items-center ">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Group 3926.svg') }}" alt="Icon"
                            class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 2</p>
                            <h2 class="text-base font-semibold">Rooms</h2>
                            <p class="text-xs text-gray-600">Tell us about your first room. Once you’ve set one up you
                                can add more.</p>
                        </div>
                    </div>
                    <a href="{{ route('partner.hotels.rooms') }}"
                        class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                        Add room
                    </a>
                </div>

                <!-- Step 3 - Photos -->
                <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center ">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                            class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                        <div>
                            <p class="text-sm text-gray-500">Step 3</p>
                            <h2 class="text-base font-semibold">Photos</h2>
                            <p class="text-xs text-gray-600">Share some photos of your property so guests know what to
                                expect.</p>
                        </div>
                    </div>
                    <a href="{{ route('partner.hotels.photos') }}"
                        class="border border-sky-400 text-sky-400 text-sm font-semibold px-4 py-2 rounded hover:bg-sky-50">
                        Add Photos
                    </a>

                </div>

                <!-- Step 4 - Final -->
                <div class=" border border-gray-300 rounded-lg p-4 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                            class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                        <div>
                            <p class="text-sm text-gray-500">Step 4</p>
                            <h2 class="text-base font-semibold">Final steps</h2>
                            <p class="text-xs text-gray-600">Set up payments and invoicing before you open for
                                bookings.</p>
                        </div>
                    </div>
                    <a href="{{ route('partner.hotels.payments') }}"
                        class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                        Add final details
                    </a>
                </div>

            </div>
        </div>
    </template>


    <template x-if="step === 9">
        <div>
            <h2 class="text-xl font-bold mb-4">Step 9: Review & Submit</h2>
            <p class="text-sm text-gray-600 mb-4">Review your details before submission.</p>
            <button
                class="mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-semibold">Submit</button>
        </div>
    </template>


  </div>
    </div>

</body>

</html>
