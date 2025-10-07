@extends('Customer.master')

@section('content')
<div class="min-h-screen bg-gray-50 py-8" x-data="bookingForm()" x-init="init()">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-[#3CC0E9] text-white p-6">
                <h1 class="text-2xl font-bold">Complete Your Booking</h1>
                <p class="text-blue-100">{{ $property->title }}</p>
            </div>

            <div class="p-6">
                <form action="{{ route('customer.bookings.store', $property) }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">

                    <!-- Dates Selection -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Check-in Date</label>
                            <input type="date" name="check_in" x-model="checkIn" required
                                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Check-out Date</label>
                            <input type="date" name="check_out" x-model="checkOut" required
                                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]">
                        </div>
                    </div>

                    <!-- Enhanced Room Selection -->
                    @if($property->rooms->count() > 0)
                    <div x-show="checkIn && checkOut" class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800">Select Your Room</h3>

                        <!-- Include the room selection component -->
                        @include('Customer.components.room-selection', ['property' => $property])

                        <!-- Room Comparison Option -->
                        <div class="mt-6">
                            <button type="button" @click="showComparison = !showComparison"
                                    class="text-[#3CC0E9] hover:underline text-sm font-medium">
                                Compare Available Rooms
                            </button>
                        </div>

                        <!-- Room Comparison Component -->
                        <div x-show="showComparison" x-transition class="mt-4">
                            @include('Customer.components.room-comparison', ['property' => $property])
                        </div>
                    </div>
                    @endif

                    <!-- Guests -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Number of Guests</label>
                        <select name="guest_count" x-model="guests" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]">
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }} guest{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Booking Summary -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold mb-3">Booking Summary</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Property:</span>
                                <span>{{ $property->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Price per night:</span>
                                <span x-show="!selectedRoom">LKR {{ number_format($property->pricing->price_per_night ?? ($property->pricing->base_price ?? 0)) }}</span>
                                <span x-show="selectedRoom" x-text="'LKR ' + getRoomPrice().toLocaleString()"></span>
                            </div>
                            <div class="flex justify-between" x-show="checkIn && checkOut">
                                <span>Nights:</span>
                                <span x-text="calculateNights()"></span>
                            </div>
                            <div class="flex justify-between font-semibold border-t pt-2" x-show="checkIn && checkOut">
                                <span>Total:</span>
                                <span x-text="'LKR ' + calculateTotal().toLocaleString()"></span>
                            </div>
                            @if($property->rooms->count() > 0)
                            <div class="text-xs text-gray-500 mt-2" x-show="selectedRoom">
                                <span x-text="getSelectedRoomDetails()"></span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white font-semibold py-3 rounded-lg transition duration-200"
                            x-bind:disabled="!isFormValid()"
                            x-bind:class="{'opacity-50 cursor-not-allowed': !isFormValid()}">
                        <span x-show="isFormValid()">Confirm Booking</span>
                        <span x-show="!checkIn || !checkOut">Select Dates to Continue</span>
                        @if($property->rooms->count() > 0)
                        <span x-show="checkIn && checkOut && !selectedRoom">Select a Room to Continue</span>
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function bookingForm() {
    return {
        checkIn: '',
        checkOut: '',
        guests: 1,
        selectedRoom: '',
        basePrice: {{ $property->pricing->base_price ?? 5000 }},
        pricePerNight: {{ $property->pricing->price_per_night ?? 5000 }},
        bookedDates: [],
        availableRooms: [],
        roomsLoaded: false,
        hasRooms: {{ $property->rooms->count() > 0 ? 'true' : 'false' }},
        showComparison: false,

        async init() {
            await this.loadBookedDates();
            this.setupDateRestrictions();
            this.setupRoomLoading();
        },

        async loadBookedDates() {
            try {
                const response = await fetch(`/customer/properties/{{ $property->id }}/booked-dates`);
                this.bookedDates = await response.json();
            } catch (error) {
                console.error('Failed to load booked dates:', error);
            }
        },

        setupDateRestrictions() {
            const checkInInput = document.querySelector('input[name="check_in"]');
            const checkOutInput = document.querySelector('input[name="check_out"]');

            if (checkInInput && checkOutInput) {
                // Set minimum date to today
                const today = new Date().toISOString().split('T')[0];
                checkInInput.min = today;
                checkOutInput.min = today;

                // Add event listeners to validate dates
                checkInInput.addEventListener('change', () => {
                    if (this.bookedDates.includes(checkInInput.value)) {
                        alert('This date is already booked. Please select another date.');
                        checkInInput.value = '';
                        return;
                    }
                    checkOutInput.min = checkInInput.value;
                });

                checkOutInput.addEventListener('change', () => {
                    if (this.bookedDates.includes(checkOutInput.value)) {
                        alert('This date is already booked. Please select another date.');
                        checkOutInput.value = '';
                        return;
                    }

                    // Check if any dates in between are booked
                    if (this.checkIn && this.checkOut) {
                        const start = new Date(this.checkIn);
                        const end = new Date(this.checkOut);

                        for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                            const dateStr = d.toISOString().split('T')[0];
                            if (this.bookedDates.includes(dateStr)) {
                                alert('Some dates in your selected range are already booked. Please choose different dates.');
                                checkOutInput.value = '';
                                return;
                            }
                        }
                    }
                });
            }
        },

        calculateNights() {
            if (!this.checkIn || !this.checkOut) return 0;
            const start = new Date(this.checkIn);
            const end = new Date(this.checkOut);
            const diffTime = Math.abs(end - start);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        },

        calculateTotal() {
            const price = this.selectedRoom ? this.getRoomPrice() : this.pricePerNight;
            return this.calculateNights() * price;
        },

        getRoomPrice() {
            if (!this.selectedRoom) return this.pricePerNight;
            const room = this.availableRooms.find(r => r.id == this.selectedRoom);
            return room ? room.price_per_night : this.pricePerNight;
        },

        getSelectedRoomDetails() {
            if (!this.selectedRoom) return '';
            const room = this.availableRooms.find(r => r.id == this.selectedRoom);
            return room ? `${room.name} - Max ${room.max_guests} guests` : '';
        },

        isFormValid() {
            if (!this.checkIn || !this.checkOut) return false;
            if (this.hasRooms && !this.selectedRoom) return false;
            return true;
        },

        async loadAvailableRooms() {
            if (!this.checkIn || !this.checkOut || !this.hasRooms) return;

            try {
                const response = await fetch(`/customer/properties/{{ $property->id }}/available-rooms?check_in=${this.checkIn}&check_out=${this.checkOut}`);
                this.availableRooms = await response.json();
                this.roomsLoaded = true;

                // Reset selected room if it's no longer available
                if (this.selectedRoom && !this.availableRooms.find(r => r.id == this.selectedRoom)) {
                    this.selectedRoom = '';
                }
            } catch (error) {
                console.error('Failed to load available rooms:', error);
                this.availableRooms = [];
                this.roomsLoaded = true;
            }
        },

        setupRoomLoading() {
            this.$watch('checkIn', () => {
                this.selectedRoom = '';
                this.roomsLoaded = false;
                this.loadAvailableRooms();
                // Update room selection component
                if (window.roomSelectionComponent) {
                    window.roomSelectionComponent.updateDates(this.checkIn, this.checkOut);
                }
            });

            this.$watch('checkOut', () => {
                this.selectedRoom = '';
                this.roomsLoaded = false;
                this.loadAvailableRooms();
                // Update room selection component
                if (window.roomSelectionComponent) {
                    window.roomSelectionComponent.updateDates(this.checkIn, this.checkOut);
                }
            });

            // Listen for room selection events
            this.$el.addEventListener('room-selected', (event) => {
                this.selectedRoom = event.detail.room.id;
            });
        }
    }
}
</script>
@endsection
