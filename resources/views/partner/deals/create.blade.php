@extends('partner.master')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Deal</h1>

        <form action="{{ route('partner.deals.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deal Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" 
                           placeholder="e.g., Weekend Getaway Special" required>
                    @error('title')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" 
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" 
                              placeholder="Describe your deal...">{{ old('description') }}</textarea>
                    @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deal Type</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="deal_type" value="percentage" class="mr-2" {{ old('deal_type', 'percentage') == 'percentage' ? 'checked' : '' }}>
                            <span>Percentage Off</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="deal_type" value="fixed" class="mr-2" {{ old('deal_type') == 'fixed' ? 'checked' : '' }}>
                            <span>Fixed Amount</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="deal_type" value="special" class="mr-2" {{ old('deal_type') == 'special' ? 'checked' : '' }}>
                            <span>Special Offer</span>
                        </label>
                    </div>
                    @error('deal_type')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Apply To</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="applicable_to" value="property" class="mr-2" {{ old('applicable_to', 'property') == 'property' ? 'checked' : '' }}>
                            <span>Entire Property</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="applicable_to" value="room" class="mr-2" {{ old('applicable_to') == 'room' ? 'checked' : '' }}>
                            <span>Specific Room</span>
                        </label>
                    </div>
                    @error('applicable_to')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Property</label>
                    <select name="property_id" id="property_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        <option value="">Select Property</option>
                        @foreach($properties as $property)
                            <option value="{{ $property->id }}" 
                                    data-price="{{ $property->pricing->price_per_night ?? ($property->rooms->first()->price_per_night ?? 0) }}"
                                    {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                {{ $property->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('property_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div id="room_selection" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Room</label>
                    <select name="room_id" id="room_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                        <option value="">Select Room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-property="{{ $room->property_id }}" data-price="{{ $room->price_per_night }}"
                                    {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->property->title }} - {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Original Price ($)</label>
                    <input type="number" name="original_price" id="original_price" value="{{ old('original_price') }}" step="0.01" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                    @error('original_price')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div id="percentage_field">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Discount (%)</label>
                    <input type="number" name="discount_percentage" value="{{ old('discount_percentage') }}" min="1" max="90"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                    @error('discount_percentage')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div id="fixed_field" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fixed Discount Amount ($)</label>
                    <input type="number" name="fixed_discount_amount" value="{{ old('fixed_discount_amount') }}" step="0.01" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                    @error('fixed_discount_amount')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div id="special_field" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Special Offer Text</label>
                    <input type="text" name="special_offer_text" value="{{ old('special_offer_text') }}" 
                           placeholder="e.g., Stay 3 nights, pay for 2"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]">
                    @error('special_offer_text')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        @error('start_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1F8FB2]" required>
                        @error('end_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Specific Available Dates (Optional)</label>
                    <p class="text-sm text-gray-500 mb-2">Leave empty to allow all dates within the date range. Add specific dates for weekend-only or limited availability deals.</p>
                    <div id="date_picker_container">
                        <input type="date" id="date_picker" class="border border-gray-300 rounded px-3 py-2 mr-2">
                        <button type="button" onclick="addDate()" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">Add Date</button>
                    </div>
                    <div id="selected_dates" class="mt-2 flex flex-wrap gap-2"></div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('partner.deals.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#1F8FB2] text-white rounded-lg hover:bg-[#3CC0E9] transition">
                        Create Deal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
let selectedDates = [];

// Deal type toggle
document.querySelectorAll('input[name="deal_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('percentage_field').style.display = this.value === 'percentage' ? 'block' : 'none';
        document.getElementById('fixed_field').style.display = this.value === 'fixed' ? 'block' : 'none';
        document.getElementById('special_field').style.display = this.value === 'special' ? 'block' : 'none';
    });
});

// Applicable to toggle
document.querySelectorAll('input[name="applicable_to"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('room_selection').style.display = this.value === 'room' ? 'block' : 'none';
        filterRooms();
    });
});

// Property change handler
document.getElementById('property_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    if (price && price > 0) {
        document.getElementById('original_price').value = price;
    }
    filterRooms();
});

// Room change handler
document.getElementById('room_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    if (price && price > 0) {
        document.getElementById('original_price').value = price;
    }
});

function filterRooms() {
    const propertyId = document.getElementById('property_id').value;
    const roomSelect = document.getElementById('room_id');
    const options = roomSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else {
            option.style.display = option.getAttribute('data-property') === propertyId ? 'block' : 'none';
        }
    });
    roomSelect.value = '';
}

function addDate() {
    const datePicker = document.getElementById('date_picker');
    const date = datePicker.value;
    
    if (date && !selectedDates.includes(date)) {
        selectedDates.push(date);
        updateDateDisplay();
        datePicker.value = '';
    }
}

function removeDate(date) {
    selectedDates = selectedDates.filter(d => d !== date);
    updateDateDisplay();
}

function updateDateDisplay() {
    const container = document.getElementById('selected_dates');
    container.innerHTML = selectedDates.map(date => `
        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm flex items-center">
            ${date}
            <button type="button" onclick="removeDate('${date}')" class="ml-2 text-red-500 hover:text-red-700">×</button>
            <input type="hidden" name="available_dates[]" value="${date}">
        </span>
    `).join('');
}
</script>
@endsection