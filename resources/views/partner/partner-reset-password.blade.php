@extends('partner.partner-layout')

@section('title', 'Signin Partner Account | ' . config('domains.app_name'))

@section('content')
  

    <!-- Form Section -->
    <section class="max-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
        <div class="w-full max-w-md space-y-6">


            <div class="bg-white border border-gray-200 shadow-md rounded-md p-6 mt-8">

                <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">Enter your password
                </h2>
                <p class="text-gray-600 text-sm " style="font-family: 'Noto Sans', sans-serif;">Please enter your
                    {{ config('domains.domain') }} password for</p>
                <p class="text-gray-600 text-sm mb-6 font-bold" style="font-family: 'Noto Sans', sans-serif;">
                    {{ $email }}.</p>

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

                <form method="POST" action="{{ route('partner.password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <!-- Password -->
                    <div class="mb-4 relative">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Enter a password" />
                        </div>
                    </div>
                    <div class="mb-4 relative">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                            Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="mt-1 w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Confirm your password" />
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white py-2 rounded hover:bg-blue-700 mb-4"
                        style=" background-color:#3CC0E9;font-family: 'Noto Sans', sans-serif;">
                        Reset Password
                    </button>
                </form>

                <div class="border-t border-gray-200 my-6"></div>

                <p class="text-xs text-gray-600 text-center" style="font-family: 'Noto Sans', sans-serif;">
                    By signing in or creating an account, you agree with our
                    <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Terms & conditions</a> and
                    <a href="#" class="text-blue-600 hover:underline"
                        style="font-family: 'Noto Sans', sans-serif;">Privacy statement</a>
                </p>

                <p class="text-[11px] text-gray-400 text-center mt-4" style="font-family: 'Noto Sans', sans-serif;">
                    All rights reserved.</p>

                <p class="text-[11px] text-gray-400 text-center mt-1" style="font-family: 'Noto Sans', sans-serif;">
                    Copyright (2006 – 2025) {{ config('domains.domain') }}™</p>
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

@endsection