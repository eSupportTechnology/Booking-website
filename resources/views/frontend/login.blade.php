







    
        @vite(['resources/js/app.js'])

    <!-- Main content wrapper to center on screen -->
    <main class="min-h-screen flex items-center justify-center px-4 sm:px-6">
        <!-- Login Box -->
        <div class="bg-white w-full max-w-md p-6 sm:p-8 mt-2 sm:mt-12 text-left" style="margin-top:5px;">
            <h2 class="text-2xl font-semibold mb-2" style="font-family: 'Lato', sans-serif;">Sign in or create an account</h2>
            <p class="text-gray-600 text-sm mb-6" style="font-family: 'Lato', sans-serif;">
                You can sign in using your Booking.com account to access our services.
            </p>

            <!-- Email Input -->
            <div class="mb-4 text-left">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1" style="font-family: 'Lato', sans-serif;">Email address</label>
                <input id="email" type="email" placeholder="Enter your email address"
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Continue Button -->
            <button class="w-full  text-white py-2 rounded hover:bg-blue-700 mb-4" style="font-family: 'Lato', sans-serif;background-color:rgb(31, 143, 178);">
                Continue with email
            </button>

            <!-- Divider -->
            <div class="flex items-center my-4">
                <hr class="flex-grow border-gray-300">
                <span class="mx-4 text-sm text-gray-500" style="font-family: 'Lato', sans-serif;">or use one of these options</span>
                <hr class="flex-grow border-gray-300">
            </div>

            <!-- Social Icons -->
            <div class="flex justify-center space-x-4 mb-4">
                <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                    <img src="{{ asset('images/google.png') }}" alt="Google" class="w-6 h-6">
                </button>
                <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                    <img src="{{ asset('images/apple.png') }}" alt="Apple" class="w-6 h-6">
                </button>
                <button class="border border-gray-300 p-2 rounded hover:bg-gray-50">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-6 h-6">
                </button>
            </div>
            <hr class="flex-grow border-gray-300">
            <!-- Terms -->
            <p class="text-xs text-gray-500 mt-6 text-center" style="font-family: 'Lato', sans-serif;">
                By signing in or creating an account, you agree with our 
                <a href="#" class="text-blue-600 underline" style="font-family: 'Lato', sans-serif;">Terms & conditions</a> and 
                <a href="#" class="text-blue-600 underline" style="font-family: 'Lato', sans-serif;">Privacy statement</a>.
            </p>



          
            <p class="text-xs text-gray-500 mt-6 text-center" style="font-family: 'Lato', sans-serif;">
  <span class="block">All rights reserved</span>
  <span class="block">© 2006 – 2025 HorizonStay™</span>
</p>

        </div>
    </main>
    <script src="https://cdn.tailwindcss.com"></script>

