<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-white font-sans">

  <!-- Header -->
  <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
          <!-- Logo -->
          <div class="w-full md:w-auto md:ml-6">
            <a href="/" class="text-2xl font-bold font-poppins">
              Bookintour.com
            </a>
          </div>

          <!-- Right Section -->
          <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto font-sans">
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
              class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
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
                      <img src="https://flagcdn.com/w40/gb.png" alt="English (UK)" class="h-5 w-5" />
                      <span>English (UK)</span>
                    </button>
                    <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                      <img src="https://flagcdn.com/w40/de.png" alt="Deutsch" class="h-5 w-5" />
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
  <main class="container mx-auto mt-16 px-4 sm:px-6 lg:px-8 max-w-md bg-white border border-gray-200 shadow-md rounded-md p-6">
    <h2 class="text-2xl font-semibold mb-2">Contact details</h2>
    <p class="text-sm text-gray-600 mb-6">
      Your full name and phone number are needed to ensure the security of your Bookintour.com account.
    </p>

    <form method="POST" action="{{ route('partner.register.contact') }}" id="contactForm">
      @csrf
      <!-- First Name -->
      <div class="mb-4">
        <label for="first_name" class="block text-sm font-medium text-gray-800">First name</label>
        <input type="text" id="first_name" name="first_name" required
          class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('first_name') border-red-500 @enderror" />
        @error('first_name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Last Name -->
      <div class="mb-4">
        <label for="last_name" class="block text-sm font-medium text-gray-800">Last name</label>
        <input type="text" id="last_name" name="last_name" required
          class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('last_name') border-red-500 @enderror" />
        @error('last_name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Phone Number with Country Flag -->
      <div class="mb-4">
        <label for="contact_number" class="block text-sm font-medium text-gray-800 mb-1">Phone number</label>
        <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2 @error('contact_number') border-red-500 @enderror">
          <!-- Flag Image -->
          <img id="selected-flag" src="https://flagcdn.com/w40/lk.png" alt="Flag" class="w-6 h-4 rounded" />

          <!-- Country Code Select -->
          <select id="country-select" name="country_code"
            class="bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
            <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
            <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
            <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
            <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
          </select>

          <!-- Phone Number Input -->
          <input type="tel" id="contact_number" name="contact_number" required placeholder="Enter phone number"
            class="flex-1 outline-none border-none focus:ring-0 text-gray-900 text-sm" />
        </div>
        @error('contact_number')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        <p class="text-xs text-gray-500 mt-1">
          We'll text a two-factor authentication code to this number when you sign in.
        </p>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700" style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
        Next
      </button>
    </form>

    <!-- Terms -->
    <div class="text-xs text-gray-500 text-center mt-6">
      <p>
        By signing in or creating an account, you agree with our
        <a href="#" class="text-blue-600 underline">Terms &amp; conditions</a> and
        <a href="#" class="text-blue-600 underline">Privacy statement</a>.
      </p>
      <p class="mt-4">© 2006 – 2025 Bookintour.com™</p>
    </div>
  </main>

  <!-- Script for Flag Switching and Modal -->
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

      // Flag update on country change
      const countrySelect = document.getElementById('country-select');
      const selectedFlag = document.getElementById('selected-flag');

      countrySelect.addEventListener('change', () => {
        const selectedOption = countrySelect.options[countrySelect.selectedIndex];
        const flagUrl = selectedOption.getAttribute('data-flag');
        if (flagUrl) selectedFlag.src = flagUrl;
      });
    });

    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const formData = new FormData(form);
        
        // Get the stored email from session storage
        const email = sessionStorage.getItem('partner_email');
        if (!email) {
            alert('Please start from the email registration page');
            window.location.href = '{{ route("partner.register.email") }}';
            return;
        }
        
        formData.append('email', email);

        // Disable submit button
        submitButton.disabled = true;
        submitButton.innerHTML = 'Processing...';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => {
            // Debug: log response status
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            // Debug: log response data
            console.log('Response data:', data);
            if (data.status === 'success') {
                window.location.href = '{{ route("partner.register.password") }}';
            } else {
                alert(data.message || 'An error occurred');
            }
        })
        .catch(error => {
            // Debug: log error
            console.error('Error:', error);
            alert('An error occurred while processing your request');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Next';
        });
    });
  </script>
</body>
</html>