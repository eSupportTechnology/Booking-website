<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Next Trip</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex flex-col">

  <!-- Header -->
  <header class="bg-[#1F8FB2] text-white py-6">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6 md:gap-0">
      <!-- Left Section -->
      <div class="w-full md:w-auto">
        <div class="flex flex-col items-start">
          @php $host = config('domains.app_name'); @endphp
          <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
            @if ($host == 'BookinTour')
              <h1>Bookintour.com</h1>
            @elseif ($host == 'Inselor')
              <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto align-middle" />
            @endif
          </a>

          @php $currentRoute = request()->route()->getName(); @endphp

          <!-- Navigation -->
          <nav class="flex flex-wrap gap-4 text-sm md:text-base mt-6">
            <a href="{{ route('stays') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
              <span>Stays</span>
            </a>

            <a href="{{ route('car.rentals') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
              <span>Car rentals</span>
            </a>

            <a href="{{ route('airport.taxis') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'airport.taxis' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/taxi.svg') }}" alt="Taxi" class="w-4 h-4" />
              <span>Airport taxis</span>
            </a>

            <a href="{{ route('airport.tours') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'airport.tours' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/tour.svg') }}" alt="Tour" class="w-4 h-4" />
              <span>Tour packages</span>
            </a>
          </nav>
        </div>
      </div>

      <!-- Right Section -->
      <div class="flex items-center gap-4 sm:gap-5 flex-wrap justify-center md:justify-end">
        <span class="text-base sm:text-lg">LKR</span>
        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden">
          <img src="https://flagcdn.com/gb.svg" alt="UK Flag" class="w-full h-full object-cover" />
        </div>
        <div>
          <a href="#" class="flex items-center justify-center w-7 h-7 bg-[#1F8FB2] rounded-full hover:bg-[#29ACD5] text-white border border-white text-sm font-semibold" title="Help">?</a>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
          <div class="bg-yellow-400 text-black rounded-full w-7 h-7 sm:w-9 sm:h-9 flex items-center justify-center text-sm sm:text-base font-semibold">D</div>
          <div>
            <p class="font-semibold leading-none text-sm sm:text-base">Dinidu Dananjaya</p>
            <p class="text-xs sm:text-sm text-yellow-300">Genius Level 1</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main -->
  <main class="flex-grow py-10 md:py-20">
    <div class="max-w-7xl mx-auto px-4 space-y-6">
      <h1 class="text-2xl md:text-3xl font-bold text-gray-800 text-left">My Next Trip</h1>

      <div class="flex justify-center">
        <img src="{{ asset('images/next-trip-illustration.png') }}" alt="Trip Illustration" class="w-60 md:w-80">
      </div>

      <div class="space-y-2 max-w-xl mx-auto text-gray-700">
        <p class="text-2xl font-bold text-left md:text-center">
          Here are 3 simple steps to get you started:
        </p>

        <ol class="list-decimal list-inside text-left md:text-center">
          <li>Search for a place to stay</li>
          <li>Tap the heart icon when you find a property you like</li>
          <li>You’ll find everything you’ve saved here</li>
        </ol>
      </div>

      <div class="text-center">
        <a href="#" class="inline-block mt-4 bg-sky-500 text-white px-6 py-2 rounded hover:bg-sky-600 transition">
          Start Searching
        </a>
      </div>


      <!-- Tag Cloud -->
      <div class="text-sm text-gray-600 mt-8 leading-relaxed text-left">
        Countries · Regions · Cities · Districts · Airports · Hotels · Places of interest · Holiday Homes · Apartments · Resorts · Villas · Hostels · B&Bs · Guest Houses · Unique places to stay · All destinations · All flight destinations · All car hire locations · All holiday destinations · Guides · Discover · Reviews · Discover monthly stays
      </div>
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
