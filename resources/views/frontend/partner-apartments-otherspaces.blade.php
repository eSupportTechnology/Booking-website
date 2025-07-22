
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
<div x-data="{ showMoreBeds: false }" class="max-w-2xl mx-auto space-y-8 lg:ml-32 px-4 py-6">
  <h2 class="text-3xl font-bold text-gray-900 mt-8">Other spaces</h2>

  <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
    <p class="text-lg font-medium text-gray-800 mb-4">Which beds are available in this room?</p>

    <!-- Main Bed Options -->
  <div class="space-y-4">
  @foreach([
      ['label' => 'Single bed', 'size' => '90 - 130 cm wide', 'icon' => 'mdi_bed-single (1)'],
      ['label' => 'Double bed', 'size' => '131 - 150 cm wide', 'icon' => 'famicons_bed'],
      ['label' => 'Large bed (King size)', 'size' => '151 - 180 cm wide', 'icon' => 'famicons_bed'],
      ['label' => 'Extra-large double bed (Super-king size)', 'size' => '181 - 210 cm wide', 'icon' => 'famicons_bed'],
  ] as $index => $bed)
    <div x-data="{ count: 0 }" class="flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <!-- Icon container to align all icons horizontally -->
        <div class="w-12 h-12 flex items-center justify-center">
          <img 
            src="{{ asset('assets/' . $bed['icon'] . '.svg') }}" 
            alt="Bed Icon"
            class="{{ $bed['label'] === 'Single bed' ? 'w-9 h-9 md:w-9 md:h-9' : 'w-6 h-6 md:w-7 md:h-7' }}"
          />
        </div>

        <div>
          
            <p class="font-medium text-gray-800">{{ $bed['label'] }}</p>
            <p class="text-sm text-gray-500">{{ $bed['size'] }}</p>
          </div>
        </div>

        <!-- Quantity selector -->
        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
          <button
            type="button"
            @click="if (count > 0) count--"
            class="w-10 h-10 text-xl text-gray-600 hover:bg-gray-100"
          >−</button>
          <span class="w-10 text-center text-gray-900 font-medium" x-text="count"></span>
          <button
            type="button"
            @click="count++"
            class="w-10 h-10 text-xl text-gray-600 hover:bg-gray-100"
          >+</button>
        </div>
      </div>
     @endforeach
    </div>

    <!-- Toggle button -->
    <div class="mt-4">
      <button @click="showMoreBeds = !showMoreBeds"
              class="text-blue-600 text-sm font-medium hover:underline focus:outline-none">
        <span x-show="!showMoreBeds">More bed options</span>
        <span x-show="showMoreBeds">Hide extra options</span>
      </button>
    </div>

    <!-- More Bed Options -->
    <div x-show="showMoreBeds" x-transition class="space-y-4 mt-4">
     @foreach([
        ['label' => 'Bunk bed', 'size' => 'Width varies', 'icon' => 'mdi_bunk-bed'],
        ['label' => 'Sofa bed', 'size' => 'Typically 90 cm wide', 'icon' => 'mdi_sofa'],
        ['label' => 'Futon bed', 'size' => 'Varies by style', 'icon' => 'famicons_bed'],
     ] as $index => $bed)
      <div x-data="{ count: 0 }" class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
           <div class="w-12 h-12 flex items-center justify-center">
           <img src="{{ asset('assets/' . $bed['icon'] . '.svg') }}" alt="Bed Icon" class="w-6 h-6 md:w-7 md:h-7" />
        </div>

          <div>
            <p class="font-medium text-gray-800">{{ $bed['label'] }}</p>
            <p class="text-sm text-gray-500">{{ $bed['size'] }}</p>
          </div>
        </div>

        <!-- Quantity selector -->
        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
          <button
            type="button"
            @click="if (count > 0) count--"
            class="w-10 h-10 text-xl text-gray-600 hover:bg-gray-100"
          >−</button>
          <span class="w-10 text-center text-gray-900 font-medium" x-text="count"></span>
          <button
            type="button"
            @click="count++"
            class="w-10 h-10 text-xl text-gray-600 hover:bg-gray-100"
          >+</button>
        </div>
      </div>
     @endforeach
    </div>
  </div>

  <!-- Action buttons -->
  <div class="flex justify-between pt-4">
    <button class="border border-[#3CC0E9] text-blue-600 font-medium px-6 py-2 rounded hover:bg-gray-50">
       ←
    </button>
    <button class="bg-[#3CC0E9] text-white font-semibold px-8 py-2 rounded  hover:bg-blue-700">
      Save
    </button>
  </div>
</div>










    </body>
    </html>