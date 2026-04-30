@extends('frontend.master')

@section('title', 'Enter Password | ' . config('domains.app_name'))

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            Enter Password
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            Sign in to your car rental account
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">

            <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">
                Enter your password
            </h2>
            <p class="text-sm text-gray-600 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                Please enter your password for
            </p>
            <p class="text-sm text-gray-800 font-semibold mb-6" style="font-family: 'Noto Sans', sans-serif;">
                {{ $email }}
            </p>

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

            <form method="POST" action="{{ route('carrentals.login.password.submit') }}">
                @csrf

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            placeholder="Enter your password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-12 focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent focus:outline-none" />
                        <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg id="eyeIcon1" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition"
                    style="background-color:#1F8FB2; font-family: 'Noto Sans', sans-serif;">
                    Sign in
                </button>

                <a href="{{ route('carrentals.password.request') }}"
                    class="block text-center text-[#1F8FB2] hover:underline mt-4 text-sm"
                    style="font-family: 'Noto Sans', sans-serif;">
                    Forgotten your password?
                </a>
            </form>

            <p class="text-[11px] text-gray-500 text-center mt-6" style="font-family: 'Noto Sans', sans-serif;">
                By signing in or creating an account, you agree with our
                <a href="#" class="text-[#1F8FB2] hover:underline">Terms & conditions</a> and
                <a href="#" class="text-[#1F8FB2] hover:underline">Privacy statement</a>.
            </p>

            <p class="text-[11px] text-gray-400 text-center mt-2" style="font-family: 'Noto Sans', sans-serif;">
                {{ config('domains.domain') }}
            </p>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">List your vehicles</h2>
                    <p class="text-sm text-gray-600">Reach travelers looking for rentals</p>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#3CC0E9] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">Earn more revenue</h2>
                    <p class="text-sm text-gray-600">Competitive rates and low commission</p>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1">24/7 Support</h2>
                    <p class="text-sm text-gray-600">We're always here to help you succeed</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}
</script>

@endsection
