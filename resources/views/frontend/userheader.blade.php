<header class=" text-white px-4 py-2" style="background-color:#1F8FB2;">
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Container flex with items-start for vertical alignment -->
      <div class="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">
        
        <!-- Left Section -->
        <div class="w-full md:w-auto">
          <div class="flex flex-col items-start">
            <!-- Logo -->
            <h1 class="text-2xl font-bold">HorizonStay.com</h1>
 


            <!-- Push nav a bit down to separate from logo -->
     @php
    $currentRoute = request()->route()->getName(); // Get current route name
@endphp

<nav class="flex flex-wrap gap-4 text-sm md:text-base mt-6 ">
  <!-- Stays Link -->
<a href="{{ route('stays') }}"
   class="flex items-center space-x-1 px-3 py-1 rounded-full border 
          text-white transition
          {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}"
>
    <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
    <span style="font-family: 'Noto Sans', sans-serif;">Stays</span>
</a>


  <!-- Car Rentals Link -->
 <a href="{{ route('car.rentals') }}"
   class="flex items-center space-x-1 px-3 py-1 rounded-full border 
          text-white transition
          {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}"
>
    <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
    <span style="font-family: 'Noto Sans', sans-serif;">Car rentals</span>
</a>


  <!-- Airport Taxis Link -->
  <a href="{{ route('airport.taxis') }}"
   class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
          {{ $currentRoute == 'airport.taxis' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
    <img src="{{ asset('assets/taxi.svg') }}" alt="Taxi" class="w-4 h-4" />
    <span style="font-family: 'Noto Sans', sans-serif;">Airport taxis</span>
</a>

<a href="{{ route('airport.tours') }}"
   class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
          {{ $currentRoute == 'airport.tours' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
    <img src="{{ asset('assets/tour.svg') }}" alt="Tour" class="w-4 h-4" />
    <span style="font-family: 'Noto Sans', sans-serif;">Tour packages</span>
</a>

</nav>


          </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4">
          <!-- Currency display button -->
<!-- Currency display and button -->
<div class="flex items-center space-x-2">
  <span
    id="current-currency"
    class="font-semibold cursor-pointer select-none"
    title="Click to change currency"
  >
    LKR
  </span>
</div>

<!-- Currency Modal -->
<div
  id="currency-modal"
  class="fixed inset-0 hidden z-50 flex items-start justify-center px-4 py-8 bg-black bg-opacity-50 overflow-y-auto"
>
  <div class="relative w-full max-w-sm p-6 bg-white rounded-lg shadow">
    <!-- Modal Header -->
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold">Select Currency</h3>
      <button
        id="currency-close-btn"
        type="button"
        class="text-gray-400 hover:text-gray-900 text-2xl font-bold leading-none"
        aria-label="Close modal"
      >
        &times;
      </button>
    </div>

    <!-- Modal Body -->
    <div class="grid grid-cols-2 gap-4">
      <button
        class="p-2 rounded hover:bg-gray-100"
        data-currency="LKR"
      >
        LKR - Sri Lankan Rupee
      </button>
      <button
        class="p-2 rounded hover:bg-gray-100"
        data-currency="USD"
      >
        USD - US Dollar
      </button>
      <button
        class="p-2 rounded hover:bg-gray-100"
        data-currency="EUR"
      >
        EUR - Euro
      </button>
      <button
        class="p-2 rounded hover:bg-gray-100"
        data-currency="GBP"
      >
        GBP - British Pound
      </button>
      <!-- Add more currencies as needed -->
    </div>
  </div>
</div>




    <!-- Language Button -->
<button
  id="language-button"
  type="button"
  class="flex items-center justify-center w-7 h-7 bg-white  rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
>
  <img
    src="{{ asset('images/uk.png') }}"
    alt="UK Flag"
    class="w-full h-full object-cover rounded-full"
  />
</button>


<!-- Language Modal -->
<div
  id="language-modal"
  class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50"
>
  <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
    <!-- Modal Header -->
    <div class="flex items-start justify-between">
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
        Select your language
      </h3>
      <button
        type="button"
        class="close-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
      >
        <svg
          aria-hidden="true"
          class="w-5 h-5"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clip-rule="evenodd"
          ></path>
        </svg>
        <span class="sr-only">Close modal</span>
      </button>
    </div>

    <!-- Modal Body -->
    <div class="mt-4">
      <p class="mb-4 text-base text-gray-500 dark:text-gray-400">
        Suggested for you
      </p>
      <div class="grid grid-cols-2 gap-4">
        <button
          class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700"
        >
          <img
            src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg"
            alt="English (UK)"
            class="h-5 w-5"
          />
          <span>English (UK)</span>
        </button>
        <button
          class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700"
        >
          <img
            src="https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Germany.svg"
            alt="Deutsch"
            class="h-5 w-5"
          />
          <span>Deutsch</span>
        </button>
      </div>
    </div>
  </div>
</div>

       <a href="">
  <img src="{{ asset('assets/question.svg') }}" alt="Taxi" class="w-5 h-5 cursor-pointer" />
</a>

          <a href="#" class="hover:underline" style="font-family: 'Noto Sans', sans-serif;">My Booking</a>

<div class="flex items-center ml-4">
  <div class="w-10 h-10 rounded-full font-bold text-black flex items-center justify-center"
       style="font-family: 'Lato', sans-serif; font-size:16px; background-color: #FFD000;">
    V
  </div>

  <div class="ml-3">
    <span class="text-base font-semibold text-white" style="font-family: 'Noto Sans', sans-serif;">vikum dewnka</span><br>
    <span class="text-xs font-medium text-white" style="font-family: 'Noto Sans', sans-serif;">Genius Level 1</span>
  </div>
</div>

        </div>

      </div>
    </div>
  </section>
</header>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Currency modal logic
    const currentCurrency = document.getElementById("current-currency");
    const currencyModal = document.getElementById("currency-modal");
    const currencyCloseBtn = document.getElementById("currency-close-btn");

    if (currentCurrency && currencyModal && currencyCloseBtn) {
      // Open currency modal on clicking the currency span
      currentCurrency.addEventListener("click", () => {
        currencyModal.classList.remove("hidden");
      });

      // Close currency modal on close button click
      currencyCloseBtn.addEventListener("click", () => {
        currencyModal.classList.add("hidden");
      });

      // Close currency modal on clicking outside the modal content
      window.addEventListener("click", (e) => {
        if (e.target === currencyModal) {
          currencyModal.classList.add("hidden");
        }
      });

      // Change currency when a currency button is clicked
      currencyModal.querySelectorAll("button[data-currency]").forEach((btn) => {
        btn.addEventListener("click", () => {
          const selectedCurrency = btn.getAttribute("data-currency");
          currentCurrency.textContent = selectedCurrency;
          currencyModal.classList.add("hidden");
        });
      });
    }

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
