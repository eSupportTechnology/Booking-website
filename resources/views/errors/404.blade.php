<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon | {{ config('domains.app_name', 'BookinTour') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    <style>
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(60, 192, 233, 0.4); }
            50% { box-shadow: 0 0 40px rgba(60, 192, 233, 0.8); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes progress {
            0% { width: 0%; }
            100% { width: 75%; }
        }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-progress { animation: progress 2s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen bg-gray-50" style="font-family: 'Poppins', sans-serif;">

    <!-- Hero Section -->
    <section class="text-white py-16 bg-[#1F8FB2] relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 border-4 border-white rounded-full"></div>
            <div class="absolute bottom-10 right-10 w-48 h-48 border-4 border-white rounded-full"></div>
            <div class="absolute top-1/2 left-1/4 w-24 h-24 border-4 border-white rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-[50px] md:text-[70px] lg:text-[90px] font-bold mb-4 animate-float">
                Coming Soon
            </h1>
            <p class="text-[18px] md:text-[22px]" style="font-family: 'Noto Sans', sans-serif;">
                We're working hard to bring you something amazing
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 text-center">

            <!-- Animated Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-gradient-to-br from-[#1F8FB2] to-[#3CC0E9] rounded-full flex items-center justify-center animate-pulse-glow">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-4">
                This Page is Under Construction
            </h2>

            <p class="text-gray-600 text-lg mb-8" style="font-family: 'Noto Sans', sans-serif;">
                We're putting the finishing touches on this page. Check back soon for updates!
            </p>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 rounded-full h-3 mb-4 overflow-hidden">
                <div class="bg-gradient-to-r from-[#1F8FB2] to-[#3CC0E9] h-3 rounded-full animate-progress"></div>
            </div>

            <p class="text-sm text-gray-500 mb-8" style="font-family: 'Noto Sans', sans-serif;">
                75% Complete
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/"
                    class="inline-flex items-center justify-center px-8 py-3 bg-[#1F8FB2] text-white font-semibold rounded-lg hover:opacity-90 transition shadow-lg"
                    style="font-family: 'Noto Sans', sans-serif;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Go to Home
                </a>
                <a href="javascript:history.back()"
                    class="inline-flex items-center justify-center px-8 py-3 border-2 border-[#1F8FB2] text-[#1F8FB2] font-semibold rounded-lg hover:bg-[#1F8FB2] hover:text-white transition"
                    style="font-family: 'Noto Sans', sans-serif;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Go Back
                </a>
            </div>
        </div>
    </section>

    <!-- Features Coming Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-center text-gray-800 mb-12">
                What's Coming
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto bg-[#1F8FB2] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2" style="font-family: 'Noto Sans', sans-serif;">
                        Fast & Reliable
                    </h4>
                    <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                        Lightning-fast booking experience
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto bg-[#3CC0E9] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2" style="font-family: 'Noto Sans', sans-serif;">
                        Secure & Safe
                    </h4>
                    <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                        Your data is protected with us
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto bg-[#1F8FB2] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2" style="font-family: 'Noto Sans', sans-serif;">
                        24/7 Support
                    </h4>
                    <p class="text-gray-600 text-sm" style="font-family: 'Noto Sans', sans-serif;">
                        We're always here to help
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#1F8FB2] text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-sm" style="font-family: 'Noto Sans', sans-serif;">
                © {{ date('Y') }} {{ config('domains.domain', 'BookinTour.com') }}. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
