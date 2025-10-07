{{-- Room Comparison Component --}}
<div x-data="roomComparison()" class="space-y-6">
    <!-- Comparison Toggle -->
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold text-gray-800">Compare Rooms</h3>
        <button @click="showComparison = !showComparison" 
                :class="selectedRooms.length < 2 ? 'opacity-50 cursor-not-allowed' : ''"
                :disabled="selectedRooms.length < 2"
                class="px-4 py-2 bg-[#3CC0E9] text-white rounded hover:bg-[#2BA8D1] transition-colors">
            <span x-text="showComparison ? 'Hide Comparison' : 'Compare Selected (' + selectedRooms.length + ')'"></span>
        </button>
    </div>

    <!-- Room Selection for Comparison -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <template x-for="room in availableRooms" :key="room.id">
            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow"
                 :class="isRoomSelected(room.id) ? 'border-[#3CC0E9] bg-blue-50' : 'border-gray-200'">
                
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h4 class="font-semibold text-gray-900" x-text="room.name"></h4>
                        <p class="text-sm text-gray-600" x-text="room.room_type"></p>
                    </div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               :value="room.id"
                               @change="toggleRoomSelection(room)"
                               :checked="isRoomSelected(room.id)"
                               class="form-checkbox text-[#3CC0E9] rounded">
                        <span class="ml-2 text-sm">Compare</span>
                    </label>
                </div>

                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Price per night:</span>
                        <span class="font-medium" x-text="room.currency + ' ' + formatPrice(room.price_per_night)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Max guests:</span>
                        <span x-text="room.max_guests"></span>
                    </div>
                    <div class="flex justify-between" x-show="room.size_sq_m">
                        <span>Size:</span>
                        <span x-text="room.size_sq_m + ' m²'"></span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Comparison Table -->
    <div x-show="showComparison && selectedRooms.length >= 2" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="bg-white border rounded-lg overflow-hidden shadow-lg">
        
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h4 class="text-lg font-semibold text-gray-800">Room Comparison</h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Feature
                        </th>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div>
                                    <div class="font-semibold text-gray-900" x-text="room.name"></div>
                                    <div class="text-sm text-gray-600" x-text="room.room_type"></div>
                                </div>
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Price -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Price per night
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="font-semibold text-[#3CC0E9]" x-text="room.currency + ' ' + formatPrice(room.price_per_night)"></span>
                            </td>
                        </template>
                    </tr>

                    <!-- Total Price -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Total price
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="font-bold text-green-600" x-text="room.currency + ' ' + formatPrice(room.total_price)"></span>
                            </td>
                        </template>
                    </tr>

                    <!-- Max Guests -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Max guests
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="room.max_guests"></td>
                        </template>
                    </tr>

                    <!-- Size -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Room size
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span x-text="room.size_sq_m ? room.size_sq_m + ' m²' : 'Not specified'"></span>
                            </td>
                        </template>
                    </tr>

                    <!-- Bathroom -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Bathroom
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span x-text="room.bathroom_count + ' ' + room.bathroom_type"></span>
                            </td>
                        </template>
                    </tr>

                    <!-- Smoking -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Smoking
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span :class="room.smoking_allowed ? 'text-yellow-600' : 'text-green-600'"
                                      x-text="room.smoking_allowed ? 'Allowed' : 'Non-smoking'"></span>
                            </td>
                        </template>
                    </tr>

                    <!-- Beds -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Bed configuration
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div x-show="room.beds && room.beds.length > 0" class="space-y-1">
                                    <template x-for="bed in room.beds" :key="bed.type">
                                        <div class="text-xs bg-gray-100 px-2 py-1 rounded" x-text="bed.count + 'x ' + bed.type"></div>
                                    </template>
                                </div>
                                <span x-show="!room.beds || room.beds.length === 0" class="text-gray-500">Not specified</span>
                            </td>
                        </template>
                    </tr>

                    <!-- Amenities -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Room amenities
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div x-show="room.amenities && room.amenities.length > 0" class="space-y-1">
                                    <template x-for="amenity in room.amenities.slice(0, 5)" :key="amenity">
                                        <div class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded" x-text="amenity"></div>
                                    </template>
                                    <div x-show="room.amenities.length > 5" class="text-xs text-gray-500">
                                        <span x-text="'+' + (room.amenities.length - 5) + ' more'"></span>
                                    </div>
                                </div>
                                <span x-show="!room.amenities || room.amenities.length === 0" class="text-gray-500">None listed</span>
                            </td>
                        </template>
                    </tr>

                    <!-- Rate Plans -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rate options
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div x-show="room.rate_plans && room.rate_plans.length > 0" class="space-y-1">
                                    <template x-for="plan in room.rate_plans" :key="plan.name">
                                        <div class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">
                                            <span x-text="plan.name"></span>
                                            <span x-show="plan.discount > 0" x-text="'(' + plan.discount + '% off)'"></span>
                                        </div>
                                    </template>
                                </div>
                                <span x-show="!room.rate_plans || room.rate_plans.length === 0" class="text-gray-500">Standard only</span>
                            </td>
                        </template>
                    </tr>

                    <!-- Action Buttons -->
                    <tr class="bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Action
                        </td>
                        <template x-for="room in selectedRooms" :key="room.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button @click="selectRoomForBooking(room)"
                                        class="bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white px-4 py-2 rounded text-sm font-medium transition-colors">
                                    Select This Room
                                </button>
                            </td>
                        </template>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function roomComparison() {
    return {
        availableRooms: [],
        selectedRooms: [],
        showComparison: false,

        init() {
            // Listen for room data updates
            this.$watch('availableRooms', () => {
                // Reset selection if rooms change
                this.selectedRooms = [];
                this.showComparison = false;
            });
        },

        toggleRoomSelection(room) {
            const index = this.selectedRooms.findIndex(r => r.id === room.id);
            if (index > -1) {
                this.selectedRooms.splice(index, 1);
            } else {
                if (this.selectedRooms.length < 4) { // Limit to 4 rooms for comparison
                    this.selectedRooms.push(room);
                }
            }

            if (this.selectedRooms.length < 2) {
                this.showComparison = false;
            }
        },

        isRoomSelected(roomId) {
            return this.selectedRooms.some(room => room.id === roomId);
        },

        selectRoomForBooking(room) {
            // Dispatch event to parent component
            this.$dispatch('room-selected-for-booking', { room: room });
            this.showComparison = false;
        },

        formatPrice(price) {
            return new Intl.NumberFormat().format(price);
        },

        updateAvailableRooms(rooms) {
            this.availableRooms = rooms;
        }
    }
}
</script>