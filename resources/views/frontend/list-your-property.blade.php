<script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<!-- HEADER -->
<header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">
        
        <!-- Left Section -->
        <div class="w-full md:w-auto">
          <div class="flex flex-col items-start space-y-2">
            <!-- Logo -->
            <h1 class="text-2xl font-bold" style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>

            <!-- Green Box Message -->
            <div id="promo-box" class="bg-green-500 text-white px-4 py-2 rounded flex items-start justify-between w-full max-w-sm">
              <span class="text-sm">We offer special discounts this season!</span>
              <button onclick="document.getElementById('promo-box').classList.add('hidden')" class="ml-4 text-white hover:text-gray-200 font-bold">&times;</button>
            </div>
          </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4 flex-wrap">
          <!-- Language Button -->
          <button id="language-button" type="button" class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden">
            <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
          </button>

          <!-- Language Modal -->
          <div id="language-modal" class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
              <div class="flex items-start justify-between">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Select your language</h3>
                <button type="button" class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto dark:hover:bg-gray-600 dark:hover:text-white">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>

              <div class="mt-4">
                <p class="mb-4 text-base text-gray-500 dark:text-gray-400">Suggested for you</p>
                <div class="grid grid-cols-2 gap-4">
                  <button class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                    <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg" alt="English (UK)" class="h-5 w-5" />
                    <span>English (UK)</span>
                  </button>
                  <button class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Germany.svg" alt="Deutsch" class="h-5 w-5" />
                    <span>Deutsch</span>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Nav Links -->
          <a href="#" class="hover:underline font-sans" style="font-family: 'Noto Sans', sans-serif;">Already a partner?</a>
          <a href="#" class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">Sign in</a>
          <a href="#" class="bg-[#3CC0E9] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans">Help</a>
        </div>
      </div>
    </div>
  </section>
</header>

<!-- MAIN SECTION -->
<section class="bg-[#1F8FB2] text-white py-12 px-4 md:px-12 relative z-0">
  <div class="container px-4 md:px-8 max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
    <!-- Left Text Column -->
    <div class="w-full md:w-1/2">
   <h1 class="text-3xl md:text-5xl font-bold  -mt-12" style="font-family: 'Poppins', sans-serif; line-height: 1.4;">
  List your <br>
  <span class="text-[#3CC0E9] font-semibold">holiday rental</span><br>
  on <span class="text-white font-extrabold">Bookintour.com</span>
</h1>
<p class="text-white text-xl mt-4 max-w-4xl font-light leading-snug" style="font-family: 'Noto Sans', sans-serif;">
  List on one of the world’s most downloaded travel apps to earn more, faster and expand into new markets.
</p>



    </div>

    <!-- Right Box -->
    <div class="w-full md:w-1/2 bg-white text-black p-6 rounded-lg border-4 border-yellow-400 shadow-md max-w-md">
      <h2 class="text-xl font-bold mb-4" style="font-family: 'Poppins', sans-serif;">Register for free</h2>
      <ul class="list-none space-y-2 mb-6">
        <li class="flex items-start">
          <span class="text-green-500 mr-2">✔</span>
          <p>45% of hosts get their first booking within a week</p>
        </li>
        <li class="flex items-start">
          <span class="text-green-500 mr-2">✔</span>
          <p>Choose instant bookings or Request to Book</p>
        </li>
        <li class="flex items-start">
          <span class="text-green-500 mr-2">✔</span>
          <p>We'll facilitate payments for you</p>
        </li>
      </ul>
      <button class="w-full bg-[#3CC0E9] text-white font-semibold py-2 rounded hover:bg-[#2bb3db] transition duration-200">
        Get started now →
      </button>
      <p class="mt-4 text-sm">
        <span class="font-bold text-black">Already started a registration?</span><br>
        <a href="#" class="text-[#3CC0E9] hover:underline">Continue your registration</a>
      </p>
    </div>
  </div>
</section>


<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           <h2 class="text-3xl font-semibold text-gray-800 mb-8"  style="font-family: 'Poppins', sans-serif;">Host worry-free. We’ve got your back</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Column 1: Your rental, your rules -->
            <div>
                <h3 class="text-xl font-semibold mb-4" style="font-family: 'Noto Sans', sans-serif;">Your rental, your rules</h3>
  <ul class=" text-gray-700 space-y-3 " style="font-family: 'Noto Sans', sans-serif;">
  <li class="flex items-start gap-2">
    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
    <span class="text-base">
      Accept or decline bookings with 
      <a href="#" class="underline text-base text-blue-500">Request to Book</a>.
    </span>
  </li>

  <li class="flex items-start gap-2">
    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
    <span class="text-base">
      Manage your guests' expectations by setting up clear house rules.
    </span>
  </li>
</ul>


                <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-10" style="font-family: 'Noto Sans', sans-serif;">
                    Host with us today
                </button>
                <p class="text-sm text-gray-500 mt-2" style="font-family: 'Noto Sans', sans-serif;">*Currently available for guest bookings made via iOS.</p>
            </div>

            <!-- Column 2: Get to know your guests -->
            <div>
                     <h3 class="text-xl font-semibold mb-4" style="font-family: 'Noto Sans', sans-serif;">Your rental, your rules</h3>
            <ul class=" text-gray-700 space-y-2" style="font-family: 'Noto Sans', sans-serif;">
  <li class="flex items-start gap-2">
    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
    <span class="text-base">
   Chat with your guests before accepting 
their stay with pre-booking messaging.*
    
    </span>
  </li>

  <li class="flex items-start gap-2">
    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
    <span class="text-base">
 Access guest travel history insights.
    </span>
  </li>
</ul>
            </div>

            <!-- Column 3: Stay protected -->
            <div>
                       <h3 class="text-xl font-semibold mb-4" style="font-family: 'Noto Sans', sans-serif;">Your rental, your rules</h3>
            <ul class=" text-gray-700 space-y-2" style="font-family: 'Noto Sans', sans-serif;">
  <li class="flex items-start gap-2">
    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
    <span class="text-base">
     Protection against liability claims from 
guests and neighbours up to €/$/
£1,000,000 for every reservation.
    </span>
  </li>

  <li class="flex items-start gap-2">
    <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
    <span class="text-base">
   Access guest travel history insights.
    </span>
  </li>
</ul>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-[#F5F5F5]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-semibold text-gray-800 mb-8" style="font-family: 'Poppins', sans-serif;">
      Take control of your finances with Payments by <br> eSupport.com
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">
      <!-- Left Column -->
      <ul class="pl-0 space-y-4">
        <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
          <div>
            <span class="font-bold font-base" style="font-family: 'Noto Sans', sans-serif;">Payments made easy</span><br />
           <span class="font-sm"> We facilitate the payment process for you, freeing up your time to grow your business.</span>
          </div>
        </li>
        <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
         <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
          <div>
            <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Greater revenue security</span><br />
            Whenever guests complete prepaid reservations at your property and pay online, you are guaranteed payment.
          </div>
        </li>
        <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
          <div>
            <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">More control over your cash flow</span><br />
            Choose your payout method and timing based on regional availability.
          </div>
        </li>
      </ul>
      

      <!-- Right Column -->
      <ul class="pl-0 space-y-4">
        <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
          <div>
            <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Daily payouts in select markets</span><br />
            Get payouts faster! We'll send your payouts 24 hours after guest checkout.
          </div>
        </li>
        <li class="flex items-start space-x-2" style="font-family: 'Noto Sans', sans-serif;">
       <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
          <div>
            <span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">One-stop solution for multiple listings</span><br />
            Save time managing finances with group invoicing and reconciliation.
          </div>
        </li>
        <li class="flex items-start space-x-2"style="font-family: 'Noto Sans', sans-serif;">
        <img src="{{ asset('assets/black-tick.svg') }}" alt="Check" class="w-5 h-5 mt-1" />
          <div>
            <span class="font-bold"style="font-family: 'Noto Sans', sans-serif;">More control over your cash flow</span><br />
            We help you stay compliant with regulatory changes and reduce the risk of fraud and chargebacks.
          </div>
        </li>
      </ul>
    </div>

    <div class="text-left mt-2">
    <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-10" style="font-family: 'Noto Sans', sans-serif;">
              Start earning today
                </button>
    </div>
  </div>
</section>


<section class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-semibold text-gray-800 mb-8" style="font-family: 'Poppins', sans-serif;">
    Simple to begin and stay ahead
    </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1: Import your property details -->
      <!-- Card 1 -->
<div class="flex flex-col items-center text-center">
    <img src="{{ asset('images/post.png') }}" alt="Import Icon" class="w-[100px] h-[100px] mb-4" />
    
    <!-- Content container to align left -->
    <div class="text-left">
        <h3 class="text-lg font-bold mb-2" style="font-family: 'Noto Sans', sans-serif;">
            Import your property details
        </h3>
        <p class="text-base" style="font-family: 'Noto Sans', sans-serif;">
            Seamlessly import your property information from other travel websites and avoid overbooking with calendar sync.
        </p>
    </div>
</div>

<!-- Repeat the same structure for Card 2 and Card 3 -->


            <!-- Card 2: Start fast with review scores -->
         <div class="flex flex-col items-center text-center">
    <img src="{{ asset('images/puzzels.png') }}" alt="Review Icon" class="w-[100px] h-[100px] mb-4" />
    
    <div class="text-left">
        <h3 class="text-lg font-bold mb-2" style="font-family: 'Noto Sans', sans-serif;">
            Start fast with review scores
        </h3>
        <p class="text-base" style="font-family: 'Noto Sans', sans-serif;">
            Your review scores on other travel websites are converted and displayed on your property page before your first eSupport.com guests leave their reviews.
        </p>
    </div>
</div>


            <!-- Card 3: Stand out in the market -->
       <div class="flex flex-col items-center text-center">
    <img src="{{ asset('images/search.png') }}" alt="Stand Out Icon" class="w-[90px] h-[100px] mb-4" />
    
    <div class="text-left">
        <h3 class="text-lg font-bold mb-2" style="font-family: 'Noto Sans', sans-serif;">
            Stand out in the market
        </h3>
        <p class="text-base" style="font-family: 'Noto Sans', sans-serif;">
            The “New to HorizonStay.com” label helps you stand out in our search results.
        </p>
    </div>
</div>

        <div class="text-left mt-2">
         <button class="bg-[#3CC0E9] hover:bg-[#29ACD5] text-white font-semibold py-2 px-4 rounded mt-2" style="font-family: 'Noto Sans', sans-serif;">
     Get started today
                </button>
        </div>
    </div>
</section>
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <!-- Background Image -->
        <img src="{{ asset('images/map.png') }}" alt="World Map" class="absolute inset-0 w-full h-full object-cover opacity-20" />

        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Left Column: Text and Button -->
            <div class="w-full md:w-1/2 mb-8 md:mb-0">
                <h2 class="text-3xl font-bold mb-4">Reach a unique global customer base</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Statistic 1 -->
                    <div>
                        <p class="text-2xl font-bold mb-1">1.8+ billion</p>
                        <p class="text-gray-600">holiday rental guests since 2010.</p>
                    </div>

                    <!-- Statistic 2 -->
                    <div>
                        <p class="text-2xl font-bold mb-1">1 in every 3</p>
                        <p class="text-gray-600">room nights booked in 2024 was a holiday rental.</p>
                    </div>

                    <!-- Statistic 3 -->
                    <div>
                        <p class="text-2xl font-bold mb-1">48% of nights</p>
                        <p class="text-gray-600">booked were for international stays at the end of 2023.</p>
                    </div>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                    Reach new guests today
                </button>
            </div>

            <!-- Right Column: Placeholder for additional content (if needed) -->
            <div class="w-full md:w-1/2 hidden md:block">
                <!-- Add any additional content here if needed -->
            </div>
        </div>
    </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Language modal logic
    const languageButton = document.getElementById("language-button");
    const languageModal = document.getElementById("language-modal");
    const closeBtn = languageModal ? languageModal.querySelector(".close-btn") : null;

    if (languageButton && languageModal && closeBtn) {
      // Open the language modal
      languageButton.addEventListener("click", () => {
        languageModal.classList.remove("hidden");
      });

      // Close language modal on close button click
      closeBtn.addEventListener("click", () => {
        languageModal.classList.add("hidden");
      });

      // Close language modal on clicking outside the modal content
      window.addEventListener("click", (event) => {
        if (event.target === languageModal) {
          languageModal.classList.add("hidden");
        }
      });
    }
  });
</script>
