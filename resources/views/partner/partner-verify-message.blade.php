<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verify Your Account - Bookintour.com</title>

  <script src="https://cdn.tailwindcss.com"></script>
  @vite(['resources/js/app.js'])

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <!-- Custom font -->
  <style>
    body {
      font-family: 'Noto Sans', sans-serif;
    }
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

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
          <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto">
            
            <!-- Help Icon -->
            <a href="/help" title="Help">
              <img src="{{ asset('assets/question.svg') }}" alt="Help" class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
            </a>

            <!-- Language Button -->
            <button id="language-button" type="button"
              class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
              title="Change Language">
              <img src="{{ asset('images/uk.png') }}" alt="UK Flag"
                class="w-full h-full object-cover rounded-full" />
            </button>

            <!-- Language Modal -->
            <div id="language-modal"
              class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
              <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                <!-- Modal Header -->
                <div class="flex items-start justify-between">
                  <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                  <button type="button"
                    class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>

                <!-- Modal Body -->
                <div class="mt-4">
                  <p class="mb-4 text-base text-gray-500">Suggested for you</p>
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

            <!-- User Icon -->
            <div class="flex items-center space-x-2">
              <div class="bg-white text-[#003580] rounded-full w-8 h-8 flex items-center justify-center font-bold">
                B
              </div>
              <span class="hidden sm:inline-block font-semibold">Weerathunga</span>
            </div>

          </div>
        </div>
      </div>
    </section>
  </header>

  <!-- Main Content -->
  <main class="flex-grow flex justify-center items-start px-4 py-16">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-xl text-center">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Verify your account</h2>
      <div class="bg-gray-100 text-left p-4 rounded">
        <p class="text-gray-700 mb-2">
          We sent you an email with a verification link to
        </p>
        <p class="font-semibold text-gray-900 break-words" id="userEmail"></p>
        <p class="mt-4 text-gray-700">
          To confirm your account please follow the link in the email we just sent.
        </p>
        <div class="mt-6">
          <button id="resendButton" class="text-blue-600 hover:text-blue-800 font-medium">
            Resend verification email
          </button>
          <p id="resendMessage" class="text-sm text-green-600 mt-2 hidden"></p>
        </div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Language modal functionality
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

      // Display email from session storage
      const userEmail = sessionStorage.getItem('partner_email');
      if (userEmail) {
        document.getElementById('userEmail').textContent = userEmail;
      }

      // Resend verification email functionality
      const resendButton = document.getElementById('resendButton');
      const resendMessage = document.getElementById('resendMessage');

      resendButton.addEventListener('click', function() {
        if (!userEmail) return;

        resendButton.disabled = true;
        resendButton.textContent = 'Sending...';

        fetch('{{ route("partner.register.resend") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ email: userEmail })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            resendMessage.textContent = 'Verification email has been resent!';
            resendMessage.classList.remove('hidden');
            setTimeout(() => {
              resendMessage.classList.add('hidden');
            }, 5000);
          } else {
            alert(data.message || 'An error occurred');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while resending the verification email');
        })
        .finally(() => {
          resendButton.disabled = false;
          resendButton.textContent = 'Resend verification email';
        });
      });
    });
  </script>
</body>
</html>