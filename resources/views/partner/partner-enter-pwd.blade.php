@extends('frontend.master')

@section('title', 'Enter Password | ' . config('domains.app_name'))

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            Partner Sign In
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            Welcome back to {{ config('domains.domain') }}
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">

            <h2 class="text-xl font-semibold mb-2 text-center" style="font-family: 'Noto Sans', sans-serif;">
                Enter your password
            </h2>
            <p class="text-gray-600 text-sm mb-1 text-center" style="font-family: 'Noto Sans', sans-serif;">
                Please enter your password for
            </p>
            <p class="text-[#1F8FB2] text-sm mb-6 font-semibold text-center" style="font-family: 'Noto Sans', sans-serif;">
                {{ $email }}
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

            <form method="POST" action="{{ route('partner.login.password') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Password -->
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2" style="font-family: 'Noto Sans', sans-serif;">
                    Password
                </label>
                <div class="relative mb-4">
                    <input type="password" id="password" name="password" required
                           placeholder="Enter your password"
                           class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent @error('password') border-red-500 @enderror" />
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>

                <button type="submit" class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition mb-4"
                        style="background-color:#1F8FB2; font-family: 'Noto Sans', sans-serif;">
                    Sign In
                </button>

                <!-- Forgot Password Link -->
                <div class="text-center mb-4">
                    <a href="{{ route('partner.password.request') }}" class="text-[#1F8FB2] hover:underline text-sm" style="font-family: 'Noto Sans', sans-serif;">
                        Forgot your password?
                    </a>
                </div>
            </form>

            <div class="border-t border-gray-200 my-6"></div>

            <!-- Change Email -->
            <p class="text-sm text-gray-600 text-center mb-4" style="font-family: 'Noto Sans', sans-serif;">
                Not {{ $email }}?
                <a href="{{ route('partner.login.email') }}" class="text-[#1F8FB2] hover:underline">Use a different email</a>
            </p>

            <p class="text-sm text-gray-600 text-center" style="font-family: 'Noto Sans', sans-serif;">
                Don't have an account?
                <a href="{{ route('partner.register.email-create') }}" class="text-[#1F8FB2] hover:underline">Create one</a>
            </p>

            <div class="border-t border-gray-200 my-6"></div>

            <p class="text-[11px] text-gray-500 text-center" style="font-family: 'Noto Sans', sans-serif;">
                By signing in, you agree with our
                <a href="#" class="text-[#1F8FB2] hover:underline">Terms & conditions</a> and
                <a href="#" class="text-[#1F8FB2] hover:underline">Privacy statement</a>.
            </p>

            <p class="text-[11px] text-gray-400 text-center mt-2" style="font-family: 'Noto Sans', sans-serif;">
                {{ config('domains.domain') }}
            </p>
        </div>
    </div>
</section>

<script>
    function togglePassword() {
        const field = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (field.type === 'password') {
            field.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
        } else {
            field.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }
    }
</script>

@endsection
