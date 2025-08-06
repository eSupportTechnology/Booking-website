<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reviews</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 font-sans min-h-screen flex flex-col">

  <!-- Header -->
  <!-- Header -->
  <header class="bg-[#1F8FB2] text-white py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 flex flex-col md:flex-row justify-between items-center">
      <!-- Left side -->
      <div class="flex flex-col mb-4 md:mb-0 text-center md:text-left">
        <div class="text-2xl font-bold mb-1">Bookintour.com</div>
        <div class="text-sm text-cyan-200">
          <a href="#" class="text-blue-300 hover:underline">My Account</a> &gt; Reviews
        </div>
      </div>

      <!-- Right side -->
      <div class="flex items-center gap-4 sm:gap-5 flex-wrap justify-center md:justify-end">
        <span class="text-base sm:text-lg">LKR</span>
        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden">
          <img src="https://flagcdn.com/gb.svg" alt="UK Flag" class="w-full h-full object-cover" />
        </div>
        <a
          href="#"
          class="flex items-center justify-center w-7 h-7 bg-[#1F8FB2] rounded-full hover:bg-[#29ACD5] text-white border border-white text-sm font-semibold"
          title="Help"
        >?</a>
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
          <div class="bg-yellow-400 text-black rounded-full w-7 h-7 sm:w-9 sm:h-9 flex items-center justify-center text-sm sm:text-base font-semibold">
            D
          </div>
          <div>
            <p class="font-semibold leading-none text-sm sm:text-base">Dinidu Dananjaya</p>
            <p class="text-xs sm:text-sm text-yellow-300">Genius Level 1</p>
          </div>
        </div>
      </div>
    </div>
  </header>


  <!-- Main Content -->
  <main class="flex-grow">
    <section
      class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-20 py-10 flex flex-col lg:flex-row gap-6"
    >
      <div
        class="flex-1 space-y-4 border rounded-md overflow-hidden divide-y divide-gray-200"
      >
        <div class="flex items-center gap-4 p-4">
          <div
            class="bg-yellow-400 text-black rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg"
          >
            D
          </div>
          <div>
            <p class="font-semibold text-lg">Dinidu Dananjaya</p>
            <a href="#" class="text-blue-600 text-sm hover:underline">Edit your profile</a>
          </div>
        </div>
        <div class="flex justify-between p-4">
          <span>All reviews</span>
          <span>0</span>
        </div>
        <div class="flex justify-between p-4">
          <span>Property reviews</span>
          <span>0</span>
        </div>
      </div>

      <div
        class="flex-1 flex flex-col justify-center items-center pt-6 lg:pt-0 lg:pl-6 text-center text-gray-500"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="mx-auto w-12 h-12 text-gray-400"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M9 5h6m2 0a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h2"
          />
        </svg>
        <p class="mt-2">You don't have any pending reviews.</p>
      </div>
    </section>

    <div class="text-sm text-gray-600 mt-8 leading-relaxed px-4 sm:px-6 lg:px-20">
      <div class="max-w-6xl mx-auto text-left">
        Countries · Regions · Cities · Districts · Airports · Hotels · Places of interest · Holiday Homes · Apartments · Resorts · Villas · Hostels · B&Bs · Guest Houses · Unique places to stay · All destinations · All flight destinations · All car hire locations · All holiday destinations · Guides · Discover · Reviews · Discover monthly stays
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gray-100 pt-8 pb-4 text-sm text-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
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
            <img src="https://flagcdn.com/gb.svg" alt="Flag" class="w-full h-full object-cover" />
          </div>
          <span class="font-black text-sm text-gray-800">LKR</span>
        </div>

        <hr class="border-t border-gray-300 my-3 w-full mx-auto" />

        <div class="text-center text-xs text-gray-500">
          <p class="leading-snug">
            All Rights Reserved. © 2025 eSupport.com &nbsp;&nbsp; Powered by eSupport ©
          </p>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
