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
<div class="max-w-7xl mx-auto px-4">
    <div class="lg:flex lg:space-x-8">
        <!-- Heading aligned with left column -->
        <div class="w-full max-w-xl">
            <h2 class="text-3xl font-bold text-gray-900 mt-8 mb-6">  Cancellation policies</h2>
        </div>
    </div>

    <div x-data="{ selectedDay: '1', showTip: true, isOn: true }" class="lg:flex lg:space-x-8">
        <!-- Left Side -->
        <div class="max-w-xl w-full space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
                <!-- Question -->
                <p class="text-base">
                    How many days before their arrival can your guests 
                    <span class="font-semibold text-black">cancel their booking for free?</span>
                </p>

                <!-- Button Group -->
                <div class="flex flex-wrap gap-3 items-start relative">
                    <template x-for="option in ['1', '5', '14', '30']" :key="option">
                        <div class="relative">
                            <!-- Badge for 1 day -->
                            <template x-if="option === '1'">
                                <span
                                    class="absolute -top-2 left-1/2 -translate-x-1/2 bg-green-600 text-white text-[10px] px-1 py-0.5 rounded tracking-wide"
                                >
                                    Recommended
                                </span>
                            </template>

                            <button
                                @click="selectedDay = option"
                                :class="selectedDay === option 
                                    ? 'border-blue-500 bg-blue-50 text-blue-800' 
                                    : 'bg-white border border-gray-300 text-gray-800'"
                                class="px-3 py-1 rounded-full text-sm font-medium mt-3 focus:outline-none transition"
                            >
                                <span x-text="option + ' day' + (option === '1' ? '' : 's')"></span>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Alert Message -->
                <div>
                    <template x-if="selectedDay === '1'">
                        <div class="text-sm text-gray-700 border-l-4 border-blue-500 bg-blue-50 p-4">
                            <p>
                                Guests love flexibility – free cancellation rates are generally the most booked rates on our site. 
                                Get your first booking sooner by allowing guests to cancel up to five days before check-in.
                            </p>
                        </div>
                    </template>

                    <template x-if="selectedDay !== '1'">
                        <div class="space-y-4">
                            <div class="bg-orange-50 border-l-4 border-orange-400 text-orange-800 text-sm p-4">
                                <p>
                                    Allow guests to cancel up to 
                                 1 day before arrival to increase your chances of getting bookings.
                                </p>
                            </div>

                            <div class="text-sm text-gray-700 border-l-4 border-blue-500 bg-blue-50 p-4">
                                <p>
                                    Guests love flexibility – free cancellation rates are generally the most booked rates on our site. 
                                    Get your first booking sooner by allowing guests to cancel up to five days before check-in.
                                </p>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Toggle Section -->
                <div class="pt-4">
                    <p class="font-semibold text-base text-gray-800 mb-2">Protection against accidental bookings</p>

                    <div class="flex items-center gap-2">
                        <button 
                            @click="isOn = !isOn"
                            :class="isOn ? 'bg-blue-600' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none"
                            role="switch"
                            :aria-checked="isOn"
                        >
                            <span 
                                :class="isOn ? 'translate-x-6' : 'translate-x-1'" 
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                            ></span>
                        </button>
                        <span class="text-sm text-gray-600">On</span>
                    </div>

                    <p class="text-sm text-gray-500 mt-2">
                        To avoid you having to spend time handling accidental bookings, we automatically waive cancellation fees 
                        for guests that cancel within the first 24 hours of making a booking.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4">
                <button type="button" @click="step--"
                        class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-100 font-semibold py-2 px-4 rounded">
                    ←
                </button>
                <button type="button" @click="step = step + 1"
                        class=" font-semibold py-3 px-8 rounded  bg-[#3CC0E9] hover:bg-[#29ACD5] text-white"> 
                    Save
                </button>
            </div>
        </div>

        <!-- Right Side Tip Box -->
        <template x-if="showTip">
            <div class="w-full max-w-xs mt-8 lg:mt-0">
                <div class="bg-white rounded-lg shadow-md p-4 relative">
                    <!-- Close Button -->
                    <button @click="showTip = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-sm">
                        ✕
                    </button>

                    <div class="flex flex-col space-y-2">
                        <!-- Row with icon and heading -->
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/system-uicons_lightbulb-on.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7" />
                            <h3 class="font-semibold text-sm text-gray-800">What policy should I choose?</h3>
                        </div>

                        <p class="text-sm text-gray-600">
                            Any policy you select now can be easily updated after you complete registration.
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

</body>
</html>