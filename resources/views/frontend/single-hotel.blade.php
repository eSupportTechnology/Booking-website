@extends('frontend.master')

@section('content')
{{-- Navigation Bar --}}
<section class="text-white py-8 bg-[#1F8FB2] relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    </div>
</section>
<!-- Search Box: Overlapping both sections -->
<div class="relative z-10 -mt-8 px-4">
    <!-- Alpine.js CDN (Required for Dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <form method="GET" class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-1 md:gap-0 border-4 border-yellow-400 max-w-6xl mx-auto overflow-visible text-sm">

        <!-- Destination Selector (Styled Like Guests) -->
        <div x-data="{ open: false, destination: '' }" class="relative px-2 py-1 flex-1 border-r md:border-r border-gray-500">
            <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-6 h-6" style="filter: brightness(0) saturate(100%);" />

                <path d="M10 2a6 6 0 00-6 6c0 4.25 6 10 6 10s6-5.75 6-10a6 6 0 00-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
                <span x-text="destination || 'Where are you going?'" style="font-family: 'Noto Sans', sans-serif;" class="text-gray-800 truncate text-base"></span>
            </button>

            <!-- Dropdown Box -->
            <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
                <template x-for="city in ['New York', 'Los Angeles', 'London', 'Paris', 'Tokyo']" :key="city">
                    <button type="button" @click="destination = city; open = false" class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                        <span x-text="city"></span>
                    </button>
                </template>
            </div>

            <!-- Hidden field to submit the selected destination -->
            <input type="hidden" name="destination" :value="destination">
        </div>

        <!-- Dates Selector -->
        <!-- Include Alpine.js if not already -->
        <!-- Include Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Dropdown with two sections: Check-in/out & Flexible -->
        <div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }" class="relative flex-1 border-t md:border-t-0 md:border-r border-gray-500 px-2 py-1">

            <!-- Dropdown Trigger Button -->
            <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
                <span class="text-gray-800 truncate">
                    <template x-if="activeTab === 'check'">
                        <span><span x-text="checkIn ? checkIn : 'Check-in'" style="font-family: 'Noto Sans', sans-serif;" class="text-base"></span> — <span x-text="checkOut ? checkOut : 'Check-out'" style="font-family: 'Noto Sans', sans-serif;" class="text-base"></span></span>
                    </template>
                    <template x-if="activeTab === 'flexible'">
                        <span x-text="flexibleOption ? flexibleOption : 'Flexible dates'"></span>
                    </template>
                </span>
            </button>

            <!-- Dropdown Content -->
            <div x-show="open" @click.away="open = false" class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-96 right-0 text-gray-800 text-sm" x-transition>
                <!-- Tabs -->
                <nav class="flex border-b border-gray-200 mb-4">
                    <button @click.prevent="activeTab = 'check'" :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'" class="px-4 py-2 border-b-2 font-semibold focus:outline-none">
                        Check-in / Check-out
                    </button>
                    <button @click.prevent="activeTab = 'flexible'" :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'" class="px-4 py-2 border-b-2 font-semibold focus:outline-none">
                        Flexible dates
                    </button>
                </nav>

                <!-- Check-in / Check-out Section -->
                <div x-show="activeTab === 'check'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-1">Check-in Date</label>
                            <input type="date" x-model="checkIn" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none" placeholder="Check-in" />
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 font-semibold mb-1">Check-out Date</label>
                            <input type="date" x-model="checkOut" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none" placeholder="Check-out" />
                        </div>
                    </div>
                </div>

                <!-- Flexible Dates Section -->
                <div x-show="activeTab === 'flexible'" x-transition>
                    <label class="block text-xs text-gray-500 font-semibold mb-1">Select Flexible Dates</label>
                    <select x-model="flexibleOption" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none">
                        <option value="" disabled>Select option</option>
                        <option value="Weekend Getaway">Weekend Getaway</option>
                        <option value="Next Month">Next Month</option>
                        <option value="Anytime">Anytime</option>
                        <option value="Custom Range">Custom Range</option>
                    </select>
                </div>

                <!-- Done Button -->
                <div class="mt-4 text-right">
                    <button @click="open = false" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        Done
                    </button>
                </div>
            </div>
        </div>




        <!-- Guests Selector -->
        <div x-data="{ open: false, adults: 2, children: 0, rooms: 1, pets: false }" class="relative px-2 py-1 flex-1 border-t md:border-t-0 md:border-r border-gray-500">
            <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                <img src="{{ asset('assets/user.svg') }}" alt="Calendar" class="w-5 h-5" />
                <span x-text="`${adults} adults · ${children} children · ${rooms} room${rooms > 1 ? 's' : ''}`" class="text-gray-800 text-base truncate" style="font-family: 'Noto Sans', sans-serif;"></span>
            </button>

            <!-- Guest Dropdown -->
            <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-4 text-sm">
                <!-- Adults -->
                <div class="flex items-center justify-between">
                    <span style="font-family: 'Noto Sans', sans-serif;">Adults</span>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="if(adults > 1) adults--" class="px-2 py-1 bg-gray-200 rounded" style="font-family: 'Noto Sans', sans-serif;">−</button>
                        <span x-text="adults"></span>
                        <button type="button" @click="adults++" class="px-2 py-1 bg-gray-200 rounded" style="font-family: 'Noto Sans', sans-serif;">+</button>
                    </div>
                </div>

                <!-- Children -->
                <div class="flex items-center justify-between">
                    <span>Children</span>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="if(children > 0) children--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                        <span x-text="children"></span>
                        <button type="button" @click="children++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                    </div>
                </div>

                <!-- Rooms -->
                <div class="flex items-center justify-between">
                    <span>Rooms</span>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="if(rooms > 1) rooms--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                        <span x-text="rooms"></span>
                        <button type="button" @click="rooms++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                    </div>
                </div>

                <!-- Pets Toggle -->
                <div class="flex items-center justify-between">
                    <span>Travelling with pets?</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" x-model="pets" class="sr-only peer">
                        <div class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4">
                            </div>
                        </div>
                    </label>
                </div>

                <p class="text-xs text-gray-500">
                    Assistance animals aren’t considered pets.<br>
                    <a href="#" class="text-blue-600 underline">Read more about travelling with assistance
                        animals</a>
                </p>

                <!-- Done Button -->
                <button type="button" @click="open = false" class="block w-full text-center bg-white border border-blue-600 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50">
                    Done
                </button>
            </div>
        </div>

        <!-- Search Button -->
        <div class="px-2 py-1">
            <button type="submit" class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm" style="background-color:#3CC0E9;">
                Search
            </button>
        </div>
    </form>


</div>


<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<section class="py-6 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        Home > Nuwara Elliya > Search Results
        <div class="border-b sticky top-0 bg-white z-50">
            <div class="max-w-6xl mx-auto flex space-x-6 overflow-x-auto text-sm md:text-base whitespace-nowrap px-4 py-2">
                <a href="#overview" class="scroll-link">Overview</a>
                <a href="#info" class="scroll-link">Villa info & price</a>
                <a href="#facilities" class="scroll-link">Facilities</a>
                <a href="#rules" class="scroll-link">House rules</a>
                <a href="#fineprint" class="scroll-link">The fine print</a>
                <a href="#reviews" class="scroll-link">Guest reviews (745)</a>
            </div>
        </div>


    </div>
</section>


<section class="min-h-screen p-4 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-4 bg-white rounded-lg shadow-sm">
            <!-- Left: Title and Info -->
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">La Grande Villa</h1>
                <div class="flex items-center mb-2">
                    @for ($i = 0; $i < 4; $i++) <svg class="w-5 h-5 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                        @endfor
                </div>
                <div class="flex items-center text-gray-600 text-sm">
                    <svg class="w-5 h-5 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                    </svg>
                    No.24, 22000 Nuwara Eliya, Sri Lanka
                </div>
            </div>

            <!-- Right: Actions -->
            <div class="flex flex-col items-start sm:items-end space-y-2">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-blue-400 hover:text-blue-600 cursor-pointer" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow">
                        Reserve
                    </button>
                </div>
                <div class="flex items-center text-blue-400 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.007 12.007 0 002.944 12c0 2.873.996 5.474 2.618 7.594L12 22.944l6.438-3.35C20.004 17.474 21 14.873 21 12a12.007 12.007 0 00-2.382-7.016z" />
                    </svg>
                    We Price Match
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:grid lg:grid-cols-7 lg:grid-rows-5 gap-4 mt-6 h-auto lg:h-[600px]">

            <div class="w-full lg:col-span-5 lg:row-span-5 space-y-4">
                @php
                $images = [
                'h1.jpg',
                'h2.jpg',
                'h3.jpg',
                'h4.jpg',
                'h5.jpg',
                'h6.jpg',
                'h7.jpg',
                'h8.jpg',
                'h9.jpg',
                'h10.jpg',
                ];

                $desktopVisibleImageCount = 8;
                $mobileVisibleImageCount = 3;

                $desktopImages = array_slice($images, 0, $desktopVisibleImageCount);
                $mobileImages = array_slice($images, 0, $mobileVisibleImageCount);

                $remainingCount = count($images) - $desktopVisibleImageCount;
                @endphp


                <div class="hidden lg:grid grid-cols-10 grid-rows-8 gap-2 h-full">
                    @php
                    $positions = [
                    'col-span-7 row-span-6',
                    'col-span-3 row-span-3 col-start-8',
                    'col-span-3 row-span-3 col-start-8 row-start-4',
                    'col-span-2 row-span-2 row-start-7',
                    'col-span-2 row-span-2 col-start-3 row-start-7',
                    'col-span-2 row-span-2 col-start-5 row-start-7',
                    'col-span-2 row-span-2 col-start-7 row-start-7',
                    'col-span-2 row-span-2 col-start-9 row-start-7',
                    ];
                    @endphp
                    @foreach ($desktopImages as $index => $img)
                    <div class="{{ $positions[$index] }} relative overflow-hidden"> {{-- Added overflow-hidden for rounded corners --}}
                        <img src="{{ asset('images/' . $img) }}" class="w-full h-full object-cover rounded-lg" alt="Gallery Image {{ $index + 1 }}">
                        @if ($index === $desktopVisibleImageCount - 1 && $remainingCount > 0)
                        <div onclick="openGalleryModal({{ $desktopVisibleImageCount }})" class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-lg font-bold cursor-pointer hover:bg-opacity-70 transition rounded-lg">
                            {{ $remainingCount }}+ more
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                
                <div class="grid grid-cols-4 grid-rows-2 gap-2 lg:hidden h-[300px] sm:h-[400px]">
                    @php
                    $mobilePositions = ['col-span-3 row-span-2', 'col-start-4', 'col-start-4 row-start-2'];
                    @endphp

                    @foreach ($mobileImages as $index => $img)
                    <div class="{{ $mobilePositions[$index] }} relative overflow-hidden"> {{-- Added overflow-hidden for rounded corners --}}
                        <img src="{{ asset('images/' . $img) }}" class="w-full h-full object-cover rounded-md" alt="Gallery Image {{ $index + 1 }}">
                        @if ($index === $mobileVisibleImageCount - 1 && $remainingCount > 0)
                        <div onclick="openGalleryModal({{ $mobileVisibleImageCount }})" class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-base font-semibold rounded-md cursor-pointer">
                            {{ $remainingCount }}+ more
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- side area -->
            <div class="w-full lg:col-span-2 lg:row-span-5 p-2">
                <div class="h-full flex flex-col justify-between gap-4">

                    <!-- Review Card -->
                    <div class="w-full bg-white border rounded-lg p-4 shadow-md flex-grow space-y-4">
                        <!-- Rating Summary -->
                        <div class="flex justify-between items-start border-b-2">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800">Superb</h2>
                                <p class="text-sm text-gray-500">939 reviews</p>
                            </div>
                            <div class="bg-blue-500 text-white text-sm font-semibold px-2 py-1 rounded">8.6</div>
                        </div>

                        <!-- Review Text -->
                        <div>
                            <h3 class="text-sm font-semibold mb-1 text-gray-700">Guests who stayed here loved</h3>
                            <p class="text-sm text-gray-700 ml-4 italic">“Really comfortable bed, and big spa bath. Enjoyed the pool table as was heavy rain outside, and the Sri Lankan breakfast was delicious! table as was heavy rain outside, and the Sri Lankan breakfast”</p>
                        </div>

                        <!-- Reviewer Info -->
                        <div class="mt-3 flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-600 text-white flex items-center justify-center rounded-full font-semibold">L</div>
                            <div class="flex items-center gap-8">
                                <p class="font-medium text-gray-800 mb-0">Linton</p>
                                <div class="flex justify-between items-center gap-1">
                                    <img src="{{ asset('assets/net.svg') }}" class="w-5 h-3 object-cover rounded-sm" alt="UK Flag">
                                    <span class="text-gray-500 text-xs">United Kingdom</span>
                                </div>
                            </div>
                        </div>

                        <!-- Staff Rating -->
                        <div class="flex justify-between items-center pt-2 border-t">
                            <span class="text-sm font-semibold text-gray-700">Staff</span>
                            <div class="border border-gray-300 px-2 py-0.5 text-sm rounded-md text-gray-800">8.6</div>
                        </div>
                    </div>

                    <!-- Map Section -->
                    <div class="w-full rounded-lg overflow-hidden shadow">
                        <div class="relative">
                            <iframe class="w-full h-44 sm:h-56" loading="lazy" src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed" frameborder="0" allowfullscreen aria-hidden="false" tabindex="0"></iframe>
                            <button class="absolute bottom-2 left-2 bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1 rounded-md shadow">
                                Show on map
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="galleryModal" class="fixed inset-0 -top-20 z-50 bg-black/90 flex items-center justify-center hidden">
        <button onclick="closeGalleryModal()" class="absolute top-20 right-20 text-white text-3xl hover:scale-110 transition">&times;</button>
        <button onclick="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/70 p-3 rounded-full transition">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <img id="modalImage" src="" alt="Gallery Image" class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-xl border border-white/10 transition duration-300">
        <button onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/70 p-3 rounded-full transition">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        <div class="absolute bottom-6 text-white text-sm tracking-wide">
            <span id="imageCounter"></span>
        </div>
    </div>

    <script>
        const images = @json($images);
        let currentIndex = 0;

        function openGalleryModal(startIndex = 0) {
            currentIndex = startIndex;
            updateModalImage();
            document.getElementById('galleryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeGalleryModal() {
            document.getElementById('galleryModal').classList.add('hidden');
            document.body.style.overflow = ''; // Restore background scrolling
        }

        function updateModalImage() {
            const img = document.getElementById('modalImage');
            const counter = document.getElementById('imageCounter');
            // Ensure images array is not empty before trying to access elements
            if (images.length > 0) {
                img.src = `/images/${images[currentIndex]}`;
                counter.textContent = `Image ${currentIndex + 1} of ${images.length}`;
            } else {
                // Handle case where no images are loaded
                img.src = ''; // Or a placeholder
                counter.textContent = 'No images available';
            }
        }

        function nextImage() {
            if (currentIndex < images.length - 1) {
                currentIndex++;
                updateModalImage();
            } else {
                // Optional: Loop back to the first image
                currentIndex = 0;
                updateModalImage();
            }
        }

        function prevImage() {
            if (currentIndex > 0) {
                currentIndex--;
                updateModalImage();
            } else {
                // Optional: Loop to the last image
                currentIndex = images.length - 1;
                updateModalImage();
            }
        }

        // --- New Event Listeners for Closing Modal ---

        document.addEventListener('DOMContentLoaded', () => {
            const galleryModal = document.getElementById('galleryModal');
            const modalImage = document.getElementById('modalImage'); // Get reference to the image element

            // 1. Close on Escape Key
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !galleryModal.classList.contains('hidden')) {
                    closeGalleryModal();
                }
            });

            // 2. Close on Background Click
            galleryModal.addEventListener('click', (event) => {
                // Check if the click occurred directly on the modal background,
                // not on the image or navigation buttons.
                if (event.target === galleryModal) {
                    closeGalleryModal();
                }
            });

            // Prevent clicks on the image itself from closing the modal
            // This prevents closing if the user clicks the image accidentally
            modalImage.addEventListener('click', (event) => {
                event.stopPropagation();
            });
        });
    </script>
    </div>


    </div>
</section>

<section class="min-h-screen flex items-center justify-center p-4 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Second Section Starts Here -->
        <div class="mt-10 select-none">
            <div class="grid grid-cols-6 gap-4 py-2">
                @php
                    $featuresTop = [
                        ['icon' => 'houses.svg', 'label' => 'Houses'],
                        ['icon' => 'mountain.svg', 'label' => 'Mountain view'],
                        ['icon' => 'garden.svg', 'label' => 'Garden'],
                        ['icon' => 'bath.svg', 'label' => 'Bath'],
                        ['icon' => 'wifi.svg', 'label' => 'Free WiFi'],
                        ['icon' => 'terrace.svg', 'label' => 'Terrace'],
                    ];
                @endphp

                @foreach($featuresTop as $feature)
                    <div class="group relative bg-white rounded-lg shadow-sm p-4 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                        <!-- Icon -->
                        <img src="{{ asset('assets/' . $feature['icon']) }}" alt="{{ $feature['label'] }}" class="w-6 h-6" />

                        <!-- Label for desktop -->
                        <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium" style="font-family: 'Noto Sans', sans-serif;">
                            {{ $feature['label'] }}
                        </span>

                        <!-- Tooltip for mobile only -->
                        <div class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
                            {{ $feature['label'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-4 gap-4 py-2">
                @php
                    $featuresBottom = [
                        ['icon' => 'balcony.svg', 'label' => 'Balcony'],
                        ['icon' => 'parking.svg', 'label' => 'Free parking'],
                        ['icon' => 'bbq.svg', 'label' => 'BBQ facilities'],
                        ['icon' => 'housekeeping.svg', 'label' => 'Daily housekeeping'],
                    ];
                @endphp

                @foreach($featuresBottom as $feature)
                    <div class="group relative bg-white rounded-lg shadow-sm p-4 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                        <!-- Icon -->
                        <img src="{{ asset('assets/' . $feature['icon']) }}" alt="{{ $feature['label'] }}" class="w-6 h-6" />

                        <!-- Label for desktop -->
                        <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium" style="font-family: 'Noto Sans', sans-serif;">
                            {{ $feature['label'] }}
                        </span>

                        <!-- Tooltip for mobile only -->
                        <div class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
                            {{ $feature['label'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        
        <div class="flex flex-col lg:flex-row gap-6 mt-10">
            <!-- Left Column -->
            <div class="flex-1 space-y-4">
                <h2 class="text-2xl font-bold text-black">Experience world-class service at La Grande Villa</h2>

                <p class="text-green-600 font-semibold" style="font-family: 'Noto Sans', sans-serif;">Reliable info:
                    <span class="text-gray-700">Guests say the description and photos for this property are very
                        accurate.</span>
                </p>


                <div class="space-y-3 text-gray-800">
                    <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm"><span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Elegant Accommodation:</span> La Grande Villa
                        in Nuwara Eliya offers a 5-star villa experience with a beautiful garden, terrace, and outdoor
                        seating area. Guests enjoy free WiFi, private check-in and check-out services, and a paid
                        shuttle service.</p>

                    <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm"><span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Comfortable Amenities:</span> The property
                        features a lounge, hot tub, concierge service, and family rooms. Additional amenities include a
                        fitness centre, spa bath, and bicycle parking. Free on-site private parking is available for
                        guests.</p>

                    <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm"><span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Dining Experience:</span> A family-friendly
                        restaurant serves Indian, local, Asian, international, and European cuisines. Breakfast options
                        include continental, vegetarian, halal, and gluten-free with pancakes and fruits. Lunch and
                        dinner are also available.</p>

                    <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm"><span class="font-bold" style="font-family: 'Noto Sans', sans-serif;">Prime Location:</span> Located 48 km from
                        Castlereigh Reservoir Seaplane Base and 3 km from Gregory Lake, La Grande Villa is near Hakgala
                        Botanical Garden (9 km) and other attractions. Highly rated for its garden, hot tub, and
                        attentive staff.</p>

                    <p class="text-sm text-gray-500" style="font-family: 'Noto Sans', sans-serif;">Distance in
                        property description is calculated using © OpenStreetMap</p>
                </div>

                <!-- Facilities -->

            </div>

            <!-- Right Sidebar -->
            <div class="w-full lg:w-1/5 bg-blue-100 rounded-lg py-4 px-4 space-y-4">
                <h3 class="font-bold text-xs" style="font-family: 'Noto Sans', sans-serif;">Property highlights</h3>
                <p class="text-xs" style="font-family: 'Noto Sans', sans-serif;"><span class="text-xs"><i class="fas fa-map-marker-alt"></i>Top location:</span> Highly rated by recent guests (9.1)
                </p>

                <div>
                    <h3 class="font-bold text-xs" style="font-family: 'Noto Sans', sans-serif;">Breakfast info</h3>
                    <p class="text-xs" style="font-family: 'Noto Sans', sans-serif;">Continental, Vegetarian, Halal,
                        Gluten-free, Breakfast to go</p>
                </div>

                <p class="text-xs flex items-center gap-x-1" style="font-family: 'Noto Sans', sans-serif;">
                    <img src="{{ asset('assets/parking.svg') }}" alt="Free Parking" class="w-4 h-4" />
                    Free private parking available on-site
                </p>


                <div>
                    <h4 class="font-semibold text-xs">Activities:</h4>
                    <ul class="list-none list-inside text-gray-800 text-xs">
                        <li>Golf course (within 3 km)</li>
                        <li>Fishing</li>
                        <li>Billiards</li>
                    </ul>
                </div>

                <button class="w-full bg-sky-500 text-white font-medium py-2 rounded hover:bg-sky-600 text-xs">Reserve</button>
                <button class="w-full border border-sky-500 text-sky-500 py-2 rounded hover:bg-sky-100 text-xs">♡ Save
                    the property</button>
            </div>
        </div>

</section>

<section id="facilities" class="p-4 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Facilities -->
        <div>
            <h3 class="text-lg font-semibold text-black mt-6 mb-4">Most popular facilities</h3>
            <div class="flex flex-wrap gap-4">
                @foreach ([['icon' => 'Vector(30).svg', 'label' => 'Good free WiFi (32Mbps)'], ['icon' => 'Group(10).svg', 'label' => 'Family rooms'], ['icon' => 'Group(11).svg', 'label' => 'Free parking'], ['icon' => 'Vector(31).svg', 'label' => 'Restaurant'], ['icon' => 'Vector(32).svg', 'label' => 'Non-smoking rooms'], ['icon' => 'Vector(33).svg', 'label' => 'Airport shuttle'], ['icon' => 'Group(12).svg', 'label' => 'Room service'], ['icon' => 'Vector(34).svg', 'label' => 'Facilities for disabled guests'], ['icon' => 'Group(13).svg', 'label' => 'Heating'], ['icon' => 'Vector(35).svg', 'label' => 'Good breakfast']] as $facility)
                <div class="flex items-center space-x-2 flex-[0_0_48%] md:flex-[0_0_23%] lg:flex-[0_0_18%] bg-white rounded-lg shadow-md border border-gray-300 p-3">
                    <img src="{{ asset('assets/' . $facility['icon']) }}" alt="{{ $facility['label'] }}" class="w-5 h-5">
                    <span class="text-sm text-gray-800 font-medium">{{ $facility['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="info" class="min-h-screen py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-4">
            <!-- Title -->
            <h2 class="text-xl font-bold">Availability</h2>

            <!-- We Price Match -->
            <div class="flex items-center text-blue-500 text-sm font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 010 8m-4-4h4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a4 4 0 00-4-4m0 0H8a4 4 0 000 8m0 0H6a2 2 0 00-2 2v4a2 2 0 002 2h2a4 4 0 004 4" />
                </svg>
                We Price Match
            </div>
        </div>


        <!-- Alert Message -->
        <div class="flex items-start gap-2 mb-6">
            <svg class="w-5 h-5 text-red-600 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
            </svg>
            <p class="text-red-600 text- mb-6">
                Select dates to see this property's availability and prices (may include Genius rates)
            </p>
        </div>



        <!-- Search Box: Overlapping both sections -->
        <!-- Alpine.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- FORM Section: Aligned with the table section -->
        <div class="relative z-10 -mt-8 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
                <form method="GET" class="w-full max-w-3xl bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-1 md:gap-0 border-4 border-yellow-400 text-sm">

                    <!-- Check-in/out Dropdown -->
                    <div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }" class="relative flex-1 border-t md:border-t-0 md:border-r border-gray-500 px-2 py-1">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                            <img src="{{ asset('assets/calender.svg') }}" alt="Calendar" class="w-5 h-5" />
                            <span class="text-gray-800 truncate">
                                <template x-if="activeTab === 'check'">
                                    <span><span x-text="checkIn ? checkIn : 'Check-in'" class="text-base"></span> —
                                        <span x-text="checkOut ? checkOut : 'Check-out'" class="text-base"></span></span>
                                </template>
                                <template x-if="activeTab === 'flexible'">
                                    <span x-text="flexibleOption ? flexibleOption : 'Flexible dates'"></span>
                                </template>
                            </span>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="open" @click.away="open = false" class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-96 right-0 text-gray-800 text-sm" x-transition>
                            <!-- Tabs -->
                            <nav class="flex border-b border-gray-200 mb-4">
                                <button @click.prevent="activeTab = 'check'" :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'" class="px-4 py-2 border-b-2 font-semibold">Check-in / Check-out</button>
                                <button @click.prevent="activeTab = 'flexible'" :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'" class="px-4 py-2 border-b-2 font-semibold">Flexible dates</button>
                            </nav>

                            <!-- Check-in/out Inputs -->
                            <div x-show="activeTab === 'check'" x-transition>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-500 font-semibold mb-1">Check-in
                                            Date</label>
                                        <input type="date" x-model="checkIn" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none" />
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 font-semibold mb-1">Check-out
                                            Date</label>
                                        <input type="date" x-model="checkOut" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none" />
                                    </div>
                                </div>
                            </div>

                            <!-- Flexible Options -->
                            <div x-show="activeTab === 'flexible'" x-transition>
                                <label class="block text-xs text-gray-500 font-semibold mb-1">Select Flexible
                                    Dates</label>
                                <select x-model="flexibleOption" class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none">
                                    <option value="" disabled>Select option</option>
                                    <option value="Weekend Getaway">Weekend Getaway</option>
                                    <option value="Next Month">Next Month</option>
                                    <option value="Anytime">Anytime</option>
                                    <option value="Custom Range">Custom Range</option>
                                </select>
                            </div>

                            <!-- Done -->
                            <div class="mt-4 text-right">
                                <button @click="open = false" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Done</button>
                            </div>
                        </div>
                    </div>

                    <!-- Guests Dropdown -->
                    <div x-data="{ open: false, adults: 2, children: 0, rooms: 1, pets: false }" class="relative px-2 py-1 flex-1 border-t md:border-t-0 md:border-r border-gray-500">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                            <img src="{{ asset('assets/user.svg') }}" alt="Guests" class="w-5 h-5" />
                            <span x-text="`${adults} adults · ${children} children · ${rooms} room${rooms > 1 ? 's' : ''}`" class="text-gray-800 text-base truncate"></span>
                        </button>

                        <!-- Guest Dropdown Panel -->
                        <div x-show="open" @click.away="open = false" class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-4 text-sm">
                            <!-- Adults -->
                            <div class="flex items-center justify-between">
                                <span>Adults</span>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="if(adults > 1) adults--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                                    <span x-text="adults"></span>
                                    <button type="button" @click="adults++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                                </div>
                            </div>

                            <!-- Children -->
                            <div class="flex items-center justify-between">
                                <span>Children</span>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="if(children > 0) children--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                                    <span x-text="children"></span>
                                    <button type="button" @click="children++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                                </div>
                            </div>

                            <!-- Rooms -->
                            <div class="flex items-center justify-between">
                                <span>Rooms</span>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="if(rooms > 1) rooms--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                                    <span x-text="rooms"></span>
                                    <button type="button" @click="rooms++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                                </div>
                            </div>

                            <!-- Pets -->
                            <div class="flex items-center justify-between">
                                <span>Travelling with pets?</span>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" x-model="pets" class="sr-only peer">
                                    <div class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4">
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <p class="text-xs text-gray-500">
                                Assistance animals aren’t considered pets.<br>
                                <a href="#" class="text-blue-600 underline">Read more</a>
                            </p>

                            <!-- Done -->
                            <button type="button" @click="open = false" class="w-full bg-white border border-blue-600 text-blue-600 font-semibold py-2 rounded hover:bg-blue-50">Done</button>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="px-2 py-1">
                        <button type="submit" class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm" style="background-color:#3CC0E9;">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-4 sm:p-6 lg:p-10 bg-white">
            <h2 class="text-xl sm:text-2xl font-bold mb-6">All available villas</h2>

            <div class="w-full overflow-x-auto">
                <table class="w-full border border-blue-500 border-collapse text-sm text-left min-w-[1000px]">
                    <thead>
                        <tr class="bg-blue-100 text-gray-800">
                            <th class="p-3 font-semibold border border-blue-500 w-[220px]">Room Type</th>
                            <th class="p-3 font-semibold border border-blue-500 w-[150px]">Number of guests</th>
                            <th class="p-3 font-semibold border border-blue-500 w-[160px]">Today's Price</th>
                            <th class="p-3 font-semibold border border-blue-500 w-[300px]">Your choices</th>
                            <th class="p-3 font-semibold border border-blue-500 w-[120px]">Select amount</th>
                            <th class="p-3 font-semibold border border-blue-500 w-[150px]">Reserve</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <!-- Room Type -->
                            <td class="p-3 align-top border border-blue-500">
                                <h3 class="text-blue-600 font-semibold underline">Private Villa by the Tea Resort</h3>
                                <p class="text-gray-600 mt-1 text-sm">
                                    Guests will have a special experience at this double room featuring a hot tub, spa
                                    bath and fireplace. The spacious double room provides soundproof walls, a minibar, a
                                    terrace with garden views as well as a private bathroom with a walk-in shower.
                                </p>
                            </td>

                            <!-- Guests -->
                            <td class="p-3 align-top border border-blue-500">
                                <div class="flex space-x-1 items-center">
                                    <img src="https://img.icons8.com/ios-filled/50/user.png" class="w-5 h-5" alt="Guest" />
                                    <img src="https://img.icons8.com/ios-filled/50/user.png" class="w-5 h-5" alt="Guest" />
                                </div>
                            </td>

                            <!-- Price -->
                            <td class="p-3 align-top border border-blue-500">
                                <div class="text-red-500 line-through">LKR 52,000</div>
                                <div class="text-lg font-bold text-green-600">LKR 45,600</div>
                                <div class="relative group inline-block">
                                    <!-- Tooltip box -->
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1 bg-black text-white text-xs rounded opacity-0 group-hover:opacity-100 transition duration-200 pointer-events-none z-10">
                                        Limited-time offer! Save more with this deal.
                                    </div>

                                    <!-- Actual button -->
                                    <button class="text-xs text-white px-2 py-1 rounded mt-2" style="background-color:#1D9D39; font-family: 'Noto Sans', sans-serif;">
                                        Getaway Deal
                                    </button>
                                    <span class="text-white px-2 py-1 rounded text-xs" style="background-color: rgb(31, 143, 178); font-family: 'Lato', sans-serif;">Genius</span>
                                </div>

                                <div class="text-xs text-gray-500">+ LKR 2,374 taxes and fees</div>
                            </td>

                            <!-- Choices -->
                            <td class="p-3 align-top border border-blue-500 text-gray-700 text-sm">
                                <ul class="space-y-1">
                                    <li><strong>Good breakfast</strong> LKR 2,394</li>
                                    <li class="text-green-700">✔ Flexible to reschedule if plans change</li>
                                    <li class="text-red-600">✘ Non-refundable</li>
                                    <li>✔ Pay the property before arrival</li>
                                    <li class="text-green-700">✔ 10% Genius discount applied</li>
                                    <li>✔ Taxes and charges included</li>
                                    <li>✔ Free stay for your child</li>
                                </ul>
                            </td>

                            <!-- Amount -->
                            <td class="p-3 align-top border border-blue-500 text-center">
                                <select class="border p-1 w-full rounded">
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </td>

                            <!-- Reserve -->
                            <td class="p-3 align-top border border-blue-500 text-center">
                                <button class="mt-2 w-full bg-blue-600 text-white text-sm py-1.5 rounded hover:bg-blue-700">
                                    I'll reserve
                                </button>
                                <p class="text-xs mt-1 text-gray-500">
                                    ✓ It only takes 2 minutes<br>
                                    ✓ You won’t be charged yet
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



</section>

<section id="reviews" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Guest Reviews Header -->
        <h2 class="text-xl sm:text-2xl font-bold mb-4">Guest reviews</h2>
        <div class="flex items-center gap-4 mb-6 flex-wrap">
            <div class="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">8.6</div>
            <span class="font-semibold text-gray-800">Superb</span>
            <span class="text-gray-500 text-sm">939 reviews</span>
            <a href="#" class="text-blue-600 text-sm underline">Read all reviews</a>
        </div>

        <!-- Categories -->
        <h3 class="font-semibold mb-3">Categories :</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Staff</span><span>9.2</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 92%;"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Facilities</span><span>9.7</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 97%;"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Cleanliness</span><span>9.4</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 94%;"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Comfort</span><span>9.4</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: 94%;"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Value for money</span><span>8.9</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 89%;"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Location</span><span>9.1</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 91%;"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span>Free WiFi</span><span>9.0</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 90%;"></div>
                </div>
            </div>
        </div>
        <!-- Guest Review Cards -->
        <h3 class="font-semibold text-lg mb-4">Guests who stayed here loved</h3>
        <div class="grid md:grid-cols-3 gap-4 mb-6">
            <!-- Card 1 -->
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <img src="https://i.pravatar.cc/40?img=12" alt="Avatar" class="w-10 h-10 rounded-full" />
                    <div>
                        <p class="font-semibold text-sm">Parley Rose</p>
                        <p class="text-xs text-gray-500">🇬🇧 United Kingdom</p>
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2">
                    “Really comfortable bed, and big spa bath. Enjoyed the pool table as was heavy rain outside, and the
                    Sri Lankan breakfast was delicious!”
                </p>
                <a href="#" class="text-blue-600 text-sm underline">Read more</a>
            </div>

            <!-- Card 2 -->
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <img src="https://i.pravatar.cc/40?img=21" alt="Avatar" class="w-10 h-10 rounded-full" />
                    <div>
                        <p class="font-semibold text-sm">Michel and Asja</p>
                        <p class="text-xs text-gray-500">🇨🇳 China</p>
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2">
                    “The Hospitality is the best and out of the world. Very homely feeling and Room comfort was
                    outstanding.. Highly recommended!! Must stay property... Cheers !!”
                </p>
                <a href="#" class="text-blue-600 text-sm underline">Read more</a>
            </div>

            <!-- Card 3 -->
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <img src="https://i.pravatar.cc/40?img=31" alt="Avatar" class="w-10 h-10 rounded-full" />
                    <div>
                        <p class="font-semibold text-sm">Martin Fieldman</p>
                        <p class="text-xs text-gray-500">🇮🇳 India</p>
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2">
                    “We didn’t realise it was a Muslim hotel and so there was no alcohol available. However they were
                    very accommodating... Food service was incredibly slow for dinner but all cooked fresh.”
                </p>
                <a href="#" class="text-blue-600 text-sm underline">Read more</a>
            </div>
        </div>

        <!-- Read All Reviews -->
        <div class="text-center">
            <a href="#" class="inline-block border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-50 text-sm">
                Read all reviews
            </a>
        </div>
</section>

<section class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Host Information -->
        <div>
            <h2 class="text-xl font-semibold mb-2">Host Information</h2>
            <div class="flex items-center gap-4">
                <img src="https://placehold.co/80x80" alt="Host" class="w-20 h-20 rounded-lg object-cover" />
                <div>
                    <p class="font-semibold">This is a Villa Type</p>
                    <p class="text-sm text-gray-600">Extra activities are available</p>
                    <p class="text-sm text-gray-600">Gregory Lake</p>
                    <p class="text-sm text-gray-600">Languages spoken: Arabic, English</p>
                </div>
                <div class="ml-auto">
                    <span class="text-sm text-gray-500">Host review score</span>
                    <div class="text-center bg-blue-100 text-blue-600 font-semibold text-sm rounded px-2 py-1 mt-1">8.6
                    </div>
                </div>
            </div>
        </div>




</section>

</div>
</section>





<section id="rules" class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-xl font-bold mb-4">House rules</h2>
        <!-- House Rules -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-semibold">House rules</h2>
                <button class="bg-sky-500 hover:bg-sky-600 text-white text-sm px-4 py-2 rounded">See
                    availability</button>
            </div>
            <p class="text-sm text-gray-600 mb-4">La Grande Villa takes special requests - add in the next step!</p>

            <div class="space-y-4 border rounded-lg p-4 text-sm text-gray-700">
                <!-- Row 1 -->
                <div class="grid md:grid-cols-2 gap-4">
                    <div><strong>Check in</strong><br>From 14:00 to 23:30</div>
                    <div><strong>Check out</strong><br>From 05:00 to 11:00</div>
                </div>
                <!-- Row 2 -->
                <div>
                    <strong>Cancellation / prepayment</strong><br>
                    Cancellation and prepayment policies vary according to accommodation type. Please check what may
                    apply to each option when making your selection.
                </div>
                <!-- Row 3 -->
                <div>
                    <strong>Children and beds</strong><br>
                    <strong>Child policies</strong><br>
                    To see correct prices and occupancy information, please add the number of children in your group and
                    their ages to your search.<br><br>
                    <strong>Cot and extra bed policies</strong><br>
                    The number of cots allowed is dependent on the option you choose. Please check your selected option
                    for more information.
                </div>
                <!-- Row 4 -->
                <div><strong>No age restriction</strong><br>There is no age requirement for check-in</div>
                <!-- Row 5 -->
                <div class="flex items-center gap-2">
                    <strong>Accepted payment methods:</strong>
                    <img src="https://img.icons8.com/color/48/visa.png" class="w-8 h-5" alt="Visa">
                    <img src="https://img.icons8.com/color/48/mastercard-logo.png" class="w-8 h-5" alt="MasterCard">
                </div>
                <!-- Row 6 -->
                <div><strong>Smoking</strong><br>Smoking is not allowed.</div>
                <!-- Row 7 -->
                <div><strong>Quiet hours</strong><br>Guests must be quiet between 22:00 and 06:00.</div>
                <!-- Row 8 -->
                <div><strong>Pets</strong><br>Pets are not allowed.</div>
            </div>
        </div>
</section>
<section id="fineprint" class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <h2 class="text-xl font-bold mb-4">The fine print</h2>
        <!-- Fine Print -->
        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-xl font-semibold">The fine print</h2>
                <button class="bg-sky-500 hover:bg-sky-600 text-white text-sm px-4 py-2 rounded">See
                    availability</button>
            </div>
            <div class="bg-gray-50 border rounded-lg p-4 text-sm text-gray-700">
                Please inform La Grande Villa in advance of your expected arrival time. You can use the Special Requests
                box when booking, or contact the property directly with the contact details provided in your
                confirmation. Quiet hours are between 22:00 and 06:00.
            </div>
        </div>

        <!-- FAQ Placeholder -->
        <div>
            <h2 class="text-lg font-semibold">FAQs about La Grande Villa</h2>
            <p class="text-sm text-gray-600 mt-1">How much does it cost to rent a car in Sri Lanka for a week? • Which
                pickup locations in Sri Lanka are the most popular?</p>
        </div>
        <!-- Two column layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        What is your refund policy?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        We offer a full refund within the first 14 days of your purchase.
                    </p>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>
                <div class="border border-gray-200 rounded-lg p-4">
                    <button class="w-full text-base text-bold flex justify-between items-center text-left  text-gray-800 toggle-answer focus:outline-none" style="font-family: 'Noto Sans', sans-serif;">
                        Is there a free trial available?
                        <svg class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <p class="mt-2 text-gray-600 hidden answer" style="font-family: 'Noto Sans', sans-serif;">
                        Yes, we offer a 7-day free trial with access to all features.
                    </p>
                </div>


            </div>
        </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.toggle-answer');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const answer = toggle.nextElementSibling;
                const icon = toggle.querySelector('svg');
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const links = document.querySelectorAll("a.scroll-link");

        // Mark the first link (Overview) as active by default
        if (links.length > 0) {
            links[0].classList.add("border-b-2", "border-blue-500", "text-blue-600", "font-semibold");
        }

        // Get section IDs from hrefs
        const sectionIds = Array.from(links).map(link => link.getAttribute("href").substring(1));
        const sections = sectionIds.map(id => document.getElementById(id)).filter(Boolean);

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    links.forEach(link => {
                        link.classList.remove("border-b-2", "border-blue-500",
                            "text-blue-600", "font-semibold");
                        if (link.getAttribute("href") === `#${entry.target.id}`) {
                            link.classList.add("border-b-2", "border-blue-500",
                                "text-blue-600", "font-semibold");
                        }
                    });
                }
            });
        }, {
            threshold: 0.6
        });

        sections.forEach(section => observer.observe(section));

        links.forEach(link => {
            link.addEventListener("click", (e) => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute("href"));
                if (target) {
                    target.scrollIntoView({
                        behavior: "smooth"
                    });
                }
            });
        });
    });
</script>