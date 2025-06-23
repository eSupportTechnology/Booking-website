<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Partner Account | Bookintour</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @vite(['resources/js/app.js'])
</head>
<body class="bg-white">

<!-- Header and Modal: Unchanged -->
<!-- ... (same as your original code up to form section) -->

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
      <p class="text-xs text-gray-600 text-center">Do you have questions about your property or the extranet?
        <a href="#" class="text-blue-600 hover:underline">Partner Help</a> or
        <a href="#" class="text-blue-600 hover:underline">Partner Community</a>
      </p>

      <div class="mt-4">
        <a href="{{ url('partner/sign-in') }}" class="block text-center border border-blue-600 text-blue-600 hover:bg-blue-50 rounded py-2 text-sm font-semibold">
          Sign in
        </a>
      </div>

      <p class="text-[11px] text-gray-500 text-center mt-6">
        By signing in or creating an account, you agree with our
        <a href="#" class="text-blue-600 hover:underline">Terms & conditions</a> and
        <a href="#" class="text-blue-600 hover:underline">Privacy statement</a>.
      </p>
      <p class="text-[11px] text-gray-400 text-center mt-1">© 2006 – 2025 Bookintour.com™</p>
    </div>
  </div>
</section>

<!-- JS for language modal -->
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

<!-- ✅ SweetAlert-integrated form handler -->
<script>
document.getElementById('emailForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const email = form.querySelector('#email').value;
    const submitButton = form.querySelector('button[type="submit"]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    submitButton.disabled = true;
    submitButton.innerHTML = 'Sending...';

    // Timeout fallback
    const timeoutPromise = new Promise((_, reject) => {
        setTimeout(() => reject(new Error('Request timed out')), 30000);
    });

    // Real fetch request
    const fetchPromise = fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ email: email }),
    });

    Promise.race([fetchPromise, timeoutPromise])
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Submission failed');
                });
            }
            return response.json();
        })
        .then(data => {
            sessionStorage.setItem('partner_email', email);
            // Optional: SweetAlert success popup
            Swal.fire({
                icon: 'success',
                title: 'Email submitted!',
                text: 'Redirecting to the next step...',
                timer: 2000,
                showConfirmButton: false
            });

            setTimeout(() => {
                window.location.href = "{{ route('partner.register.contact.form') }}";
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error.message || 'Something went wrong!',
            });
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Continue';
        });
});
</script>

</body>
</html>
