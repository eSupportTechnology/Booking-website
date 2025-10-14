<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<!-- HEADER -->
<header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">

        <!-- Left Section -->
        <div class="w-full md:w-auto">
          <div class="flex flex-col items-start space-y-2">
            @php $host = config('domains.app_name'); @endphp

            <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
              @if ($host == 'BookinTour')
                <h1>Bookintour.com</h1>
              @elseif ($host == 'Inselor')
                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto align-middle" />
              @endif
            </a>

            <!-- Green Box Message -->
            <div id="promo-box" class="bg-green-500 text-white px-4 py-2 rounded flex items-start justify-between w-full max-w-sm">
              <span class="text-sm">We offer special discounts this season!</span>
              <button onclick="document.getElementById('promo-box').classList.add('hidden')" class="ml-4 text-white hover:text-gray-200 font-bold">&times;</button>
            </div>
          </div>
        </div>

        <!-- Right Section -->
        <div class="flex flex-wrap md:flex-nowrap items-center gap-2 md:gap-4 w-full md:w-auto justify-center md:justify-end">
          
          @if (session('partner_name'))
            <span class="bg-white text-[#1F8FB2] px-3 py-2 rounded font-bold text-sm sm:text-base">{{ session('partner_name') }}</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="bg-[#1F8FB2] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white text-sm sm:text-base">Logout</a>
            <form id="logout-form" action="{{ route('partner.logout') }}" method="POST" class="hidden">@csrf</form>

          @elseif(Auth::check())
            <span class="bg-white text-[#1F8FB2] px-3 py-2 rounded font-bold text-sm sm:text-base">{{ Auth::user()->name }}</span>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="bg-[#1F8FB2] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white text-sm sm:text-base">Logout</a>
            <form id="logout-form" action="{{ route('partner.logout') }}" method="POST" class="hidden">@csrf</form>

          @else
            <a href="#" class="hover:underline text-sm sm:text-base">Already a partner?</a>
            <a href="#" class="bg-[#1F8FB2] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white text-sm sm:text-base">Sign in</a>
          @endif

          <a href="#" class="bg-[#3CC0E9] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans text-sm sm:text-base">Help</a>
        </div>

      </div>
    </div>
  </section>
</header>
