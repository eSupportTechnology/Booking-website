<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Bookings & Trips</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex flex-col justify-between">

  <!-- Header -->
  <header class="bg-[#1F8FB2] text-white py-6">
    <div
      class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4 md:gap-0"
    >
      <!-- Left side -->
      <div class="text-2xl font-bold">Bookintour.com</div>

      <!-- Right side -->
      <div
        class="flex flex-wrap justify-center md:justify-end items-center gap-3 sm:gap-5"
      >
        <span class="text-base sm:text-lg">LKR</span>
        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden">
          <img
            src="https://flagcdn.com/gb.svg"
            alt="UK Flag"
            class="w-full h-full object-cover"
          />
        </div>
        <a
          href="#"
          class="flex items-center justify-center w-7 h-7 bg-[#1F8FB2] rounded-full hover:bg-[#29ACD5] text-white border border-white text-sm font-semibold"
          title="Help"
          >?</a
        >
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
          <div
            class="bg-yellow-400 text-black rounded-full w-7 h-7 sm:w-9 sm:h-9 flex items-center justify-center text-sm sm:text-base font-semibold"
          >
            D
          </div>
          <div>
            <p class="font-semibold leading-none text-sm sm:text-base">
              Dinidu Dananjaya
            </p>
            <p class="text-xs sm:text-sm text-yellow-300">Genius Level 1</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="px-4 py-10 max-w-7xl mx-auto space-y-12">
    <!-- Bookings Section -->
    <div class="space-y-6">
      <!-- Header row: Bookings & Trips on left, Can’t find a booking? on right -->
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0">
        <h2 class="text-2xl font-semibold">Bookings & Trips</h2>
        <p
          class="text-sm text-blue-600 cursor-pointer hover:underline whitespace-nowrap"
        >
          Can’t find a booking?
        </p>
      </div>

      <!-- Content below -->
      <div class="flex flex-col md:flex-row flex-wrap items-start md:space-x-10 gap-6 md:gap-0">
        <!-- Image and buttons stacked vertically and centered -->
        <div class="flex flex-col items-center">
          <img
            src="https://cdn-icons-png.flaticon.com/512/3043/3043731.png"
            class="w-40 md:w-52 max-w-full"
            alt="Globe Icon"
          />
          <div class="mt-4 flex space-x-4">
            <button
              class="px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm"
            >
              Past
            </button>
            <button
              class="px-4 py-1 bg-gray-100 text-gray-600 rounded-full text-sm"
            >
              Cancelled
            </button>
          </div>
        </div>

        <!-- Text block next to image/buttons -->
        <div class="mt-0 md:mt-20 flex-1 pl-0 md:pl-8">
          <h3 class="text-lg font-semibold">Where to next?</h3>
          <p class="text-gray-600 mt-1">
            You haven’t started any trips yet. Once you make a booking, it’ll appear here.
          </p>
        </div>

      </div>

      <!-- Revisit Section -->
      <div
        class="flex flex-col md:flex-row flex-wrap items-center md:items-start md:space-x-20 gap-6 md:gap-0"
      >
        <img
          src="https://cdn-icons-png.flaticon.com/512/2942/2942889.png"
          class="w-40 md:w-52 max-w-full"
          alt="Map Icon"
        />
        <div class="mt-0 md:mt-20 flex-1">
          <h3 class="text-lg font-semibold">Revisit your favorite places</h3>
          <p class="text-gray-600">
            Here you'll find all your past trips and inspiration for your next
            ones.
          </p>
        </div>
      </div>
    </div>

    <!-- Tag Cloud -->
    <div class="text-sm text-gray-600 mt-8 leading-relaxed">
      Countries · Regions · Cities · Districts · Airports · Hotels · Places of
      interest · Holiday Homes · Apartments · Resorts · Villas · Hostels · B&Bs
      · Guest Houses · Unique places to stay · All destinations · All flight
      destinations · All car hire locations · All holiday destinations · Guides
      · Discover · Reviews · Discover monthly stays
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 pt-8 pb-4 text-sm text-gray-700">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
        <!-- Footer Columns -->
        <div>
          <p class="font-semibold mb-2">Support</p>
          <ul class="space-y-1">
            <li>Coronavirus (COVID-19) FAQs</li>
            <li>Manage your trips</li>
            <li>Contact Customer Service</li>
            <li>Safety resource centre</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Discover</p>
          <ul class="space-y-1">
            <li>Genius loyalty programme</li>
            <li>Seasonal and holiday deals</li>
            <li>Travel articles</li>
            <li>eSupport.com for Business</li>
            <li>Traveller Review Awards</li>
            <li>Car hire</li>
            <li>Flight finder</li>
            <li>Restaurant reservations</li>
            <li>eSupport.com for Travel Agents</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Terms and settings</p>
          <ul class="space-y-1">
            <li>Privacy & cookies</li>
            <li>Terms and conditions</li>
            <li>Partner dispute</li>
            <li>Modern Slavery Statement</li>
            <li>Human Rights Statement</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Partners</p>
          <ul class="space-y-1">
            <li>Extranet login</li>
            <li>Partner help</li>
            <li>List your property</li>
            <li>Become an affiliate</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">About</p>
          <ul class="space-y-1">
            <li>About eSupport.com</li>
            <li>How we work</li>
            <li>Sustainability</li>
            <li>Press centre</li>
            <li>Careers</li>
            <li>Investor relations</li>
            <li>Corporate contact</li>
          </ul>
        </div>
      </div>

      <div class="mt-20">
        <div class="flex items-center space-x-4 mb-2">
          <div class="w-4 h-4 rounded-full overflow-hidden -ml-0">
            <img
              src="https://flagcdn.com/gb.svg"
              alt="Flag"
              class="w-full h-full object-cover"
            />
          </div>
          <span class="font-black text-sm text-gray-800">LKR</span>
        </div>

        <hr class="border-t border-gray-300 my-3 w-full mx-auto" />

        <div class="text-center text-xs text-gray-500">
          <p class="leading-snug">
            All Rights Reserved. © 2025 eSupport.com &nbsp;&nbsp; Powered by eSupport
            ©
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
