@extends('frontend.master')

@section ('title', 'Home')

@section('content')


    <!-- Header -->
    <header class="w-full bg-blue-800 py-4 px-4 sm:px-6 flex justify-between items-center">
        <h1 class="text-white text-xl font-bold">Booking.com</h1>
        <div class="flex items-center space-x-4">
            <img src="https://flagcdn.com/gb.svg" alt="English" class="w-6 h-4">
            <button class="text-white text-lg">?</button>
        </div>
    </header>

    <!-- Main content wrapper to center on screen -->
    <main class="min-h-screen flex items-center justify-center px-4 sm:px-6">
        <!-- Login Box -->
        <div class="bg-white w-full max-w-md p-6 sm:p-8 mt-8 sm:mt-12 shadow-md rounded border border-gray-200 text-center">
            <h2 class="text-2xl font-semibold mb-2">Sign in or create an account</h2>
            <p class="text-gray-600 text-sm mb-6">
                You can sign in using your Booking.com account to access our services.
            </p>

            <!-- Email Input -->
            <div class="mb-4 text-left">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input id="email" type="email" placeholder="Enter your email address"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Continue Button -->
            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 mb-4">
                Continue with email
            </button>

            <!-- Divider -->
            <div class="flex items-center my-4">
                <hr class="flex-grow border-gray-300">
                <span class="mx-4 text-sm text-gray-500">or use one of these options</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <!-- Social Icons -->
            <div class="flex justify-center space-x-4 mb-4">
                <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-6 h-6">
                </button>
                <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                    <img src="https://www.svgrepo.com/show/452234/apple.svg" alt="Apple" class="w-6 h-6">
                </button>
                <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                    <img src="https://www.svgrepo.com/show/475700/facebook-color.svg" alt="Facebook" class="w-6 h-6">
                </button>
            </div>

            <!-- Terms -->
            <p class="text-xs text-gray-500 mt-6">
                By signing in or creating an account, you agree with our 
                <a href="#" class="text-blue-600 underline">Terms & conditions</a> and 
                <a href="#" class="text-blue-600 underline">Privacy statement</a>.
            </p>

            <p class="text-xs text-gray-500 mt-2">
                © 2006 – 2025 Booking.com™
            </p>
        </div>
    </main>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection
