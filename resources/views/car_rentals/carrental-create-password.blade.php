@extends('frontend.carrental-layout')

@section('title', ' Create password | ' . config('domains.app_name'))

@section('content')

<!-- Form Section -->
<section class="container mx-auto px-4 py-12">
  <div class="max-w-md mx-auto bg-white border border-gray-200 rounded-md shadow-md p-6 mt-6">
    <!-- Title -->
    <div class="text-left mb-6">
      <h2 class="text-2xl font-bold text-gray-900">Create password</h2>
      <p class="text-sm text-gray-700 mt-1">Use a minimum of 10 characters, including uppercase letters, lowercase letters and numbers.</p>
    </div>

    <!-- Form -->
  <form method="POST" action="{{ route('carrentals.register.password.store') }}">
  @csrf

  <!-- Password -->
  <div class="mb-4">
    <label for="password" class="block text-sm font-medium text-gray-700">
      Password <span class="text-red-500">*</span>
    </label>
    <input type="password" id="password" name="password" required
      class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
      placeholder="Enter a password" />
  </div>

  <!-- Confirm Password -->
  <div class="mb-6">
    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
      Confirm password <span class="text-red-500">*</span>
    </label>
    <input type="password" id="password_confirmation" name="password_confirmation" required
      class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
      placeholder="Confirm your password" />
  </div>

  <!-- Submit -->
  <button type="submit"
    class="w-full text-white py-2 rounded font-semibold"
    style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
    Create account
  </button>
</form>
  </div>
</section>

<!-- Toggle Password JS -->
<script>
  function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    input.type = input.type === "password" ? "text" : "password";
  }
</script>

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

@endsection
