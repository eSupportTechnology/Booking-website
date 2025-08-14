<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Single Hotel | Bookintour.com</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">

  <!-- Header -->
  <header class="bg-[#1F8FB2] text-white py-6">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6 md:gap-0">
      <!-- Left Section -->
      <div class="w-full md:w-auto">
        <div class="flex flex-col items-start">
          @php $host = config('domains.app_name'); @endphp
          <a href="{{ url('/') }}" class="text-2xl font-bold flex items-center">
            @if ($host == 'BookinTour')
              <h1>Bookintour.com</h1>
            @elseif ($host == 'Inselor')
              <img src="{{ asset('images/inselor-logo.png') }}" alt="Inselor" class="h-12 w-auto align-middle" />
            @endif
          </a>

          @php $currentRoute = request()->route()->getName(); @endphp

          <!-- Navigation -->
          <nav class="flex flex-wrap gap-4 text-sm md:text-base mt-6">
            <a href="{{ route('stays') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'stays' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-4 h-4" />
              <span>Stays</span>
            </a>

            <a href="{{ route('car.rentals') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'car.rentals' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/car.svg') }}" alt="Car" class="w-4 h-4" />
              <span>Car rentals</span>
            </a>

            <a href="{{ route('airport.taxis') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'airport.taxis' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/taxi.svg') }}" alt="Taxi" class="w-4 h-4" />
              <span>Airport taxis</span>
            </a>

            <a href="{{ route('airport.tours') }}"
              class="flex items-center space-x-1 px-3 py-1 rounded-full border text-white transition
              {{ $currentRoute == 'airport.tours' ? 'border-white bg-[#1F8FB2]' : 'border-transparent hover:border-white' }}">
              <img src="{{ asset('assets/tour.svg') }}" alt="Tour" class="w-4 h-4" />
              <span>Tour packages</span>
            </a>
          </nav>
        </div>
      </div>

      <!-- Right Section -->
      <div class="flex items-center gap-4 sm:gap-5 flex-wrap justify-center md:justify-end">
        <span class="text-base sm:text-lg">LKR</span>
        <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden">
          <img src="https://flagcdn.com/gb.svg" alt="UK Flag" class="w-full h-full object-cover" />
        </div>
        <div>
          <a href="#" class="flex items-center justify-center w-7 h-7 bg-[#1F8FB2] rounded-full hover:bg-[#29ACD5] text-white border border-white text-sm font-semibold" title="Help">?</a>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
          <div class="bg-yellow-400 text-black rounded-full w-7 h-7 sm:w-9 sm:h-9 flex items-center justify-center text-sm sm:text-base font-semibold">D</div>
          <div>
            <p class="font-semibold leading-none text-sm sm:text-base">Dinidu Dananjaya</p>
            <p class="text-xs sm:text-sm text-yellow-300">Genius Level 1</p>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <!-- Page Content -->
  <main class="max-w-7xl mx-auto px-4 py-12">
    <!-- Title -->
    <div class="mb-4 text-sm text-gray-500">
      <a href="#" class="text-cyan-600 hover:underline">Home</a> >
      <a href="#" class="text-cyan-600 hover:underline">Tour package</a> >
      <span class="text-gray-800">Search Results</span>
    </div>

    <div class="flex items-center justify-between mb-4">
      <h1 class="text-3xl font-bold text-gray-800">Yala Safari Tour from Galle/Unawatuna</h1>
      <div class="flex items-center space-x-4">
        <!-- Heart Icon with blue color -->
        <button aria-label="Add to favorites" class="hover:text-red-500 transition text-2xl" style="color: #60A5FA;">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
          </svg>
        </button>

        <!-- Share Icon as you provided -->
        <button aria-label="Share" class="transition text-2xl">
          <svg
            class="w-6 h-6 text-blue-400 hover:text-blue-600 cursor-pointer"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
            />
          </svg>
        </button>
      </div>


    </div>

    <!-- Ratings -->
    <div class="flex items-center mb-6">
      <div class="flex text-yellow-400 space-x-1 text-lg">
        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
      </div>
      <span class="ml-2 text-sm text-gray-600">(932 reviews)</span>
    </div>


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
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
                                    <img src="{{ asset('images/' . $img) }}" class="w-full h-full object-cover rounded-lg"
                                        alt="Gallery Image {{ $index + 1 }}">
                                    @if ($index === $desktopVisibleImageCount - 1 && $remainingCount > 0)
                                        <div onclick="openGalleryModal({{ $desktopVisibleImageCount }})"
                                            class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-lg font-bold cursor-pointer hover:bg-opacity-70 transition rounded-lg">
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
                                    <img src="{{ asset('images/' . $img) }}" class="w-full h-full object-cover rounded-md"
                                        alt="Gallery Image {{ $index + 1 }}">
                                    @if ($index === $mobileVisibleImageCount - 1 && $remainingCount > 0)
                                        <div onclick="openGalleryModal({{ $mobileVisibleImageCount }})"
                                            class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-base font-semibold rounded-md cursor-pointer">
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
                                            <img src="{{ asset('assets/net.svg') }}" class="w-5 h-3 object-cover rounded-sm"
                                                alt="UK Flag">
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
                const images = @json($images);
                let currentIndex = 0;

                function openGalleryModal(startIndex = 0) {
                    currentIndex = startIndex;
                    updateModalImage();
                    document.getElementById('galleryModal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closeGalleryModal() {
                    document.getElementById('galleryModal').classList.add('hidden');
                    document.body.style.overflow = '';
                }

                function updateModalImage() {
                    const img = document.getElementById('modalImage');
                    const counter = document.getElementById('imageCounter');

                    if (images.length > 0) {
                        img.src = `/images/${images[currentIndex]}`;
                        counter.textContent = `Image ${currentIndex + 1} of ${images.length}`;
                    } else {
                        img.src = ''; // Or a placeholder
                        counter.textContent = 'No images available';
                    }
                }

                function nextImage() {
                    if (currentIndex < images.length - 1) {
                        currentIndex++;
                        updateModalImage();
                    } else {
                        currentIndex = 0;
                        updateModalImage();
                    }
                }

                function prevImage() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateModalImage();
                    } else {

                        currentIndex = images.length - 1;
                        updateModalImage();
                    }
                }



                document.addEventListener('DOMContentLoaded', () => {
                    const galleryModal = document.getElementById('galleryModal');
                    const modalImage = document.getElementById('modalImage');


                    document.addEventListener('keydown', (event) => {
                        if (event.key === 'Escape' && !galleryModal.classList.contains('hidden')) {
                            closeGalleryModal();
                        }
                    });


                    galleryModal.addEventListener('click', (event) => {
                        if (event.target === galleryModal) {
                            closeGalleryModal();
                        }
                    });
                    modalImage.addEventListener('click', (event) => {
                        event.stopPropagation();
                    });
                });
            </script>
        </div>
    </div>

     {{-- Outer page container --}}
        <div class="min-h-screen py-6 px-4 lg:px-0">

            {{-- Your tour details card --}}
            <div class="bg-white text-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="max-w-7xl mx-auto p-4 lg:p-0">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <!-- LEFT SIDE -->
                        <div class="lg:col-span-2 space-y-4">
                            <div>
                                <h1 class="text-2xl font-bold mb-2">About tour</h1>
                                <p class="text-sm leading-relaxed">
                                    Yala Safari Day Trip is organized by Bentota Travel Mart (BTM) for the tourists who stay in Wadduwa,
                                    Waskaduwa, Kalutara, Maggona, Beruwala, Aluthgama, Bentota, Kosgoda, Ahungalla, Balapitiya,
                                    Ambalangoda, Hikkaduwa, Rathgama areas and free pick-up & drop-off are included. Yala Safari Day
                                    Trip is organized by Bentota Travel Mart (BTM) for the tourists who stay in Wadduwa, Waskaduwa,
                                    Kalutara, Maggona, Beruwala, Aluthgama, Bentota, Kosgoda, Ahungalla, Balapitiya, Ambalangoda,
                                    Hikkaduwa, Rathgama areas and free pick-up & drop-off are included. Yala Safari Day Trip is
                                    organized by Bentota Travel Mart (BTM) for the tourists who stay in Wadduwa, Waskaduwa, Kalutara,
                                    Maggona, Beruwala, Aluthgama, Bentota, Kosgoda, Ahungalla, Balapitiya, Ambalangoda ...
                                    <span class="text-blue-600 cursor-pointer">Read more</span>
                                </p>
                            </div>

                            <!-- Cancellation + Reserve -->
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="text-yellow-500">⚠️</span>
                                    Cancellation policy Full refund if cancelled up to 24 hours before the experience starts (local time).
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <span class="text-green-600">💲</span>
                                    Reserve now & pay later Secure your spot while staying flexible.
                                </div>
                            </div>

                            <!-- Highlights -->
                            <div>
                                <h2 class="font-semibold mb-3">Highlights</h2>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex items-center gap-2">
                                        <!-- Person icon -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 1115 0v.75H4.5v-.75z"/>
                                        </svg>
                                        Ages 0-99
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <!-- Clock -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6v6h4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Duration: 10-12 hours
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <!-- Start time -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Start time: Check availability
                                    </li>
                                    <li class="flex items-center gap-2">📱 Mobile ticket</li>
                                    <li class="flex items-center gap-2">🐾 Meets animal welfare guidelines</li>
                                    <li class="flex items-center gap-2">🌐 Live guide: English</li>
                                </ul>
                            </div>

                            <!-- Accordion -->
                            <div class="divide-y border rounded-md">
                                @foreach (['What\'s included','What to expect','Departure and return','Accessibility','Additional information','Cancellation policy','Help'] as $section)
                                    <div class="p-4 flex justify-between items-center cursor-pointer">
                                        <span class="font-medium text-sm">{{ $section }}</span>
                                        <span class="text-gray-500">⌄</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- RIGHT SIDE CARD -->
                        <div>
                            <div class="border rounded-lg shadow-md p-4 space-y-4 sticky top-4">
                                <div class="text-lg font-semibold">From $155.00</div>
                                <div class="text-xs text-gray-500">per adult (price varies by group size)</div>

                                <!-- Date + Travelers -->
                                <div class="flex flex-col gap-3">
                                    <input type="date" value="2025-06-25" class="border rounded px-2 py-1 text-sm w-full">
                                    <select class="border rounded px-2 py-1 text-sm w-full">
                                        <option>2 adults - 0 children</option>
                                    </select>
                                </div>

                                <!-- Cancellation + Reserve -->
                                <div class="flex items-start gap-2 text-sm">
                                    <span class="text-yellow-500">⚠️</span>
                                    Cancel anytime before Jun 24 for full refund
                                </div>
                                <div class="flex items-start gap-2 text-sm">
                                    <span class="text-green-600">💲</span>
                                    Reserve now & pay later Secure your spot while staying flexible.
                                </div>

                                <!-- Options -->
                                <div class="space-y-4">
                                    <div class="border rounded p-3">
                                        <div class="flex items-center justify-between text-xs mb-2">
                                            <span class="bg-black text-white px-2 py-0.5 rounded">POPULAR</span>
                                            <span class="text-green-600 font-medium">RESERVE NOW & PAY LATER ELIGIBLE</span>
                                        </div>
                                        <div class="text-sm font-medium">From Ahungalla / Kosgoda</div>
                                        <div class="text-xs text-gray-500">Pick up from: Ahungalla, Kosgoda, Balapitiya, Ambalangoda areas</div>
                                        <div class="text-sm font-medium mt-2">2 Adults × $190.00</div>
                                        <div class="text-sm">Total $380.00</div>
                                        <div class="text-xs text-gray-400">(Price includes taxes and booking fees)</div>
                                        <div class="flex gap-2 mt-2">
                                            <button class="border rounded px-2 py-1 text-sm">4:00 AM</button>
                                            <button class="border rounded px-2 py-1 text-sm">9:30 AM</button>
                                        </div>
                                    </div>

                                    <div class="border rounded p-3">
                                        <div class="flex items-center justify-between text-xs mb-2">
                                            <span class="text-green-600 font-medium">RESERVE NOW & PAY LATER ELIGIBLE</span>
                                        </div>
                                        <div class="text-sm font-medium">From Ahungalla / Kosgoda</div>
                                        <div class="text-xs text-gray-500">Pick up from: Ahungalla, Kosgoda, Balapitiya, Ambalangoda areas</div>
                                        <div class="text-sm font-medium mt-2">2 Adults × $190.00</div>
                                        <div class="text-sm">Total $380.00</div>
                                        <div class="text-xs text-gray-400">(Price includes taxes and booking fees)</div>
                                        <div class="flex gap-2 mt-2">
                                            <button class="border rounded px-2 py-1 text-sm">4:00 AM</button>
                                            <button class="border rounded px-2 py-1 text-sm">9:30 AM</button>
                                        </div>
                                    <p class="mt-2 text-xs text-gray-500">
                                        *Popular option based on the number of bookings on this site over the past 60 days.
                                    </p>


                                    </div>
                                </div>
                                <a href="#" class="block text-left text-blue-600 underline font-medium mb-4 pl-1">
                                  See all 5 tour options
                                </a>
                               <button class="bg-sky-500 text-white text-center w-full py-2 rounded-full font-medium">
                                 Reserve Now
                               </button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


    <div class="min-h-screen py-6 px-4 lg:px-0">
        <!-- Title -->
        <h1 class="text-2xl font-bold mb-6">Itinerary</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Side -->
            <div>
                <!-- Starting Options -->
                <div class="flex items-start mb-6">
                    <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full border border-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a8 8 0 00-16 0v2h5" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <div class="ml-3 text-sm">
                        <p class="font-medium">You'll have 13 starting options</p>
                        <p class="text-gray-500">Or, you can also get picked up</p>
                        <a href="#" class="text-blue-600 underline">See departure details</a>
                    </div>
                </div>

                <!-- Timeline Item -->
                <div class="flex">
                    <div class="flex flex-col items-center mr-4">
                        <div class="w-6 h-6 flex items-center justify-center bg-black text-white rounded-full">1</div>
                        <div class="flex-1 w-px bg-gray-300"></div>
                    </div>
                    <div>
                        <h2 class="font-semibold">Palatupana</h2>
                        <p class="text-sm text-gray-600">Stop: 4 hours - Admission included</p>
                        <p class="mt-2 text-gray-700 text-sm">
                            This is the country’s second largest and most famous National park for locals and foreigners alike.
                            Situated on the south-East coast of Sri Lanka it has an area of over 375 square miles. It is made
                            up of five blocks of which two are open to visitors. The Ruhuna national Park and the Kumana bird
                            sanctuary. These two parks are most important for conservation. It has a variety of eco
                            <a href="#" class="text-blue-600 underline">...Read more</a>
                        </p>

                        <!-- Pass By List -->
                        <div class="mt-4">
                            <p class="font-semibold">Pass By</p>
                            <ul class="list-none text-sm text-gray-700 space-y-1">
                                <li>Bentota Travel Mart</li>
                                <li>Bentota Beach</li>
                                <li>Wadduwa Beach</li>
                                <li>Waskaduwa</li>
                                <li>Kalutara Beach</li>
                                <li>Maggona</li>
                                <li>Beruwala Beach</li>
                                <li>Moragalla Beach</li>
                                <li>Aluthgama</li>
                                <li>Induruwa</li>
                                <li>Kosgoda</li>
                                <li>Ahungalla Beach</li>
                                <li>Balapitiya</li>
                                <li>Ambalangoda</li>
                                <li>Hikkaduwa</li>
                                <li>Rathgama</li>
                                <li>Mount Lavinia</li>
                                <li>Kosgoda</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Return Point -->
                <div class="flex items-start mt-6">
                    <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full border border-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m7-7v14" />
                        </svg>
                    </div>
                    <p class="ml-3 text-sm font-medium">You'll return to the starting point</p>
                </div>
            </div>

            <!-- Right Side (Map) -->
            <!-- Map Section -->
            <div class="w-full rounded-lg overflow-hidden shadow">
                <div class="relative">
                    <iframe
                        class="w-full h-80 sm:h-[800px]"
                        loading="lazy"
                        src="https://www.google.com/maps?q=La+Grande+Villa+Nuwara+Eliya&output=embed"
                        frameborder="0"
                        allowfullscreen
                        aria-hidden="false"
                        tabindex="0"
                    ></iframe>
                    <button
                        class="absolute bottom-2 left-2 bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white text-sm px-3 py-1 rounded-md shadow"
                    >
                        Show on map
                    </button>
                </div>
            </div>


        </div>
    </div>

    <div class="max-w-7xl mx-auto p-4 space-y-0">
        <!-- Similar Experiences -->
        <section class="relative">
            <h2 class="text-xl font-bold mb-4">Similar experiences</h2>

            <!-- Cards container -->
            <div id="exp-container" class="flex gap-4 pb-2 overflow-hidden scroll-smooth">
              @foreach ([
                ['img' => 'images/exp1.jpg', 'title' => 'Yala Safari Tour from Galle/ Unawatuna', 'price' => 130, 'rating' => 4, 'reviews' => 91],
                ['img' => 'images/exp2.jpg', 'title' => 'Ella Day Trip with Train Ride & Tea Factory - All Inclusive', 'price' => 180, 'rating' => 5, 'reviews' => 91],
                ['img' => 'images/exp3.jpg', 'title' => 'Kandy Day Trip with Tooth Relic Temple & Unique Attractions', 'price' => 20, 'rating' => 5, 'reviews' => 91],
                ['img' => 'images/exp4.jpg', 'title' => 'Half-Day Lagoon and Village Cycling Tour in Galle', 'price' => 45, 'rating' => 4, 'reviews' => 91]
              ] as $exp)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition w-[80vw] sm:w-[300px] flex-shrink-0">
                  <div class="relative w-full h-[250px] sm:h-[320px] overflow-hidden rounded-t-lg">
                    <img src="{{ asset('images/' . $img) }}" alt="" class="w-full h-full object-cover">

                    <!-- Heart icon with white circular background -->
                    <button
                      class="absolute top-2 right-2 bg-white rounded-full p-1.5 shadow-md text-gray-400 hover:text-red-500 transition"
                      aria-label="Add to favorites"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 fill-current" viewBox="0 0 24 24" stroke="none">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3
                          7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5
                          3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55
                          11.54L12 21.35z"/>
                      </svg>
                    </button>
                  </div>
                  <div class="p-3 space-y-2">
                    <div class="flex items-center gap-1">
                      <span class="bg-blue-500 text-white text-xs font-bold px-1.5 py-0.5 rounded">9.7</span>
                      <div class="flex text-yellow-400">
                        @for ($i = 0; $i < 5; $i++)
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $i < $exp['rating'] ? '' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.966h4.175c.969 0 1.371 1.24.588 1.81l-3.38
                              2.454 1.287 3.966c.3.921-.755 1.688-1.54
                              1.118l-3.38-2.454-3.38 2.454c-.785.57-1.84-.197-1.54-1.118l1.287-3.966-3.38-2.454c-.783-.57-.38-1.81.588-1.81h4.175L9.049 2.927z" />
                          </svg>
                        @endfor
                      </div>
                    </div>
                    <p class="text-sm font-semibold leading-snug">{{ $exp['title'] }}</p>
                    <p class="text-sm text-gray-600">from ${{ number_format($exp['price'], 2) }} per adult</p>
                  </div>
                </div>
              @endforeach
            </div>


            <!-- Left arrow button -->
            <button id="prev-btn"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100 hidden sm:flex">
                &lt;
            </button>

            <!-- Right arrow button -->
            <button id="next-btn"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100 hidden sm:flex">
                &gt;
            </button>
        </section>

        <script>
            const container = document.getElementById('exp-container');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            function getScrollAmount() {

                return container.querySelector('div').offsetWidth + 16;
            }

            nextBtn.addEventListener('click', () => {
                container.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
            });

            prevBtn.addEventListener('click', () => {
                container.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
            });


            function updateButtons() {
                prevBtn.style.display = container.scrollLeft > 0 ? 'flex' : 'none';
                nextBtn.style.display =
                    container.scrollLeft + container.clientWidth < container.scrollWidth ? 'flex' : 'none';
            }

            container.addEventListener('scroll', updateButtons);
            window.addEventListener('resize', updateButtons);
            updateButtons();
        </script>





        <!-- About the Operator -->
        <section>
            <h2 class="text-xl font-bold mb-4">About the operator</h2>
            <div class="border-t border-gray-200 pt-4 flex flex-col sm:flex-row sm:items-center gap-4">
                <img src="{{ asset('images/' . ($img ?? 'default-avatar.png')) }}" alt="Operator" class="w-20 h-20 rounded-full object-cover">
                <div>
                    <p class="font-semibold">Bentota Travel Mart</p>
                    <p class="text-gray-600">Bentota, Sri Lanka</p>
                    <p class="text-gray-600">Joined in December 2018</p>
                    <p class="text-gray-600">Languages spoken: Arabic, <span class="font-semibold">English</span></p>
                </div>
            </div>
        </section>

        <!-- Tour Reviews -->
       <section>
         <h2 class="text-xl font-bold mb-4">Tour reviews</h2>
         <div class="flex flex-col sm:flex-row items-center sm:items-start gap-10 sm:gap-40 w-full max-w-full">
           <!-- Overall Rating -->
           <div class="flex items-center space-x-8 w-full sm:w-auto max-w-full">
             <div class="relative w-28 h-28 flex items-center justify-center">
               <svg class="w-full h-full" viewBox="0 0 36 36">
                 <path class="text-gray-200" stroke-width="3" stroke="currentColor" fill="none"
                   d="M18 2.0845a15.9155 15.9155 0 1 1 0 31.831a15.9155 15.9155 0 1 1 0 -31.831" />
                 <path
                   style="color: #1F8FB2;"
                   stroke-width="3"
                   stroke="currentColor"
                   fill="none"
                   stroke-dasharray="75, 100"
                   d="M18 2.0845a15.9155 15.9155 0 1 1 0 31.831a15.9155 15.9155 0 1 1 0 -31.831"/>
               </svg>
               <span class="absolute text-3xl font-bold">4.5</span>
             </div>

             <div class="flex flex-col items-center mt-3 w-full max-w-[100px] sm:max-w-none">
               <!-- Rating number -->
               <!-- Stars -->
               <div class="flex space-x-1 text-yellow-400 mt-1">
                 @for ($s = 1; $s <= 5; $s++)
                   <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
                     <path
                       d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.564-.955L10 0l2.948 5.955 6.564.955-4.756 4.635 1.122 6.545z" />
                   </svg>
                 @endfor
               </div>
               <!-- Reviews count text -->
               <p class="text-sm text-gray-600 mt-3 text-center sm:text-left">from 1,25k reviews</p>
             </div>
           </div>

           <!-- Star Breakdown -->
           <div class="flex-1 space-y-2 w-full max-w-full">
             @foreach ([5 => 2823, 4 => 38, 3 => 4, 2 => 0, 1 => 0] as $stars => $count)
               <div class="flex items-center gap-2">
                 <span class="flex items-center gap-0.5 w-10">
                   {{ $stars }}
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" fill="currentColor"
                     viewBox="0 0 20 20">
                     <path
                       d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.966h4.175c.969 0 1.371 1.24.588 1.81l-3.38 2.454 1.287 3.966c.3.921-.755 1.688-1.54 1.118l-3.38-2.454-3.38 2.454c-.785.57-1.84-.197-1.54-1.118l1.287-3.966-3.38-2.454c-.783-.57-.38-1.81.588-1.81h4.175L9.049 2.927z" />
                   </svg>
                 </span>
                 <div class="flex-1 bg-gray-200 h-2 rounded-full overflow-hidden">
                   <div class="bg-black h-full" style="width: {{ $count > 0 ? ($count / 2823) * 100 : 0 }}%"></div>
                 </div>
                 <span class="w-10 text-sm text-gray-600">{{ $count }}</span>
               </div>
             @endforeach
           </div>
         </div>
       </section>
    </div>

    <div class="max-w-7xl mx-auto p-4 space-y-0">
      <h2 class="text-xl font-bold mb-4">Review Lists</h2>

      <!-- Tabs -->
      <div class="flex space-x-2 mb-6">
        <button class="px-4 py-2 bg-blue-500 text-white rounded border border-blue-500">All Reviews</button>
        <button class="px-4 py-2 bg-white text-gray-800 border rounded hover:bg-gray-100">Add Review</button>
      </div>

      <!-- Review List -->
      @for($i = 0; $i < 4; $i++)
      <br>
      <div class="border-b border-dotted pb-4 mb-4">

        <!-- Stars -->
        <!-- Stars -->
        <div class="flex text-yellow-400 mb-3 space-x-0.5">
          @for($s = 0; $s < 5; $s++)
            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
              <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.564-.955L10 0l2.948 5.955 6.564.955-4.756 4.635 1.122 6.545z"/>
            </svg>
          @endfor
        </div>


        <!-- Review text -->
        <p class="text-sm mb-1">This is amazing tour I have.</p>
        <p class="text-xs text-gray-500 mb-3">July 2, 2020 03:29 PM</p>

        <!-- Reviewer + Like/Unlike in one row -->
        <div class="flex items-center justify-between">

          <!-- Reviewer -->
          <div class="flex items-center space-x-2">
            <img src="{{ asset('images/' . ($img ?? 'default-avatar.png')) }}"
                 alt="Reviewer avatar"
                 class="w-8 h-8 rounded-full object-cover">
            <p class="font-medium">Darrell Steward</p>
          </div>

          <!-- Like/Unlike Buttons -->
          <div class="flex space-x-6 text-sm items-center">
            <!-- Like button -->
            <button type="button" class="flex items-center space-x-1 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black font-bold" fill="currentColor" viewBox="0 0 24 24" stroke="none" aria-hidden="true" focusable="false">
                <path d="M2 21h4V9H2v12zM23 10c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32a1 1 0 0 0-.29-.7L14 2 7.59 8.41C7.22 8.78 7 9.3 7 9.83V19c0 1.1.9 2 2 2h7c.83 0 1.54-.5 1.85-1.22l3.02-7.05c.09-.23.13-.47.13-.73v-1z"/>
              </svg>
              <span class="font-semibold text-black select-none">128</span>
            </button>

            <!-- Unlike button -->
            <button type="button" class="flex items-center space-x-1 text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="none" aria-hidden="true" focusable="false">
                <path d="M2 3h4v12H2V3zm19 7c0 1.1-.9 2-2 2h-6.31l.95 4.57.03.32a1 1 0 0 1-.29.7L14 22l-6.41-6.41c-.37-.37-.59-.89-.59-1.42V5c0-1.1.9-2 2-2h7c.83 0 1.54.5 1.85-1.22l3.02 7.05c.09.23.13.47.13.73v1z"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
      @endfor
    </div>



  </main>


       <!-- Pagination -->
             <div class="flex justify-center items-center space-x-3 mt-6 mb-8">
               <button aria-label="Page 1" class="px-3 py-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">1</button>
               <button aria-label="Page 2" class="px-3 py-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">2</button>
               <span class="select-none">...</span>
               <button aria-label="Page 19" class="px-3 py-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">19</button>
               <button aria-label="Next Page" class="px-3 py-1 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                 <i class="fas fa-chevron-right" aria-hidden="true"></i>
                 <span class="sr-only">Next</span>
               </button>
             </div>

      <footer class="mt-8 mb-8 text-xs text-gray-600 leading-relaxed max-w-7xl mx-auto px-4 text-left">
        Countries · Regions · Cities · Districts · Airports · Hotels · Places of interest · Holiday Homes · Apartments · Resorts · Villas · Hostels · B&amp;Bs · Guest Houses · Unique places to stay · All destinations·All flight destinations · All car hire locations · All holiday destinations · Guides · Discover · Reviews · Discover monthly stays
      </footer>


  <!-- Footer -->
  <footer class="bg-gray-100 pt-8 pb-4 text-sm text-gray-700">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
        <div>
          <p class="font-semibold mb-2">Support</p>
          <ul class="space-y-1">
            <li>Coronavirus (COVID-19) FAQs</li>
            <li>Manage your trips</li>
            <li>Contact Customer Service</li>
            <li>Safety resource centre</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Discover</p>
          <ul class="space-y-1">
            <li>Genius loyalty programme</li>
            <li>Seasonal and holiday deals</li>
            <li>Travel articles</li>
            <li>eSupport.com for Business</li>
            <li>Traveller Review Awards</li>
            <li>Car hire</li>
            <li>Flight finder</li>
            <li>Restaurant reservations</li>
            <li>eSupport.com for Travel Agents</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Terms and settings</p>
          <ul class="space-y-1">
            <li>Privacy & cookies</li>
            <li>Terms and conditions</li>
            <li>Partner dispute</li>
            <li>Modern Slavery Statement</li>
            <li>Human Rights Statement</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Partners</p>
          <ul class="space-y-1">
            <li>Extranet login</li>
            <li>Partner help</li>
            <li>List your property</li>
            <li>Become an affiliate</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">About</p>
          <ul class="space-y-1">
            <li>About eSupport.com</li>
            <li>How we work</li>
            <li>Sustainability</li>
            <li>Press centre</li>
            <li>Careers</li>
            <li>Investor relations</li>
            <li>Corporate contact</li>
          </ul>
        </div>
      </div>

      <div class="mt-20">
        <div class="flex items-center space-x-4 mb-2">
          <div class="w-4 h-4 rounded-full overflow-hidden -ml-0">
            <img src="https://flagcdn.com/gb.svg" alt="Flag" class="w-full h-full object-cover" />
          </div>
          <span class="font-black text-sm text-gray-800">LKR</span>
        </div>

        <hr class="border-t border-gray-300 my-3 w-full mx-auto" />

        <div class="text-center text-xs text-gray-500">
          <p class="leading-snug">
            All Rights Reserved. © 2025 eSupport.com &nbsp;&nbsp; Powered by eSupport ©
          </p>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>
