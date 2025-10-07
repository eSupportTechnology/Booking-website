{{-- Enhanced Room Selection Component --}}
<div x-data="roomSelection()" x-init="init()" class="space-y-4">
    <!-- Room Selection Header -->
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Available Rooms</h3>
        <div x-show="selectedDates.checkIn && selectedDates.checkOut" class="text-sm text-gray-600">
            <span x-text="calculateNights()"></span> nights
        </div>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="flex justify-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#3CC0E9]"></div>
    </div>

    <!-- No Rooms Available -->
    <div x-show="!loading && availableRooms.length === 0 && roomsLoaded" 
         class="text-center py-8 bg-red-50 rounded-lg border border-red-200">
        <div class="text-red-600 font-medium">No rooms available for selected dates</div>
        <p class="text-sm text-red-500 mt-1">Please try different dates</p>
    </div>

    <!-- Available Rooms Grid -->
    <div x-show="!loading && availableRooms.length > 0" class="space-y-4">
        <template x-for="room in availableRooms" :key="room.id">
            <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200"
                 :class="selectedRoom?.id === room.id ? 'border-[#3CC0E9] bg-blue-50' : 'border-gray-200'">
                
                <!-- Room Header -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900" x-text="room.name"></h4>
                            <p class="text-sm text-gray-600 mt-1" x-text="room.room_type"></p>
                            <p x-show="room.description" class="text-sm text-gray-500 mt-1" x-text="room.description"></p>
                        </div>
                        <div class="text-right ml-4">
                            <div class="text-lg font-bold text-gray-900">
                                <span x-text="room.currency"></span> <span x-text="formatPrice(room.price_per_night)"></span>
                            </div>
                            <div class="text-sm text-gray-500">per night</div>
                            <div class="text-sm font-medium text-[#3CC0E9] mt-1">
                                Total: <span x-text="room.currency"></span> <span x-text="formatPrice(room.total_price)"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Details -->
                <div class="p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <!-- Guests -->
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span x-text="room.max_guests + ' guests'"></span>
                        </div>

                        <!-- Size -->
                        <div x-show="room.size_sq_m" class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z"/>
                            </svg>
                            <span x-text="room.size_sq_m + ' m²'"></span>
                        </div>

                        <!-- Bathroom -->
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 2v1h6V2h2v1h1c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h1V2h2z"/>
                            </svg>
                            <span x-text="room.bathroom_count + ' ' + room.bathroom_type"></span>
                        </div>

                        <!-- Smoking -->
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2 16h20v2H2zm1.5-5L12 7.5 20.5 11 12 14.5z"/>
                            </svg>
                            <span x-text="room.smoking_allowed ? 'Smoking allowed' : 'Non-smoking'"></span>
                        </div>
                    </div>

                    <!-- Beds -->
                    <div x-show="room.beds && room.beds.length > 0" class="mb-4">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Bed Configuration:</h5>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="bed in room.beds" :key="bed.type">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">
                                    <span x-text="bed.count + 'x ' + bed.type"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div x-show="room.amenities && room.amenities.length > 0" class="mb-4">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Room Amenities:</h5>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="amenity in room.amenities.slice(0, 6)" :key="amenity">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                    <span x-text="amenity"></span>
                                </span>
                            </template>
                            <button x-show="room.amenities.length > 6" 
                                    @click="showAllAmenities = !showAllAmenities"
                                    class="text-xs text-[#3CC0E9] hover:underline">
                                <span x-text="showAllAmenities ? 'Show less' : '+' + (room.amenities.length - 6) + ' more'"></span>
                            </button>
                        </div>
                        <div x-show="showAllAmenities" class="flex flex-wrap gap-2 mt-2">
                            <template x-for="amenity in room.amenities.slice(6)" :key="amenity">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                    <span x-text="amenity"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Rate Plans -->
                    <div x-show="room.rate_plans && room.rate_plans.length > 0" class="mb-4">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Rate Options:</h5>
                        <div class="space-y-2">
                            <template x-for="plan in room.rate_plans" :key="plan.name">
                                <div class="flex justify-between items-center p-2 bg-gray-50 rounded text-sm">
                                    <div>
                                        <span class="font-medium" x-text="plan.name"></span>
                                        <span x-show="plan.discount > 0" class="text-green-600 ml-2" x-text="'(' + plan.discount + '% off)'"></span>
                                        <div x-show="plan.policy_notes" class="text-xs text-gray-500" x-text="plan.policy_notes"></div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium" x-text="room.currency + ' ' + formatPrice(plan.total_price)"></div>
                                        <div class="text-xs text-gray-500" x-text="plan.is_refundable ? 'Refundable' : 'Non-refundable'"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Selection Button -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <button @click="toggleRoomDetails(room.id)" 
                                class="text-sm text-[#3CC0E9] hover:underline">
                            View Details
                        </button>
                        <button @click="selectRoom(room)" 
                                :class="selectedRoom?.id === room.id ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3CC0E9] hover:bg-[#2BA8D1]'"
                                class="px-4 py-2 text-white rounded font-medium transition-colors">
                            <span x-text="selectedRoom?.id === room.id ? 'Selected' : 'Select Room'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Hidden input for form submission -->
    <input type="hidden" name="room_id" :value="selectedRoom?.id || ''">
    <input type="hidden" name="room_price" :value="selectedRoom?.price_per_night || ''">
    <input type="hidden" name="total_price" :value="selectedRoom?.total_price || ''">
</div>

<script>
function roomSelection() {
    return {
        availableRooms: [],
        selectedRoom: null,
        loading: false,
        roomsLoaded: false,
        showAllAmenities: false,
        selectedDates: {
            checkIn: '',
            checkOut: ''
        },
        propertyId: {{ $property->id }},

        init() {
            // Watch for date changes
            this.$watch('selectedDates.checkIn', () => this.loadRooms());
            this.$watch('selectedDates.checkOut', () => this.loadRooms());
        },

        async loadRooms() {
            if (!this.selectedDates.checkIn || !this.selectedDates.checkOut) {
                this.availableRooms = [];
                this.roomsLoaded = false;
                return;
            }

            this.loading = true;
            this.selectedRoom = null;

            try {
                const response = await fetch(`/customer/properties/${this.propertyId}/rooms/available?check_in=${this.selectedDates.checkIn}&check_out=${this.selectedDates.checkOut}&guests=2`);
                const data = await response.json();
                
                if (data.success) {
                    this.availableRooms = data.rooms;
                    this.roomsLoaded = true;
                }
            } catch (error) {
                console.error('Failed to load rooms:', error);
                this.availableRooms = [];
            } finally {
                this.loading = false;
            }
        },

        selectRoom(room) {
            this.selectedRoom = room;
            // Dispatch event for parent components
            this.$dispatch('room-selected', { room: room });
        },

        calculateNights() {
            if (!this.selectedDates.checkIn || !this.selectedDates.checkOut) return 0;
            const start = new Date(this.selectedDates.checkIn);
            const end = new Date(this.selectedDates.checkOut);
            const diffTime = Math.abs(end - start);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        },

        formatPrice(price) {
            return new Intl.NumberFormat().format(price);
        },

        toggleRoomDetails(roomId) {
            // Could open a modal or expand details
            console.log('Show details for room:', roomId);
        },

        updateDates(checkIn, checkOut) {
            this.selectedDates.checkIn = checkIn;
            this.selectedDates.checkOut = checkOut;
        }
    }
}
</script>