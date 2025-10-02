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
                                <span>LKR {{ number_format($property->pricing->base_price ?? 5000) }}</span>
                            </div>
                            <div class="flex justify-between" x-show="checkIn && checkOut">
                                <span>Nights:</span>
                                <span x-text="calculateNights()"></span>
                            </div>
                            <div class="flex justify-between font-semibold border-t pt-2" x-show="checkIn && checkOut">
                                <span>Total:</span>
                                <span x-text="'LKR ' + calculateTotal().toLocaleString()"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-[#3CC0E9] hover:bg-[#2BA8D1] text-white font-semibold py-3 rounded-lg transition duration-200"
                            x-bind:disabled="!checkIn || !checkOut"
                            x-bind:class="{'opacity-50 cursor-not-allowed': !checkIn || !checkOut}">
                        <span x-show="checkIn && checkOut">Confirm Booking</span>
                        <span x-show="!checkIn || !checkOut">Select Dates to Continue</span>
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
        basePrice: {{ $property->pricing->base_price ?? 5000 }},
        bookedDates: [],
        
        async init() {
            await this.loadBookedDates();
            this.setupDateRestrictions();
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
            return this.calculateNights() * this.basePrice;
        }
    }
}
</script>
@endsection