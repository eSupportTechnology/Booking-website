<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
     
   <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class=" min-h-screen ">

    <!-- HEADER START -->
    <header class="text-white px-4 py-2 w-full" style="background-color:#1F8FB2;">
        <section class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <div class="w-full md:w-auto md:ml-6">
                        <a href="/" class="text-2xl font-bold">
                            <h1 style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto" style="font-family: 'Noto Sans', sans-serif;">
                        <a href="/help" title="Help" class="ml-2">
                            <img src="{{ asset('assets/question.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                        </a>
                        <button id="language-button" type="button" class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden" title="Change Language">
                            <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
                        </button>

                        <!-- Modal -->
                        <div id="language-modal" class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white" >
                                        Select your language
                                    </h3>
                                    <button type="button" class="close-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
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
                        <!-- Modal End -->
                    </div>
                </div>
            </div>
        </section>
    </header>
    <!-- HEADER END -->

    <!-- Main Content -->
     <main class="min-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
    <div class="bg-white rounded shadow-md w-full max-w-md p-6 sm:p-8 text-center mt-10">
        <div class="text-left mb-6">
            <h1 class="text-2xl font-semibold" style="font-family: 'Noto Sans', sans-serif;">Verify your email address</h1>
            <p class="text-sm text-gray-700 mt-2" style="font-family: 'Noto Sans', sans-serif;">We’ve sent a verification code to<br>
                <span class="font-semibold" style="font-family: 'Noto Sans', sans-serif;">www.sample256@gmail.com</span>. Please enter this code to continue.
            </p>
        </div>

        <!-- Code Input Boxes -->
        <div class="flex justify-between gap-2 mb-6" id="code-container">
            <input type="text" maxlength="1" class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="handleInput(this, 0)">
            <input type="text" maxlength="1" class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="handleInput(this, 1)">
            <input type="text" maxlength="1" class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="handleInput(this, 2)">
            <input type="text" maxlength="1" class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="handleInput(this, 3)">
            <input type="text" maxlength="1" class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="handleInput(this, 4)">
            <input type="text" maxlength="1" class="code-input w-10 h-12 text-center text-lg border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="handleInput(this, 5)">
        </div>

        <!-- Verify Button -->
        <button id="verify-btn" disabled class="w-full bg-gray-300 text-white font-semibold py-2 rounded cursor-not-allowed" style="font-family: 'Noto Sans', sans-serif;">
            Verify email
        </button>

        <p class="text-sm text-gray-600 mt-4"style="font-family: 'Noto Sans', sans-serif;">Didn’t receive an email? Please check your spam folder or request another code in <strong>48 seconds</strong></p>
        <a href="#" class="block mt-4 text-blue-600 hover:underline text-sm" style="font-family: 'Noto Sans', sans-serif;">Back to sign in</a>

        <div class="mt-8 text-xs text-gray-500">
            <p style="font-family: 'Noto Sans', sans-serif;">By signing in or creating an account, you agree with our 
                <a href="#" class="text-blue-600 underline" style="font-family: 'Noto Sans', sans-serif;">Terms & Conditions</a> and 
                <a href="#" class="text-blue-600 underline"style="font-family: 'Noto Sans', sans-serif;">Privacy Statement</a>.
            </p>
            <p class="mt-2"style="font-family: 'Noto Sans', sans-serif;">All rights reserved<br>Copyright (2025) – Bookintour™</p>
        </div>
    </div>
</main>

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

      // Enable button when all inputs are filled
      function handleInput(el, index) {
        el.value = el.value.replace(/[^0-9]/g, '');

        const inputs = document.querySelectorAll('.code-input');
        const verifyBtn = document.getElementById('verify-btn');
        let allFilled = true;

        inputs.forEach(input => {
          if (input.value.trim() === '') allFilled = false;
        });

        if (allFilled) {
          verifyBtn.disabled = false;
          verifyBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
          verifyBtn.classList.add('bg-[#3CC0E9]', 'hover:bg-blue-700', 'cursor-pointer');
        } else {
          verifyBtn.disabled = true;
          verifyBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
          verifyBtn.classList.remove('bg-[#3CC0E9]', 'hover:bg-blue-700', 'cursor-pointer');
        }

        // Auto-focus next input
        if (el.value && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      }
    </script>
</body>
</html>
