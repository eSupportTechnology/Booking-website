<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Box</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts: Lato --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <style>
        h3 {
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-cover bg-center h-screen flex items-center justify-center" style="font-family: 'Lato', sans-serif;">

    <!-- Confirmation Modal -->
    <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto">
        <div class="relative w-full max-w-xl min-h-[400px] p-6 bg-white rounded-lg shadow-lg">
            <!-- Close Button -->
            <button type="button"
                class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                aria-label="Close modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="text-center">
                <h3 class="mb-5 text-2xl font-bold"  style="color: rgb(31, 143, 178);">Genius</h3>
                <p class="mt-5 text-base text-gray-500">
                    Welcome, Vikum! You just unlocked Level 1<br>
                    Enjoy a lifetime of travel rewards worldwide - just look for the Genius label to save!
                </p>

                <div class="flex items-center justify-center mb-5 mt-4">
                    <img src="{{ asset('images/gift.png') }}" alt="Gift Icon" class="w-6 h-6 mr-2">
                    <span class="text-sm text-gray-500">10% off select stays</span>
                </div>

                <a href="#" class="text-blue-500 hover:underline text-sm">Learn more about Genius</a>

                <button type="button"
                    class="mt-6 w-full px-4 py-2 text-white rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300"
                    style="background-color: rgb(31, 143, 178);">Got it!</button>
            </div>
        </div>
    </div>

</body>
</html>
