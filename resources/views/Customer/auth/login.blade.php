@vite(['resources/js/app.js'])
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<!-- Header -->
<header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
    <section class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <!-- Logo -->
                <div class="w-full md:w-auto md:ml-6">
                    @php
                        $host = config('domains.app_name');
                    @endphp
                    <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                        @if($host == 'BookinTour')
                            <h1>Bookintour.com</h1>
                        @elseif ($host == 'Inselor')
                            <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto align-middle" />
                        @endif
                    </a>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto"
                    style="font-family: 'Noto Sans', sans-serif;">
                    <!-- Help Icon -->
                    <a href="/help" title="Help" class="ml-2">
                        <img src="{{ asset('assets/question.svg') }}" alt="Help"
                            class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                    </a>

                    
                </div>
            </div>
        </div>
    </section>
</header>

<!-- Main Content -->
<main class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full h-screen sm:w-[28rem] sm:h-auto bg-white p-6 sm:p-8 sm:rounded-lg shadow-md flex flex-col justify-center">
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

        <h2 class="text-2xl font-semibold mb-2" style="font-family: 'Noto Sans', sans-serif;">
            {{ __('messages.Sign in or create an account') }}
        </h2>
        <p class="text-gray-600 text-sm mb-6" style="font-family: 'Noto Sans', sans-serif;">
            {{ __('messages.You can sign in using your') }}
            {{ config('domains.subdomain') }}
            {{ __('messages.account to access our services.') }}
        </p>

        <form method="POST" action="{{ route('customer.request.otp') }}" class="needs-validation" novalidate>
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __('messages.Email address') }}
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="Enter your email address" required
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2
                       {{ $errors->has('email') ? 'border-red-500 ring-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500' }}">
            </div>

            <button type="submit" class="w-full text-white py-3 rounded hover:bg-blue-700 mb-4"
                    style="background-color:#3CC0E9; font-family: 'Noto Sans', sans-serif;">
                {{ __('messages.Continue with email') }}
            </button>
        </form>

        <div class="flex items-center my-4">
            <hr class="flex-grow border-gray-300">
            <span class="mx-4 text-sm text-gray-500"> {{ __('messages.or use one of these options') }} </span>
            <hr class="flex-grow border-gray-300">
        </div>

        <div class="flex justify-center space-x-4 mb-4">
            <a href="{{ route('customer.google.auth') }}" class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                <img src="{{ asset('images/google.png') }}" alt="Google" class="w-6 h-6">
            </a>
            <a href="{{ route('auth.apple') }}" class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                <img src="{{ asset('images/apple.png') }}" alt="Apple" class="w-6 h-6">
            </a>
            <a href="{{ route('auth.facebook') }}" class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-6 h-6">
            </a>
        </div>

        <p class="text-xs text-gray-500 mt-6 text-center">
            {{ __('messages.By signing in or creating an account, you agree with our') }}
            <a href="#" class="text-blue-600 underline">{{ __('messages.Terms & conditions') }}</a>
            {{ __('messages.and') }}
            <a href="#" class="text-blue-600 underline">{{ __('messages.Privacy statement') }}</a>.
        </p>

        <p class="text-xs text-gray-500 mt-6 text-center">
            <span class="block">All rights reserved</span>
            <span class="block">© 2006 – 2025 {{ config('domains.domain') }}™</span>
        </p>
    </div>
</main>


<script src="https://cdn.tailwindcss.com"></script>
@push('scripts')
    <script src="{{ asset('assets/Customer/js/auth/login.js') }}"></script>
@endpush
@stack('scripts')
