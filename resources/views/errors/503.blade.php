<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance | {{ config('domains.app_name', 'BookinTour') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin-slow 8s linear infinite; }
    </style>
</head>
<body class="min-h-screen bg-gray-50" style="font-family: 'Poppins', sans-serif;">

    <section class="text-white py-16 bg-[#1F8FB2]">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-[60px] md:text-[80px] font-bold mb-4">Maintenance</h1>
            <p class="text-[18px] md:text-[22px]">We'll be back shortly</p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-[#1F8FB2] to-[#3CC0E9] rounded-full flex items-center justify-center animate-spin-slow">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-4">Under Maintenance</h2>
            <p class="text-gray-600 text-lg mb-8">We're performing scheduled maintenance. Please check back soon!</p>

            <a href="javascript:location.reload()" class="inline-flex items-center justify-center px-8 py-3 bg-[#1F8FB2] text-white font-semibold rounded-lg hover:opacity-90 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh Page
            </a>
        </div>
    </section>

    <footer class="bg-[#1F8FB2] text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">© {{ date('Y') }} {{ config('domains.domain', 'BookinTour.com') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
