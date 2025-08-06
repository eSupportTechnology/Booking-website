<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Partner Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-blue-50 text-gray-800">

    <!-- Top Navbar -->
    <nav class="bg-[#1F8FB2] text-white fixed w-full z-50 shadow">
        <div class="max-w-full mx-auto px-4">
            <div class="flex justify-between h-16 items-center">

                <!-- Left: Logo + Hamburger -->
                <div class="flex items-center space-x-4">
                    <!-- Hamburger -->
                    <button id="menuToggle" class="text-white focus:outline-none block md:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="#" class="text-xl font-bold">Partner Panel</a>
                </div>

                <!-- Center: Search -->
                <div class="hidden md:flex">
                    <input type="text" placeholder="Search..."
                        class="px-3 py-1 rounded bg-[#3CC0E9] placeholder-white text-white focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm" />
                </div>

                <!-- Right: Notifications + Profile -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-white">
                            <i class="fas fa-bell"></i>
                        </button>
                        <span class="absolute -top-1 -right-2 bg-red-500 text-xs px-1.5 rounded-full">3</span>
                    </div>
                    <div class="relative group">
                        <button class="text-white flex items-center space-x-1">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span class="text-sm">{{ Auth::user()->name ?? 'Partner' }}</span>
                        </button>
                        <div
                            class="absolute right-0 bg-white text-black shadow-lg rounded hidden group-hover:block min-w-[150px] z-50">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">Profile</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">Settings</a>
                            <div class="border-t"></div>
                            <form method="POST" action="{{ route('partner.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 rounded">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>




    <section class="py-6 bg-white">
        <div class="max-w-6xl mt-16 mx-auto px-4 sm:px-6 lg:px-8">
            Home > Nuwara Elliya > Search Results
            <div class="border-b sticky top-0 bg-white">
                <div
                    class="max-w-6xl mx-auto flex space-x-6 overflow-x-auto text-sm md:text-base whitespace-nowrap px-4 py-2">
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
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-4 bg-white rounded-lg shadow-sm">
                <!-- Left: Title and Info -->
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
                        {{ $property->title ?? 'Property Title' }}</h1>
                    <div class="flex items-center mb-2">
                        @for ($i = 0; $i < 4; $i++)
                            <svg class="w-5 h-5 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        @endfor
                    </div>
                    <div class="flex items-center text-gray-600 text-sm">
                        <svg class="w-5 h-5 mr-1 text-[#3CC0E9]" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                        </svg>
                        {{ $property->address ?? 'Address' }}, {{ $property->city ?? 'City' }},
                        {{ $property->country ?? 'Country' }}
                    </div>
                </div>

                <!-- Right: Actions -->
                <div class="flex flex-col items-start sm:items-end space-y-2">
                    <div class="flex items-center text-[#3CC0E9] text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.007 12.007 0 002.944 12c0 2.873.996 5.474 2.618 7.594L12 22.944l6.438-3.35C20.004 17.474 21 14.873 21 12a12.007 12.007 0 00-2.382-7.016z" />
                        </svg>
                        We Price Match
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:grid lg:grid-cols-7 lg:grid-rows-5 gap-4 mt-6 h-auto lg:h-[600px]">

                <div class="w-full lg:col-span-5 lg:row-span-5 space-y-4">
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
                        @php
                            $files = $property->files ?? collect();
                            $visibleFiles = $files->take(8);
                            $remainingCount = max(0, $files->count() - 8);
                        @endphp

                        @if ($files->count() > 0)
                            @php
                                $visibleFiles = $files->take(8);
                                $remainingCount = max(0, $files->count() - 8);
                            @endphp
                            @foreach ($visibleFiles as $index => $file)
                                <div class="{{ $positions[$index] ?? '' }} relative overflow-hidden"
                                    onclick="openGalleryModal({{ $index }})">
                                    <img src="{{ asset('storage/' . $file->path) }}"
                                        class="w-full h-full object-cover rounded-lg cursor-pointer"
                                        alt="Property Image {{ $index + 1 }}"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        onload="console.log('Image loaded: {{ $file->path }}')">
                                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center"
                                        style="display:none;">
                                        <span class="text-gray-500 text-sm">Image not found</span>
                                    </div>
                                    @if ($loop->last && $remainingCount > 0)
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-lg font-bold cursor-pointer hover:bg-opacity-70 transition rounded-lg">
                                            {{ $remainingCount }}+ more
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div
                                class="col-span-10 row-span-8 flex items-center justify-center bg-gray-200 rounded-lg">
                                <p class="text-gray-500 text-lg">No images uploaded for this property</p>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-4 grid-rows-2 gap-2 lg:hidden h-[300px] sm:h-[400px]">
                        @php
                            $mobilePositions = ['col-span-3 row-span-2', 'col-start-4', 'col-start-4 row-start-2'];
                        @endphp

                        @php
                            $mobileFiles = $files->take(3);
                            $mobileRemainingCount = max(0, $files->count() - 3);
                        @endphp
                        @if ($files->count() > 0)
                            @php
                                $mobileFiles = $files->take(3);
                                $mobileRemainingCount = max(0, $files->count() - 3);
                            @endphp
                            @foreach ($mobileFiles as $index => $file)
                                <div class="{{ $mobilePositions[$index] ?? '' }} relative overflow-hidden"
                                    onclick="openGalleryModal({{ $index }})">
                                    <img src="{{ asset('storage/' . $file->path) }}"
                                        class="w-full h-full object-cover rounded-md cursor-pointer"
                                        alt="Property Image {{ $index + 1 }}">
                                    @if ($loop->last && $mobileRemainingCount > 0)
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-base font-semibold rounded-md cursor-pointer">
                                            {{ $mobileRemainingCount }}+ more
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-4 row-span-2 flex items-center justify-center bg-gray-200 rounded-md">
                                <p class="text-gray-500 text-sm">No images uploaded</p>
                            </div>
                        @endif
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
                                <div class="bg-[#3CC0E9] text-white text-sm font-semibold px-2 py-1 rounded">8.6</div>
                            </div>

                            <!-- Review Text -->
                            <div>
                                <h3 class="text-sm font-semibold mb-1 text-gray-700">Guests who stayed here loved</h3>
                                <p class="text-sm text-gray-700 ml-4 italic">“Really comfortable bed, and big spa bath.
                                    Enjoyed the pool table as was heavy rain outside, and the Sri Lankan breakfast was
                                    delicious! table as was heavy rain outside, and the Sri Lankan breakfast”</p>
                            </div>

                            <!-- Reviewer Info -->
                            <div class="mt-3 flex items-center gap-3">
                                <div
                                    class="w-8 h-8 bg-green-600 text-white flex items-center justify-center rounded-full font-semibold">
                                    L</div>
                                <div class="flex items-center gap-8">
                                    <p class="font-medium text-gray-800 mb-0">Linton</p>
                                    <div class="flex justify-between items-center gap-1">
                                        <img src="{{ asset('assets/net.svg') }}"
                                            class="w-5 h-3 object-cover rounded-sm" alt="UK Flag">
                                        <span class="text-gray-500 text-xs">United Kingdom</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Staff Rating -->
                            <div class="flex justify-between items-center pt-2 border-t">
                                <span class="text-sm font-semibold text-gray-700">Staff</span>
                                <div class="border border-gray-300 px-2 py-0.5 text-sm rounded-md text-gray-800">8.6
                                </div>
                            </div>
                        </div>

                        <!-- Map Section -->
                        <div class="w-full rounded-lg overflow-hidden shadow">
                            <div class="relative">
                                <iframe class="w-full h-44 sm:h-56" loading="lazy"
                                    src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                                    frameborder="0" allowfullscreen aria-hidden="false" tabindex="0"></iframe>
                                <button
                                    class="absolute bottom-2 left-2 bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white text-sm px-3 py-1 rounded-md shadow">
                                    Show on map
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div id="galleryModal"
            class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center hidden px-4 py-6 sm:px-8 sm:py-10">

            <!-- Close Button -->
            <button onclick="closeGalleryModal()"
                class="absolute top-4 right-4 sm:top-8 sm:right-8 text-white text-3xl sm:text-4xl hover:scale-110 transition">
                &times;
            </button>

            <!-- Previous Button -->
            <button onclick="prevImage()"
                class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/70 p-2 sm:p-3 rounded-full transition">
                <svg class="w-6 h-6 sm:w-10 sm:h-10" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Image -->
            <img id="modalImage" src="" alt="Gallery Image"
                class="max-h-[75vh] sm:max-h-[90vh] max-w-full rounded-xl shadow-xl border border-white/10 transition duration-300 object-contain" />

            <!-- Next Button -->
            <button onclick="nextImage()"
                class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/70 p-2 sm:p-3 rounded-full transition">
                <svg class="w-6 h-6 sm:w-10 sm:h-10" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Counter -->
            <div class="absolute bottom-4 sm:bottom-6 text-white text-xs sm:text-sm tracking-wide">
                <span id="imageCounter"></span>
            </div>
        </div>


        <script>
            @php
                $imageArray = [];
                if ($property->files && $property->files->count() > 0) {
                    $imageArray = $property->files->pluck('path')->toArray();
                }
            @endphp
            const images = @json($imageArray);
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
                if (images.length > 0) {
                    img.src = `/storage/${images[currentIndex]}`;
                    counter.textContent = `Image ${currentIndex + 1} of ${images.length}`;
                } else {
                    img.src = '';
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

    <section class=" p-4 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

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

                    @foreach ($featuresTop as $feature)
                        <div
                            class="group relative bg-white rounded-lg shadow-sm p-4 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                            <!-- Icon -->
                            <img src="{{ asset('assets/' . $feature['icon']) }}" alt="{{ $feature['label'] }}"
                                class="w-6 h-6" />

                            <!-- Label for desktop -->
                            <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium"
                                style="font-family: 'Noto Sans', sans-serif;">
                                {{ $feature['label'] }}
                            </span>

                            <!-- Tooltip for mobile only -->
                            <div
                                class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
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

                    @foreach ($featuresBottom as $feature)
                        <div
                            class="group relative bg-white rounded-lg shadow-sm p-4 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                            <!-- Icon -->
                            <img src="{{ asset('assets/' . $feature['icon']) }}" alt="{{ $feature['label'] }}"
                                class="w-6 h-6" />

                            <!-- Label for desktop -->
                            <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium"
                                style="font-family: 'Noto Sans', sans-serif;">
                                {{ $feature['label'] }}
                            </span>

                            <!-- Tooltip for mobile only -->
                            <div
                                class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
                                {{ $feature['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Database Details Section -->
    <section class="py-4 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-black mb-6">Property Database Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Property Basic Info -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-3">Property Information</h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Title:</strong> {{ $property->title ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $property->address ?? 'N/A' }}</p>
                        <p><strong>City:</strong> {{ $property->city ?? 'N/A' }}</p>
                        <p><strong>Country:</strong> {{ $property->country ?? 'N/A' }}</p>
                        <p><strong>Zipcode:</strong> {{ $property->zipcode ?? 'N/A' }}</p>
                        <p><strong>Status:</strong> {{ $property->status ?? 'N/A' }}</p>
                        <p><strong>Stars:</strong> {{ $property->stars ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Additional Details -->
                @if ($property->additionalDetails)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-3">Additional Details</h3>
                        <div class="space-y-2 text-sm">
                            <p><strong>Details:</strong> {{ $property->additionalDetails->details ?? 'N/A' }}</p>
                            <p><strong>Special Features:</strong>
                                {{ $property->additionalDetails->special_features ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif

                <!-- Pricing -->
                @if ($property->pricing)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-3">Pricing Details</h3>
                        <div class="space-y-2 text-sm">
                            <p><strong>Base Price:</strong> LKR
                                {{ number_format($property->pricing->base_price ?? 0) }}</p>
                            <p><strong>Original Price:</strong> LKR
                                {{ number_format($property->pricing->original_price ?? 0) }}</p>
                            <p><strong>Discount:</strong> {{ $property->pricing->discount_percentage ?? 0 }}%</p>
                            <p><strong>Tax Amount:</strong> LKR
                                {{ number_format($property->pricing->tax_amount ?? 0) }}</p>
                            <p><strong>Currency:</strong> {{ $property->pricing->currency ?? 'LKR' }}</p>
                        </div>
                    </div>
                @endif

                <!-- Services -->
                @if ($property->services)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-3">Services</h3>
                        <div class="space-y-2 text-sm">
                            <p><strong>Breakfast:</strong> {{ $property->services->breakfast_included ? 'Yes' : 'No' }}
                            </p>
                            <p><strong>WiFi:</strong> {{ $property->services->wifi_available ? 'Yes' : 'No' }}</p>
                            <p><strong>Parking:</strong> {{ $property->services->parking_available ? 'Yes' : 'No' }}
                            </p>
                            <p><strong>Room Service:</strong> {{ $property->services->room_service ? 'Yes' : 'No' }}
                            </p>
                            <p><strong>Laundry:</strong> {{ $property->services->laundry_service ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                @endif

                <!-- Policies -->
                @if ($property->policies)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-3">Policies</h3>
                        <div class="space-y-2 text-sm">
                            <p><strong>Check-in:</strong> {{ $property->policies->check_in_time ?? 'N/A' }}</p>
                            <p><strong>Check-out:</strong> {{ $property->policies->check_out_time ?? 'N/A' }}</p>
                            <p><strong>Cancellation:</strong>
                                {{ $property->policies->flexible_cancellation ? 'Flexible' : 'Strict' }}</p>
                            <p><strong>Children:</strong>
                                {{ $property->policies->children_allowed ? 'Allowed' : 'Not allowed' }}</p>
                            <p><strong>Pets:</strong>
                                {{ $property->policies->pets_allowed ? 'Allowed' : 'Not allowed' }}</p>
                            <p><strong>Smoking:</strong>
                                {{ $property->policies->smoking_allowed ? 'Allowed' : 'Not allowed' }}</p>
                            <p><strong>Pay at Property:</strong>
                                {{ $property->policies->pay_at_property ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                @endif

                <!-- Host Profile -->
                @if ($property->hostProfile)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-lg mb-3">Host Information</h3>
                        <div class="space-y-2 text-sm">
                            <p><strong>Host Name:</strong> {{ $property->hostProfile->host_name ?? 'N/A' }}</p>
                            <p><strong>Contact:</strong> {{ $property->hostProfile->contact_info ?? 'N/A' }}</p>
                            <p><strong>Bio:</strong> {{ $property->hostProfile->bio ?? 'N/A' }}</p>
                            <p><strong>Response Rate:</strong> {{ $property->hostProfile->response_rate ?? 'N/A' }}%
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Bedrooms -->
            @if ($property->bedrooms && $property->bedrooms->count() > 0)
                <div class="mt-6 bg-white p-4 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-3">Bedrooms ({{ $property->bedrooms->count() }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($property->bedrooms as $bedroom)
                            <div class="border p-3 rounded">
                                <p><strong>Type:</strong> {{ $bedroom->bedroom_type ?? 'N/A' }}</p>
                                <p><strong>Beds:</strong> {{ $bedroom->bed_count ?? 'N/A' }}</p>
                                <p><strong>Bed Type:</strong> {{ $bedroom->bed_type ?? 'N/A' }}</p>
                                <p><strong>Size:</strong> {{ $bedroom->room_size ?? 'N/A' }} sqm</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Amenities -->
            @if ($property->amenities && $property->amenities->count() > 0)
                <div class="mt-6 bg-white p-4 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-3">Amenities ({{ $property->amenities->count() }})</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($property->amenities as $amenity)
                            <span
                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ $amenity->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Languages -->
            @if ($property->languages && $property->languages->count() > 0)
                <div class="mt-6 bg-white p-4 rounded-lg shadow">
                    <h3 class="font-bold text-lg mb-3">Languages Spoken ({{ $property->languages->count() }})</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($property->languages as $language)
                            <span
                                class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $language->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="py-4 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">

                <div class="flex-1 space-y-4">
                    <h2 class="text-2xl font-bold text-black">Experience world-class service at
                        {{ $property->title ?? 'Property' }}</h2>

                    <p class="text-green-600 font-semibold" style="font-family: 'Noto Sans', sans-serif;">Reliable
                        info:
                        <span class="text-gray-700">Guests say the description and photos for this property are very
                            accurate.</span>
                    </p>

                    <div class="space-y-3 text-gray-800">
                        <p class="text-sm"><span class="font-bold">Property Description:</span>
                            {{ $property->description ?? 'No description available' }}</p>

                        @if ($property->additionalDetails)
                            <p class="text-sm"><span class="font-bold">Additional Details:</span>
                                {{ $property->additionalDetails->details ?? 'No additional details' }}</p>
                        @endif

                        @if ($property->bedrooms && $property->bedrooms->count() > 0)
                            <div class="text-sm">
                                <span class="font-bold">Bedrooms:</span>
                                @foreach ($property->bedrooms as $bedroom)
                                    <span
                                        class="inline-block bg-gray-100 px-2 py-1 rounded mr-2 mb-1">{{ $bedroom->bedroom_type ?? 'Bedroom' }}
                                        ({{ $bedroom->bed_count ?? 1 }} beds)
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if ($property->hostProfile)
                            <p class="text-sm"><span class="font-bold">Host:</span>
                                {{ $property->hostProfile->host_name ?? 'Host information available' }}</p>
                        @endif

                        @if ($property->languages && $property->languages->count() > 0)
                            <div class="text-sm">
                                <span class="font-bold">Languages Spoken:</span>
                                @foreach ($property->languages as $language)
                                    <span
                                        class="inline-block bg-blue-100 px-2 py-1 rounded mr-2 mb-1">{{ $language->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-black mt-6 mb-4">Most popular facilities</h3>
                        <div class="flex flex-wrap gap-4">
                            @if ($property->amenities && $property->amenities->count() > 0)
                                @foreach ($property->amenities as $amenity)
                                    <div
                                        class="flex items-center justify-center lg:justify-start p-2 bg-gray-50 rounded">
                                        <span class="text-sm text-gray-800 font-medium">{{ $amenity->name }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500">No amenities listed</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-auto lg:max-w-xs">
                    <div class="bg-blue-100 rounded-lg py-4 px-4 space-y-4">
                        @if ($property->pricing)
                            <div>
                                <h3 class="font-bold text-xs">Pricing Details</h3>
                                <p class="text-xs">Base Price: LKR
                                    {{ number_format($property->pricing->base_price ?? 0) }}</p>
                                @if ($property->pricing->discount_percentage)
                                    <p class="text-xs text-green-600">Discount:
                                        {{ $property->pricing->discount_percentage }}%</p>
                                @endif
                            </div>
                        @endif

                        @if ($property->services)
                            <div>
                                <h3 class="font-bold text-xs">Services</h3>
                                @if ($property->services->breakfast_included)
                                    <p class="text-xs">✓ Breakfast included</p>
                                @endif
                                @if ($property->services->wifi_available)
                                    <p class="text-xs">✓ WiFi available</p>
                                @endif
                                @if ($property->services->parking_available)
                                    <p class="text-xs">✓ Parking available</p>
                                @endif
                            </div>
                        @endif

                        <p class="text-xs flex items-center gap-x-1" style="font-family: 'Noto Sans', sans-serif;">
                            <img src="{{ asset('assets/parking.svg') }}" alt="Free Parking" class="w-4 h-4" />
                            Free private parking available on-site
                        </p>

                        <div>
                            <h4 class="font-semibold text-xs">Activities:</h4>
                            <ul class="list-disc list-inside text-gray-800 text-xs">
                                <li>Golf course (within 3 km)</li>
                                <li>Fishing</li>
                                <li>Billiards</li>
                            </ul>
                        </div>

                        <button
                            class="w-full bg-sky-500 text-white font-medium py-2 rounded hover:bg-sky-600 text-xs">Reserve</button>
                        <button
                            class="w-full border border-sky-500 text-sky-500 py-2 rounded hover:bg-sky-100 text-xs flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            Save the property
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="info" class="min-h-screen py-8 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 border-t">
            <div class="flex items-center justify-between mb-4">
                <!-- Title -->
                <h2 class="text-xl font-bold">Availability</h2>

                <!-- We Price Match -->
                <div class="flex items-center text-blue-500 text-sm font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 010 8m-4-4h4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a4 4 0 00-4-4m0 0H8a4 4 0 000 8m0 0H6a2 2 0 00-2 2v4a2 2 0 002 2h2a4 4 0 004 4" />
                    </svg>
                    We Price Match
                </div>
            </div>

            <div class="pt-4 sm:pt-6 lg:pt-10 bg-white">
                <h2 class="text-xl sm:text-2xl font-bold mb-6">All available villas</h2>

                <div class="w-full overflow-x-auto">
                    <table class="w-full border border-blue-500 border-collapse text-sm text-left min-w-[1000px]">
                        <thead>
                            <tr class="bg-blue-100 text-gray-800">
                                <th class="p-3 font-semibold border border-blue-500 w-[220px]">Room Type</th>
                                <th class="p-3 font-semibold border border-blue-500 w-[150px]">Number of guests</th>
                                <th class="p-3 font-semibold border border-blue-500 w-[160px]">Today's Price</th>
                                <th class="p-3 font-semibold border border-blue-500 w-[300px]">Your choices</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <!-- Room Type -->
                                <td class="p-3 align-top border border-blue-500">
                                    <h3 class="text-blue-600 font-semibold underline">
                                        {{ $property->title ?? 'No details provided' }}</h3>
                                    <p class="text-gray-600 mt-1 text-sm">
                                        {{ $property->description ?? 'No details provided' }}
                                    </p>
                                </td>

                                <!-- Guests -->
                                <td class="p-3 align-top border border-blue-500">
                                    <div class="flex space-x-1 items-center">
                                        <img src="https://img.icons8.com/ios-filled/50/user.png" class="w-5 h-5"
                                            alt="Guest" />
                                        <img src="https://img.icons8.com/ios-filled/50/user.png" class="w-5 h-5"
                                            alt="Guest" />
                                    </div>
                                </td>

                                <!-- Price -->
                                <td class="p-3 align-top border border-blue-500">
                                    @if ($property->pricing)
                                        @if ($property->pricing->original_price)
                                            <div class="text-red-500 line-through">LKR
                                                {{ number_format($property->pricing->original_price) }}</div>
                                        @endif
                                        <div class="text-lg font-bold text-green-600">LKR
                                            {{ number_format($property->pricing->base_price ?? 45600) }}</div>
                                        @if ($property->pricing->discount_percentage)
                                            <div class="relative group inline-block">
                                                <button class="text-xs text-white px-2 py-1 rounded mt-2"
                                                    style="background-color:#1D9D39; font-family: 'Noto Sans', sans-serif;">
                                                    {{ $property->pricing->discount_percentage }}% Off
                                                </button>
                                            </div>
                                        @endif
                                        @if ($property->pricing->tax_amount)
                                            <div class="text-xs text-gray-500">+ LKR
                                                {{ number_format($property->pricing->tax_amount) }} taxes and fees
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-lg font-bold text-gray-600">No details provided</div>
                                    @endif
                                </td>

                                <!-- Choices -->
                                <td class="p-3 align-top border border-blue-500 text-gray-700 text-sm">
                                    <ul class="space-y-1">
                                        @if ($property->services)
                                            @if ($property->services->breakfast_included)
                                                <li><strong>Breakfast included</strong></li>
                                            @endif
                                            @if ($property->services->wifi_available)
                                                <li>✔ Free WiFi</li>
                                            @endif
                                            @if ($property->services->parking_available)
                                                <li>✔ Free parking</li>
                                            @endif
                                        @endif
                                        @if ($property->policies)
                                            @if ($property->policies->flexible_cancellation)
                                                <li class="text-green-700">✔ Flexible cancellation</li>
                                            @else
                                                <li class="text-red-600">✘ Non-refundable</li>
                                            @endif
                                            @if ($property->policies->pay_at_property)
                                                <li>✔ Pay at property</li>
                                            @endif
                                            @if ($property->policies->children_allowed)
                                                <li>✔ Children allowed</li>
                                            @endif
                                            @if ($property->policies->pets_allowed)
                                                <li>✔ Pets allowed</li>
                                            @endif
                                        @endif
                                        @if ($property->pricing && $property->pricing->discount_percentage)
                                            <li class="text-green-700">✔
                                                {{ $property->pricing->discount_percentage }}% discount</li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section id="reviews" class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

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
                        “Really comfortable bed, and big spa bath. Enjoyed the pool table as was heavy rain outside, and
                        the
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
                        “We didn’t realise it was a Muslim hotel and so there was no alcohol available. However they
                        were
                        very accommodating... Food service was incredibly slow for dinner but all cooked fresh.”
                    </p>
                    <a href="#" class="text-blue-600 text-sm underline">Read more</a>
                </div>
            </div>

            <!-- Read All Reviews -->
            <div class="text-center">
                <a href="#"
                    class="inline-block border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-50 text-sm">
                    Read all reviews
                </a>
            </div>

            <!-- Host Information -->
            <div class="pt-6 mt-10">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6">
                    <!-- Left: Title -->
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2 sm:mb-0">Host Information</h2>

                    <!-- Right: Host Review Score -->
                    <div class="flex items-center text-sm font-semibold text-gray-700">
                        <span class="mr-2 ">Host review score</span>
                        <span class="px-2 py-0.5 border border-blue-300 rounded-md text-blue-600">8.6</span>
                    </div>
                </div>

                <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <!-- Host Image -->
                    <img src="{{ asset('images/h3.jpg') }}" alt="Host"
                        class="w-32 h-32 object-cover rounded-full border">

                    <!-- Host Details -->
                    <div class="space-y-2 text-sm text-gray-700">
                        @if ($property->hostProfile)
                            <p><strong>Host:</strong> {{ $property->hostProfile->host_name ?? 'Host Name' }}</p>
                            <p><strong>Contact:</strong>
                                {{ $property->hostProfile->contact_info ?? 'Contact available' }}</p>
                            <p><strong>Response Rate:</strong> {{ $property->hostProfile->response_rate ?? '95' }}%</p>
                        @else
                            <p>This is a <span class="font-medium">Villa Type</span></p>
                            <p>Extra activities are available</p>
                        @endif
                        <p><strong>Location:</strong> {{ $property->city ?? 'Gregory Lake' }}</p>
                        @if ($property->languages && $property->languages->count() > 0)
                            <p><strong>Languages spoken:</strong> <span>{{ $property->languages->pluck('name')->join(', ') }}</spanlass=></p>
                        @else
                            <p><strong>Languages spoken:</strong> <span>English</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>





    <section id="rules" class="min-h-screen bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- House Rules -->
            <div class="mt-10 space-y-6">
                <!-- Title Section -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-semibold">House rules</h2>
                        <button class="bg-sky-500 hover:bg-sky-600 text-white text-sm px-4 py-2 rounded">See
                            availability</button>
                    </div>
                    <div class="">
                        <p class="text-xs sm:text-sm md:text-base text-gray-500 truncate">
                            {{ $property->title ?? 'Property' }} takes special requests - add in the next step!
                        </p>
                    </div>
                </div>

                <!-- Rules Table -->
                <div class="w-full">
                    <div class="overflow-none border rounded-lg shadow-sm">
                        <table class="table-fixed w-full text-xs sm:text-sm text-left text-gray-700 break-words">
                            <colgroup>
                                <col class="w-1/3">
                                <col class="w-2/3">
                            </colgroup>
                            <tbody class="divide-y divide-gray-200">
                                @if($property->policies)
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/check-in.svg" class="w-4 h-4 mt-1 shrink-0" alt="Check in">
                                            <span>Check in</span>
                                        </th>
                                        <td class="p-4">
                                            <p>From {{ $property->policies->check_in_from ?? 'No details provided' }} to {{ $property->policies->check_in_until ?? 'No details provided' }}</p>
                                            <p class="text-gray-500">You'll need to let the property know in advance what time you'll arrive.</p>
                                        </td>
                                    </tr>
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/check-out.svg" class="w-4 h-4 mt-1 shrink-0" alt="Check out">
                                            <span>Check out</span>
                                        </th>
                                        <td class="p-4">From {{ $property->policies->check_out_from ?? 'No details provided' }} to {{ $property->policies->check_out_until ?? 'No details provided' }}</td>
                                    </tr>
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/prepayment.svg" class="w-4 h-4 mt-1 shrink-0" alt="Cancellation">
                                            <span>Cancellation/ prepayment</span>
                                        </th>
                                        <td class="p-4">{{ $property->policies->cancellation_policy ?? 'No details provided' }}</td>
                                    </tr>
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/children.svg" class="w-4 h-4 mt-1 shrink-0" alt="Children">
                                            <span>Children</span>
                                        </th>
                                        <td class="p-4">{{ $property->policies->children_allowed ? 'Children are allowed' : 'Children are not allowed' }}</td>
                                    </tr>
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/nosmoking.svg" class="w-4 h-4 mt-1 shrink-0" alt="Smoking">
                                            <span>Smoking</span>
                                        </th>
                                        <td class="p-4">{{ $property->policies->smoking_allowed ? 'Smoking is allowed' : 'Smoking is not allowed' }}</td>
                                    </tr>
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/pets.svg" class="w-4 h-4 mt-1 shrink-0" alt="Pets">
                                            <span>Pets</span>
                                        </th>
                                        <td class="p-4">{{ $property->policies->pets_allowed ? 'Pets are allowed' : 'Pets are not allowed' }}</td>
                                    </tr>
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/payment.svg" class="w-4 h-4 mt-1 shrink-0" alt="Parties">
                                            <span>Parties</span>
                                        </th>
                                        <td class="p-4">{{ $property->policies->parties_allowed ? 'Parties are allowed' : 'Parties are not allowed' }}</td>
                                    </tr>
                                @else
                                    <tr class="align-top">
                                        <td colspan="2" class="p-4 text-center text-gray-500">No policy details provided</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- TAGS -->
            <div class="mt-10">
                <div
                    class="text-xs sm:text-sm text-gray-700 flex flex-wrap items-center justify-center gap-x-1 gap-y-1 leading-relaxed">
                    <span>Countries</span><span>&middot;</span>
                    <span>Regions</span><span>&middot;</span>
                    <span>Cities</span><span>&middot;</span>
                    <span>Districts</span><span>&middot;</span>
                    <span>Airports</span><span>&middot;</span>
                    <span>Hotels</span><span>&middot;</span>
                    <span>Places of interest</span><span>&middot;</span>
                    <span>Holiday Homes</span><span>&middot;</span>
                    <span>Apartments</span><span>&middot;</span>
                    <span>Resorts</span><span>&middot;</span>
                    <span>Villas</span><span>&middot;</span>
                    <span>Hostels</span><span>&middot;</span>
                    <span>B&amp;Bs</span><span>&middot;</span>
                    <span>Guest Houses</span><span>&middot;</span>
                    <span>Unique places to stay</span><span>&middot;</span>
                    <span>All destinations</span><span>&middot;</span>
                    <span>All flight destinations</span><span>&middot;</span>
                    <span>All car hire locations</span><span>&middot;</span>
                    <span>All</span><span>&middot;</span>
                    <span>Holiday destinations</span><span>&middot;</span>
                    <span>Guides</span><span>&middot;</span>
                    <span>Discover</span><span>&middot;</span>
                    <span>Reviews</span><span>&middot;</span>
                    <span>Discover monthly stays</span>
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



</body>

</html>
