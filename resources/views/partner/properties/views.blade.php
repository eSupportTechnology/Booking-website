<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Partner Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <a href="{{ route('partner.dashboard') }}" class="text-xl font-bold">Partner Panel</a>
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
                            <a href="{{ route('partner.earnings') }}"
                                class="block px-4 py-2 hover:bg-gray-100 rounded">Profile</a>
                            <a href="{{ route('partner.settings') }}"
                                class="block px-4 py-2 hover:bg-gray-100 rounded">Settings</a>
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
            <div class="border-b sticky top-0 bg-white">
                <div
                    class="max-w-6xl mx-auto flex space-x-6 overflow-x-auto text-sm md:text-base whitespace-nowrap px-4 py-2">
                    <a href="#overview" class="scroll-link">Overview</a>
                    <a href="#info" class="scroll-link">Villa info & price</a>
                    <a href="#facilities" class="scroll-link">Facilities</a>
                    <a href="#rules" class="scroll-link">House rules</a>
                    <a href="#fineprint" class="scroll-link">The fine print</a>
                    <a href="#reviews" class="scroll-link">Guest reviews ({{ $totalReviews }})</a>
                </div>
            </div>


        </div>
    </section>


    @php
        // Calculate review data at the top of the page for use throughout
        $guestReviews = \App\Models\Review::where('property_id', $property->id)->get();
        $hostReviews = \App\Models\HostReview::where('property_id', $property->id)->get();

        // Calculate average ratings
        $guestAvgRating = $guestReviews->count() > 0 ? round($guestReviews->avg('rating'), 1) : 0;
        $hostAvgRating = $hostReviews->count() > 0 ? round($hostReviews->avg('rating'), 1) : 0;

        // Get overall rating (average of both)
        $overallRating = ($guestAvgRating + $hostAvgRating) / 2;
        $overallRating = round($overallRating, 1);

        // Determine rating text
        $ratingText = 'Superb';
        if ($overallRating >= 9.0) {
            $ratingText = 'Exceptional';
        } elseif ($overallRating >= 8.0) {
            $ratingText = 'Superb';
        } elseif ($overallRating >= 7.0) {
            $ratingText = 'Very Good';
        } elseif ($overallRating >= 6.0) {
            $ratingText = 'Good';
        } else {
            $ratingText = 'Average';
        }

        $totalReviews = $guestReviews->count() + $hostReviews->count();
    @endphp

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
                            <div class="col-span-10 row-span-8 flex items-center justify-center bg-gray-200 rounded-lg">
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
                                    <h2 class="text-lg font-semibold text-gray-800">{{ $ratingText }}</h2>
                                    <p class="text-sm text-gray-500">{{ $totalReviews }} reviews</p>
                                </div>
                                <div class="bg-[#3CC0E9] text-white text-sm font-semibold px-2 py-1 rounded">
                                    {{ $overallRating }}</div>
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
                                <div class="border border-gray-300 px-2 py-0.5 text-sm rounded-md text-gray-800">
                                    {{ $hostAvgRating }}
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
                <!-- Dynamic Features from Database -->
                <div class="grid grid-cols-6 gap-4 py-2">
                    @php
                        // Get amenities from database
                        $amenities = $property->amenities ?? collect();
                        $topAmenities = $amenities->take(6);
                    @endphp

                    @if ($topAmenities->count() > 0)
                        @foreach ($topAmenities as $amenity)
                            <div
                                class="group relative bg-white rounded-lg shadow-sm p-2 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                                <!-- SVG Icon -->
                                @php
                                    $amenityFiles = [
                                        'Private bathroom' => 'Private_bathroom.svg',
                                        'Sea views' => 'Sea_view.svg',
                                        'Family rooms' => 'Family_rooms.svg',
                                        'Airport shuttle' => 'Airport_shuttle.svg',
                                        'Spa and wellness center' => 'Spa_and_wellness_centre.svg',
                                        'Air conditioning' => 'Air_conditioning.svg',
                                        'Heating' => 'Heating.svg',
                                        'Free WiFi' => 'In_all_areas_78_Mbps.svg',
                                        'Kitchen' => 'Kitchen.svg',
                                        'Kitchenette' => 'Kitchen.svg',
                                        'Washing machine' => 'Washing_machine.svg',
                                        'Flat-screen TV' => 'Flat-screen_TV.svg',
                                        'Balcony' => 'Balcony.svg',
                                        'View' => 'View.svg',
                                        'Bath' => 'Bath.svg',
                                        'Apartments' => 'Apartments.svg',
                                        'Pets allowed' => 'Pets_allowed.svg',
                                        'Non-smoking rooms' => 'Non-smoking_rooms.svg',
                                        'Free on-site parking' => 'Free_on-site_parking.svg',
                                        'Private parking' => 'Private_parking.svg',
                                        'Very good breakfast' => 'Very_good_breakfast.svg',
                                        'Private pool' => '2_swimming_pools.svg',
                                        '4 restaurants' => '4_restaurants.svg',
                                        '64 m size' => '64_m_size.svg',
                                        'Swimming Pool' => 'Swimming_Pool.svg',
                                        'Hot tub' => 'Hot_tub.svg',
                                        'Minibar' => 'Minibar.svg',
                                        'Sauna' => 'Sauna.svg',
                                        'Garden view' => 'Garden_view.svg',
                                        'Terrace' => 'Terrace.svg',
                                    ];

                                    $svgFile = $amenityFiles[$amenity->name] ?? null;
                                @endphp

                                @if($svgFile && file_exists(public_path('assets/amenities/' . $svgFile)))
                                    <img src="{{ asset('assets/amenities/' . $svgFile) }}"
                                         alt="{{ $amenity->name }}"
                                         class="w-8 h-8 object-contain">
                                @else
                                    <svg class="w-8 h-8 object-contain" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                                    </svg>
                                @endif

                                <!-- Label for desktop -->
                                <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium"
                                    style="font-family: 'Noto Sans', sans-serif;">
                                    {{ $amenity->name }}
                                </span>

                                <!-- Tooltip for mobile only -->
                                <div
                                    class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
                                    {{ $amenity->name }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="grid grid-cols-4 gap-4 py-2">
                    @php
                        // Get additional amenities for bottom row
                        $bottomAmenities = $amenities->skip(6)->take(4);

                    @endphp

                    @if ($bottomAmenities->count() > 0)
                        @foreach ($bottomAmenities as $amenity)
                            <div
                                class="group relative bg-white rounded-lg shadow-sm p-4 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                                <!-- SVG Icon -->
                                @php
                                    $amenityFiles = [
                                        'Private bathroom' => 'Private_bathroom.svg',
                                        'Sea views' => 'Sea_view.svg',
                                        'Family rooms' => 'Family_rooms.svg',
                                        'Airport shuttle' => 'Airport_shuttle.svg',
                                        'Spa and wellness center' => 'Spa_and_wellness_centre.svg',
                                        'Air conditioning' => 'Air_conditioning.svg',
                                        'Heating' => 'Heating.svg',
                                        'Free WiFi' => 'In_all_areas_78_Mbps.svg',
                                        'Kitchen' => 'Kitchen.svg',
                                        'Kitchenette' => 'Kitchen.svg',
                                        'Washing machine' => 'Washing_machine.svg',
                                        'Flat-screen TV' => 'Flat-screen_TV.svg',
                                        'Balcony' => 'Balcony.svg',
                                        'View' => 'View.svg',
                                        'Bath' => 'Bath.svg',
                                        'Apartments' => 'Apartments.svg',
                                        'Pets allowed' => 'Pets_allowed.svg',
                                        'Non-smoking rooms' => 'Non-smoking_rooms.svg',
                                        'Free on-site parking' => 'Free_on-site_parking.svg',
                                        'Private parking' => 'Private_parking.svg',
                                        'Very good breakfast' => 'Very_good_breakfast.svg',
                                        'Private pool' => '2_swimming_pools.svg',
                                        '4 restaurants' => '4_restaurants.svg',
                                        'size' => '64_m_size.svg',
                                        'Swimming Pool' => 'Swimming_Pool.svg',
                                        'Hot tub' => 'Hot_tub.svg',
                                        'Minibar' => 'Minibar.svg',
                                        'Sauna' => 'Sauna.svg',
                                        'Garden view' => 'Garden_view.svg',
                                        'Terrace' => 'Terrace.svg',

                                    ];

                                    $svgFile = $amenityFiles[$amenity->name] ?? null;
                                @endphp

                                @if($svgFile && file_exists(public_path('assets/amenities/' . $svgFile)))
                                    <img src="{{ asset('assets/amenities/' . $svgFile) }}"
                                         alt="{{ $amenity->name }}"
                                         class="w-8 h-8 object-contain">
                                @else
                                    <svg class="w-8 h-8 object-contain" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                                    </svg>
                                @endif

                                <!-- Label for desktop -->
                                <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium"
                                    style="font-family: 'Noto Sans', sans-serif;">
                                    {{ $amenity->name }}
                                </span>

                                <!-- Tooltip for mobile only -->
                                <div
                                    class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
                                    {{ $amenity->name }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
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
                            @if ($property->additionalDetails->guests)
                                <p class="text-sm"><span class="font-bold">Max Guests:</span>
                                    {{ $property->additionalDetails->guests }}</p>
                            @endif
                            @if ($property->additionalDetails->bathrooms)
                                <p class="text-sm"><span class="font-bold">Bathrooms:</span>
                                    {{ $property->additionalDetails->bathrooms }}</p>
                            @endif
                            @if ($property->additionalDetails->apartment_size)
                                <p class="text-sm"><span class="font-bold">Size:</span>
                                    {{ $property->additionalDetails->apartment_size }}
                                    {{ $property->additionalDetails->apartment_unit ?? 'sqm' }}</p>
                            @endif
                        @endif

                        @if ($property->bedrooms && $property->bedrooms->count() > 0)
                            <div class="text-sm">
                                <span class="font-bold">Bedrooms:</span>
                                @foreach ($property->bedrooms as $bedroom)
                                    <span
                                        class="inline-block bg-gray-100 px-2 py-1 rounded mr-2 mb-1">{{ $bedroom->name ?? 'Bedroom' }}
                                        ({{ $bedroom->twin + $bedroom->full + $bedroom->queen + $bedroom->king + $bedroom->bunk + $bedroom->sofa + $bedroom->futon }}
                                        beds)
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if ($property->hostProfile)
                            <p class="text-sm"><span class="font-bold">Host:</span>
                                {{ $property->hostProfile->host_name ?? 'Host information available' }}</p>
                            @if ($property->hostProfile->about_host)
                                <p class="text-sm"><span class="font-bold">About Host:</span>
                                    {{ $property->hostProfile->about_host }}</p>
                            @endif
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

                        @if ($property->category)
                            <div class="text-sm">
                                <span class="font-bold">Property Type:</span>
                                <span class="inline-block bg-green-100 px-2 py-1 rounded mr-2 mb-1">
                                    {{ $property->category->name ?? 'N/A' }}
                                    @if ($property->subcategory)
                                        - {{ $property->subcategory->name ?? 'N/A' }}
                                    @endif
                                    @if ($property->subtype)
                                        - {{ $property->subtype->name ?? 'N/A' }}
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                    @if ($property->amenities && $property->amenities->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-black mt-6 mb-4">Most popular facilities</h3>
                            <div class="flex flex-wrap gap-4">
                                @php
                                    $amenityIcons = [
                                        'Private bathroom' => 'Private_bathroom.svg',
                                        'Sea views' => 'Sea_view.svg',
                                        'Family rooms' => 'Family_rooms.svg',
                                        'Airport shuttle' => 'Airport_shuttle.svg',
                                        'Spa and wellness center' => 'Spa_and_wellness_centre.svg',
                                        'Air conditioning' => 'Air_conditioning.svg',
                                        'Heating' => 'Heating.svg',
                                        'Free WiFi' => 'In_all_areas_78_Mbps.svg',
                                        'Kitchen' => 'Kitchen.svg',
                                        'Kitchenette' => 'Kitchen.svg',
                                        'Washing machine' => 'Washing_machine.svg',
                                        'Flat-screen TV' => 'Flat-screen_TV.svg',
                                        'Balcony' => 'Balcony.svg',
                                        'View' => 'View.svg',
                                        'Bath' => 'Bath.svg',
                                        'Apartments' => 'Apartments.svg',
                                        'Pets allowed' => 'Pets_allowed.svg',
                                        'Non-smoking rooms' => 'Non-smoking_rooms.svg',
                                        'Free on-site parking' => 'Free_on-site_parking.svg',
                                        'Private parking' => 'Private_parking.svg',
                                        'Very good breakfast' => 'Very_good_breakfast.svg',
                                        'Private pool' => '2_swimming_pools.svg',
                                        '4 restaurants' => '4_restaurants.svg',
                                        'Swimming Pool' => 'Swimming_Pool.svg',
                                        'Hot tub' => 'Hot_tub.svg',
                                        'Minibar' => 'Minibar.svg',
                                        'Sauna' => 'Sauna.svg',
                                        'Garden view' => 'Garden_view.svg',
                                        'Terrace' => 'Terrace.svg',
                                    ];
                                @endphp
                                @foreach ($property->amenities as $amenity)
                                    @if (isset($amenityIcons[$amenity->name]))
                                        <div class="flex items-center justify-center lg:justify-start p-2">
                                            <img src="{{ asset('assets/amenities/' . $amenityIcons[$amenity->name]) }}" alt="{{ $amenity->name }}" class="w-5 h-5 mr-4" style="filter: brightness(0) saturate(100%) invert(47%) sepia(89%) saturate(1352%) hue-rotate(88deg) brightness(96%) contrast(86%);">
                                            <span class="text-sm text-gray-800 font-medium">{{ $amenity->name }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="w-full lg:w-auto lg:max-w-xs">
                    <div class="bg-blue-100 rounded-lg py-4 px-4 space-y-4">
                        @if ($property->pricing)
                            <div>
                                <h3 class="font-bold text-xs">Pricing Details</h3>
                                <p class="text-xs">Price per Night: LKR
                                    {{ number_format($property->pricing->price_per_night ?? ($property->pricing->base_price ?? 0)) }}
                                </p>
                                @if ($property->pricing->discount_percent)
                                    <p class="text-xs text-green-600">Discount:
                                        {{ $property->pricing->discount_percent }}%</p>
                                @endif
                                @if ($property->pricing->currency)
                                    <p class="text-xs">Currency: {{ strtoupper($property->pricing->currency) }}</p>
                                @endif
                            </div>
                        @endif

                        @if ($property->services)
                            <div>
                                <h3 class="font-bold text-xs">Services</h3>
                                @if ($property->services->serve_breakfast)
                                    <p class="text-xs">✓ Breakfast available</p>
                                @endif
                                @if ($property->services->breakfast_included)
                                    <p class="text-xs">✓ Breakfast included</p>
                                @endif
                                @if ($property->services->parking_available)
                                    <p class="text-xs">✓ Parking available</p>
                                @endif
                                @if ($property->services->parking_cost)
                                    <p class="text-xs">Parking: LKR
                                        {{ number_format($property->services->parking_cost) }}/{{ $property->services->parking_cost_unit ?? 'night' }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        <p class="text-xs flex items-center gap-x-1" style="font-family: 'Noto Sans', sans-serif;">
                            <img src="{{ asset('assets/parking.svg') }}" alt="Free Parking" class="w-4 h-4" />
                            Free private parking available on-site
                        </p>

                        @if($property->amenities && $property->amenities->whereIn('name', ['Golf', 'Fishing', 'Billiards', 'Swimming Pool', 'Gym', 'Spa', 'Tennis Court', 'Beach Access'])->count() > 0)
                        <div>
                            <h4 class="font-semibold text-xs">Activities:</h4>
                            <ul class="list-disc list-inside text-gray-800 text-xs">
                                @foreach($property->amenities->whereIn('name', ['Golf', 'Fishing', 'Billiards', 'Swimming Pool', 'Gym', 'Spa', 'Tennis Court', 'Beach Access']) as $activity)
                                    <li>{{ $activity->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($property->rooms && $property->rooms->count() > 0)
    <section id="info" class="py-8 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 border-t">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Room Management & Availability</h2>
                <div class="flex items-center gap-4">
                    <button onclick="alert('Room creation feature coming soon')"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium">
                        Add New Room
                    </button>
                    <div class="flex items-center text-blue-500 text-sm font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 010 8m-4-4h4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a4 4 0 00-4-4m0 0H8a4 4 0 000 8m0 0H6a2 2 0 00-2 2v4a2 2 0 002 2h2a4 4 0 004 4" />
                        </svg>
                        Partner Dashboard
                    </div>
                </div>
            </div>

            @if($property->rooms && $property->rooms->count() > 0)
                <div class="space-y-6">
                    <!-- Room Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-600">Total Rooms</h4>
                            <p class="text-2xl font-bold text-blue-800">{{ $property->rooms->count() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-green-600">Available</h4>
                            <p class="text-2xl font-bold text-green-800">{{ $property->rooms->where('is_available', true)->count() }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-yellow-600">Occupied</h4>
                            <p class="text-2xl font-bold text-yellow-800">{{ $property->rooms->where('is_available', false)->count() }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-purple-600">Avg. Price</h4>
                            <p class="text-2xl font-bold text-purple-800">LKR {{ number_format($property->rooms->avg('price_per_night') ?? 0) }}</p>
                        </div>
                    </div>

                    <!-- Rooms by Type -->
                    @foreach($property->rooms->groupBy('room_type_id') as $roomTypeId => $rooms)
                        @php
                            $roomType = $rooms->first()->roomType;
                            $sampleRoom = $rooms->first();
                        @endphp
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 p-4 border-b flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $roomType->name ?? 'Standard Room' }}</h3>
                                    <p class="text-sm text-gray-600">{{ $rooms->count() }} room(s) of this type</p>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="toggleRoomType({{ $roomTypeId }})"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                        Manage Type
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="text-left p-3 font-semibold">Room Details</th>
                                            <th class="text-left p-3 font-semibold">Capacity</th>
                                            <th class="text-left p-3 font-semibold">Price/Night</th>
                                            <th class="text-left p-3 font-semibold">Status</th>
                                            <th class="text-left p-3 font-semibold">Commission</th>
                                            <th class="text-left p-3 font-semibold">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rooms as $room)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="p-3 align-top">
                                                    <div class="space-y-1">
                                                        <h4 class="font-medium">{{ $room->name }}</h4>
                                                        <p class="text-xs text-gray-500">{{ $room->description ?? 'No description' }}</p>
                                                        @if($room->size_sq_m)
                                                            <p class="text-xs text-gray-500">{{ $room->size_sq_m }} m²</p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="p-3 align-top">
                                                    <div class="flex gap-1">
                                                        @for($i = 0; $i < min($room->max_guests ?? 2, 4); $i++)
                                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Max {{ $room->max_guests ?? 2 }}</p>
                                                </td>
                                                <td class="p-3 align-top">
                                                    <div class="text-lg font-bold">LKR {{ number_format($room->price_per_night ?? 0) }}</div>
                                                    @if($room->discount_enabled && $room->discount_percentage)
                                                        <span class="bg-green-600 text-white text-xs px-2 py-1 rounded">{{ $room->discount_percentage }}% off</span>
                                                    @endif
                                                    <div class="text-xs text-gray-500 mt-1">{{ $room->currency ?? 'LKR' }}</div>
                                                </td>
                                                <td class="p-3 align-top">
                                                    @php
                                                        $bookedDates = \App\Models\Booking::where('room_id', $room->id)
                                                            ->where('status', '!=', 'cancelled')
                                                            ->where('check_out', '>=', now())
                                                            ->get(['check_in', 'check_out']);
                                                        $isCurrentlyOccupied = $bookedDates->where('check_in', '<=', now())
                                                            ->where('check_out', '>=', now())->count() > 0;
                                                    @endphp
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        {{ $isCurrentlyOccupied ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ $isCurrentlyOccupied ? 'Occupied' : 'Available' }}
                                                    </span>
                                                    @if($bookedDates->count() > 0)
                                                        <div class="mt-1">
                                                            <p class="text-xs text-gray-600 font-medium">Upcoming bookings:</p>
                                                            @foreach($bookedDates->take(2) as $booking)
                                                                <p class="text-xs text-gray-500">
                                                                    {{ \Carbon\Carbon::parse($booking->check_in)->format('M j') }} -
                                                                    {{ \Carbon\Carbon::parse($booking->check_out)->format('M j') }}
                                                                </p>
                                                            @endforeach
                                                            @if($bookedDates->count() > 2)
                                                                <p class="text-xs text-gray-400">+{{ $bookedDates->count() - 2 }} more</p>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @if($room->bathroom_count)
                                                        <p class="text-xs text-gray-500 mt-1">{{ $room->bathroom_count }} bath(s)</p>
                                                    @endif
                                                </td>
                                                <td class="p-3 align-top">
                                                    <div class="text-sm font-medium">{{ $room->commission_percentage ?? 0 }}%</div>
                                                    <div class="text-xs text-gray-500">You earn: LKR {{ number_format($room->you_earn ?? 0) }}</div>
                                                </td>
                                                <td class="p-3 align-top">
                                                    <div class="flex flex-col gap-1">
                                                        <button onclick="alert('Room editing feature coming soon')"
                                                           class="text-blue-600 hover:text-blue-800 text-xs underline">
                                                            Edit
                                                        </button>
                                                        <button onclick="toggleAvailability({{ $room->id }})"
                                                                class="text-yellow-600 hover:text-yellow-800 text-xs underline text-left">
                                                            {{ $room->is_available ? 'Mark Occupied' : 'Mark Available' }}
                                                        </button>
                                                        <button onclick="viewBookings({{ $room->id }})"
                                                                class="text-green-600 hover:text-green-800 text-xs underline text-left">
                                                            View Bookings
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No rooms configured</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding your first room to this property.</p>
                    <div class="mt-6">
                        <button onclick="alert('Room creation feature coming soon')"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Room
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </section>
    @endif

    <script>
        function toggleAvailability(roomId) {
            if (confirm('Are you sure you want to change the availability status of this room?')) {
                fetch(`/partner/rooms/${roomId}/toggle-availability`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating room availability');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating room availability');
                });
            }
        }

        function viewBookings(roomId) {
            window.location.href = `/partner/rooms/${roomId}/bookings`;
        }

        function toggleRoomType(roomTypeId) {
            // Implement room type management functionality
            console.log('Managing room type:', roomTypeId);
        }
    </script>


    <section id="reviews" class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Guest Reviews Header -->
            <h2 class="text-xl sm:text-2xl font-bold mb-4">Guest reviews</h2>
            <div class="flex items-center gap-4 mb-6 flex-wrap">
                <div class="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">{{ $overallRating }}</div>
                <span class="font-semibold text-gray-800">{{ $ratingText }}</span>
                <span class="text-gray-500 text-sm">{{ $totalReviews }} reviews</span>
                <a href="#" class="text-blue-600 text-sm underline">Read all reviews</a>
            </div>

            <!-- Categories -->
            <h3 class="font-semibold mb-3">Categories :</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Staff</span><span>{{ $staffRating }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $staffRating * 10 }}%;"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Facilities</span><span>{{ $facilitiesRating }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $facilitiesRating * 10 }}%;">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Cleanliness</span><span>{{ $cleanlinessRating }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $cleanlinessRating * 10 }}%;">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Comfort</span><span>{{ $comfortRating }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $comfortRating * 10 }}%;"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Value for money</span><span>{{ $valueRating }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $valueRating * 10 }}%;"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Location</span><span>{{ $locationRating }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $locationRating * 10 }}%;"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Free WiFi</span><span>{{ $wifiRating }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $wifiRating * 10 }}%;"></div>
                    </div>
                </div>
            </div>
            <!-- Guest Reviews -->
            <h3 class="font-semibold text-lg mb-4">
                Guests who stayed here loved ({{ $guestReviews->count() }})
            </h3>

            <div class="grid md:grid-cols-3 gap-4 mb-6">
                @foreach ($guestReviews as $review)
                    <div class="border rounded-lg p-4 shadow-sm bg-gray-50">
                        <div class="flex items-center gap-2 mb-2">
                            <!-- Example avatar placeholder -->
                            <img src="https://i.pravatar.cc/40?u={{ $review->user_id ?? rand(1, 100) }}"
                                alt="Avatar" class="w-10 h-10 rounded-full" />
                            <div>
                                <p class="font-semibold text-sm">
                                    User ID: {{ $review->user_id ?? 'N/A' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    Booking ID: {{ $review->booking_id ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Rating Stars -->
                        <p class="mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <span class="text-yellow-500">★</span>
                                @else
                                    <span class="text-gray-300">★</span>
                                @endif
                            @endfor
                            <span class="text-sm text-gray-500">({{ $review->rating }}/5)</span>
                        </p>

                        <!-- Comment -->
                        @if ($review->comment)
                            <p class="text-sm text-gray-700 mb-2">
                                “{{ $review->comment }}”
                            </p>
                        @endif

                        <!-- Created Date -->
                        <p class="text-xs text-gray-500 mb-2">
                            Created: {{ $review->created_at ? $review->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                        </p>

                        <!-- Read More -->
                        <a href="#" class="text-blue-600 text-sm underline">
                            Read more
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Read All Reviews Button -->
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
                        <span
                            class="px-2 py-0.5 border border-blue-300 rounded-md text-blue-600">{{ $hostAvgRating }}</span>
                    </div>
                </div>

                <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <!-- Host Image -->
                    @if ($property->files && $property->files->count() > 0)
                        <img src="{{ asset('storage/' . $property->files->first()->path) }}" alt="Host"
                            class="w-32 h-32 object-cover rounded-full border">
                    @else
                        <div
                            class="w-32 h-32 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full border flex items-center justify-center">
                            <i class="fas fa-user text-gray-500 text-4xl"></i>
                        </div>
                    @endif

                    <!-- Host Details -->
                    <div class="space-y-2 text-sm text-gray-700">
                        @if ($property->hostProfile)
                            <p><strong>Host:</strong> {{ $property->hostProfile->host_name ?? 'Host Name' }}</p>
                            <p><strong>Contact:</strong>
                                {{ $property->hostProfile->contact_info ?? 'Contact unavailable' }}</p>
                            <p><strong>Response Rate:</strong> {{ $property->hostProfile->response_rate ?? 'n/a' }}%</p>
                        @else
                            <p>This is a <span class="font-medium">Villa Type</span></p>
                            <p>Extra activities are unavailable</p>
                        @endif
                        <p><strong>Location:</strong> {{ $property->city ?? 'Gregory Lake' }}</p>
                        @if ($property->languages && $property->languages->count() > 0)
                            <p><strong>Languages spoken:</strong>
                                <span>{{ $property->languages->pluck('name')->join(', ') }}</spanlass=>
                            </p>
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
                                @if ($property->policies)
                                    <tr class="align-top">
                                        <th
                                            class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/check-in.svg" class="w-4 h-4 mt-1 shrink-0"
                                                alt="Check in">
                                            <span>Check in</span>
                                        </th>
                                        <td class="p-4">
                                            <p>From {{ $property->policies->check_in_from ?? 'No details provided' }}
                                                to {{ $property->policies->check_in_until ?? 'No details provided' }}
                                            </p>
                                            <p class="text-gray-500">You'll need to let the property know in advance
                                                what time you'll arrive.</p>
                                        </td>
                                    </tr>
                                    <tr class="align-top">
                                        <th
                                            class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/check-out.svg" class="w-4 h-4 mt-1 shrink-0"
                                                alt="Check out">
                                            <span>Check out</span>
                                        </th>
                                        <td class="p-4">From
                                            {{ $property->policies->check_out_from ?? 'No details provided' }} to
                                            {{ $property->policies->check_out_until ?? 'No details provided' }}</td>
                                    </tr>
                                    <tr class="align-top">
                                        <th
                                            class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/prepayment.svg" class="w-4 h-4 mt-1 shrink-0"
                                                alt="Cancellation">
                                            <span>Cancellation/ prepayment</span>
                                        </th>
                                        <td class="p-4">
                                            {{ $property->policies->cancellation_policy ?? 'No details provided' }}
                                        </td>
                                    </tr>
                                    <tr class="align-top">
                                        <th
                                            class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/children.svg" class="w-4 h-4 mt-1 shrink-0"
                                                alt="Children">
                                            <span>Children</span>
                                        </th>
                                        <td class="p-4">
                                            {{ $property->policies->children_allowed ? 'Children are allowed' : 'Children are not allowed' }}
                                        </td>
                                    </tr>
                                    <tr class="align-top">
                                        <th
                                            class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/nosmoking.svg" class="w-4 h-4 mt-1 shrink-0"
                                                alt="Smoking">
                                            <span>Smoking</span>
                                        </th>
                                        <td class="p-4">
                                            {{ $property->policies->smoking_allowed ? 'Smoking is allowed' : 'Smoking is not allowed' }}
                                        </td>
                                    </tr>
                                    <tr class="align-top">
                                        <th
                                            class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/pets.svg" class="w-4 h-4 mt-1 shrink-0" alt="Pets">
                                            <span>Pets</span>
                                        </th>
                                        <td class="p-4">
                                            {{ $property->policies->pets_allowed ? 'Pets are allowed' : 'Pets are not allowed' }}
                                        </td>
                                    </tr>
                                    <tr class="align-top">
                                        <th
                                            class="p-4 font-bold whitespace-normal flex items-center justify-start lg:justify-start gap-2">
                                            <img src="/assets/payment.svg" class="w-4 h-4 mt-1 shrink-0"
                                                alt="Parties">
                                            <span>Parties</span>
                                        </th>
                                        <td class="p-4">
                                            {{ $property->policies->parties_allowed ? 'Parties are allowed' : 'Parties are not allowed' }}
                                        </td>
                                    </tr>
                                @else
                                    <tr class="align-top">
                                        <td colspan="2" class="p-4 text-center text-gray-500">No policy details
                                            provided</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



    @php
        // Helper function to safely display JSON fields
        function safeDisplay($value)
        {
            if (is_null($value)) {
                return 'N/A';
            }
            if (is_array($value)) {
                return implode(
                    ', ',
                    array_map(function ($item) {
                        return is_array($item) ? json_encode($item) : (string) $item;
                    }, $value),
                );
            }
            if (is_string($value)) {
                return $value;
            }
            if (is_bool($value)) {
                return $value ? 'Yes' : 'No';
            }
            if (is_numeric($value)) {
                return (string) $value;
            }
            return json_encode($value);
        }
    @endphp

    <!-- Database Details Section -->
    <section class="py-4 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-black">All Property Details</h2>
                <button onclick="toggleDatabaseDetails()"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors duration-200">
                    <span id="toggleText">Show Details</span>
                </button>
            </div>

            <div id="databaseDetails" class="pt-4 sm:pt-6 lg:pt-10 bg-white" style="display: none;">
                <div class="w-full overflow-x-auto">
                    <table class="w-full border border-blue-500 border-collapse text-sm text-left min-w-[1000px]">
                        <thead>
                            <tr class="bg-blue-100 text-gray-800">
                                <th class="p-3 font-semibold border border-blue-500 w-[250px]">Category</th>
                                <th class="p-3 font-semibold border border-blue-500">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Property Basic Info -->
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                    <h3 class="text-blue-600 font-semibold">Property Information</h3>
                                </td>
                                <td class="p-3 align-top border border-blue-500">
                                    <div class="space-y-2 text-sm">
                                        <p class="border-b pb-2"><strong>Title:</strong>
                                            {{ $property->title ?? 'N/A' }}</p>
                                        <p class="border-b pb-2"><strong>Address:</strong>
                                            {{ $property->address ?? 'N/A' }}</p>
                                        <p class="border-b pb-2"><strong>City:</strong>
                                            {{ $property->city ?? 'N/A' }}</p>
                                        <p class="border-b pb-2"><strong>Country:</strong>
                                            {{ $property->country ?? 'N/A' }}</p>
                                        <p class="border-b pb-2"><strong>Zipcode:</strong>
                                            {{ $property->zipcode ?? 'N/A' }}</p>
                                        <p class="border-b pb-2"><strong>Status:</strong>
                                            {{ $property->status ?? 'N/A' }}</p>
                                        <p class="border-b pb-2"><strong>Stars:</strong>
                                            {{ $property->stars ?? 'N/A' }}</p>
                                        @if ($property->invoicing_info)
                                            <p class="border-b pb-2"><strong>Invoicing Info:</strong>
                                                {{ safeDisplay($property->invoicing_info) }}</p>
                                        @endif
                                        @if ($property->payment_method)
                                            <p class="border-b pb-2"><strong>Payment Method:</strong>
                                                {{ $property->payment_method }}</p>
                                        @endif
                                        @if ($property->open_for_bookings !== null)
                                            <p class="border-b pb-2"><strong>Open for Bookings:</strong>
                                                {{ safeDisplay($property->open_for_bookings) }}</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Additional Details -->
                            @if ($property->additionalDetails)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Additional Details</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Details:</strong>
                                                {{ $property->additionalDetails->details ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Special Features:</strong>
                                                {{ $property->additionalDetails->special_features ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Pricing -->
                            @if ($property->pricings)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Pricing Details</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Base Price:</strong> LKR
                                                {{ number_format($property->pricing->price_per_night ?? ($property->pricing->base_price ?? 0)) }}</p>
                                            <p class="border-b pb-2"><strong>Original Price:</strong> LKR
                                                {{ number_format($property->pricings->original_price ?? 0) }}</p>
                                            <p class="border-b pb-2"><strong>Discount:</strong>
                                                {{ $property->pricings->discount_percentage ?? 0 }}%</p>
                                            <p class="border-b pb-2"><strong>Tax Amount:</strong> LKR
                                                {{ number_format($property->pricings->tax_amount ?? 0) }}</p>
                                            <p class="border-b pb-2"><strong>Currency:</strong>
                                                {{ $property->pricings->currency ?? 'LKR' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Services -->
                            @if ($property->services)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Services</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Breakfast:</strong>
                                                {{ $property->services->breakfast_included ? 'Yes' : 'No' }}</p>
                                            <p class="border-b pb-2"><strong>WiFi:</strong>
                                                {{ $property->services->wifi_available ? 'Yes' : 'No' }}</p>
                                            <p class="border-b pb-2"><strong>Parking:</strong>
                                                {{ $property->services->parking_available ? 'Yes' : 'No' }}</p>
                                            <p class="border-b pb-2"><strong>Room Service:</strong>
                                                {{ $property->services->room_service ? 'Yes' : 'No' }}</p>
                                            <p class="border-b pb-2"><strong>Laundry:</strong>
                                                {{ $property->services->laundry_service ? 'Yes' : 'No' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Policies -->
                            @if ($property->policies)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Policies</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Check-in:</strong> From
                                                {{ $property->policies->check_in_from ?? 'No details provided' }} to
                                                {{ $property->policies->check_in_until ?? 'No details provided' }}</p>
                                            <p class="border-b pb-2"><strong>Check-out:</strong> From
                                                {{ $property->policies->check_out_from ?? 'No details provided' }} to
                                                {{ $property->policies->check_out_until ?? 'No details provided' }}
                                            </p>
                                            <p class="border-b pb-2"><strong>Cancellation:</strong>
                                                {{ $property->policies->flexible_cancellation ? 'Flexible' : 'Strict' }}
                                            </p>
                                            <p class="border-b pb-2"><strong>Children:</strong>
                                                {{ $property->policies->children_allowed ? 'Allowed' : 'Not allowed' }}
                                            </p>
                                            <p class="border-b pb-2"><strong>Pets:</strong>
                                                {{ $property->policies->pets_allowed ? 'Allowed' : 'Not allowed' }}
                                            </p>
                                            <p class="border-b pb-2"><strong>Smoking:</strong>
                                                {{ $property->policies->smoking_allowed ? 'Allowed' : 'Not allowed' }}
                                            </p>
                                            <p class="border-b pb-2"><strong>Pay at Property:</strong>
                                                {{ $property->policies->pay_at_property ? 'Yes' : 'No' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Host Profile -->
                            @if ($property->hostProfile)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Host Information</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Host Name:</strong>
                                                {{ $property->hostProfile->host_name ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Contact:</strong>
                                                {{ $property->hostProfile->contact_info ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Bio:</strong>
                                                {{ $property->hostProfile->bio ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Response Rate:</strong>
                                                {{ $property->hostProfile->response_rate ?? 'N/A' }}%</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Bedrooms -->
                            @if ($property->bedrooms && $property->bedrooms->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Bedrooms
                                            ({{ $property->bedrooms->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach ($property->bedrooms as $bedroom)
                                                <div class="border p-3 rounded bg-gray-50">
                                                    <p class="border-b pb-2"><strong>Type:</strong>
                                                        {{ $bedroom->bedroom_type ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Beds:</strong>
                                                        {{ $bedroom->bed_count ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Bed Type:</strong>
                                                        {{ $bedroom->bed_type ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Size:</strong>
                                                        {{ $bedroom->room_size ?? 'N/A' }} sqm</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Amenities -->
                            @if ($property->amenities && $property->amenities->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Amenities
                                            ({{ $property->amenities->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($property->amenities as $amenity)
                                                <span
                                                    class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">{{ $amenity->name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Languages -->
                            @if ($property->languages && $property->languages->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Languages Spoken
                                            ({{ $property->languages->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($property->languages as $language)
                                                <span
                                                    class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">{{ $language->name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Categories -->
                            @if ($property->category)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Property Category</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Category:</strong>
                                                {{ $property->category->name ?? 'N/A' }}</p>
                                            @if ($property->subcategory)
                                                <p class="border-b pb-2"><strong>Subcategory:</strong>
                                                    {{ $property->subcategory->name ?? 'N/A' }}</p>
                                            @endif
                                            @if ($property->subtype)
                                                <p class="border-b pb-2"><strong>Subtype:</strong>
                                                    {{ $property->subtype->name ?? 'N/A' }}</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Availability Settings -->
                            @if ($property->availabilitySettings)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Availability Settings</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Availability Mode:</strong>
                                                {{ $property->availabilitySettings->availability_mode ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Availability Days:</strong>
                                                {{ $property->availabilitySettings->availability_days ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Allow Long Stays:</strong>
                                                {{ $property->availabilitySettings->allow_long_stays ? 'Yes' : 'No' }}
                                            </p>
                                            <p class="border-b pb-2"><strong>Max Nights:</strong>
                                                {{ $property->availabilitySettings->max_nights ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Sync TripAdvisor:</strong>
                                                {{ $property->availabilitySettings->sync_tripadvisor ? 'Yes' : 'No' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Facilities -->
                            @if ($property->facilities && $property->facilities->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Property Facilities
                                            ({{ $property->facilities->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($property->facilities as $facility)
                                                <span
                                                    class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">{{ $facility->facility_name }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Photos -->
                            @if ($property->photos && $property->photos->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Property Photos
                                            ({{ $property->photos->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            @foreach ($property->photos as $photo)
                                                <div class="border-b pb-2">
                                                    <p><strong>Photo URL:</strong> <a href="{{ $photo->path }}"
                                                            target="_blank"
                                                            class="text-blue-600 hover:underline">{{ Str::limit($photo->path, 50) }}</a>
                                                    </p>
                                                    <p><strong>File Type:</strong> {{ $photo->file_type ?? 'N/A' }}
                                                    </p>
                                                    <p><strong>Property Type:</strong>
                                                        {{ $photo->property_type ?? 'N/A' }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Rooms -->
                            @if ($property->rooms && $property->rooms->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Rooms
                                            ({{ $property->rooms->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach ($property->rooms as $room)
                                                <div class="border p-3 rounded bg-gray-50">
                                                    <p class="border-b pb-2"><strong>Name:</strong>
                                                        {{ $room->name ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Description:</strong>
                                                        {{ $room->description ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Price Per Night:</strong>
                                                        {{ $room->price_per_night ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Max Guests:</strong>
                                                        {{ $room->max_guests ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Bathroom Count:</strong>
                                                        {{ $room->bathroom_count ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Bathroom Type:</strong>
                                                        {{ $room->bathroom_type ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Bathroom Amenities:</strong>
                                                        {{ safeDisplay($room->bathroom_amenities ?? null) }}</p>
                                                    <p class="border-b pb-2"><strong>Size (sq m):</strong>
                                                        {{ $room->size_sq_m ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Smoking Allowed:</strong>
                                                        {{ safeDisplay($room->smoking_allowed ?? null) }}</p>
                                                    <p class="border-b pb-2"><strong>Room Type:</strong>
                                                        {{ $room->room_type ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Currency:</strong>
                                                        {{ $room->currency ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Discount Enabled:</strong>
                                                        {{ safeDisplay($room->discount_enabled ?? null) }}</p>
                                                    <p class="border-b pb-2"><strong>Commission Percentage:</strong>
                                                        {{ $room->commission_percentage ?? 'N/A' }}%</p>
                                                    <p class="border-b pb-2"><strong>You Earn:</strong>
                                                        {{ $room->you_earn ?? 'N/A' }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Amenity -->
                            @if ($property->propertyAmenities && $property->propertyAmenities->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Property Amenities
                                            ({{ $property->propertyAmenities->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($property->propertyAmenities as $propertyAmenity)
                                                <span
                                                    class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">{{ $propertyAmenity->amenity->name ?? 'N/A' }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Language -->
                            @if ($property->propertyLanguages && $property->propertyLanguages->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Property Languages
                                            ({{ $property->propertyLanguages->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($property->propertyLanguages as $propertyLanguage)
                                                <span
                                                    class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">{{ $propertyLanguage->language->name ?? 'N/A' }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Additional Details Extended -->
                            @if ($property->additionalDetails)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Additional Details Extended</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Guests:</strong>
                                                {{ $property->additionalDetails->guests ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Bathrooms:</strong>
                                                {{ $property->additionalDetails->bathrooms ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Allow Children:</strong>
                                                {{ $property->additionalDetails->allow_children ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Offer Cribs:</strong>
                                                {{ $property->additionalDetails->offer_cribs ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Apartment Size:</strong>
                                                {{ $property->additionalDetails->apartment_size ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Apartment Unit:</strong>
                                                {{ $property->additionalDetails->apartment_unit ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Breakfast:</strong>
                                                {{ $property->additionalDetails->breakfast ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Parking:</strong>
                                                {{ $property->additionalDetails->parking ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Services Extended -->
                            @if ($property->services)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Services Extended</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Serve Breakfast:</strong>
                                                {{ safeDisplay($property->services->serve_breakfast ?? null) }}</p>
                                            <p class="border-b pb-2"><strong>Breakfast Included:</strong>
                                                {{ $property->services->breakfast_included ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Breakfast Type:</strong>
                                                {{ safeDisplay($property->services->breakfast_type ?? null) }}</p>
                                            <p class="border-b pb-2"><strong>Breakfast Price:</strong>
                                                {{ $property->services->breakfast_price ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Parking Available:</strong>
                                                {{ $property->services->parking_available ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Parking Cost:</strong>
                                                {{ $property->services->parking_cost ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Parking Cost Unit:</strong>
                                                {{ $property->services->parking_cost_unit ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Parking Reservation:</strong>
                                                {{ $property->services->parking_reservation ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Parking Location:</strong>
                                                {{ $property->services->parking_location ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Parking Type:</strong>
                                                {{ safeDisplay($property->services->parking_type ?? null) }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Policies Extended -->
                            @if ($property->policies)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Policies Extended</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Cancellation Policy:</strong>
                                                {{ $property->policies->cancellation_policy ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Check In From:</strong>
                                                {{ $property->policies->check_in_from ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Check In Until:</strong>
                                                {{ $property->policies->check_in_until ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Check Out From:</strong>
                                                {{ $property->policies->check_out_from ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Check Out Until:</strong>
                                                {{ $property->policies->check_out_until ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Smoking Allowed:</strong>
                                                {{ safeDisplay($property->policies->smoking_allowed ?? null) }}</p>
                                            <p class="border-b pb-2"><strong>Parties Allowed:</strong>
                                                {{ safeDisplay($property->policies->parties_allowed ?? null) }}</p>
                                            <p class="border-b pb-2"><strong>Pets Allowed:</strong>
                                                {{ $property->policies->pets_allowed ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Pets Fees:</strong>
                                                {{ $property->policies->pets_fees ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Pricings Extended -->
                            @if ($property->pricings)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Pricing Extended</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>Booking Type:</strong>
                                                {{ $property->pricings->booking_type ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Price Per Night:</strong>
                                                {{ $property->pricings->price_per_night ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Currency:</strong>
                                                {{ $property->pricings->currency ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Discount Enabled:</strong>
                                                {{ safeDisplay($property->pricings->discount_enabled ?? null) }}</p>
                                            <p class="border-b pb-2"><strong>Discount Percent:</strong>
                                                {{ $property->pricings->discount_percent ?? 'N/A' }}%</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Host Profile Extended -->
                            @if ($property->hostProfile)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Host Profile Extended</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-2 text-sm">
                                            <p class="border-b pb-2"><strong>About Property:</strong>
                                                {{ $property->hostProfile->about_property ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>About Host:</strong>
                                                {{ $property->hostProfile->about_host ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>About Neighborhood:</strong>
                                                {{ $property->hostProfile->about_neighborhood ?? 'N/A' }}</p>
                                            <p class="border-b pb-2"><strong>Show Property:</strong>
                                                {{ safeDisplay($property->hostProfile->show_property ?? null) }}</p>
                                            <p class="border-b pb-2"><strong>Show Host:</strong>
                                                {{ safeDisplay($property->hostProfile->show_host ?? null) }}</p>
                                            <p class="border-b pb-2"><strong>Show Neighborhood:</strong>
                                                {{ safeDisplay($property->hostProfile->show_neighborhood ?? null) }}
                                            </p>
                                            <p class="border-b pb-2"><strong>None Selected:</strong>
                                                {{ safeDisplay($property->hostProfile->none_selected ?? null) }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Property Bedrooms Extended -->
                            @if ($property->bedrooms && $property->bedrooms->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Bedrooms Extended
                                            ({{ $property->bedrooms->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach ($property->bedrooms as $bedroom)
                                                <div class="border p-3 rounded bg-gray-50">
                                                    <p class="border-b pb-2"><strong>Room Type:</strong>
                                                        {{ $bedroom->room_type ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Name:</strong>
                                                        {{ $bedroom->name ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Twin Beds:</strong>
                                                        {{ $bedroom->twin ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Full Beds:</strong>
                                                        {{ $bedroom->full ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Queen Beds:</strong>
                                                        {{ $bedroom->queen ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>King Beds:</strong>
                                                        {{ $bedroom->king ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Bunk Beds:</strong>
                                                        {{ $bedroom->bunk ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Sofa Beds:</strong>
                                                        {{ $bedroom->sofa ?? 'N/A' }}</p>
                                                    <p class="border-b pb-2"><strong>Futon Beds:</strong>
                                                        {{ $bedroom->futon ?? 'N/A' }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Host Reviews -->
                            @php
                                $hostReviews = \App\Models\HostReview::where('property_id', $property->id)
                                    ->with(['guest', 'host', 'booking'])
                                    ->get();
                            @endphp
                            @if ($hostReviews && $hostReviews->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Host Reviews
                                            ({{ $hostReviews->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-4">
                                            @foreach ($hostReviews as $review)
                                                <div class="border p-3 rounded bg-gray-50">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <p class="border-b pb-2"><strong>Rating:</strong>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $review->rating)
                                                                        <span class="text-yellow-500">★</span>
                                                                    @else
                                                                        <span class="text-gray-300">★</span>
                                                                    @endif
                                                                @endfor
                                                                ({{ $review->rating }}/5)
                                                            </p>
                                                            <p class="border-b pb-2"><strong>Guest ID:</strong>
                                                                {{ $review->guest_id ?? 'N/A' }}</p>
                                                            <p class="border-b pb-2"><strong>Host ID:</strong>
                                                                {{ $review->host_id ?? 'N/A' }}</p>
                                                            <p class="border-b pb-2"><strong>Booking ID:</strong>
                                                                {{ $review->booking_id ?? 'N/A' }}</p>
                                                            @if ($review->comment)
                                                                <p class="border-b pb-2"><strong>Comment:</strong>
                                                                    {{ $review->comment }}</p>
                                                            @endif
                                                            <p class="border-b pb-2"><strong>Created:</strong>
                                                                {{ $review->created_at ? $review->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            <!-- Guest Reviews -->
                            @php
                                $guestReviews = \App\Models\Review::where('property_id', $property->id)
                                    ->with(['user', 'booking'])
                                    ->get();
                            @endphp
                            @if ($guestReviews && $guestReviews->count() > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500 bg-gray-50">
                                        <h3 class="text-blue-600 font-semibold">Guest Reviews
                                            ({{ $guestReviews->count() }})</h3>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="space-y-4">
                                            @foreach ($guestReviews as $review)
                                                <div class="border p-3 rounded bg-gray-50">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <div>
                                                            <p class="border-b pb-2"><strong>Rating:</strong>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $review->rating)
                                                                        <span class="text-yellow-500">★</span>
                                                                    @else
                                                                        <span class="text-gray-300">★</span>
                                                                    @endif
                                                                @endfor
                                                                ({{ $review->rating }}/5)
                                                            </p>
                                                            <p class="border-b pb-2"><strong>User ID:</strong>
                                                                {{ $review->user_id ?? 'N/A' }}</p>
                                                            <p class="border-b pb-2"><strong>Booking ID:</strong>
                                                                {{ $review->booking_id ?? 'N/A' }}</p>
                                                            @if ($review->comment)
                                                                <p class="border-b pb-2"><strong>Comment:</strong>
                                                                    {{ $review->comment }}</p>
                                                            @endif
                                                            <p class="border-b pb-2"><strong>Created:</strong>
                                                                {{ $review->created_at ? $review->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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

    <script>
        function toggleDatabaseDetails() {
            const details = document.getElementById('databaseDetails');
            const toggleText = document.getElementById('toggleText');

            if (details.style.display === 'none') {
                details.style.display = 'block';
                toggleText.textContent = 'Hide Details';
            } else {
                details.style.display = 'none';
                toggleText.textContent = 'Show Details';
            }
        }
    </script>



</body>

</html>

