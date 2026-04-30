<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error | {{ config('domains.app_name', 'BookinTour') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-50" style="font-family: 'Poppins', sans-serif;">

    <!-- Hero Section -->
    <section class="text-white py-16 bg-[#1F8FB2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-[60px] md:text-[80px] font-bold mb-4">Oops!</h1>
            <p class="text-[18px] md:text-[22px]" style="font-family: 'Noto Sans', sans-serif;">
                Something went wrong on our end
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 text-center">
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-[#1F8FB2] to-[#3CC0E9] rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-4">Server Error</h2>
            <p class="text-gray-600 text-lg mb-8" style="font-family: 'Noto Sans', sans-serif;">
                We're experiencing some technical difficulties. Our team has been notified.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" class="inline-flex items-center justify-center px-8 py-3 bg-[#1F8FB2] text-white font-semibold rounded-lg hover:opacity-90 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Go to Home
                </a>
                <a href="javascript:location.reload()" class="inline-flex items-center justify-center px-8 py-3 border-2 border-[#1F8FB2] text-[#1F8FB2] font-semibold rounded-lg hover:bg-[#1F8FB2] hover:text-white transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Try Again
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-[#1F8FB2] text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">© {{ date('Y') }} {{ config('domains.domain', 'BookinTour.com') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
