@extends('partner.partner-layout')

@section('title', 'Create Password | ' . config('domains.app_name'))

@section('content')

 
    <meta name="csrf-token" content="{{ csrf_token() }}">

   

    <!-- Form Section -->
    <section class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto bg-white border border-gray-200 rounded-md shadow-md p-6 mt-6">
            <!-- Title -->
            <div class="text-left mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Create password</h2>
                <p class="text-sm text-gray-700 mt-1">Use a minimum of 10 characters, including uppercase letters,
                    lowercase letters and numbers.</p>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 border border-green-400 text-green-700 text-sm"
                    role="alert">
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

            <!-- Form -->
            <form method="POST" action="{{ route('partner.register.password') }}" id="passwordForm">
                @csrf

                <!-- Password -->
                <div class="mb-4 relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                            placeholder="Enter a password" />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6 relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm password
                        <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Confirm your password" />
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4"
                    style="background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
                    Create account
                </button>

                <!-- Footer text -->
                <p class="text-xs text-center text-gray-600 mt-4">
                    By signing in or creating an account, you agree with our
                    <a href="#" class="text-blue-600 hover:underline">Terms & conditions</a> and
                    <a href="#" class="text-blue-600 hover:underline">Privacy statement</a>.
                </p>

                <p class="text-[11px] text-gray-400 text-center mt-2">
                    © 2006 – 2025 {{ config('domains.subdomain') }}™
                </p>
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