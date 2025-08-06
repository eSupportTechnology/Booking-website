@extends('partner.partner-layout')

@section('title', ' Partner Contact Details | ' . config('domains.app_name'))

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Form Section -->
    <main
        class="container mx-auto mt-16 px-4 sm:px-6 lg:px-8 max-w-md bg-white border border-gray-200 shadow-md rounded-md p-6">
        <h2 class="text-2xl font-semibold mb-2">Contact details</h2>
        <p class="text-sm text-gray-600 mb-6">
            Your full name and phone number are needed to ensure the security of your {{ config('domains.domain') }} account.
        </p>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 border border-green-400 text-green-700 text-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
                <ul class="mb-0 pl-4 list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                <div
                    class="flex items-center border border-gray-300 rounded-md px-3 py-2 space-x-2 @error('contact_number') border-red-500 @enderror">
                    <!-- Flag Image -->
                    <img id="selected-flag" src="https://flagcdn.com/w40/lk.png" alt="Flag"
                        class="w-6 h-4 rounded" />

                    <!-- Country Code Select -->
                    <select id="country-select" name="country_code"
                        class="bg-white border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                        <option value="+94" data-flag="https://flagcdn.com/w40/lk.png" selected>+94</option>
                        <option value="+44" data-flag="https://flagcdn.com/w40/gb.png">+44</option>
                        <option value="+49" data-flag="https://flagcdn.com/w40/de.png">+49</option>
                        <option value="+1" data-flag="https://flagcdn.com/w40/us.png">+1</option>
                    </select>

                    <!-- Phone Number Input -->
                    <input type="tel" id="contact_number" name="contact_number" required
                        placeholder="Enter phone number"
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
            <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700"
                style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
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
            <p class="mt-4">© 2006 – 2025 {{ config('domains.domain') }}™</p>
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
    </script>
@endsection
