<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Having Trouble Signing In? | Bookintour</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
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
            <button id="language-button" type="button"
              class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
              title="Change Language">
              <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
            </button>

            <!-- Language Modal -->
            <div id="language-modal"
              class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
              <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                <div class="flex items-start justify-between">
                  <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                  <button type="button"
                    class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>
                <div class="mt-4">
                  <p class="mb-4 text-base text-gray-500">Suggested for you</p>
                  <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                      <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg" class="h-5 w-5" />
                      <span>English (UK)</span>
                    </button>
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Germany.svg" class="h-5 w-5" />
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

  <!-- Main Section -->
  <main class="min-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
    <div class="w-full max-w-md">
      <div class="bg-white border border-gray-200 shadow-md rounded-md p-6 text-center">
        <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Having trouble signing in?</h2>
        <p class="text-gray-700 text-sm mb-6" style="font-family: 'Noto Sans', sans-serif;">
          We're here to help. Below are some options to help get you back on track.
        </p>

        <ul class="space-y-4 text-left">
          <li class="flex items-center justify-between border-b pb-2">
            <a href="#" class="flex items-center text-blue-600 hover:underline space-x-2 font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.38 0 2.5-1.12 2.5-2.5S13.38 6 12 6 9.5 7.12 9.5 8.5 10.62 11 12 11zM12 14.5c-1.5 0-4.5.75-4.5 2.25V18h9v-1.25c0-1.5-3-2.25-4.5-2.25z" />
              </svg>
              <span>Forgot your password?</span>
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
          </li>

          <li class="flex items-center justify-between border-b pb-2">
            <a href="#" class="flex items-center text-blue-600 hover:underline space-x-2 font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zM12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
              </svg>
              <span>Forgot your username?</span>
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
          </li>

          <li class="flex items-center justify-between">
            <a href="#" class="flex items-center text-blue-600 hover:underline space-x-2 font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 14v1m8-8h1M3 12H2m15.364-6.364l.707.707M6.343 17.657l-.707.707m0-13.657l.707.707M17.657 17.657l-.707.707M12 8v4l3 1" />
              </svg>
              <span>Go to sign-in</span>
            </a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L11.586 9 7.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
          </li>
        </ul>

        <div class="border-t border-gray-200 my-6"></div>

        <p class="text-xs text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
          By signing in or creating an account, you agree with our
          <a href="#" class="text-blue-600 hover:underline">Terms & conditions</a> and
          <a href="#" class="text-blue-600 hover:underline">Privacy statement</a>.
        </p>

        <p class="text-[11px] text-gray-400 mt-4">All rights reserved.</p>
        <p class="text-[11px] text-gray-400">Copyright (2006 – 2025) Bookintour.com™</p>
      </div>
    </div>
  </main>

  <!-- Script for Modal -->
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
