<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>List Your Property</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

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
            <a href="/help" title="Help">
              <img src="{{ asset('assets/question.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
            </a>
            <button
              id="language-button"
              type="button"
              class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
              title="Change Language">
              <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
            </button>
          </div>
        </div>
      </div>
    </section>
  </header>

  <!-- Main Section -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <h2 class="text-xl sm:text-3xl font-bold text-left mb-2 mt-20">
      List your property on Bookintour.com and start welcoming guests in no time!
    </h2>
    <p class="text-left text-gray-600 text-lg mb-8">
      To get started, choose the type of property you want to list on Bookintour.com
    </p>

    <!-- Responsive Property Cards All in One Row (no scroll) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-12">

      <!-- Card 1 -->
      <div class="relative bg-white p-4 rounded-lg shadow border text-center flex flex-col items-center h-full justify-between">
        <!-- Badge at top-left corner -->
        <span class="absolute -top-2 bg-green-700 text-white text-xs px-2 py-1 rounded-lg font-semibold z-10 inline-flex items-center space-x-1">
          <img src="{{ asset('assets/mdi_playlist-tick.svg') }}" alt="Tick" class="w-4 h-4" />
          <span>Quick start</span>
        </span>

        <div class="flex flex-col flex-grow items-center space-y-4 mt-6">
          <img src="{{ asset('images/accomm_one_apt_main@2x.png') }}" alt="Apartment" class="w-12 h-12">
          <h2 class="text-base font-semibold">Apartment</h2>
          <p class="text-sm text-gray-600 text-center">Furnished and self-catering accommodation, where guests rent the entire place.</p>
        </div>

        <a href="{{ url('/partner/property_subcategory/2') }}" class="w-[70%] mt-4 mb-2">
          <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white px-4 py-2 rounded text-sm font-semibold w-full">
            List your property
          </button>
        </a>

      </div>

      <!-- Grouped Cards 2, 3, 4 without spacing -->

      <!-- Card 2 -->
      <div class="bg-white p-4 rounded-l-lg shadow border text-center flex flex-col w-full h-full justify-between">
        <div class="flex flex-col flex-grow items-center space-y-4 mt-6">
          <img src="{{ asset('images/accomm_single_home@2x (1).png') }}" alt="Apartment" class="w-12 h-12">
          <h2 class="text-base font-semibold">Homes</h2>
          <p class="text-sm text-gray-600 text-center">Properties like apartments, holiday homes, villas, etc.</p>
        </div>

        <a href="{{ url('/partner/property_subcategory/1') }}"
          class="mt-4 mb-2 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white px-4 py-2 rounded text-sm font-semibold mx-auto w-[70%] text-center block">
          List your property
        </a>

      </div>

      <!-- Card 3 -->
      <div class="bg-white p-4 rounded-none shadow border-t lg:border-l lg:border-t-0 text-center flex flex-col w-full h-full justify-between">
        <div class="flex flex-col flex-grow items-center space-y-4 mt-6">
          <img src="{{ asset('images/accomm_hotels_main_v2@2x.png') }}" alt="Apartment" class="w-12 h-12">
          <h2 class="text-base font-semibold">Hotel, B&Bs, and more</h2>
          <p class="text-sm text-gray-600 text-center">Properties like hotels, B&Bs, guest houses, hostels, aparthotels, etc.</p>
        </div>
        <button class="mt-4 mb-2 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white px-4 py-2 rounded text-sm font-semibold mx-auto w-[70%]">
          List your property
        </button>
      </div>

      <!-- Card 4 -->
      <div class="bg-white p-4 rounded-r-lg shadow border-t lg:border-l lg:border-t-0 text-center flex flex-col w-full h-full justify-between">
        <div class="flex flex-col flex-grow items-center space-y-4 mt-6">
          <img src="{{ asset('images/tent-big@2x.png') }}" alt="Apartment" class="w-12 h-12">
          <h2 class="text-base font-semibold">Alternative places</h2>
          <p class="text-sm text-gray-600 text-center">Properties like boats, campsites, luxury tents, etc.</p>
        </div>
        <button class="mt-4 mb-2 bg-[#3CC0E9] hover:bg-[#29ACD5] text-white px-4 py-2 rounded text-sm font-semibold mx-auto w-[70%]">
          List your property
        </button>
      </div>

    </div>

    </div>

  </main>

</body>

</html>