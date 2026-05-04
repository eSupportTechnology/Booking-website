@extends('frontend.master')

@section('title', $property->title ?? 'Property')

@section('content')
    @php
        // Gallery images (skip placeholders entirely if there are none)
        $images = ($property->files ?? collect())->pluck('path')->filter()->values()->all();
        $hasImages = !empty($images);
        $desktopVisibleImageCount = 8;
        $mobileVisibleImageCount = 3;
        $desktopImages = array_slice($images, 0, $desktopVisibleImageCount);
        $mobileImages = array_slice($images, 0, $mobileVisibleImageCount);
        $remainingCount = max(0, count($images) - $desktopVisibleImageCount);

        // Amenities split for the features grid
        $amenities = $property->amenities ?? collect();
        $topAmenities = $amenities->take(6);
        $bottomAmenities = $amenities->slice(6, 4);
        $popularFacilities = $amenities->take(10);

        // Best review pick (top-rated, most-recent)
        $featuredReview = ($reviews ?? collect())->sortByDesc('rating')->first();

        $mapQuery = trim(($property->title ?? '') . ' ' . ($property->city ?? '') . ' ' . ($property->country ?? ''));
        if ($mapQuery === '') {
            $mapQuery = 'Sri Lanka';
        }

        // Format clock-time strings: "15:00:00" -> "15:00"
        $formatTime = function ($t) {
            if (empty($t)) return null;
            return preg_replace('/:\d{2}$/', '', (string) $t);
        };

        // Build a deduplicated address string (splits comma-rich address fields and removes repeats)
        $addressRaw = array_merge(
            [$property->apartment ?? null],
            explode(',', (string) ($property->address ?? '')),
            [$property->zipcode ?? null, $property->city ?? null, $property->country ?? null]
        );
        $seen = [];
        $addressClean = collect($addressRaw)
            ->map(fn ($v) => trim((string) $v))
            ->filter()
            ->filter(function ($p) use (&$seen) {
                $key = strtolower($p);
                if (isset($seen[$key])) return false;
                $seen[$key] = true;
                return true;
            })->join(', ');

        // Apartment-size unit: replace underscores -> spaces
        $sizeUnit = $property->additionalDetails->apartment_unit ?? null;
        $sizeUnit = $sizeUnit ? str_replace('_', ' ', $sizeUnit) : 'sqm';

        // Whether the current user owns this property (hide guest CTAs for owners)
        $isOwner = auth()->check() && (int) auth()->id() === (int) ($property->user_id ?? 0);
    @endphp

    {{-- Hero spacer --}}
    <section class="{{ $isOwner ? 'py-4' : 'py-8' }} text-white bg-[#1F8FB2] relative z-0">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($isOwner)
                <p class="text-white/90 text-sm">
                    <a href="{{ route('partner.dashboard') }}" class="underline hover:text-white">Partner dashboard</a>
                    &nbsp;›&nbsp; <a href="{{ route('partner.dashboard') }}" class="underline hover:text-white">My properties</a>
                    &nbsp;›&nbsp; <span class="font-semibold">{{ $property->title ?? 'Property' }}</span>
                </p>
            @endif
        </div>
    </section>

    @unless ($isOwner)
    {{-- Search Box --}}
    <div class="relative z-10 -mt-8 px-4">
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <form method="GET"
            class="bg-white rounded-xl px-2 py-1 shadow-lg flex flex-col md:flex-row items-center gap-1 md:gap-0 border-4 border-yellow-400 max-w-6xl mx-auto overflow-visible text-sm">

            <div x-data="{ open: false, destination: '{{ $property->city ?? '' }}' }" class="relative px-2 py-1 flex-1 border-r md:border-r border-gray-500">
                <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                    <img src="{{ asset('assets/stay.svg') }}" alt="Stay" class="w-6 h-6"
                        style="filter: brightness(0) saturate(100%);" />
                    <span x-text="destination || 'Where are you going?'" style="font-family: 'Noto Sans', sans-serif;"
                        class="text-gray-800 truncate text-base"></span>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-2 text-sm">
                    <template x-for="city in ['Colombo', 'Kandy', 'Galle', 'Nuwara Eliya', 'Ella']" :key="city">
                        <button type="button" @click="destination = city; open = false"
                            class="block w-full text-left px-3 py-2 hover:bg-gray-100 rounded">
                            <span x-text="city"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="destination" :value="destination">
            </div>

            <div x-data="{ open: false, activeTab: 'check', checkIn: '', checkOut: '', flexibleOption: '' }"
                class="relative flex-1 border-t md:border-t-0 md:border-r border-gray-500 px-2 py-1">
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
                <div x-show="open" @click.away="open = false"
                    class="absolute z-30 bg-white shadow-xl rounded-xl p-4 mt-2 w-96 right-0 text-gray-800 text-sm" x-transition>
                    <nav class="flex border-b border-gray-200 mb-4">
                        <button @click.prevent="activeTab = 'check'"
                            :class="activeTab === 'check' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                            class="px-4 py-2 border-b-2 font-semibold focus:outline-none">Check-in / Check-out</button>
                        <button @click.prevent="activeTab = 'flexible'"
                            :class="activeTab === 'flexible' ? 'border-blue-600 text-blue-600' : 'text-gray-500'"
                            class="px-4 py-2 border-b-2 font-semibold focus:outline-none">Flexible dates</button>
                    </nav>
                    <div x-show="activeTab === 'check'" x-transition>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-500 font-semibold mb-1">Check-in Date</label>
                                <input type="date" x-model="checkIn"
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 font-semibold mb-1">Check-out Date</label>
                                <input type="date" x-model="checkOut"
                                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none" />
                            </div>
                        </div>
                    </div>
                    <div x-show="activeTab === 'flexible'" x-transition>
                        <label class="block text-xs text-gray-500 font-semibold mb-1">Select Flexible Dates</label>
                        <select x-model="flexibleOption"
                            class="w-full border border-gray-300 rounded px-3 py-2 text-sm outline-none">
                            <option value="" disabled>Select option</option>
                            <option value="Weekend Getaway">Weekend Getaway</option>
                            <option value="Next Month">Next Month</option>
                            <option value="Anytime">Anytime</option>
                            <option value="Custom Range">Custom Range</option>
                        </select>
                    </div>
                    <div class="mt-4 text-right">
                        <button @click="open = false"
                            class="bg-[#3CC0E9] text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Done</button>
                    </div>
                </div>
            </div>

            <div x-data="{ open: false, adults: 2, children: 0, rooms: 1, pets: false }"
                class="relative px-2 py-1 flex-1 border-t md:border-t-0 md:border-r border-gray-500">
                <button @click="open = !open" type="button" class="flex items-center gap-2 w-full text-left text-sm">
                    <img src="{{ asset('assets/user.svg') }}" alt="Guests" class="w-5 h-5" />
                    <span x-text="`${adults} adults · ${children} children · ${rooms} room${rooms > 1 ? 's' : ''}`"
                        class="text-gray-800 text-base truncate"></span>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute z-20 bg-white shadow-xl rounded-xl p-4 mt-2 w-72 right-0 text-gray-800 space-y-4 text-sm">
                    <div class="flex items-center justify-between">
                        <span>Adults</span>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if(adults > 1) adults--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                            <span x-text="adults"></span>
                            <button type="button" @click="adults++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Children</span>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if(children > 0) children--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                            <span x-text="children"></span>
                            <button type="button" @click="children++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Rooms</span>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if(rooms > 1) rooms--" class="px-2 py-1 bg-gray-200 rounded">−</button>
                            <span x-text="rooms"></span>
                            <button type="button" @click="rooms++" class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Travelling with pets?</span>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="pets" class="sr-only peer">
                            <div class="w-10 h-6 bg-gray-300 rounded-full peer peer-checked:bg-blue-600 relative transition-all">
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                            </div>
                        </label>
                    </div>
                    <button type="button" @click="open = false"
                        class="block w-full text-center bg-white border border-[#3CC0E9] text-[#3CC0E9] font-semibold py-2 rounded hover:bg-[#3CC0E9]/10">
                        Done
                    </button>
                </div>
            </div>

            <div class="px-2 py-1">
                <button type="submit"
                    class="w-full md:w-auto h-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm"
                    style="background-color:#3CC0E9;">
                    Search
                </button>
            </div>
        </form>
    </div>
    @endunless

    {{-- Breadcrumb + Tab navigation --}}
    <section class="py-6 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            Home > {{ $property->city ?? 'Sri Lanka' }} > {{ $property->title ?? 'Property' }}
            <div class="border-b sticky top-0 bg-white">
                <div class="max-w-6xl mx-auto flex space-x-6 overflow-x-auto text-sm md:text-base whitespace-nowrap px-4 py-2">
                    <a href="#overview" class="scroll-link">Overview</a>
                    <a href="#info" class="scroll-link">Info & price</a>
                    <a href="#facilities" class="scroll-link">Facilities</a>
                    <a href="#rules" class="scroll-link">House rules</a>
                    <a href="#fineprint" class="scroll-link">The fine print</a>
                    <a href="#reviews" class="scroll-link">Guest reviews ({{ $totalReviews }})</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Header + Gallery + Sidebar --}}
    <section id="overview" class="p-4 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-4 bg-white rounded-lg shadow-sm">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">{{ $property->title ?? 'Property' }}</h1>
                    @if (!is_null($property->stars) && (int) $property->stars > 0)
                        <div class="flex items-center mb-2">
                            @for ($i = 0; $i < (int) $property->stars; $i++)
                                <svg class="w-5 h-5 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            @endfor
                        </div>
                    @endif
                    <div class="flex items-center text-gray-600 text-sm">
                        <svg class="w-5 h-5 mr-1 text-[#3CC0E9]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                        </svg>
                        {{ $addressClean ?: 'Address not specified' }}
                    </div>
                </div>

                <div class="flex flex-col items-start sm:items-end space-y-2">
                    <div class="flex items-center gap-3">
                        @if ($isOwner)
                            <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 font-medium">
                                {{ ucfirst($property->status ?? 'draft') }}
                            </span>
                            <a href="{{ route('partner.dashboard') }}"
                                class="border border-[#3CC0E9] text-[#3CC0E9] hover:bg-[#3CC0E9]/10 font-semibold py-2 px-4 rounded-md text-sm">
                                Back to listings
                            </a>
                        @else
                            <button class="bg-[#3CC0E9] hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-md shadow">
                                Reserve
                            </button>
                        @endif
                    </div>
                    @unless ($isOwner)
                        <div class="flex items-center text-[#3CC0E9] text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.007 12.007 0 002.944 12c0 2.873.996 5.474 2.618 7.594L12 22.944l6.438-3.35C20.004 17.474 21 14.873 21 12a12.007 12.007 0 00-2.382-7.016z" />
                            </svg>
                            We Price Match
                        </div>
                    @endunless
                </div>
            </div>

            <div class="flex flex-col lg:grid lg:grid-cols-7 lg:grid-rows-5 gap-4 mt-6 h-auto lg:h-[600px]">
                <div class="w-full lg:col-span-5 lg:row-span-5 space-y-4">
                    @if ($hasImages)
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
                                <div class="{{ $positions[$index] ?? '' }} relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $img) }}"
                                        class="w-full h-full object-cover rounded-lg" alt="Gallery image {{ $index + 1 }}">
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
                                $mobileRemaining = max(0, count($images) - $mobileVisibleImageCount);
                            @endphp
                            @foreach ($mobileImages as $index => $img)
                                <div class="{{ $mobilePositions[$index] ?? '' }} relative overflow-hidden">
                                    <img src="{{ asset('storage/' . $img) }}"
                                        class="w-full h-full object-cover rounded-md" alt="Gallery image {{ $index + 1 }}">
                                    @if ($index === $mobileVisibleImageCount - 1 && $mobileRemaining > 0)
                                        <div onclick="openGalleryModal({{ $mobileVisibleImageCount }})"
                                            class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center text-white text-base font-semibold rounded-md cursor-pointer">
                                            {{ $mobileRemaining }}+ more
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="h-full min-h-[300px] lg:min-h-[600px] rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex flex-col items-center justify-center text-center p-8">
                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-700 mb-1">No photos uploaded yet</h3>
                            <p class="text-sm text-gray-500 mb-4">Add photos so guests can see what makes this property special.</p>
                            @if ($isOwner)
                                <a href="{{ route('partner.dashboard') }}"
                                    class="inline-block bg-[#3CC0E9] hover:bg-sky-600 text-white text-sm font-medium px-4 py-2 rounded-md">
                                    Upload photos
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <div class="w-full lg:col-span-2 lg:row-span-5 p-2">
                    <div class="h-full flex flex-col justify-between gap-4">

                        {{-- Review summary --}}
                        <div class="w-full bg-white border rounded-lg p-4 shadow-md flex-grow space-y-4">
                            @if ($totalReviews > 0)
                                <div class="flex justify-between items-start pb-3 border-b-2">
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-800">{{ $ratingText }}</h2>
                                        <p class="text-sm text-gray-500">{{ $totalReviews }} {{ \Illuminate\Support\Str::plural('review', $totalReviews) }}</p>
                                    </div>
                                    <div class="bg-[#3CC0E9] text-white text-sm font-semibold px-2 py-1 rounded">{{ $overallRating }}</div>
                                </div>

                                @if ($featuredReview)
                                    @php
                                        $reviewerName = optional($featuredReview->user)->name
                                            ?? optional($featuredReview->traveler)->name
                                            ?? ($featuredReview->guest_name ?? 'Guest');
                                        $reviewerCountry = optional($featuredReview->user)->country
                                            ?? optional($featuredReview->traveler)->country
                                            ?? ($featuredReview->country ?? '');
                                    @endphp
                                    <div>
                                        <h3 class="text-sm font-semibold mb-1 text-gray-700">Guests who stayed here loved</h3>
                                        <p class="text-sm text-gray-700 ml-4 italic">
                                            "{{ \Illuminate\Support\Str::limit($featuredReview->comment ?? $featuredReview->review ?? 'Great stay!', 200) }}"
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-green-600 text-white flex items-center justify-center rounded-full font-semibold">
                                            {{ strtoupper(substr($reviewerName, 0, 1)) }}
                                        </div>
                                        <p class="font-medium text-gray-800 mb-0">{{ $reviewerName }}</p>
                                        @if ($reviewerCountry)
                                            <span class="text-gray-500 text-xs">{{ $reviewerCountry }}</span>
                                        @endif
                                    </div>
                                @endif

                                @if ($staffRating)
                                    <div class="flex justify-between items-center pt-2 border-t">
                                        <span class="text-sm font-semibold text-gray-700">Staff</span>
                                        <div class="border border-gray-300 px-2 py-0.5 text-sm rounded-md text-gray-800">{{ $staffRating }}</div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                    </svg>
                                    <h3 class="text-sm font-semibold text-gray-700 mb-1">No reviews yet</h3>
                                    <p class="text-xs text-gray-500">Guest reviews will appear here after the first stay.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Map --}}
                        <div class="w-full rounded-lg overflow-hidden shadow">
                            <div class="relative">
                                <iframe class="w-full h-44 sm:h-56" loading="lazy"
                                    src="https://www.google.com/maps?q={{ urlencode($mapQuery) }}&output=embed"
                                    frameborder="0" allowfullscreen aria-hidden="false" tabindex="0"></iframe>
                                <button class="absolute bottom-2 left-2 bg-[#3CC0E9] hover:bg-[#3CC0E9]/80 text-white text-sm px-3 py-1 rounded-md shadow">
                                    Show on map
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gallery Modal --}}
        <div id="galleryModal"
            class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center hidden px-4 py-6 sm:px-8 sm:py-10">
            <button onclick="closeGalleryModal()"
                class="absolute top-4 right-4 sm:top-8 sm:right-8 text-white text-3xl sm:text-4xl hover:scale-110 transition">&times;</button>
            <button onclick="prevImage()"
                class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/70 p-2 sm:p-3 rounded-full transition">
                <svg class="w-6 h-6 sm:w-10 sm:h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <img id="modalImage" src="" alt="Gallery Image"
                class="max-h-[75vh] sm:max-h-[90vh] max-w-full rounded-xl shadow-xl border border-white/10 transition duration-300 object-contain" />
            <button onclick="nextImage()"
                class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 text-white bg-black/40 hover:bg-black/70 p-2 sm:p-3 rounded-full transition">
                <svg class="w-6 h-6 sm:w-10 sm:h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <div class="absolute bottom-4 sm:bottom-6 text-white text-xs sm:text-sm tracking-wide">
                <span id="imageCounter"></span>
            </div>
        </div>

        <script>
            const galleryImages = @json($images);
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
                if (galleryImages.length > 0) {
                    img.src = `/storage/${galleryImages[currentIndex]}`;
                    counter.textContent = `Image ${currentIndex + 1} of ${galleryImages.length}`;
                } else {
                    img.src = '';
                    counter.textContent = 'No images available';
                }
            }

            function nextImage() {
                if (galleryImages.length === 0) return;
                currentIndex = (currentIndex + 1) % galleryImages.length;
                updateModalImage();
            }

            function prevImage() {
                if (galleryImages.length === 0) return;
                currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
                updateModalImage();
            }

            document.addEventListener('DOMContentLoaded', () => {
                const galleryModal = document.getElementById('galleryModal');
                const modalImage = document.getElementById('modalImage');
                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !galleryModal.classList.contains('hidden')) closeGalleryModal();
                });
                galleryModal.addEventListener('click', (event) => {
                    if (event.target === galleryModal) closeGalleryModal();
                });
                modalImage.addEventListener('click', (event) => event.stopPropagation());
            });
        </script>
    </section>

    {{-- Features grid (top 6 + bottom 4 amenities) --}}
    <section id="facilities" class="p-4 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mt-4 select-none">
                @if ($topAmenities->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 py-2">
                        @foreach ($topAmenities as $feature)
                            <div class="group relative bg-white rounded-lg shadow-sm p-4 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                                @if (!empty($feature->icon))
                                    <img src="{{ asset('assets/' . $feature->icon) }}" alt="{{ $feature->name }}" class="w-6 h-6" />
                                @else
                                    <svg class="w-6 h-6 text-[#3CC0E9]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                    </svg>
                                @endif
                                <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium" style="font-family: 'Noto Sans', sans-serif;">
                                    {{ $feature->name }}
                                </span>
                                <div class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
                                    {{ $feature->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($bottomAmenities->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-2">
                        @foreach ($bottomAmenities as $feature)
                            <div class="group relative bg-white rounded-lg shadow-sm p-4 flex items-center justify-center lg:justify-start border border-gray-300 hover:shadow-md transition duration-300">
                                @if (!empty($feature->icon))
                                    <img src="{{ asset('assets/' . $feature->icon) }}" alt="{{ $feature->name }}" class="w-6 h-6" />
                                @else
                                    <svg class="w-6 h-6 text-[#3CC0E9]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                    </svg>
                                @endif
                                <span class="hidden lg:inline-block ml-3 text-gray-800 text-sm font-medium" style="font-family: 'Noto Sans', sans-serif;">
                                    {{ $feature->name }}
                                </span>
                                <div class="absolute bottom-full mb-2 bg-black text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap lg:hidden">
                                    {{ $feature->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($amenities->isEmpty())
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-6 text-center">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-700">No amenities added yet</h3>
                        <p class="text-xs text-gray-500 mt-1">Add amenities to highlight what your property offers.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Description + popular facilities + property highlights --}}
    <section class="py-4 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1 space-y-4">
                    <h2 class="text-2xl font-bold text-black">Experience world-class service at {{ $property->title ?? 'this property' }}</h2>

                    <p class="text-green-600 font-semibold" style="font-family: 'Noto Sans', sans-serif;">Reliable info:
                        <span class="text-gray-700">Guests say the description and photos for this property are very accurate.</span>
                    </p>

                    <div class="space-y-3 text-gray-800">
                        @if (!empty($property->description))
                            <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm">
                                <span class="font-bold">About this property:</span>
                                {{ $property->description }}
                            </p>
                        @endif

                        @if ($property->additionalDetails && !empty($property->additionalDetails->details))
                            <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm">
                                <span class="font-bold">Additional details:</span>
                                {{ $property->additionalDetails->details }}
                            </p>
                        @endif

                        @if ($property->additionalDetails && !empty($property->additionalDetails->special_features))
                            <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm">
                                <span class="font-bold">Special features:</span>
                                {{ $property->additionalDetails->special_features }}
                            </p>
                        @endif

                        @if ($property->category || $property->subcategory || $property->subtype)
                            <p style="font-family: 'Noto Sans', sans-serif;" class="text-sm">
                                <span class="font-bold">Category:</span>
                                {{ collect([
                                    optional($property->category)->name,
                                    optional($property->subcategory)->name,
                                    optional($property->subtype)->name,
                                ])->filter()->join(' · ') }}
                            </p>
                        @endif

                        @if ($property->additionalDetails)
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-sm">
                                @if (!empty($property->additionalDetails->guests))
                                    <p><span class="font-bold">Guests:</span> {{ $property->additionalDetails->guests }}</p>
                                @endif
                                @if (!empty($property->additionalDetails->bathrooms))
                                    <p><span class="font-bold">Bathrooms:</span> {{ $property->additionalDetails->bathrooms }}</p>
                                @endif
                                @if (!empty($property->additionalDetails->apartment_size))
                                    <p><span class="font-bold">Size:</span> {{ $property->additionalDetails->apartment_size }} {{ $sizeUnit }}</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if ($popularFacilities->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-black mt-6 mb-4">Most popular facilities</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($popularFacilities as $facility)
                                    <div class="flex items-center justify-start p-2">
                                        <svg class="w-5 h-5 mr-3 text-[#3CC0E9]" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                        </svg>
                                        <span class="text-sm text-gray-800 font-medium">{{ $facility->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Property highlights sidebar --}}
                <div class="w-full lg:w-auto lg:max-w-xs">
                    <div class="bg-blue-100 rounded-lg py-4 px-4 space-y-4">
                        <div>
                            <h3 class="font-bold text-xs" style="font-family: 'Noto Sans', sans-serif;">Property highlights</h3>
                            <p class="text-xs" style="font-family: 'Noto Sans', sans-serif;">
                                <span class="text-xs flex items-center gap-x-1">
                                    <i class="fas fa-map-marker-alt"></i> Location:
                                </span>
                                {{ $property->city ?? 'Sri Lanka' }}@if ($locationRating) (rated {{ $locationRating }})@endif
                            </p>
                        </div>

                        @if ($property->services && $property->services->serve_breakfast)
                            <div>
                                <h3 class="font-bold text-xs" style="font-family: 'Noto Sans', sans-serif;">Breakfast info</h3>
                                <p class="text-xs" style="font-family: 'Noto Sans', sans-serif;">
                                    {{ $property->services->breakfast_included ? 'Breakfast included with your stay' : 'Breakfast available (extra charge)' }}
                                </p>
                            </div>
                        @endif

                        @if ($property->services && $property->services->parking_available)
                            <p class="text-xs flex items-center gap-x-1" style="font-family: 'Noto Sans', sans-serif;">
                                <img src="{{ asset('assets/parking.svg') }}" alt="Parking" class="w-4 h-4" />
                                @if (!empty($property->services->parking_cost))
                                    Parking: LKR {{ number_format($property->services->parking_cost) }}/{{ $property->services->parking_cost_unit ?? 'night' }}
                                @else
                                    Free private parking available on-site
                                @endif
                            </p>
                        @endif

                        @php
                            $activityNames = ['Golf', 'Fishing', 'Billiards', 'Swimming Pool', 'Gym', 'Spa', 'Tennis Court', 'Beach Access'];
                            $activities = $amenities->filter(fn ($a) => in_array($a->name, $activityNames));
                        @endphp
                        @if ($activities->count() > 0)
                            <div>
                                <h4 class="font-semibold text-xs">Activities:</h4>
                                <ul class="list-disc list-inside text-gray-800 text-xs">
                                    @foreach ($activities as $activity)
                                        <li>{{ $activity->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($isOwner)
                            <a href="{{ route('partner.dashboard') }}"
                                class="block w-full text-center bg-sky-500 text-white font-medium py-2 rounded hover:bg-sky-600 text-xs">
                                Manage listing
                            </a>
                        @else
                            <button class="w-full bg-sky-500 text-white font-medium py-2 rounded hover:bg-sky-600 text-xs">Reserve</button>
                            <button class="w-full border border-sky-500 text-sky-500 py-2 rounded hover:bg-sky-100 text-xs flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                                Save the property
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Availability / Rooms --}}
    <section id="info" class="py-6 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 border-t">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Availability</h2>
                <div class="flex items-center text-blue-500 text-sm font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 010 8m-4-4h4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a4 4 0 00-4-4m0 0H8a4 4 0 000 8m0 0H6a2 2 0 00-2 2v4a2 2 0 002 2h2a4 4 0 004 4" />
                    </svg>
                    We Price Match
                </div>
            </div>

            <div class="flex items-start gap-2 mb-6">
                <svg class="w-5 h-5 text-red-600 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                </svg>
                <p class="text-red-600 mb-6">
                    Select dates to see this property's availability and prices (may include Genius rates)
                </p>
            </div>

            <div class="pt-4 bg-white">
                <h2 class="text-xl sm:text-2xl font-bold mb-6">All available rooms</h2>

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
                            @forelse (($property->rooms ?? collect()) as $room)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 align-top border border-blue-500">
                                        <h3 class="text-blue-600 font-semibold underline">{{ $room->name ?? ($room->room_type ?? 'Room') }}</h3>
                                        <p class="text-gray-600 mt-1 text-sm">
                                            {{ $room->description ?? 'A comfortable room with all essential amenities for a pleasant stay.' }}
                                        </p>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        <div class="flex space-x-1 items-center">
                                            @for ($i = 0; $i < (int) ($room->max_guests ?? $room->capacity ?? 2); $i++)
                                                <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.3 0-9.8 1.7-9.8 4.9V22h19.6v-2.7c0-3.3-6.5-4.9-9.8-4.9z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500">
                                        @php
                                            $roomPrice = $room->price_per_night ?? $room->price ?? null;
                                            $currency = $property->currency ?? 'LKR';
                                        @endphp
                                        @if ($roomPrice !== null)
                                            <div class="text-lg font-bold text-green-600">{{ $currency }} {{ number_format($roomPrice) }}</div>
                                        @else
                                            <div class="text-sm text-gray-500">Price on request</div>
                                        @endif
                                    </td>
                                    <td class="p-3 align-top border border-blue-500 text-gray-700 text-sm">
                                        <ul class="space-y-1">
                                            @if ($property->services && $property->services->breakfast_included)
                                                <li class="text-green-700">✔ Breakfast included</li>
                                            @endif
                                            @if ($property->services && $property->services->wifi_available)
                                                <li class="text-green-700">✔ Free WiFi</li>
                                            @endif
                                            @if ($property->policies && $property->policies->flexible_cancellation)
                                                <li class="text-green-700">✔ Flexible cancellation</li>
                                            @else
                                                <li class="text-red-600">✘ Non-refundable</li>
                                            @endif
                                            @if ($property->policies && $property->policies->pay_at_property)
                                                <li>✔ Pay at the property</li>
                                            @endif
                                        </ul>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500 text-center">
                                        <select class="border p-1 w-full rounded">
                                            @for ($i = 0; $i <= 5; $i++)
                                                <option>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td class="p-3 align-top border border-blue-500 text-center">
                                        <button class="mt-2 w-full bg-blue-600 text-white text-sm py-1.5 rounded hover:bg-blue-700">
                                            I'll reserve
                                        </button>
                                        <p class="text-xs mt-1 text-gray-500">
                                            ✓ It only takes 2 minutes<br>
                                            ✓ You won't be charged yet
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500 border border-blue-500">
                                        No rooms available for this property.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    {{-- Reviews + Host --}}
    <section id="reviews" class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <h2 class="text-xl sm:text-2xl font-bold mb-4">Guest reviews</h2>

            @if ($totalReviews > 0)
                <div class="flex items-center gap-4 mb-6 flex-wrap">
                    <div class="bg-blue-600 text-white px-3 py-1 rounded text-sm font-semibold">{{ $overallRating }}</div>
                    <span class="font-semibold text-gray-800">{{ $ratingText }}</span>
                    <span class="text-gray-500 text-sm">{{ $totalReviews }} {{ \Illuminate\Support\Str::plural('review', $totalReviews) }}</span>
                </div>

                @php
                    $categoryRows = collect([
                        ['Staff', $staffRating, 'bg-blue-500'],
                        ['Facilities', $facilitiesRating, 'bg-green-500'],
                        ['Cleanliness', $cleanlinessRating, 'bg-green-500'],
                        ['Comfort', $comfortRating, 'bg-green-500'],
                        ['Value for money', $valueRating, 'bg-blue-500'],
                        ['Location', $locationRating, 'bg-blue-500'],
                        ['Free WiFi', $wifiRating, 'bg-blue-500'],
                    ])->filter(fn ($row) => $row[1] !== null && $row[1] !== '');
                @endphp

                @if ($categoryRows->count() > 0)
                    <h3 class="font-semibold mb-3">Categories</h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
                        @foreach ($categoryRows as [$label, $score, $colour])
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span>{{ $label }}</span><span>{{ $score }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $colour }} h-2 rounded-full" style="width: {{ (float) $score * 10 }}%;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (($reviews ?? collect())->count() > 0)
                    <h3 class="font-semibold text-lg mb-4">Guests who stayed here loved</h3>
                    <div class="grid md:grid-cols-3 gap-4 mb-6">
                        @foreach ($reviews as $review)
                            @php
                                $rName = optional($review->user)->name ?? optional($review->traveler)->name ?? ($review->guest_name ?? 'Guest');
                                $rCountry = optional($review->user)->country ?? optional($review->traveler)->country ?? ($review->country ?? '');
                                $rText = $review->comment ?? $review->review ?? '';
                            @endphp
                            <div class="border rounded-lg p-4 shadow-sm">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
                                        {{ strtoupper(substr($rName, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm">{{ $rName }}</p>
                                        @if ($rCountry)
                                            <p class="text-xs text-gray-500">{{ $rCountry }}</p>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700 mb-2">"{{ \Illuminate\Support\Str::limit($rText, 220) }}"</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-8 text-center mb-10">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                    <h3 class="text-base font-semibold text-gray-700 mb-1">No reviews yet</h3>
                    <p class="text-sm text-gray-500">Once guests stay at this property, their reviews will appear here.</p>
                </div>
            @endif

            {{-- Host Information --}}
            <div class="pt-6 mt-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2 sm:mb-0">Host Information</h2>
                    @if ($hostAvgRating)
                        <div class="flex items-center text-sm font-semibold text-gray-700">
                            <span class="mr-2">Host review score</span>
                            <span class="px-2 py-0.5 border border-blue-300 rounded-md text-blue-600">{{ $hostAvgRating }}</span>
                        </div>
                    @endif
                </div>

                <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    @php
                        $hostImage = optional($property->files)->first()?->path;
                    @endphp
                    @if ($hostImage)
                        <img src="{{ asset('storage/' . $hostImage) }}" alt="Host" class="w-32 h-32 object-cover rounded-full border">
                    @else
                        <div class="w-32 h-32 rounded-full border bg-gray-200 flex items-center justify-center text-gray-500">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.9-2.2 4.9-4.9S14.7 2.2 12 2.2 7.1 4.4 7.1 7.1 9.3 12 12 12zm0 2.4c-3.3 0-9.8 1.7-9.8 4.9V22h19.6v-2.7c0-3.3-6.5-4.9-9.8-4.9z" />
                            </svg>
                        </div>
                    @endif

                    <div class="space-y-2 text-sm text-gray-700">
                        @if ($property->hostProfile && !empty($property->hostProfile->host_name))
                            <p><span class="font-medium">Host:</span> {{ $property->hostProfile->host_name }}</p>
                        @endif
                        @if (optional($property->subtype)->name)
                            <p>This is a <span class="font-medium">{{ $property->subtype->name }}</span></p>
                        @endif
                        @if ($property->hostProfile && !empty($property->hostProfile->about_host))
                            <p>{{ $property->hostProfile->about_host }}</p>
                        @endif
                        @if (!empty($property->city))
                            <p><span class="font-medium">{{ $property->city }}</span></p>
                        @endif
                        @if ($property->languages && $property->languages->count() > 0)
                            <p>Languages spoken: <span class="font-bold">{{ $property->languages->pluck('name')->join(', ') }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- House Rules --}}
    <section id="rules" class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xl font-semibold">House rules</h2>
                        <button class="bg-sky-500 hover:bg-sky-600 text-white text-sm px-4 py-2 rounded">See availability</button>
                    </div>
                    <p class="text-xs sm:text-sm md:text-base text-gray-500 truncate">
                        {{ $property->title ?? 'This property' }} takes special requests - add in the next step!
                    </p>
                </div>

                <div class="w-full">
                    <div class="overflow-none border rounded-lg shadow-sm">
                        <table class="table-fixed w-full text-xs sm:text-sm text-left text-gray-700 break-words">
                            <colgroup>
                                <col class="w-1/3">
                                <col class="w-2/3">
                            </colgroup>
                            <tbody class="divide-y divide-gray-200">
                                @php $policies = $property->policies; @endphp

                                <tr class="align-top">
                                    <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                        <img src="{{ asset('assets/check-in.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Check in">
                                        <span>Check in</span>
                                    </th>
                                    <td class="p-4">
                                        @if ($policies && ($policies->check_in_from || $policies->check_in_until))
                                            <p>From {{ $formatTime($policies->check_in_from) ?? '—' }} to {{ $formatTime($policies->check_in_until) ?? '—' }}</p>
                                        @else
                                            <p>Check-in time not specified.</p>
                                        @endif
                                        <p class="text-gray-500">You'll need to let the property know in advance what time you'll arrive.</p>
                                    </td>
                                </tr>

                                <tr class="align-top">
                                    <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                        <img src="{{ asset('assets/check-out.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Check out">
                                        <span>Check out</span>
                                    </th>
                                    <td class="p-4">
                                        @if ($policies && ($policies->check_out_from || $policies->check_out_until))
                                            From {{ $formatTime($policies->check_out_from) ?? '—' }} to {{ $formatTime($policies->check_out_until) ?? '—' }}
                                        @else
                                            Check-out time not specified.
                                        @endif
                                    </td>
                                </tr>

                                <tr class="align-top">
                                    <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                        <img src="{{ asset('assets/prepayment.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Cancellation">
                                        <span>Cancellation / prepayment</span>
                                    </th>
                                    <td class="p-4">
                                        {{ $policies && $policies->cancellation_policy
                                            ? ucfirst(str_replace('_', ' ', $policies->cancellation_policy)) . ' cancellation policy applies.'
                                            : 'Cancellation and prepayment policies vary according to accommodation type. Please check what may apply to each option when making your selection.' }}
                                    </td>
                                </tr>

                                <tr class="align-top">
                                    <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                        <img src="{{ asset('assets/children.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Children">
                                        <span>Children and beds</span>
                                    </th>
                                    <td class="p-4">
                                        <p class="font-semibold">Child policies</p>
                                        <p>{{ $policies && isset($policies->children_allowed) ? ($policies->children_allowed ? 'Children are allowed at this property.' : 'Children are not allowed at this property.') : 'Please add the number of children in your group and their ages to your search to see correct prices and occupancy information.' }}</p>
                                    </td>
                                </tr>

                                <tr class="align-top">
                                    <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                        <img src="{{ asset('assets/payment.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Payment methods">
                                        <span>Accepted payment methods</span>
                                    </th>
                                    <td class="p-4">
                                        @if ($property->payment_method)
                                            <p class="mb-2">{{ $property->payment_method }}</p>
                                        @endif
                                        <div class="flex flex-wrap items-center gap-4 mt-1">
                                            <img src="{{ asset('images/visa.png') }}" alt="Visa" class="h-10 p-1 border rounded-md">
                                            <img src="{{ asset('images/mastercard.png') }}" alt="MasterCard" class="h-10 p-1 border rounded-md">
                                        </div>
                                    </td>
                                </tr>

                                <tr class="align-top">
                                    <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                        <img src="{{ asset('assets/nosmoking.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Smoking">
                                        <span>Smoking</span>
                                    </th>
                                    <td class="p-4">
                                        {{ $policies && isset($policies->smoking_allowed) ? ($policies->smoking_allowed ? 'Smoking is allowed.' : 'Smoking is not allowed.') : 'Smoking policy not specified.' }}
                                    </td>
                                </tr>

                                <tr class="align-top">
                                    <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                        <img src="{{ asset('assets/pets.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Pets">
                                        <span>Pets</span>
                                    </th>
                                    <td class="p-4">
                                        {{ $policies && isset($policies->pets_allowed) ? ($policies->pets_allowed ? 'Pets are allowed.' : 'Pets are not allowed.') : 'Pet policy not specified.' }}
                                    </td>
                                </tr>

                                @if ($policies && isset($policies->parties_allowed))
                                    <tr class="align-top">
                                        <th class="p-4 font-bold whitespace-normal flex items-center justify-start gap-2">
                                            <img src="{{ asset('assets/quiet.svg') }}" class="w-4 h-4 mt-1 shrink-0" alt="Parties">
                                            <span>Parties</span>
                                        </th>
                                        <td class="p-4">
                                            {{ $policies->parties_allowed ? 'Parties / events are allowed.' : 'Parties / events are not allowed.' }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fine Print + FAQ --}}
    <section id="fineprint" class="bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="mb-10 space-y-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-semibold">The fine print</h2>
                    <button class="bg-sky-500 hover:bg-sky-600 text-white text-sm px-4 py-2 rounded">See availability</button>
                </div>
                <div class="bg-gray-50 border rounded-lg p-4 text-base text-gray-700">
                    <p class="m-2">Please inform {{ $property->title ?? 'this property' }} in advance of your expected arrival time. You can use the Special Requests box when booking, or contact the property directly with the contact details provided in your confirmation.</p>
                    @if ($policies && ($policies->check_in_from || $policies->check_in_until))
                        <p class="m-2">Check-in is between {{ $formatTime($policies->check_in_from) ?? '—' }} and {{ $formatTime($policies->check_in_until) ?? '—' }}.</p>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold">FAQs about {{ $property->title ?? 'this property' }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                            What is the cancellation policy?
                            <svg class="w-5 h-5 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <p class="mt-2 text-gray-600 hidden answer">
                            {{ $policies && $policies->cancellation_policy
                                ? ucfirst(str_replace('_', ' ', $policies->cancellation_policy)) . ' cancellation policy applies.'
                                : 'Cancellation policy varies. Please check at booking time.' }}
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                            Are pets allowed?
                            <svg class="w-5 h-5 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <p class="mt-2 text-gray-600 hidden answer">
                            {{ $policies && isset($policies->pets_allowed) ? ($policies->pets_allowed ? 'Yes, pets are welcome.' : 'No, pets are not allowed.') : 'Pet policy not specified.' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                            What time is check-in?
                            <svg class="w-5 h-5 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <p class="mt-2 text-gray-600 hidden answer">
                            @if ($policies && ($policies->check_in_from || $policies->check_in_until))
                                Check-in is from {{ $formatTime($policies->check_in_from) ?? '—' }} to {{ $formatTime($policies->check_in_until) ?? '—' }}.
                            @else
                                Please contact the property for check-in times.
                            @endif
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <button class="w-full flex justify-between items-center text-left font-medium text-gray-800 toggle-answer focus:outline-none">
                            Is breakfast available?
                            <svg class="w-5 h-5 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <p class="mt-2 text-gray-600 hidden answer">
                            @if ($property->services && $property->services->serve_breakfast)
                                {{ $property->services->breakfast_included ? 'Yes, breakfast is included with your stay.' : 'Yes, breakfast is available (extra charge).' }}
                            @else
                                Breakfast is not available at this property.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // FAQ toggles
            const toggles = document.querySelectorAll('.toggle-answer');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const answer = toggle.nextElementSibling;
                    const icon = toggle.querySelector('svg');
                    answer.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Section scroll-spy
            const links = document.querySelectorAll('a.scroll-link');
            if (links.length > 0) {
                links[0].classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'font-semibold');
            }
            const sectionIds = Array.from(links).map(link => link.getAttribute('href').substring(1));
            const sections = sectionIds.map(id => document.getElementById(id)).filter(Boolean);
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        links.forEach(link => {
                            link.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600', 'font-semibold');
                            if (link.getAttribute('href') === `#${entry.target.id}`) {
                                link.classList.add('border-b-2', 'border-blue-500', 'text-blue-600', 'font-semibold');
                            }
                        });
                    }
                });
            }, { threshold: 0.6 });
            sections.forEach(section => observer.observe(section));

            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth' });
                });
            });
        });
    </script>
@endsection
