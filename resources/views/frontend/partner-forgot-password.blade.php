<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signin Partner Account | Bookintour</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <!-- Vite assets (optional for Laravel Mix setup) -->
  @vite(['resources/js/app.js'])
</head>
<body class="bg-white">

<!-- Header -->
<header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
  <section class="py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
        <!-- Logo -->
        <div class="w-full md:w-auto md:ml-6">
          <a href="/" class="text-2xl font-bold">
            <h1 style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
          </a>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto" style="font-family: 'Noto Sans', sans-serif;">
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
            class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50"
          >
            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
              <!-- Modal Header -->
              <div class="flex items-start justify-between">
                <h3 class="text-xl font-semibold text-gray-900">
                  Select your language
                </h3>
                <button
                  type="button"
                  class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                >
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="sr-only" >Close modal</span>
                </button>
              </div>

              <!-- Modal Body -->
              <div class="mt-4">
                <p class="mb-4 text-base text-gray-500" style="font-family: 'Noto Sans', sans-serif;">Suggested for you</p>
                <div class="grid grid-cols-2 gap-4">
                  <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                    <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg" alt="English (UK)" class="h-5 w-5" />
                    <span>English (UK)</span>
                  </button>
                  <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
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

<!-- Form Section -->
<section class="max-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
  <div class="w-full max-w-md space-y-6">
    

    <div class="bg-white border border-gray-200 shadow-md rounded-md p-6 mt-8">

    <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Forgotten your password?</h2>
     <p class="text-gray-600 text-sm mb-4 " style="font-family: 'Noto Sans', sans-serif;">No problem! We'll send you a link to reset it. Please enter the email address you use to sign in to Booking.com.</p>

      <form method="POST" action="#">
        @csrf
    <div class="mb-4 relative">
  <label for="email" class="block text-sm font-medium text-gray-700">
    Username <span class="text-red-500">*</span>
  </label>
  <div class="relative">
    <input type="email" id="email" name="email" required 
           class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" 
           placeholder="Enter your email address"/>
  </div>
</div>


        <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-2" style=" background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
          Send reset link
        </button>
   


      </form>

      <div class="border-t border-gray-200 my-6"></div>

      <p class="text-xs text-gray-600 text-center" style="font-family: 'Noto Sans', sans-serif;">
       By signing in or creating an account, you agree with our 
        <a href="#" class="text-blue-600 hover:underline" style="font-family: 'Noto Sans', sans-serif;">Terms & conditions</a> and
         <a href="#" class="text-blue-600 hover:underline" style="font-family: 'Noto Sans', sans-serif;">Privacy statement</a>
      </p>

     <p class="text-[11px] text-gray-400 text-center mt-4" style="font-family: 'Noto Sans', sans-serif;">All rights reserved.</p>

      <p class="text-[11px] text-gray-400 text-center mt-1" style="font-family: 'Noto Sans', sans-serif;"> Copyright (2006 – 2025) Bookintour.com™</p>
    </div>
  </div>
</section>

<!-- Modal Script -->
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

</body>
</html>
