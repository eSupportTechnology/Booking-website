<!DOCTYPE html>
<html lang="en" x-data="{ step: 1 }">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>9-Step Wizard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <header class="text-white px-4 py-2" style="background-color:#1F8FB2;">
        <section class="py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                    <!-- Logo -->
                    <div class="w-full md:w-auto md:ml-6">
                        <!-- Logo -->
                        @php
                            $host = config('domains.app_name');

                        @endphp

                        <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
                            @if ($host == 'BookinTour')
                                <h1>Bookintour.com</h1>
                            @elseif ($host == 'Inselor')
                                <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor"
                                    class="h-12 w-auto align-middle" />
                            @endif
                        </a>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4 text-sm font-medium md:ml-auto font-sans">
                        <!-- Help Icon -->
                        <a href="/help" title="Help">
                            <img src="{{ asset('assets/question.svg') }}" alt="Help"
                                class="w-6 h-6 md:w-7 md:h-7 cursor-pointer" />
                        </a>

                        <!-- Language Button -->
                        <button id="language-button" type="button"
                            class="flex items-center justify-center w-8 h-8 bg-white rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 overflow-hidden"
                            title="Change Language">
                            <img src="{{ asset('images/uk.png') }}" alt="UK Flag"
                                class="w-full h-full object-cover rounded-full" />
                        </button>

                        <!-- Language Modal -->
                        <div id="language-modal"
                            class="fixed inset-0 hidden z-50 overflow-y-auto flex items-start justify-center px-4 py-8 bg-black bg-opacity-50">
                            <div class="relative w-full max-w-md p-6 bg-white rounded-lg shadow">
                                <!-- Modal Header -->
                                <div class="flex items-start justify-between">
                                    <h3 class="text-xl font-semibold text-gray-900">Select your language</h3>
                                    <button type="button"
                                        class="close-btn text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="mt-4">
                                    <p class="mb-4 text-base text-gray-500">Suggested for you</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                            <img src="https://flagcdn.com/w40/gb.png" alt="English (UK)"
                                                class="h-5 w-5" />
                                            <span>English (UK)</span>
                                        </button>
                                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                                            <img src="https://flagcdn.com/w40/de.png" alt="Deutsch" class="h-5 w-5" />
                                            <span>Deutsch</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </header>
    <div class="mt-16">
        <div class="max-w-3xl mx-auto p-4 space-y-4 ">

            <!-- Step 1 - Completed -->
            <div class="border border-gray-300 border rounded-lg p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/flat-color-icons_ok.svg') }}" alt="Icon"
                        class="w-6 h-6 md:w-7 md:h-7" />
                    <div>
                        <p class="text-sm text-gray-500">Step 1</p>
                        <h2 class="text-base font-semibold">Property details</h2>
                        <p class="text-xs text-gray-600">The basics, Add your property name, address, facilities and
                            more</p>
                    </div>
                </div>
                <a href="{{ route('partner.hotels.create.2') }}"
                    class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
            </div>

            <div class="border border-gray-300 rounded-lg p-4 flex flex-col gap-6">

                <!-- Step 2 Header -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img src="assets/Group 3926.svg" alt="Icon" class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 2</p>
                            <h2 class="text-base font-semibold">Rooms</h2>
                            <p class="text-xs text-gray-600">Tell us about your first room. Once you’ve set one up you
                                can add more.</p>
                        </div>
                    </div>

                </div>

                <!-- Room Card -->
                <div class="space-y-4 ">

                    <!-- Room Card 1 -->
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 border border-gray-200 rounded-lg shadow-sm bg-gray-100 ">
                        <!-- Room Image -->
                        <img src="{{ asset('images/room.jpg') }}" alt="Room Image"
                            class="w-24 h-24 object-cover rounded-md" />

                        <!-- Horizontal Info Table -->
                        <div class="flex-1 overflow-x-auto">
                            <p class="text-sm text-gray-600 font-semibold mb-2">Double Room</p>
                            <table class="w-full text-xs b">
                                <thead>
                                    <tr class="text-gray-500 text-left whitespace-nowrap">
                                        <th class="pr-6 border-r border-gray-300">Guests</th>
                                        <th class="pr-6 border-r border-gray-300">Beds</th>
                                        <th class="pr-6 border-r border-gray-300">Bathroom</th>
                                        <th class="pr-6 border-r border-gray-300">Price</th>
                                        <th class="pr-6 ">Rooms of this type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-gray-800 text-xs">
                                        <td class="pr-6 border-r border-gray-300">3</td>
                                        <td class="pr-6 border-r border-gray-300">1</td>
                                        <td class="pr-6 border-r border-gray-300">private</td>
                                        <td class="pr-6 border-r border-gray-300">$20</td>
                                        <td class="pr-6 border-gray-300">2</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 mt-4 sm:mt-0">
                            <button class="text-sky-600 text-sm hover:underline">Edit</button>
                            <button class="text-red-600 text-sm hover:underline">Delete</button>
                        </div>
                    </div>

                </div>

                <!-- Add Another Room -->
                <div class="text-right">

                    <a href="{{ route('partner.hotels.rooms') }}">
                        <button
                            class="mt-4  text-sky-600 text-sm font-semibold px-4 py-2 rounded border border-sky-300 hover:bg-sky-100">
                            + Add another room
                        </button></a>
                </div>
            </div>





            <!-- Step 3 - Photos -->
            <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center ">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                        class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                    <div>
                        <p class="text-sm text-gray-500">Step 3</p>
                        <h2 class="text-base font-semibold">Photos</h2>
                        <p class="text-xs text-gray-600">Share some photos of your property so guests know what to
                            expect.</p>
                    </div>
                </div>
                <a href="{{ route('partner.hotels.photos') }}"
                    class="text-sky-600 font-medium text-sm hover:underline">Edit</a>

            </div>

            <!-- Step 4 - Final -->
            <div class=" border border-gray-300 rounded-lg p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                        class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                    <div>
                        <p class="text-sm text-gray-500">Step 4</p>
                        <h2 class="text-base font-semibold">Final steps</h2>
                        <p class="text-xs text-gray-600">Set up payments and invoicing before you open for bookings.
                        </p>
                    </div>
                </div>

                <a href="{{ route('partner.hotels.payments') }}"
                    class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
            </div>


            <div class="flex justify-center">
                <button
                    class="mt-4 w-full  bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow">
                    Complete Registration
                </button>
            </div>
        </div>
</body>

</html>
