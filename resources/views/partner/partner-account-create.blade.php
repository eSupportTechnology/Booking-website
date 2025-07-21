<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Partner Account | {{ config('domains.app_name') }}</title>

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

      @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 border border-green-400 text-green-700 text-sm" role="alert">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
          {{ session('error') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
          <ul class="mb-0 pl-4 list-disc">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

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
      <p class="text-[11px] text-gray-400 text-center mt-1">© 2006 – 2025 {{ config('domains.domain') }}™</p>
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

</body>
</html>
