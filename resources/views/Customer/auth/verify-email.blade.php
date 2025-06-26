<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" min-h-screen ">

    <!-- HEADER START -->
    <header class="text-white px-4 py-2 w-full" style="background-color:#1F8FB2;">
        <section class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <div class="w-full md:w-auto md:ml-6">
                        <a href="/" class="text-2xl font-bold">
                            <h1 style="font-family: 'Poppins', sans-serif;">Bookintour.com</h1>
                        </a>
                    </div>

                    <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto"
                        style="font-family: 'Noto Sans', sans-serif;">
                        <a href="/help" title="Help" class="ml-2">
                            <img src="{{ asset('assets/question.svg') }}" alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                        </a>

                        <!-- Language Button -->
                        @php
                            $locale = app()->getLocale();
                            $language = config('languages.' . $locale);
                            $flag = isset($language['flag']) ? asset($language['flag']) : asset('images/flags/uk.png');
                        @endphp

                        <button id="language-button" type="button"
                            class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden">
                            <img src="{{ $flag }}" alt="{{ $language['name'] ?? 'Language' }}"
                                class="w-full h-full object-cover rounded-full" />
                        </button>

                        <!-- Modal -->
                        <div id="language-modal"
                            class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                                <!-- Modal Header -->
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                        Select your language
                                    </h3>
                                    <button type="button"
                                        class="close-btn text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mt-4">
                                    <p class="mb-4 text-base text-gray-500 dark:text-gray-400">
                                        Suggested for you
                                    </p>
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach (config('languages') as $code => $lang)
                                            <a href="{{ route('lang.change', ['lang' => $code]) }}">
                                                <button
                                                    class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                                    <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}"
                                                        class="h-5 w-5" />
                                                    <span>{{ $lang['name'] }}</span>
                                                </button>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal End -->
                    </div>
                </div>
            </div>
        </section>
    </header>
    <!-- HEADER END -->

    <!-- Main Content -->
    <main class="min-h-screen flex items-start justify-center pt-10 px-4 sm:px-6">
        <div class="bg-white rounded shadow-md w-full max-w-md p-6 sm:p-8 text-center mt-10">
            <div class="text-left mb-6">
                <form method="POST" action="{{ route('customer.verify.otp') }}" id="otp-form">
                    @csrf
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
                    <h1 class="text-2xl font-semibold" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Verify your email address') }}</h1>
                    <p class="text-sm text-gray-700 mt-2" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __("messages.We've sent a verification code to") }}<br>
                        <span class="font-semibold" style="font-family: 'Noto Sans', sans-serif;">
                            {{ session('customer_email', 'your email') }}
                        </span>. {{ __('messages.Please enter this code to continue.') }}
                    </p>

                    <!-- Hidden input to collect the full OTP -->
                    <input type="hidden" name="otp" id="full-otp">

                    {{-- 6 OTP input boxes --}}
                    <div class="flex justify-between gap-2 mb-2 mt-4" id="code-container">
                        @for ($i = 0; $i < 6; $i++)
                            <input type="text" maxlength="1" name="otp_{{ $i }}"
                                value="{{ old('otp_' . $i) }}"
                                class="code-input w-10 h-12 text-center text-lg border rounded focus:outline-none focus:ring-2
                    {{ $errors->has('otp') ? 'border-red-500 ring-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' }}"
                                oninput="handleInput(this, {{ $i }})">
                        @endfor
                    </div>

                    {{-- Single error under boxes (not per box) --}}
                    @if ($errors->has('otp'))
                        <p class="text-red-500 text-sm mt-1">{{ $errors->first('otp') }}</p>
                    @endif

                    <!-- Verify Button -->
                    <button id="verify-btn" disabled
                        class="w-full bg-gray-300 text-white font-semibold py-2 rounded cursor-not-allowed"
                        style="font-family: 'Noto Sans', sans-serif;">
                        {{ __('messages.Verify email') }}
                    </button>
                    <!-- Resend Timer -->
                    <p class="text-sm text-gray-600 mt-4" style="font-family: 'Noto Sans', sans-serif;">
                        {{ __("messages.Didn't receive an email? Please check your spam folder or request another code in") }}
                        <strong id="countdown">60 {{ __('messages.seconds') }}</strong>
                    </p>
                    <a href="{{ route('customer.login') }}" class="block mt-4 text-blue-600 hover:underline text-sm"
                        style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Back to sign in') }}</a>

                    <div class="mt-8 text-xs text-gray-500">
                        <p style="font-family: 'Noto Sans', sans-serif;">
                            {{ __('messages.By signing in or creating an account, you agree with our') }}
                            <a href="#" class="text-blue-600 underline"
                                style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Terms & Conditions') }}</a>
                            {{ __('messages.and') }}
                            <a href="#"
                                class="text-blue-600 underline"style="font-family: 'Noto Sans', sans-serif;">{{ __('messages.Privacy Statement') }}</a>
                        </p>
                        <p class="mt-4 justify-center text-center "style="font-family: 'Noto Sans', sans-serif;">All
                            rights reserved<br>Copyright
                            (2025)
                            – Bookintour™
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @push('scripts')
        <script src="{{ asset('assets/Customer/js/auth/verify-email.js') }}"></script>
    @endpush
    @stack('scripts')
</body>

</html>
