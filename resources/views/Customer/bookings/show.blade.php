@extends('frontend.master')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-[#3CC0E9] text-white p-6">
                <h1 class="text-2xl font-bold">Complete Your Booking</h1>
                <p class="text-blue-100">{{ $property->title }}</p>
            </div>

            <div class="p-6">
                {{--
                    Pass all PHP variables to JavaScript via data attributes on the form.
                    This prevents syntax errors when mixing Blade and JavaScript.
                --}}
                <form action="{{ route('customer.bookings.store', $property) }}" method="POST" class="space-y-6" id="bookingForm"
                    data-property-id="{{ $property->id }}"
                    data-base-price="{{ $property->pricing->base_price ?? 5000 }}"
                    data-price-per-night="{{ $property->pricing->price_per_night ?? 5000 }}"
                    data-adult-price="{{ $property->adult_price ?? 0 }}"
                    data-child-price="{{ $property->child_price ?? 0 }}"
                    data-commission-rate="{{ $property->commission_rate ?? 10 }}"
                    data-base-currency="{{ $property->pricing->currency ?? 'USD' }}"
                    data-user-currency="{{ app(\App\Services\CurrencyManager::class)->getUserCurrency() }}"
                    data-has-rooms="{{ $property->rooms->count() > 0 ? 'true' : 'false' }}"
                    data-selected-deal="{{ json_encode($selectedDeal) }}"
                    data-additional-guests="{{ $property->additionalDetails->guests ?? 8 }}">
                    @csrf
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    @if($selectedDeal)
                    <input type="hidden" name="deal_id" value="{{ $selectedDeal->id }}">
                    @endif

                    <!-- Dates Selection -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Check-in Date</label>
                            <input type="text" name="check_in" id="checkInInput" required placeholder="Select Check-in Date"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Check-out Date</label>
                            <input type="text" name="check_out" id="checkOutInput" required placeholder="Select Check-out Date"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9] bg-white">
                        </div>
                    </div>

                    <!-- Room Selection -->
                    @if($property->rooms->count() > 0)
                    <div id="roomSelectionSection" style="display: none;">
                        <label class="block text-sm font-medium mb-2">Select Room</label>
                        <div id="noRoomsMessage" class="text-red-600 text-sm mb-2" style="display: none;">
                            No rooms available for selected dates
                        </div>
                        <select name="room_id" id="roomSelect" required
                            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]">
                            <option value="">Select a room</option>
                        </select>
                    </div>
                    @endif

                    <!-- Guests -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Adults</label>
                            <input type="number" name="adults" id="adultsInput" value="1" min="1" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Children</label>
                            <input type="number" name="children" id="childrenInput" value="0" min="0" required
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#3CC0E9]">
                        </div>
                    </div>

                    <!-- Total Guests Display -->
                    <div class="mt-2 text-sm text-gray-600 font-medium" id="guestLimitMessage">
                        Total Guests: <span id="totalGuestsDisplay">1</span> / <span id="maxGuestsDisplay">8</span>
                    </div>

                    @if($selectedDeal)
                    <!-- Deal Information -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="font-semibold text-green-800 mb-2">🎉 Special Deal Applied</h3>
                        <div class="space-y-1 text-sm text-green-700">
                            <div><strong>{{ $selectedDeal->title }}</strong></div>
                            <div>{{ $selectedDeal->description }}</div>
                            <div class="font-semibold">{{ $selectedDeal->discount_display }}</div>
                            @if($selectedDeal->applicable_to === 'room' && $selectedDeal->room)
                            <div class="text-xs">Valid for: {{ $selectedDeal->room->name }}</div>
                            @endif
                            @if($selectedDeal->dealDates->count() > 0)
                            <div class="text-xs">Available dates: {{ $selectedDeal->dealDates->pluck('available_date')->map(fn($d) => $d->format('M d'))->join(', ') }}</div>
                            @endif
                        </div>
                    </div>
                    @endif

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
                                <span id="pricePerNightDisplay">
                                    <x-price :amount="$property->pricing->price_per_night ?? ($property->pricing->base_price ?? 0)" :currency="$property->pricing->currency ?? 'USD'" />
                                </span>
                            </div>
                            <div class="flex justify-between" id="nightsRow" style="display: none;">
                                <span>Nights:</span>
                                <span id="nightsDisplay">0</span>
                            </div>
                            @if($selectedDeal)
                            <div class="flex justify-between text-green-600" id="originalPriceRow" style="display: none;">
                                <span>Original Price:</span>
                                <span id="originalPriceDisplay"></span>
                            </div>
                            <div class="flex justify-between text-green-600" id="discountRow" style="display: none;">
                                <span>Discount:</span>
                                <span id="discountDisplay"></span>
                            </div>
                            @endif
                            <div class="flex justify-between font-semibold border-t pt-2" id="totalRow" style="display: none;">
                                <span>Total:</span>
                                <span id="totalDisplay">Calculating...</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-2" id="selectedRoomDetails" style="display: none;"></div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" disabled
                        class="w-full bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white font-semibold py-3 rounded-lg transition duration-200 opacity-50 cursor-not-allowed">
                        <span id="submitBtnText">Select Dates to Continue</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        class BookingManager {
            constructor() {
                // Elements
                this.form = document.getElementById('bookingForm');
                this.checkInInput = document.getElementById('checkInInput');
                this.checkOutInput = document.getElementById('checkOutInput');
                this.adultsInput = document.getElementById('adultsInput');
                this.childrenInput = document.getElementById('childrenInput');
                this.roomSelect = document.getElementById('roomSelect');
                this.submitBtn = document.getElementById('submitBtn');
                this.submitBtnText = document.getElementById('submitBtnText');

                // Sections
                this.roomSelectionSection = document.getElementById('roomSelectionSection');
                this.noRoomsMessage = document.getElementById('noRoomsMessage');

                // Display Elements
                this.pricePerNightDisplay = document.getElementById('pricePerNightDisplay');
                this.nightsRow = document.getElementById('nightsRow');
                this.nightsDisplay = document.getElementById('nightsDisplay');
                this.totalRow = document.getElementById('totalRow');
                this.totalDisplay = document.getElementById('totalDisplay');
                this.originalPriceRow = document.getElementById('originalPriceRow');
                this.originalPriceDisplay = document.getElementById('originalPriceDisplay');
                this.discountRow = document.getElementById('discountRow');
                this.discountDisplay = document.getElementById('discountDisplay');
                this.selectedRoomDetails = document.getElementById('selectedRoomDetails');

                // Guest Display Elements
                this.totalGuestsDisplay = document.getElementById('totalGuestsDisplay');
                this.maxGuestsDisplay = document.getElementById('maxGuestsDisplay');

                // Data from Data Attributes
                const dataset = this.form.dataset;
                this.propertyId = dataset.propertyId;
                this.basePrice = parseFloat(dataset.basePrice);
                this.pricePerNight = parseFloat(dataset.pricePerNight);
                this.adultPrice = parseFloat(dataset.adultPrice);
                this.childPrice = parseFloat(dataset.childPrice);
                this.commissionRate = parseFloat(dataset.commissionRate);
                this.baseCurrency = dataset.baseCurrency;
                this.userCurrency = dataset.userCurrency;
                this.hasRooms = dataset.hasRooms === 'true';
                this.selectedDeal = dataset.selectedDeal ? JSON.parse(dataset.selectedDeal) : null;
                this.additionalGuests = parseInt(dataset.additionalGuests) || 8;

                this.availableRooms = [];
                this.bookedDates = [];

                this.init();
            }

            async init() {
                await this.loadBookedDates();
                this.setupFlatpickr();
                this.attachEventListeners();
                this.updateUI(); // Initial UI update to set max guests
            }

            async loadBookedDates() {
                try {
                    const response = await fetch(`/customer/properties/${this.propertyId}/booked-dates`);
                    if (response.ok) {
                        this.bookedDates = await response.json();
                    }
                } catch (error) {
                    console.error('Failed to load booked dates', error);
                }
            }

            setupFlatpickr() {
                const today = new Date();
                const config = {
                    minDate: "today",
                    dateFormat: "Y-m-d",
                    disable: this.bookedDates,
                    onChange: (selectedDates, dateStr, instance) => {
                        if (instance.element === this.checkInInput) {
                            this.checkOutPicker.set('minDate', dateStr);
                            this.checkOutInput.value = '';
                            this.updateUI();
                        } else {
                            // Validate date range availability
                            if (this.checkInInput.value && dateStr) {
                                if (!this.isDateRangeAvailable(this.checkInInput.value, dateStr)) {
                                    alert("Selected range includes already booked dates. Please choose a different range.");
                                    this.checkOutInput.value = '';
                                    instance.clear();
                                    return;
                                }
                            }
                            this.updateUI();
                            this.loadAvailableRooms();
                        }
                    }
                };

                this.checkInPicker = flatpickr(this.checkInInput, config);
                this.checkOutPicker = flatpickr(this.checkOutInput, {
                    ...config,
                    minDate: "today"
                });
            }

            attachEventListeners() {
                this.adultsInput.addEventListener('input', () => this.updateUI());
                this.childrenInput.addEventListener('input', () => this.updateUI());
                if (this.roomSelect) {
                    this.roomSelect.addEventListener('change', () => this.updateUI());
                }
            }

            async loadAvailableRooms() {
                if (!this.hasRooms || !this.checkInInput.value || !this.checkOutInput.value) return;

                try {
                    const response = await fetch(`/customer/properties/${this.propertyId}/available-rooms?check_in=${this.checkInInput.value}&check_out=${this.checkOutInput.value}`);
                    if (response.ok) {
                        this.availableRooms = await response.json();
                        this.renderRoomOptions();
                    }
                } catch (error) {
                    console.error('Failed to load rooms', error);
                }
            }

            renderRoomOptions() {
                this.roomSelect.innerHTML = '<option value="">Select a room</option>';

                if (this.availableRooms.length === 0) {
                    this.noRoomsMessage.style.display = 'block';
                    this.roomSelect.disabled = true;
                } else {
                    this.noRoomsMessage.style.display = 'none';
                    this.roomSelect.disabled = false;
                    this.availableRooms.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.id;
                        option.textContent = `${room.name} - ${room.price_per_night} ${room.currency}/night (Max ${room.max_guests})`;
                        this.roomSelect.appendChild(option);
                    });
                }
                this.roomSelectionSection.style.display = 'block';
            }

            async updateUI() {
                const checkIn = this.checkInInput.value;
                const checkOut = this.checkOutInput.value;
                let adults = parseInt(this.adultsInput.value) || 0;
                let children = parseInt(this.childrenInput.value) || 0;
                const roomId = this.roomSelect ? this.roomSelect.value : null;

                // Validate Guests and Update Limits
                this.updateGuestLimits(adults, children, roomId);

                // Re-read values in case they were clamped
                adults = parseInt(this.adultsInput.value) || 0;
                children = parseInt(this.childrenInput.value) || 0;

                // Calculate Nights
                let nights = 0;
                if (checkIn && checkOut) {
                    const start = new Date(checkIn);
                    const end = new Date(checkOut);
                    nights = Math.ceil(Math.abs(end - start) / (1000 * 60 * 60 * 24));
                    this.nightsDisplay.textContent = nights;
                    this.nightsRow.style.display = 'flex';
                } else {
                    this.nightsRow.style.display = 'none';
                }

                // Calculate Total
                if (nights > 0) {
                    this.totalRow.style.display = 'flex';
                    await this.calculateAndDisplayTotal(nights, roomId, adults, children);
                } else {
                    this.totalRow.style.display = 'none';
                    if (this.originalPriceRow) this.originalPriceRow.style.display = 'none';
                    if (this.discountRow) this.discountRow.style.display = 'none';
                }

                // Update Submit Button
                this.updateSubmitButton(checkIn, checkOut, roomId);
            }

            updateGuestLimits(adults, children, roomId) {
                let maxGuests = 20;
                if (roomId) {
                    const room = this.availableRooms.find(r => r.id == roomId);
                    if (room) maxGuests = room.max_guests;
                } else {
                    maxGuests = this.additionalGuests;
                }

                // Update Display
                if (this.totalGuestsDisplay) this.totalGuestsDisplay.textContent = adults + children;
                if (this.maxGuestsDisplay) this.maxGuestsDisplay.textContent = maxGuests;

                // Enforce Limits
                if (adults + children > maxGuests) {
                    if (children > 0) {
                        children = Math.max(0, maxGuests - adults);
                        this.childrenInput.value = children;
                    }
                    if (adults + children > maxGuests) {
                        adults = maxGuests;
                        children = 0;
                        this.adultsInput.value = adults;
                        this.childrenInput.value = children;
                    }
                    if (this.totalGuestsDisplay) this.totalGuestsDisplay.textContent = adults + children;
                }

                // Set dynamic max attributes
                this.adultsInput.max = maxGuests - children;
                this.childrenInput.max = maxGuests - adults;
            }

            isDateRangeAvailable(start, end) {
                if (!start || !end || this.bookedDates.length === 0) return true;

                const startDate = new Date(start);
                const endDate = new Date(end);

                for (const bookedDateStr of this.bookedDates) {
                    const bookedDate = new Date(bookedDateStr);
                    // Check if bookedDate is between start (inclusive) and end (exclusive)
                    if (bookedDate >= startDate && bookedDate < endDate) {
                        return false;
                    }
                }
                return true;
            }

            async calculateAndDisplayTotal(nights, roomId, adults, children) {
                let total = 0;
                let currency = this.baseCurrency;

                if (roomId) {
                    const room = this.availableRooms.find(r => r.id == roomId);
                    if (room) {
                        total = room.price_per_night * nights;
                        currency = room.currency;
                        this.selectedRoomDetails.textContent = `${room.name} - Max ${room.max_guests} guests`;
                        this.selectedRoomDetails.style.display = 'block';
                    }
                } else {
                    const adultPriceWithComm = this.adultPrice * (1 + this.commissionRate / 100);
                    const childPriceWithComm = this.childPrice * (1 + this.commissionRate / 100);
                    let dailyTotal = (adults * adultPriceWithComm) + (children * childPriceWithComm);
                    if (dailyTotal <= 0) dailyTotal = this.pricePerNight;
                    total = dailyTotal * nights;
                    this.selectedRoomDetails.style.display = 'none';
                }

                // Apply Deal
                let discount = 0;
                if (this.selectedDeal) {
                    if (this.selectedDeal.deal_type === 'percentage') {
                        discount = total * (this.selectedDeal.discount_percentage / 100);
                    } else if (this.selectedDeal.deal_type === 'fixed') {
                        discount = this.selectedDeal.fixed_discount_amount * nights;
                    }

                    this.originalPriceDisplay.textContent = await this.formatPrice(total, currency);
                    this.discountDisplay.textContent = await this.formatPrice(discount, currency);
                    this.originalPriceRow.style.display = 'flex';
                    this.discountRow.style.display = 'flex';

                    total = Math.max(0, total - discount);
                }

                this.totalDisplay.textContent = await this.formatPrice(total, currency);
            }

            async formatPrice(amount, currency) {
                try {
                    const response = await fetch('/api/convert-price', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            amount,
                            from: currency,
                            to: this.userCurrency
                        })
                    });
                    const data = await response.json();
                    return data.formattedPrice;
                } catch (e) {
                    return `${currency} ${amount.toFixed(2)}`;
                }
            }

            updateSubmitButton(checkIn, checkOut, roomId) {
                let isValid = checkIn && checkOut;
                if (this.hasRooms && !roomId) isValid = false;

                this.submitBtn.disabled = !isValid;
                if (isValid) {
                    this.submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    this.submitBtnText.textContent = 'Confirm Booking';
                } else {
                    this.submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    if (!checkIn || !checkOut) {
                        this.submitBtnText.textContent = 'Select Dates to Continue';
                    } else if (this.hasRooms && !roomId) {
                        this.submitBtnText.textContent = 'Select a Room to Continue';
                    }
                }
            }
        }

        new BookingManager();
    });
</script>
@endsection