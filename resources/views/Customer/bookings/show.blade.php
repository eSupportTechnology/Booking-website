@extends('frontend.master')

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

                    <!-- Room Selection (for hotels and accommodations with rooms) -->
                    @if($property->rooms->count() > 0)
                    <div x-show="checkIn && checkOut">
                        <label class="block text-sm font-medium mb-2">Select Room</label>
                        <div x-show="availableRooms.length === 0 && roomsLoaded" class="text-red-600 text-sm mb-2">
                            No rooms available for selected dates
                        </div>
                        <select name="room_id" x-model="selectedRoom" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]"
                                x-bind:disabled="availableRooms.length === 0">
                            <option value="">Select a room</option>
                            <template x-for="room in availableRooms" :key="room.id">
                                <option :value="room.id" x-text="`${room.name} - ${formatPrice(room.price_per_night, room.currency)}/night (Max ${room.max_guests} guests)`"></option>
                            </template>
                        </select>
                    </div>
                    @endif

                    <!-- Guests -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Number of Guests</label>
                        <select name="guest_count" x-model="guests" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]">
                            <template x-for="i in getMaxGuests()" :key="i">
                                <option :value="i" x-text="i + (i > 1 ? ' guests' : ' guest')"></option>
                            </template>
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
                                <span x-show="!selectedRoom">
                                    <template x-if="formattedBasePrice">
                                        <span x-text="formattedBasePrice"></span>
                                    </template>
                                    <template x-if="!formattedBasePrice">
                                        <x-price :amount="$property->pricing->price_per_night ?? ($property->pricing->base_price ?? 0)" :currency="$property->pricing->currency ?? 'USD'" />
                                    </template>
                                </span>
                                <span x-show="selectedRoom">
                                    <template x-if="formattedRoomPrice">
                                        <span x-text="formattedRoomPrice"></span>
                                    </template>
                                    <template x-if="!formattedRoomPrice">
                                        <span>Loading...</span>
                                    </template>
                                </span>
                            </div>
                            <div class="flex justify-between" x-show="checkIn && checkOut">
                                <span>Nights:</span>
                                <span x-text="calculateNights()"></span>
                            </div>
                            <div class="flex justify-between font-semibold border-t pt-2" x-show="checkIn && checkOut">
                                <span>Total:</span>
                                <span>
                                    <template x-if="formattedTotal">
                                        <span x-text="formattedTotal"></span>
                                    </template>
                                    <template x-if="!formattedTotal">
                                        <span>Calculating...</span>
                                    </template>
                                </span>
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
        userCurrency: '{{ app(\App\Services\CurrencyManager::class)->getUserCurrency() }}',
    // The property's base currency (used when no room selected)
    baseCurrency: '{{ $property->pricing->currency ?? 'USD' }}',

    // Formatted strings shown in the booking summary (in user's currency)
    formattedBasePrice: null,
    formattedRoomPrice: null,
    formattedTotal: null,

        async formatPrice(amount, currency) {
            try {
                const response = await fetch('/api/convert-price', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        amount: amount,
                        from: currency,
                        to: this.userCurrency
                    })
                });
                const data = await response.json();
                return data.formattedPrice;
            } catch (error) {
                console.error('Price conversion failed:', error);
                const symbols = { USD: '$', EUR: '€', GBP: '£', LKR: 'Rs' };
                const symbol = symbols[currency] || currency;
                return symbol + amount.toLocaleString();
            }
        },

        getSelectedRoomCurrency() {
            if (!this.selectedRoom) return this.userCurrency;
            const room = this.availableRooms.find(r => r.id == this.selectedRoom);
            return room?.currency || this.userCurrency;
        },


        async init() {
            await this.loadBookedDates();
            this.setupDateRestrictions();
            this.setupRoomLoading();
            // initial formatted prices
            this.updateFormattedPrices();
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

        // Update formatted price strings (converts to this.userCurrency)
        async updateFormattedPrices() {
            // Reset while loading
            this.formattedBasePrice = null;
            this.formattedRoomPrice = null;
            this.formattedTotal = null;

            try {
                // Base price (when no room selected)
                if (!this.selectedRoom) {
                    const amount = this.pricePerNight;
                    this.formattedBasePrice = await this.formatPrice(amount, this.baseCurrency);
                }

                // Room price (when room selected)
                if (this.selectedRoom) {
                    const roomAmount = this.getRoomPrice();
                    const roomCurrency = this.getSelectedRoomCurrency() || this.baseCurrency;
                    this.formattedRoomPrice = await this.formatPrice(roomAmount, roomCurrency);
                }

                // Total (nights * price)
                const nights = this.calculateNights();
                if (nights > 0) {
                    const totalAmount = this.calculateTotal();
                    const totalCurrency = this.selectedRoom ? (this.getSelectedRoomCurrency() || this.baseCurrency) : this.baseCurrency;
                    this.formattedTotal = await this.formatPrice(totalAmount, totalCurrency);
                }
            } catch (e) {
                console.error('Failed to update formatted prices', e);
            }
        },

        getMaxGuests() {
            if (this.selectedRoom) {
                const room = this.availableRooms.find(r => r.id == this.selectedRoom);
                const maxGuests = room?.max_guests || 8;
                return Array.from({length: maxGuests}, (_, i) => i + 1);
            }
            @if($property->additionalDetails && $property->additionalDetails->guests)
                return Array.from({length: {{ $property->additionalDetails->guests }}}, (_, i) => i + 1);
            @else
                return Array.from({length: 8}, (_, i) => i + 1);
            @endif
        },

        // Ensure the selected guests value never exceeds the currently allowed max
        clampGuests() {
            const options = this.getMaxGuests();
            const max = (options && options.length) ? options[options.length - 1] : 8;
            if (!this.guests || this.guests < 1) this.guests = 1;
            if (this.guests > max) this.guests = max;
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
                // Clamp guests to the new maximum after rooms are loaded/updated
                this.clampGuests();
                // Update formatted prices since room availability/selection may change pricing
                this.updateFormattedPrices();
            } catch (error) {
                console.error('Failed to load available rooms:', error);
                this.availableRooms = [];
                this.roomsLoaded = true;
                this.clampGuests();
                this.updateFormattedPrices();
            }
        },

        setupRoomLoading() {
            this.$watch('checkIn', () => {
                this.selectedRoom = '';
                this.roomsLoaded = false;
                this.loadAvailableRooms();
                // Update formatted prices when dates change (may affect total)
                this.updateFormattedPrices();
            });

            this.$watch('checkOut', () => {
                this.selectedRoom = '';
                this.roomsLoaded = false;
                this.loadAvailableRooms();
                // Update formatted prices when dates change (may affect total)
                this.updateFormattedPrices();
            });

            // When the selected room changes, ensure guest count does not exceed that room's max
            this.$watch('selectedRoom', () => {
                this.clampGuests();
                this.updateFormattedPrices();
            });
        }
    }
}
</script>
@endsection
