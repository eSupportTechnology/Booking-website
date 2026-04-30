<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | {{ config('domains.app_name', 'BookinTour') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-50" style="font-family: 'Poppins', sans-serif;">

    <section class="text-white py-16 bg-[#1F8FB2]">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-[60px] md:text-[80px] font-bold mb-4">403</h1>
            <p class="text-[18px] md:text-[22px]">Access Denied</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-[#1F8FB2] to-[#3CC0E9] rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-4">You don't have permission</h2>
            <p class="text-gray-600 text-lg mb-8">Sorry, you don't have access to this page.</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" class="inline-flex items-center justify-center px-8 py-3 bg-[#1F8FB2] text-white font-semibold rounded-lg hover:opacity-90 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Go to Home
                </a>
                <a href="javascript:history.back()" class="inline-flex items-center justify-center px-8 py-3 border-2 border-[#1F8FB2] text-[#1F8FB2] font-semibold rounded-lg hover:bg-[#1F8FB2] hover:text-white transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Go Back
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
