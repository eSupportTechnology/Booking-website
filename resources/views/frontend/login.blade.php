@vite(['resources/js/app.js'])
 <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<!-- Header -->
<header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Flex Container -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">

        <!-- Logo -->
        <div class="w-full md:w-auto md:ml-6">
          <a href="/" class="text-2xl font-bold">
            <h1  style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
          </a>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto" style="font-family: 'Noto Sans', sans-serif;">
          <!-- Help Icon -->
          <a href="/help" title="Help" class="ml-2">
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
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>

              <!-- Modal Body -->
              <div class="mt-4">
                <p class="mb-4 text-base text-gray-500 dark:text-gray-400">Suggested for you</p>
                <div class="grid grid-cols-2 gap-4">
                  <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                    <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg" alt="English (UK)" class="h-5 w-5" />
                    <span>English (UK)</span>
                  </button>
                  <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Germany.svg" alt="Deutsch" class="h-5 w-5" />
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

<!-- Language Modal Script -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const languageButton = document.getElementById("language-button");
    const languageModal = document.getElementById("language-modal");
    const closeBtn = languageModal?.querySelector(".close-btn");

    if (languageButton && languageModal && closeBtn) {
      languageButton.addEventListener("click", () => {
        languageModal.classList.remove("hidden");
      });

      closeBtn.addEventListener("click", () => {
        languageModal.classList.add("hidden");
      });

      window.addEventListener("click", (event) => {
        if (event.target === languageModal) {
          languageModal.classList.add("hidden");
        }
      });
    }
  });
</script>

<!-- Main Content -->
<main class="min-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">


  <div class="bg-white w-full max-w-md p-6 sm:p-8 mb-12 sm:mt-8 text-left shadow-md rounded-md mx-auto">
    <h2 class="text-2xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Sign in or create an account</h2>
    <p class="text-gray-600 text-sm mb-6" style="font-family: 'Noto Sans', sans-serif;">
      You can sign in using your Booking.com account to access our services.
    </p>

    <!-- Email Input -->
    <div class="mb-4">
      <label for="email" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Noto Sans', sans-serif;">Email address</label>
      <input id="email" type="email" placeholder="Enter your email address"
             class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Continue Button -->
    <button class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4" style=" background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
      Continue with email
    </button>

    <!-- Divider -->
    <div class="flex items-center my-4">
      <hr class="flex-grow border-gray-300">
      <span class="mx-4 text-sm text-gray-500" style="font-family: 'Noto Sans', sans-serif;">or use one of these options</span>
      <hr class="flex-grow border-gray-300">
    </div>

    <!-- Social Login Buttons -->
    <div class="flex justify-center space-x-4 mb-4">
      <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
        <img src="{{ asset('images/google.png') }}" alt="Google" class="w-6 h-6">
      </button>
      <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
        <img src="{{ asset('images/apple.png') }}" alt="Apple" class="w-6 h-6">
      </button>
      <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
        <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-6 h-6">
      </button>
    </div>
    <hr class="flex-grow border-gray-300">

    <!-- Terms -->
    <p class="text-xs text-gray-500 mt-6 text-center"style="font-family: 'Noto Sans', sans-serif;" >
      By signing in or creating an account, you agree with our
      <a href="#" class="text-blue-600 underline" style="font-family: 'Noto Sans', sans-serif;">Terms & conditions</a> and
      <a href="#" class="text-blue-600 underline" style="font-family: 'Noto Sans', sans-serif;">Privacy statement</a>.
    </p>

    <!-- Footer Text -->
    <p class="text-xs text-gray-500 mt-6 text-center" >
      <span class="block" style="font-family: 'Noto Sans', sans-serif;">All rights reserved</span>
      <span class="block" style="font-family: 'Noto Sans', sans-serif;">© 2006 – 2025 Bookintour.com™</span>
    </p>
  </div>
</main>

<script src="https://cdn.tailwindcss.com"></script>
