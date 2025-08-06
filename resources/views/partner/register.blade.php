
@extends('partner.partner-layout')

@section('title', ' Partner Registration | ' . config('domains.app_name'))

@section('content')

    


<!-- Main Content -->
<main class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white border border-gray-200 rounded-md shadow-md p-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Become a Partner</h2>
        <p class="text-gray-600 text-sm mb-6">
            List your property on {{ config('domains.domain') }} and start earning more bookings.
        </p>

        <a href="{{ route('partner.register.email.form') }}"
           class="block w-full text-white py-2 rounded hover:bg-blue-700 text-center"
           style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
            Get Started
        </a>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="#" class="text-blue-600 hover:underline">Sign in</a>
            </p>
        </div>

        <!-- Terms -->
        <div class="text-xs text-gray-500 text-center mt-6">
            <p>
                By signing in or creating an account, you agree with our
                <a href="#" class="text-blue-600 underline">Terms & conditions</a> and
                <a href="#" class="text-blue-600 underline">Privacy statement</a>.
            </p>
            <p class="mt-4">© 2006 – 2025 {{ config('domains.domain') }}™</p>
        </div>
    </div>
</main>

<!-- Language Modal -->
<div id="language-modal" class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
    <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
        <!-- Modal Header -->
        <div class="flex items-start justify-between">
            <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
            <button type="button" class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
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

<!-- Scripts -->
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
