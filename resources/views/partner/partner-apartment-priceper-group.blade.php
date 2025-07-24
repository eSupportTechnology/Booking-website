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

<div x-data="{ enabled: true }" class="max-w-xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
       <h1 class="text-2xl font-bold text-gray-800 mb-4">Price per group size</h1>
  <!-- Header -->
  <div class="bg-white p-6 rounded-lg shadow-md">
  

    <p class="text-sm text-gray-700 mb-1">
      Offering lower rates for groups of less than 2 makes your property more attractive to potential guests.
    </p>
    <p class="text-sm text-gray-700 mb-4">
      The recommended discounts are based on data from properties like yours. These can be updated at any time.
    </p>

    <!-- Toggle -->
    <div class="flex items-center gap-2 mb-4">
      <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" x-model="enabled" class="sr-only peer">
        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
      </label>
      <span class="text-sm text-gray-700 font-medium">Enabled</span>
    </div>

    <!-- Table -->
    <div x-show="enabled" x-transition class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-700 border">
        <thead class="bg-white text-gray-900  text-sm font-semibold">
          <tr>
            <th class="px-4 py-2">Occupancy</th>
            <th class="px-4 py-2">Discount</th>
            <th class="px-4 py-2">Guests pay</th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white border-t">
            <td class="px-4 py-2">2 guests</td>
            <td class="px-4 py-2">0%</td>
            <td class="px-4 py-2">US$ 120.00</td>
          </tr>
          <tr class="bg-white border-t">
            <td class="px-4 py-2">1 guest</td>
            <td class="px-4 py-2">
              <input type="number" value="10" class="w-16 border rounded px-2 py-1 text-center" /> %
            </td>
            <td class="px-4 py-2">US$ 108.00</td>
          </tr>
        </tbody>
      </table>
    </div>

   
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
      class="px-12 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 mb-16">
      Save
    </button>
  </div>

</div>
</body>
</html>