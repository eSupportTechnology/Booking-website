@extends('frontend.master')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Hero Section with Hotel Images -->
<section class="bg-white py-4">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 mb-4">
            <a href="{{ url('/') }}" class="hover:text-blue-600">Home</a> > 
            <a href="{{ route('hotel-listing') }}" class="hover:text-blue-600">Hotels</a> > 
            <span class="text-gray-800">{{ $property->title ?? 'Hotel Details' }}</span>
        </nav>

        <!-- Hotel Title and Rating -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $property->title ?? 'Luxury Hotel' }}</h1>
            <div class="flex items-center gap-4 mb-2">
                @if(isset($property->stars))
                    <div class="flex items-center">
                        @for($i = 1; $i <= $property->stars; $i++)
                            <i class="fas fa-star text-yellow-400"></i>
                        @endfor
                        <span class="ml-2 text-sm text-gray-600">{{ $property->stars }}-Star Hotel</span>
                    </div>
                @endif
                @php
                    $avgRating = isset($property) ? $property->reviews->avg('rating') ?? 0 : 4.5;
                    $reviewCount = isset($property) ? $property->reviews->count() : 128;
                @endphp
                <div class="flex items-center">
                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-sm font-semibold">{{ number_format($avgRating, 1) }}</span>
                    <span class="ml-2 text-sm text-gray-600">{{ $reviewCount }} reviews</span>
                </div>
            </div>
            <p class="text-gray-600"><i class="fas fa-map-marker-alt mr-1"></i>{{ $property->address ?? 'Downtown Location' }}, {{ $property->city ?? 'City Center' }}</p>
        </div>

        <!-- Image Gallery -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-2 mb-8" x-data="{ showGallery: false }">
            <div class="lg:col-span-2">
                <img src="{{ isset($property) && $property->files->where('file_type', 'image')->first() ? asset('storage/' . $property->files->where('file_type', 'image')->first()->path) : asset('images/hotel-main.jpg') }}" 
                     alt="Hotel Main" class="w-full h-80 object-cover rounded-lg cursor-pointer" @click="showGallery = true">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <img src="{{ asset('images/hotel-room.jpg') }}" alt="Room" class="w-full h-39 object-cover rounded-lg cursor-pointer" @click="showGallery = true">
                <img src="{{ asset('images/hotel-lobby.jpg') }}" alt="Lobby" class="w-full h-39 object-cover rounded-lg cursor-pointer" @click="showGallery = true">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <img src="{{ asset('images/hotel-pool.jpg') }}" alt="Pool" class="w-full h-39 object-cover rounded-lg cursor-pointer" @click="showGallery = true">
                <div class="relative">
                    <img src="{{ asset('images/hotel-restaurant.jpg') }}" alt="Restaurant" class="w-full h-39 object-cover rounded-lg cursor-pointer" @click="showGallery = true">
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg flex items-center justify-center cursor-pointer" @click="showGallery = true">
                        <span class="text-white font-semibold">+5 more photos</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Hotel Details -->
            <div class="lg:col-span-2 space-y-8">
                <!-- About Section -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-2xl font-semibold mb-4">About this hotel</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        {{ $property->description ?? 'Experience luxury and comfort at our premium hotel located in the heart of the city. Our elegant rooms and suites offer modern amenities, stunning views, and exceptional service to make your stay memorable.' }}
                    </p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div class="flex items-center"><i class="fas fa-wifi text-blue-600 mr-2"></i>Free WiFi</div>
                        <div class="flex items-center"><i class="fas fa-car text-blue-600 mr-2"></i>Free Parking</div>
                        <div class="flex items-center"><i class="fas fa-swimming-pool text-blue-600 mr-2"></i>Pool</div>
                        <div class="flex items-center"><i class="fas fa-dumbbell text-blue-600 mr-2"></i>Fitness Center</div>
                    </div>
                </div>

                <!-- Amenities -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-2xl font-semibold mb-4">Popular amenities</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="flex items-center"><i class="fas fa-wifi text-gray-600 mr-3"></i>Free WiFi</div>
                        <div class="flex items-center"><i class="fas fa-car text-gray-600 mr-3"></i>Free parking</div>
                        <div class="flex items-center"><i class="fas fa-swimming-pool text-gray-600 mr-3"></i>Pool</div>
                        <div class="flex items-center"><i class="fas fa-dumbbell text-gray-600 mr-3"></i>Fitness center</div>
                        <div class="flex items-center"><i class="fas fa-utensils text-gray-600 mr-3"></i>Restaurant</div>
                        <div class="flex items-center"><i class="fas fa-cocktail text-gray-600 mr-3"></i>Bar/Lounge</div>
                        <div class="flex items-center"><i class="fas fa-concierge-bell text-gray-600 mr-3"></i>Room service</div>
                        <div class="flex items-center"><i class="fas fa-spa text-gray-600 mr-3"></i>Spa</div>
                        <div class="flex items-center"><i class="fas fa-paw text-gray-600 mr-3"></i>Pet friendly</div>
                    </div>
                </div>

                <!-- Room Types -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-2xl font-semibold mb-4">Available rooms</h2>
                    <div class="space-y-4">
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-lg">Standard Room</h3>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600">${{ $property->price_per_night ?? '120' }}</div>
                                    <div class="text-sm text-gray-600">per night</div>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">Comfortable room with city view, free WiFi, and modern amenities</p>
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                <span><i class="fas fa-bed mr-1"></i>1 Queen bed</span>
                                <span><i class="fas fa-users mr-1"></i>2 guests</span>
                                <span><i class="fas fa-expand-arrows-alt mr-1"></i>25 m²</span>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Select Room</button>
                        </div>
                        
                        <div class="border rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-lg">Deluxe Room</h3>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600">${{ isset($property->price_per_night) ? $property->price_per_night + 50 : '170' }}</div>
                                    <div class="text-sm text-gray-600">per night</div>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">Spacious room with premium amenities and stunning city views</p>
                            <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                                <span><i class="fas fa-bed mr-1"></i>1 King bed</span>
                                <span><i class="fas fa-users mr-1"></i>2 guests</span>
                                <span><i class="fas fa-expand-arrows-alt mr-1"></i>35 m²</span>
                            </div>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Select Room</button>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="bg-white rounded-lg p-6 shadow-sm">
                    <h2 class="text-2xl font-semibold mb-4">Guest reviews</h2>
                    <div class="mb-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="text-4xl font-bold text-blue-600">{{ number_format($avgRating, 1) }}</div>
                            <div>
                                <div class="flex items-center mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <div class="text-sm text-gray-600">Based on {{ $reviewCount }} reviews</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @if(isset($property) && $property->reviews->count() > 0)
                            @foreach($property->reviews->take(3) as $review)
                                <div class="border-b pb-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                            {{ substr($review->user->name ?? 'Guest', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-sm">{{ $review->user->name ?? 'Anonymous Guest' }}</div>
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="border-b pb-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">J</div>
                                    <div>
                                        <div class="font-semibold text-sm">John D.</div>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-xs text-yellow-400"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-sm">Excellent hotel with great service and amenities. The room was clean and comfortable. Highly recommend!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Booking Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg p-6 shadow-lg sticky top-4" x-data="{ adults: 2, children: 0, rooms: 1, checkIn: '', checkOut: '', totalPrice: {{ $property->price_per_night ?? 120 }} }">
                    <div class="mb-6">
                        <div class="text-3xl font-bold text-blue-600 mb-1">${{ $property->price_per_night ?? '120' }}</div>
                        <div class="text-sm text-gray-600">per night</div>
                    </div>

                    <form class="space-y-4">
                        <!-- Check-in/Check-out -->
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-in</label>
                                <input type="date" x-model="checkIn" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Check-out</label>
                                <input type="date" x-model="checkOut" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <!-- Guests -->
                        <div x-data="{ open: false }" class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Guests</label>
                            <button @click="open = !open" type="button" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-left focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <span x-text="`${adults} adults, ${children} children, ${rooms} room${rooms > 1 ? 's' : ''}`"></span>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" class="absolute z-20 w-full bg-white border border-gray-300 rounded-lg mt-1 p-4 shadow-lg">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm">Adults</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="if(adults > 1) adults--" class="w-8 h-8 border rounded-full flex items-center justify-center">-</button>
                                            <span x-text="adults" class="w-8 text-center"></span>
                                            <button type="button" @click="adults++" class="w-8 h-8 border rounded-full flex items-center justify-center">+</button>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm">Children</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="if(children > 0) children--" class="w-8 h-8 border rounded-full flex items-center justify-center">-</button>
                                            <span x-text="children" class="w-8 text-center"></span>
                                            <button type="button" @click="children++" class="w-8 h-8 border rounded-full flex items-center justify-center">+</button>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm">Rooms</span>
                                        <div class="flex items-center gap-2">
                                            <button type="button" @click="if(rooms > 1) rooms--" class="w-8 h-8 border rounded-full flex items-center justify-center">-</button>
                                            <span x-text="rooms" class="w-8 text-center"></span>
                                            <button type="button" @click="rooms++" class="w-8 h-8 border rounded-full flex items-center justify-center">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>${{ $property->price_per_night ?? '120' }} × <span x-text="checkIn && checkOut ? Math.ceil((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24)) || 1 : 1"></span> nights</span>
                                <span x-text="'$' + ({{ $property->price_per_night ?? 120 }} * (checkIn && checkOut ? Math.ceil((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24)) || 1 : 1))"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Taxes and fees</span>
                                <span>$25</span>
                            </div>
                            <div class="border-t pt-2 flex justify-between font-semibold">
                                <span>Total</span>
                                <span x-text="'$' + ({{ $property->price_per_night ?? 120 }} * (checkIn && checkOut ? Math.ceil((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24)) || 1 : 1) + 25)"></span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#3CC0E9] text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Reserve Now
                        </button>
                    </form>

                    <p class="text-xs text-gray-500 text-center mt-4">You won't be charged yet</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection