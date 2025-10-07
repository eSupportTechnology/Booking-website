{{-- Partner Room Management Component --}}
<div x-data="roomManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Room Management</h2>
            <p class="text-gray-600 mt-1">Manage your property's rooms, pricing, and availability</p>
        </div>
        <button @click="showAddRoomModal = true" 
                class="bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white px-4 py-2 rounded-lg font-medium">
            Add New Room
        </button>
    </div>

    <!-- Room Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="text-2xl font-bold text-gray-900" x-text="rooms.length"></div>
            <div class="text-sm text-gray-600">Total Rooms</div>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="text-2xl font-bold text-green-600" x-text="availableRoomsCount"></div>
            <div class="text-sm text-gray-600">Available Today</div>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="text-2xl font-bold text-blue-600" x-text="bookedRoomsCount"></div>
            <div class="text-sm text-gray-600">Currently Booked</div>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="text-2xl font-bold text-[#3CC0E9]" x-text="'LKR ' + formatPrice(averagePrice)"></div>
            <div class="text-sm text-gray-600">Average Price</div>
        </div>
    </div>

    <!-- Room Filters -->
    <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex flex-wrap gap-4 items-center">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                <select x-model="filters.roomType" @change="applyFilters()" 
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option value="">All Types</option>
                    <template x-for="type in roomTypes" :key="type.id">
                        <option :value="type.id" x-text="type.name"></option>
                    </template>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                <select x-model="filters.availability" @change="applyFilters()" 
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option value="">All Rooms</option>
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                <select x-model="filters.priceRange" @change="applyFilters()" 
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option value="">All Prices</option>
                    <option value="0-5000">LKR 0 - 5,000</option>
                    <option value="5000-10000">LKR 5,000 - 10,000</option>
                    <option value="10000-20000">LKR 10,000 - 20,000</option>
                    <option value="20000+">LKR 20,000+</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" x-model="filters.search" @input="applyFilters()" 
                       placeholder="Search rooms..."
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <template x-for="room in filteredRooms" :key="room.id">
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Room Header -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-gray-900" x-text="room.name"></h3>
                            <p class="text-sm text-gray-600" x-text="room.room_type?.name || 'Standard'"></p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="editRoom(room)" 
                                    class="text-[#3CC0E9] hover:text-[#2BA8D1] p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button @click="deleteRoom(room)" 
                                    class="text-red-600 hover:text-red-700 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Room Details -->
                <div class="p-4 space-y-3">
                    <!-- Price and Availability -->
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-lg font-bold text-gray-900">
                                LKR <span x-text="formatPrice(room.price_per_night)"></span>
                            </div>
                            <div class="text-sm text-gray-500">per night</div>
                        </div>
                        <div class="text-right">
                            <div :class="room.is_available ? 'text-green-600' : 'text-red-600'" 
                                 class="text-sm font-medium">
                                <span x-text="room.is_available ? 'Available' : 'Booked'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Room Info -->
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span x-text="room.max_guests + ' guests'"></span>
                        </div>
                        <div class="flex items-center" x-show="room.size_sq_m">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z"/>
                            </svg>
                            <span x-text="room.size_sq_m + ' m²'"></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 2v1h6V2h2v1h1c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h1V2h2z"/>
                            </svg>
                            <span x-text="room.bathroom_count + ' ' + room.bathroom_type"></span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2 16h20v2H2zm1.5-5L12 7.5 20.5 11 12 14.5z"/>
                            </svg>
                            <span x-text="room.smoking_allowed ? 'Smoking' : 'Non-smoking'"></span>
                        </div>
                    </div>

                    <!-- Amenities Preview -->
                    <div x-show="room.amenities && room.amenities.length > 0">
                        <div class="text-sm font-medium text-gray-700 mb-2">Amenities:</div>
                        <div class="flex flex-wrap gap-1">
                            <template x-for="amenity in room.amenities.slice(0, 3)" :key="amenity.id">
                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                    <span x-text="amenity.name"></span>
                                </span>
                            </template>
                            <span x-show="room.amenities.length > 3" 
                                  class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">
                                <span x-text="'+' + (room.amenities.length - 3) + ' more'"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="flex space-x-2 pt-3 border-t border-gray-100">
                        <button @click="toggleAvailability(room)" 
                                :class="room.is_available ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200'"
                                class="flex-1 px-3 py-2 text-sm font-medium rounded transition-colors">
                            <span x-text="room.is_available ? 'Mark Unavailable' : 'Mark Available'"></span>
                        </button>
                        <button @click="manageRoomPricing(room)" 
                                class="flex-1 px-3 py-2 text-sm font-medium bg-[#3CC0E9] text-white rounded hover:bg-[#2BA8D1] transition-colors">
                            Manage Pricing
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredRooms.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No rooms found</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by adding your first room.</p>
        <div class="mt-6">
            <button @click="showAddRoomModal = true" 
                    class="bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white px-4 py-2 rounded-lg font-medium">
                Add Room
            </button>
        </div>
    </div>
</div>

<script>
function roomManagement() {
    return {
        rooms: [],
        filteredRooms: [],
        roomTypes: [],
        showAddRoomModal: false,
        filters: {
            roomType: '',
            availability: '',
            priceRange: '',
            search: ''
        },

        get availableRoomsCount() {
            return this.rooms.filter(room => room.is_available).length;
        },

        get bookedRoomsCount() {
            return this.rooms.filter(room => !room.is_available).length;
        },

        get averagePrice() {
            if (this.rooms.length === 0) return 0;
            const total = this.rooms.reduce((sum, room) => sum + (room.price_per_night || 0), 0);
            return total / this.rooms.length;
        },

        async init() {
            await this.loadRooms();
            await this.loadRoomTypes();
            this.applyFilters();
        },

        async loadRooms() {
            try {
                const response = await fetch(`/partner/properties/{{ $property->id ?? 1 }}/rooms`);
                const data = await response.json();
                if (data.success) {
                    this.rooms = data.rooms;
                }
            } catch (error) {
                console.error('Failed to load rooms:', error);
            }
        },

        async loadRoomTypes() {
            try {
                const response = await fetch('/partner/room-types');
                const data = await response.json();
                if (data.success) {
                    this.roomTypes = data.room_types;
                }
            } catch (error) {
                console.error('Failed to load room types:', error);
            }
        },

        applyFilters() {
            let filtered = [...this.rooms];

            // Filter by room type
            if (this.filters.roomType) {
                filtered = filtered.filter(room => room.room_type_id == this.filters.roomType);
            }

            // Filter by availability
            if (this.filters.availability) {
                const isAvailable = this.filters.availability === 'available';
                filtered = filtered.filter(room => room.is_available === isAvailable);
            }

            // Filter by price range
            if (this.filters.priceRange) {
                const [min, max] = this.filters.priceRange.split('-').map(p => p.replace('+', ''));
                filtered = filtered.filter(room => {
                    const price = room.price_per_night || 0;
                    if (max) {
                        return price >= parseInt(min) && price <= parseInt(max);
                    } else {
                        return price >= parseInt(min);
                    }
                });
            }

            // Filter by search
            if (this.filters.search) {
                const search = this.filters.search.toLowerCase();
                filtered = filtered.filter(room => 
                    room.name.toLowerCase().includes(search) ||
                    (room.description && room.description.toLowerCase().includes(search))
                );
            }

            this.filteredRooms = filtered;
        },

        editRoom(room) {
            // Navigate to room edit page or open modal
            window.location.href = `/partner/rooms/${room.id}/edit`;
        },

        async deleteRoom(room) {
            if (!confirm(`Are you sure you want to delete "${room.name}"?`)) return;

            try {
                const response = await fetch(`/partner/rooms/${room.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    this.rooms = this.rooms.filter(r => r.id !== room.id);
                    this.applyFilters();
                    this.showSuccessMessage('Room deleted successfully');
                }
            } catch (error) {
                console.error('Failed to delete room:', error);
                this.showErrorMessage('Failed to delete room');
            }
        },

        async toggleAvailability(room) {
            try {
                const response = await fetch(`/partner/rooms/${room.id}/toggle-availability`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (response.ok) {
                    room.is_available = !room.is_available;
                    this.showSuccessMessage(`Room ${room.is_available ? 'enabled' : 'disabled'} successfully`);
                }
            } catch (error) {
                console.error('Failed to toggle availability:', error);
            }
        },

        manageRoomPricing(room) {
            // Navigate to pricing management page
            window.location.href = `/partner/rooms/${room.id}/pricing`;
        },

        formatPrice(price) {
            return new Intl.NumberFormat().format(price || 0);
        },

        showSuccessMessage(message) {
            // Implement toast notification
            console.log('Success:', message);
        },

        showErrorMessage(message) {
            // Implement toast notification
            console.log('Error:', message);
        }
    }
}
</script>