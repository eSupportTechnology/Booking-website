@extends('frontend.master')

@section('title', 'Signin Partner Account | ' . config('domains.app_name'))

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            Partner Sign In
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            Manage your properties and bookings
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">

            <h2 class="text-xl font-semibold mb-4 text-center" style="font-family: 'Noto Sans', sans-serif;">
                Sign in to manage your property
            </h2>

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

            <form method="POST" action="{{ route('partner.login.email') }}">
                @csrf
                <label for="email" class="block text-sm font-medium text-gray-700 mt-4" style="font-family: 'Noto Sans', sans-serif;">
                    Email Address
                </label>
                <input type="email" id="email" name="email" required
                    class="w-full border border-gray-300 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#3CC0E9] focus:border-transparent mb-4"
                    placeholder="Enter your email" />

                <button type="submit"
                    class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition mb-4"
                    style="background-color:#1F8FB2; font-family: 'Noto Sans', sans-serif;">
                    Continue
                </button>

                <button type="button"
                    class="w-full text-[#1F8FB2] font-semibold text-sm py-2 rounded hover:bg-gray-100 transition"
                    style="font-family: 'Noto Sans', sans-serif;">
                    Having trouble signing in?
                </button>
            </form>

            <div class="border-t border-gray-200 my-6"></div>

            <p class="text-sm text-gray-600 text-center" style="font-family: 'Noto Sans', sans-serif;">
                Do you have questions about your property or the extranet?
                <a href="#" class="text-[#1F8FB2] hover:underline">Partner Help</a> or
                ask another question on the <a href="#" class="text-[#1F8FB2] hover:underline">Partner Community</a>
            </p>

            <div class="mt-6">
                <a href="{{ url('partner/register/email') }}"
                    class="block text-center border-2 border-[#1F8FB2] text-[#1F8FB2] hover:bg-[#1F8FB2] hover:text-white rounded-lg py-3 text-sm font-semibold transition"
                    style="font-family: 'Noto Sans', sans-serif;">
                    Create your partner account
                </a>
            </div>

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
            <!-- Card 1 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-16 0H3"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        List your property
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        Reach millions of travelers worldwide
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#3CC0E9] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        Earn more revenue
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        Competitive rates and low commission
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <div class="w-16 h-16 bg-[#1F8FB2] rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        24/7 Partner support
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        We're always here to help you succeed
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
