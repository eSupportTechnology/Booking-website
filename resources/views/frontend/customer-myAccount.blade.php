<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    {{-- Tailwind CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-gray-800">
    <!-- HEADER -->
    <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
        <section class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-start space-y-4 md:space-y-0">
                    <div class="w-full md:w-auto">
                        <div class="flex flex-col items-start space-y-2">
                            <h1 class="text-2xl font-bold" style="font-family: 'Poppins', sans-serif;">{{ config('domains.domain') }}
                            </h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 flex-wrap">
                        <button id="language-button" type="button" class="flex items-center justify-center w-7 h-7 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden">
                            <img src="{{ asset('images/uk.png') }}" alt="UK Flag" class="w-full h-full object-cover rounded-full" />
                        </button>
                        <div id="language-modal" class="fixed top-0 left-0 right-0 bottom-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Select your language
                                    </h3>
                                    <button type="button" class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto dark:hover:bg-gray-600 dark:hover:text-white">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-4 text-base text-gray-500 dark:text-gray-400">Suggested for you</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                            <img src="https://upload.wikimedia.org/wikipedia/en/a/ae/Flag_of_the_United_Kingdom_%281-2%29.svg" alt="English (UK)" class="h-5 w-5" />
                                            <span>English (UK)</span>
                                        </button>
                                        <button class="flex items-center justify-between p-2 space-x-2 text-base font-normal text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/48/Flag_of_Germany.svg" alt="Deutsch" class="h-5 w-5" />
                                            <span>Deutsch</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="hover:underline font-sans">Already a partner?</a>
                        <a href="#" class="bg-[#1F8FB2] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans border border-white">Sign
                            in</a>
                        <a href="#" class="bg-[#3CC0E9] px-4 py-2 rounded hover:bg-[#29ACD5] text-white font-sans">Help</a>
                    </div>
                </div>
            </div>
        </section>
    </header>

    <!-- Hero Section -->
    <section class="text-white pb-72 bg-[#1F8FB2] relative z-0">
        <div class="max-w-7xl pb-6 mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-start gap-6">
                <div class="bg-yellow-400 rounded-full h-20 w-20 flex items-center justify-center text-4xl font-bold text-gray-800 shadow-md border-4 border-white">
                    IS
                </div>
                <div class="flex flex-col justify-center">
                    <h1 class="text-white text-3xl font-bold leading-tight">Hi, Isuru</h1>
                    <span class="text-base -mt-2 font-semibold text-white tracking-wide">
                        Genius <span class="text-yellow-400">Level 1</span>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- rewards: Overlapping both sections -->

    <section class="relative z-0 -mt-72 px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Genius Rewards: main content, spans 2 columns and 2 rows -->
            <div class="lg:col-span-2 lg:row-span-2 scroll-section">
                <div class="bg-white p-8 rounded-2xl shadow-md h-full flex flex-col justify-between">
                    <h2 class="text-2xl font-bold mb-1">You have 2 Genius rewards</h2>
                    <p class="text-gray-600 mb-4">Enjoy rewards and discounts on select stays and rental cars worldwide</p>
                    <div class="border-t pt-4 relative">
                        <!-- Scroll container -->
                        <div class="scroll-container flex space-x-4 overflow-x-auto scroll-smooth no-scrollbar min-w-full">
                            <!-- Inner grid to preserve original layout inside scroll -->
                            <div class="grid grid-rows-[auto_auto] grid-flow-col gap-x-4 gap-y-1 min-w-max">

                                <!-- Level 1 label -->
                                <div class="row-start-1 flex space-x-2 mb-2">
                                    <span class="inline-flex items-center bg-[#FFD600] text-black font-semibold h-[52px] px-8 py-1 rounded-full text-sm">
                                        <img src="{{ asset('assets/acount/clarity_unlock-line.svg') }}" alt="10% off stays" class="h-4 w-4 mr-2">
                                        Level 1
                                    </span>
                                </div>

                                <!-- Level 2 label -->
                                <div class="row-start-1 col-start-3 flex space-x-2 mb-2">
                                    <span class="inline-flex items-center bg-gray-100 text-gray-500 font-semibold h-[52px] ml-8 px-8 py-1 rounded-full text-sm">
                                        <img src="{{ asset('assets/acount/clarity_lock-line.svg') }}" alt="10% off stays" class="h-4 w-4 mr-2">
                                        Level 2
                                    </span>
                                </div>

                                <!-- Level 1 Reward 1 -->
                                <div class="row-start-2 bg-white border-2 border-[#35C1EA] rounded-xl shadow-sm flex flex-col items-center p-8 max-w-[180px]">
                                    <img src="{{ asset('assets/acount/GeniusRewardGiftBoxDiscount 1.svg') }}" alt="10% off stays" class="h-16 w-16 mb-2">
                                    <span class="font-semibold text-black text-center">10% off stays</span>
                                </div>

                                <!-- Level 1 Reward 2 -->
                                <div class="row-start-2 bg-white border-2 border-[#35C1EA] rounded-xl shadow-sm flex flex-col items-center p-8 max-w-[180px]">
                                    <img src="{{ asset('assets/acount/GeniusCarBenefit.svg') }}" alt="10% off discounts on rental cars" class="h-16 w-16 mb-2">
                                    <span class="font-semibold text-black text-center">10% off discounts on rental cars</span>
                                </div>

                                <!-- Level 2 Reward 1 -->
                                <div class="row-start-2 bg-gray-100 rounded-xl shadow-sm flex flex-col items-center ml-8 p-8 max-w-[180px]">
                                    <img src="{{ asset('assets/acount/GeniusRewardGiftBoxDiscount 2.svg') }}" alt="10%-15% off stays" class="h-16 w-16 mb-2 grayscale">
                                    <span class="font-semibold text-black text-center">10%-15% off stays</span>
                                </div>

                                <!-- Level 2 Reward 2 -->
                                <div class="row-start-2 bg-gray-100 rounded-xl shadow-sm flex flex-col items-center p-8 max-w-[180px]">
                                    <img src="{{ asset('assets/acount/GeniusCarBenefit (1).svg') }}" alt="10%-15% discounts on rental cars" class="h-16 w-16 mb-2 grayscale">
                                    <span class="font-semibold text-black text-center">10%-15% discounts on rental cars</span>
                                </div>

                                <!-- Level 2 Reward 3 -->
                                <div class="row-start-2 bg-gray-100 rounded-xl shadow-sm flex flex-col items-center p-8 max-w-[180px]">
                                    <img src="{{ asset('assets/acount/GeniusRewardFreeBreakfast.svg') }}" alt="Free breakfast" class="h-16 w-16 mb-2 grayscale">
                                    <span class="font-semibold text-black text-center">Free breakfast</span>
                                </div>

                                <!-- Level 2 Reward 4 -->
                                <div class="row-start-2 bg-gray-100 rounded-xl shadow-sm flex flex-col items-center p-8 max-w-[180px]">
                                    <img src="{{ asset('assets/acount/GeniusRewardFreeRoomUpgrade.svg') }}" alt="Free room upgrade" class="h-16 w-16 mb-2 grayscale">
                                    <span class="font-semibold text-black text-center">Free room upgrade</span>
                                </div>
                            </div>
                        </div>

                        <!-- Scroll Left Arrow -->
                        <button class="scroll-left absolute top-1/2 left-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100" style="margin-left:-20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <!-- Scroll Right Arrow -->
                        <button class="scroll-right absolute top-1/2 right-0 -translate-y-1/2 bg-white border shadow p-2 rounded-full z-10 hover:bg-gray-100" style="margin-right:-20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <a href="#" class="text-[#35C1EA] font-medium mt-4 block">Learn more about your rewards</a>

                </div>
            </div>
            <!-- Sidebar1: Genius Progress -->
            <div>
                <div class="bg-white p-6 rounded-xl shadow flex flex-col justify-between min-h-[110px] h-full">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/acount/GeniusAllBookingsStamp.svg') }}" alt="Genius" class="h-10 w-10">
                        <p class="font-bold text-gray-800">You're 5 bookings away from Genius Level 2</p>
                    </div>
                    <a href="#" class="text-[#35C1EA] font-semibold text-sm hover:underline mt-1 inline-block">Check your progress</a>
                </div>
            </div>
            <!-- Sidebar2: Vouchers -->
            <div>
                <div class="bg-white p-6 rounded-xl shadow flex flex-col justify-between min-h-[110px] h-full">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-gray-500">No credit or vouchers yet</p>
                        <span class="font-bold text-gray-400">0</span>
                    </div>
                    <div class="border-t mt-4 pt-4">
                        <a href="#" class="text-[#35C1EA] font-medium text-sm hover:underline">More Details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Main Content -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-3 space-y-8">
                <!-- Complete Your Profile -->
                <div class="bg-white p-8 rounded-2xl shadow-md">
                    <div class="flex flex-col lg:flex-row items-start gap-6">
                        <!-- Avatar Image: Top on mobile, Right on desktop -->
                        <div class="order-1 lg:order-2 flex-shrink-0 self-center rounded-2xl p-8 bg-[rgba(60,192,233,0.09)]">
                            <img src="{{ asset('assets/acount/bx_user.svg') }}" alt="User" class="h-8 w-8" />
                        </div>

                        <!-- Left Side (Text + Buttons) -->
                        <div class="order-2 lg:order-1 flex-1 flex flex-col justify-between items-start text-center lg:text-left">
                            <!-- Title + Description -->
                            <div>
                                <h2 class="text-xl font-bold">Complete your profile</h2>
                                <p class="text-gray-600 mt-1">
                                    Complete your profile and use this information for your next booking
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex flex-col sm:flex-row gap-3 w-full sm:w-auto justify-center sm:justify-start">
                                <a href="#" class="bg-[#35C1EA] text-white px-6 py-2 rounded-md hover:bg-[#35C1EA]/90 text-sm font-semibold w-full sm:w-auto text-center transition">
                                    Complete now
                                </a>
                                <button class="text-[#35C1EA] font-medium text-sm hover:underline w-full sm:w-auto text-center bg-transparent">
                                    Not now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Main sections grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Payment info -->
                    <div class="bg-white p-7 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="font-bold text-lg mb-5">Payment info</h3>
                        <ul class="space-y-5">
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/wallet 1.svg') }}" alt="wallet" class="h-7 w-7 mr-4" /><span class="flex-grow">Rewards & Wallet</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/bi_card-text.svg') }}" alt="payment" class="h-7 w-7 mr-4" /><span class="flex-grow">Payment methods</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                        </ul>
                    </div>

                    <!-- Manage account -->
                    <div class="bg-white p-7 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="font-bold text-lg mb-5">Manage account</h3>
                        <ul class="space-y-5">
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/bx_user.svg') }}" alt="user" class="h-7 w-7 mr-4" /><span class="flex-grow">Personal details</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/clarity_lock-line.svg') }}" alt="security" class="h-7 w-7 mr-4" /><span class="flex-grow">Security settings</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/mingcute_group-2-line.svg') }}" alt="travelers" class="h-7 w-7 mr-4" /><span class="flex-grow">Other travelers</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                        </ul>
                    </div>

                    <!-- Preferences -->
                    <div class="bg-white p-7 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="font-bold text-lg mb-5">Preferences</h3>
                        <ul class="space-y-5">
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/mi_filter.svg') }}" alt="customization" class="h-7 w-7 mr-4" /><span class="flex-grow">Customization preferences</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/fontisto_email.svg') }}" alt="email" class="h-7 w-7 mr-4" /><span class="flex-grow">Email preferences</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                        </ul>
                    </div>

                    <!-- Travel activity -->
                    <div class="bg-white p-7 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="font-bold text-lg mb-5">Travel activity</h3>
                        <ul class="space-y-5">
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/hugeicons_luggage-01.svg') }}" alt="trips" class="h-7 w-7 mr-4" /><span class="flex-grow">Trips & Bookings</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/mdi-light_heart.svg') }}" alt="saved" class="h-7 w-7 mr-4" /><span class="flex-grow">Saved lists</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/iconamoon_comment-thin.svg') }}" alt="reviews" class="h-7 w-7 mr-4" /><span class="flex-grow">My reviews</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                        </ul>
                    </div>

                    <!-- Help and support -->
                    <div class="bg-white p-7 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="font-bold text-lg mb-5">Help and support</h3>
                        <ul class="space-y-5">
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/qlementine-icons_question-32.svg') }}" alt="support" class="h-7 w-7 mr-4" /><span class="flex-grow">Contact customer service</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/ph_lifebuoy-thin.svg') }}" alt="safety" class="h-7 w-7 mr-4" /><span class="flex-grow">Safety resource center</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/ph_handshake-thin.svg') }}" alt="dispute" class="h-7 w-7 mr-4" /><span class="flex-grow">Dispute resolution</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                        </ul>
                    </div>

                    <!-- Legal and privacy -->
                    <div class="bg-white p-7 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="font-bold text-lg mb-5">Legal and privacy</h3>
                        <ul class="space-y-5">
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/lsicon_shield-outline.svg') }}" alt="privacy" class="h-7 w-7 mr-4" /><span class="flex-grow">Privacy and data management</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/fluent-mdl2_edit-note.svg') }}" alt="content" class="h-7 w-7 mr-4" /><span class="flex-grow">Content guidelines</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                        </ul>
                    </div>

                    <!-- Manage your property -->
                    <div class="bg-white p-7 rounded-2xl shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="font-bold text-lg mb-5">Manage your property</h3>
                        <ul class="space-y-5">
                            <li><a href="#" class="flex items-center text-gray-800 hover:text-[#35C1EA] group"><img src="{{ asset('assets/acount/bi_house-add.svg') }}" alt="property" class="h-7 w-7 mr-4" /><span class="flex-grow">List your property</span><span class="text-gray-300 text-lg group-hover:text-[#35C1EA] transition">&gt;</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tailwind scroll styling -->
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <!-- Scroll button script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollSections = document.querySelectorAll('.scroll-section');
            const scrollAmount = 648;

            scrollSections.forEach(section => {
                const scrollContainer = section.querySelector('.scroll-container');
                const scrollLeftBtn = section.querySelector('.scroll-left');
                const scrollRightBtn = section.querySelector('.scroll-right');

                function toggleArrows() {
                    const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                    scrollLeftBtn.classList.toggle('hidden', scrollContainer.scrollLeft <= 0);
                    scrollRightBtn.classList.toggle('hidden', scrollContainer.scrollLeft >= maxScrollLeft -
                        10);
                }

                scrollLeftBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                    setTimeout(toggleArrows, 400);
                });

                scrollRightBtn.addEventListener('click', () => {
                    scrollContainer.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                    setTimeout(toggleArrows, 400);
                });

                scrollContainer.addEventListener('scroll', toggleArrows);

                // Initial visibility check
                toggleArrows();
            });
        });
    </script>
</body>

</html>
