<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Partner Account | Bookintour</title>

  <!-- CSRF Token for AJAX requests -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <h2 class="text-2xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Create your partner account</h2>
     <p class="text-gray-600 text-sm mb-6" style="font-family: 'Noto Sans', sans-serif;">Create an account to list and manage your property.</p>

      <form method="POST" action="{{ route('partner.register.email') }}" id="emailForm">
        @csrf
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Noto Sans', sans-serif;">Email address</label>
        <input type="email" id="email" name="email" required 
               class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4 @error('email') border-red-500 @enderror" />
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4" style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
          Continue
        </button>
      </form>

      <div class="border-t border-gray-200 my-6"></div>

      <p class="text-xs text-gray-600 text-center" style="font-family: 'Noto Sans', sans-serif;">
        Do you have questions about your property or the extranet?
        <a href="#" class="text-blue-600 hover:underline" style="font-family: 'Noto Sans', sans-serif;">Partner Help</a> or
        <a href="#" class="text-blue-600 hover:underline" style="font-family: 'Noto Sans', sans-serif;">Partner Community</a>
      </p>

      <div class="mt-4">
        <a href="{{ url('partner/sign-in') }}" class="block text-center border border-blue-600 text-blue-600 hover:bg-blue-50 rounded py-2 text-sm font-semibold" style="font-family: 'Noto Sans', sans-serif;">
          Sign in
        </a>
      </div>

      <p class="text-[11px] text-gray-500 text-center mt-6" style="font-family: 'Noto Sans', sans-serif;">
        By signing in or creating an account, you agree with our
        <a href="#" class="text-blue-600 hover:underline" style="font-family: 'Noto Sans', sans-serif;">Terms & conditions</a> and
        <a href="#" class="text-blue-600 hover:underline" style="font-family: 'Noto Sans', sans-serif;">Privacy statement</a>.
      </p>

      <p class="text-[11px] text-gray-400 text-center mt-1" style="font-family: 'Noto Sans', sans-serif;">© 2006 – 2025 Bookintour.com™</p>
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

<script>
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitButton = form.querySelector('button[type="submit"]');
    const email = form.querySelector('#email').value;

    // Debug: Log email and CSRF token
    console.log('Submitting email:', email);
    console.log('CSRF token:', document.querySelector('meta[name="csrf-token"]').content);

    // Disable submit button
    submitButton.disabled = true;
    submitButton.innerHTML = 'Sending...';

    // Create a timeout promise
    const timeoutPromise = new Promise((_, reject) => {
        setTimeout(() => reject(new Error('Request timeout')), 30000); // 30 second timeout
    });

    // Create the fetch promise
    const fetchPromise = fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ email: email })
    });

    // Race between fetch and timeout
    Promise.race([fetchPromise, timeoutPromise])
        .then(response => {
            // Debug: Log response status
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Debug: Log response data
            console.log('Response data:', data);
            // Store email in sessionStorage for use in the next step
            sessionStorage.setItem('partner_email', email);
            // Redirect to contact details page
            window.location.href = "{{ route('partner.register.contact.form') }}";
        })
        .catch(error => {
            // Debug: Log error
            console.error('Error:', error);
            alert('Error: ' + error.message);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Continue';
        });
});
</script>

</body>
</html>