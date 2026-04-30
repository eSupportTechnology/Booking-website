@extends('frontend.master')

@section('title', 'Sign In | ' . config('domains.app_name'))

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            {{ __('messages.Sign in or create an account') }}
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            {{ __('messages.You can sign in using your') }} {{ config('domains.subdomain') }} {{ __('messages.account to access our services.') }}
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <h2 class="text-xl font-semibold mb-2 text-center" style="font-family: 'Noto Sans', sans-serif;">
                {{ __('messages.Sign in or create an account') }}
            </h2>
            <p class="text-gray-600 text-sm mb-6 text-center" style="font-family: 'Noto Sans', sans-serif;">
                Enter your email to sign in or create a new account
            </p>

            <form method="POST" action="{{ route('customer.request.otp') }}" class="needs-validation" novalidate>
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('messages.Email address') }}
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           placeholder="Enter your email address" required
                           class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2
                           {{ $errors->has('email') ? 'border-red-500 ring-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#3CC0E9]' }}">
                </div>

                <button type="submit" class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition mb-4"
                        style="background-color:#1F8FB2; font-family: 'Noto Sans', sans-serif;">
                    {{ __('messages.Continue with email') }}
                </button>
            </form>

            <div class="border-t border-gray-200 my-6"></div>

            <p class="text-sm text-gray-600 text-center mb-4" style="font-family: 'Noto Sans', sans-serif;">
                Don't have an account?
            </p>
            <a href="{{ route('customer.register') }}"
               class="block text-center border-2 border-[#1F8FB2] text-[#1F8FB2] hover:bg-[#1F8FB2] hover:text-white rounded-lg py-3 text-sm font-semibold transition mb-4"
               style="font-family: 'Noto Sans', sans-serif;">
                Create Account
            </a>

            <p class="text-xs text-gray-500 mt-6 text-center" style="font-family: 'Noto Sans', sans-serif;">
                {{ __('messages.By signing in or creating an account, you agree with our') }}
                <a href="#" class="text-[#1F8FB2] underline">{{ __('messages.Terms & conditions') }}</a>
                {{ __('messages.and') }}
                <a href="#" class="text-[#1F8FB2] underline">{{ __('messages.Privacy statement') }}</a>.
            </p>

            <p class="text-xs text-gray-400 mt-4 text-center" style="font-family: 'Noto Sans', sans-serif;">
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
                <img src="{{ asset('images/cal.png') }}" alt="Calendar" class="w-16 h-16 object-cover rounded-md mr-4" onerror="this.style.display='none'">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Book now, pay at the property')}}
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.FREE cancellation on most rooms')}}
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/world.png') }}" alt="World" class="w-16 h-16 object-cover rounded-md mr-4" onerror="this.style.display='none'">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.2+ million properties worldwide')}}
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Hotels, guest houses, apartments, and more...')}}
                    </p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white shadow-md rounded-lg flex flex-row items-center p-4 w-full md:w-1/3 border border-gray-300">
                <img src="{{ asset('images/man.png') }}" alt="Support" class="w-16 h-16 object-cover rounded-md mr-4" onerror="this.style.display='none'">
                <div class="flex flex-col justify-between">
                    <h2 class="text-sm font-semibold text-gray-800 mb-1" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Trusted customer service you can rely on, 24/7')}}
                    </h2>
                    <p class="text-sm text-gray-600" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __("messages.We're always here to help")}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('assets/Customer/js/auth/login.js') }}"></script>
@endpush
