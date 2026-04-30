@extends('frontend.master')

@section('title', 'Verify Email | ' . config('domains.app_name'))

@section('content')

<!-- Hero Section -->
<section class="text-white py-12 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-[32px] md:text-[40px] lg:text-[50px] font-bold mb-4">
            {{ __('messages.Verify your email address') }}
        </h1>
        <p class="text-[18px] md:text-[20px] font-sans">
            Enter the code sent to your email
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-white">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white border border-gray-200 shadow-lg rounded-xl p-8">

            <form method="POST" action="{{ route('customer.verify.otp') }}" id="otp-form">
                @csrf

                @if (session('success'))
                    <div class="mb-4 p-3 rounded bg-green-100 border border-green-400 text-green-700 text-sm" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-sm" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <h2 class="text-xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">
                    {{ __('messages.Verify your email address') }}
                </h2>
                <p class="text-sm text-gray-600 mb-6" style="font-family: 'Noto Sans', sans-serif;">
                    {{ __("messages.We've sent a verification code to") }}<br>
                    <span class="font-semibold text-gray-800">
                        {{ session('customer_email', 'your email') }}
                    </span>. {{ __('messages.Please enter this code to continue.') }}
                </p>

                <!-- Hidden input to collect the full OTP -->
                <input type="hidden" name="otp" id="full-otp">

                <!-- 6 OTP input boxes -->
                <div class="flex justify-between gap-2 mb-4" id="code-container">
                    @for ($i = 0; $i < 6; $i++)
                        <input type="text" maxlength="1" name="otp_{{ $i }}"
                            value="{{ old('otp_' . $i) }}"
                            class="code-input w-12 h-14 text-center text-lg border rounded-lg focus:outline-none focus:ring-2
                            {{ $errors->has('otp') ? 'border-red-500 ring-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-[#3CC0E9]' }}"
                            oninput="handleInput(this, {{ $i }})">
                    @endfor
                </div>

                @if ($errors->has('otp'))
                    <p class="text-red-500 text-sm mb-4">{{ $errors->first('otp') }}</p>
                @endif

                <!-- Verify Button -->
                <button id="verify-btn" disabled
                    class="w-full bg-gray-300 text-white py-3 rounded-lg font-semibold cursor-not-allowed transition"
                    style="font-family: 'Noto Sans', sans-serif;">
                    {{ __('messages.Verify email') }}
                </button>

                <!-- Resend Timer -->
                <p class="text-sm text-gray-600 mt-4 text-center" style="font-family: 'Noto Sans', sans-serif;">
                    {{ __("messages.Didn't receive an email? Please check your spam folder or request another code in") }}
                    <strong id="countdown">60 {{ __('messages.seconds') }}</strong>
                </p>

                <a href="{{ route('customer.login') }}" class="block mt-4 text-[#1F8FB2] hover:underline text-sm text-center"
                    style="font-family: 'Noto Sans', sans-serif;">
                    {{ __('messages.Back to sign in') }}
                </a>
            </form>

            <p class="text-[11px] text-gray-500 text-center mt-6" style="font-family: 'Noto Sans', sans-serif;">
                {{ __('messages.By signing in or creating an account, you agree with our') }}
                <a href="#" class="text-[#1F8FB2] hover:underline">{{ __('messages.Terms & conditions') }}</a>
                {{ __('messages.and') }}
                <a href="#" class="text-[#1F8FB2] hover:underline">{{ __('messages.Privacy statement') }}</a>.
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
    <script src="{{ asset('assets/Customer/js/auth/verify-email.js') }}"></script>
@endpush
