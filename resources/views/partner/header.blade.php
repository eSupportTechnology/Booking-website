<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- HEADER -->
<header class="text-white px-4 py-2 w-full" style="background-color:#1F8FB2;">
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Flex container -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 md:gap-0 w-full">

        <!-- Left Section -->
        <div class="w-full md:w-auto flex flex-col items-start gap-3">
          @php
          $host = config('domains.app_name');
          @endphp

          <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center flex-wrap text-center md:text-left">
            @if ($host == 'BookinTour')
            <h1 style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
            @elseif ($host == 'Inselor')
            <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-10 sm:h-12 w-auto align-middle" />
            @endif
          </a>

          <!-- Green Box Message -->
          <div id="promo-box"
            class="bg-green-500 text-white px-4 py-2 rounded flex items-start justify-between w-full sm:max-w-sm text-sm sm:text-base">
            <span>We offer special discounts this season!</span>
            <button onclick="document.getElementById('promo-box').classList.add('hidden')"
              class="ml-3 sm:ml-4 text-white hover:text-gray-200 font-bold text-lg leading-none">&times;</button>
          </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center justify-center md:justify-end flex-wrap gap-3 md:gap-4 w-full md:w-auto">
          <!-- Language Button -->
         

          <!-- Language Modal -->
          <div id="language-modal"
            class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-center justify-center px-4 py-8 bg-black bg-opacity-50">
            <div
              class="relative w-full max-w-sm sm:max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800 max-h-[90vh] overflow-y-auto">
              <div class="flex items-start justify-between">
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Select your language</h3>
                <button type="button"
                  class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto dark:hover:bg-gray-600 dark:hover:text-white">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>

              <div class="mt-4">
                <p class="mb-4 text-sm sm:text-base text-gray-500 dark:text-gray-400">Suggested for you</p>
                <div class="grid grid-cols-2 sm:grid-cols-2 gap-4">
                  @foreach (config('languages') as $code => $lang)
                  <a href="{{ route('lang.change', ['lang' => $code]) }}">
                    <button
                      class="flex items-center justify-between w-full p-2 text-sm sm:text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                      <img src="{{ asset($lang['flag']) }}" alt="{{ $lang['name'] }}" class="h-5 w-5" />
                      <span>{{ $lang['name'] }}</span>
                    </button>
                  </a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <!-- Auth Section -->
          @if (session('partner_name'))
          <span class="bg-white text-[#1F8FB2] px-3 py-2 rounded font-bold text-sm sm:text-base"
            style="font-family: 'Noto Sans', sans-serif;">
            <a href="{{ route('partner.dashboard') }}">{{ session('partner_name') }}</a>
          </span>
          <a href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="bg-[#1F8FB2] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white text-sm sm:text-base">
            Logout
          </a>
          <form id="logout-form" action="{{ route('partner.logout') }}" method="POST" class="hidden">@csrf</form>

          @elseif(Auth::check())
          <span class="bg-white text-[#1F8FB2] px-3 py-2 rounded font-bold text-sm sm:text-base"
            style="font-family: 'Noto Sans', sans-serif;">
            <a href="{{ route('partner.dashboard') }}">{{ Auth::user()->name }}</a>
          </span>
          <a href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="bg-[#1F8FB2] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white text-sm sm:text-base">
            Logout
          </a>
          <form id="logout-form" action="{{ route('partner.logout') }}" method="POST" class="hidden">@csrf</form>

          @else
          <div class="flex flex-wrap justify-center md:justify-end gap-2">
            <a href="#" class="hover:underline text-sm sm:text-base"
              style="font-family: 'Noto Sans', sans-serif;">Already a partner?</a>
            <a href="/choose-option"
              class="bg-[#1F8FB2] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white text-sm sm:text-base">
              Sign in
            </a>
          </div>
          @endif

          <a href="#"
            class="bg-[#3CC0E9] px-3 py-2 rounded hover:bg-[#29ACD5] text-white font-sans text-sm sm:text-base">
            Help
          </a>
        </div>
      </div>
    </div>
  </section>
</header>

<script>
  const langBtn = document.getElementById("language-button");
  const modal = document.getElementById("language-modal");
  const closeBtn = modal.querySelector(".close-btn");

  langBtn.addEventListener("click", () => modal.classList.remove("hidden"));
  closeBtn.addEventListener("click", () => modal.classList.add("hidden"));
  modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.classList.add("hidden");
  });
</script>
