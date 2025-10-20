<div class="p-4 sm:p-6 md:p-8">
    <div class="mb-6 md:mb-8">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Room Configuration</h3>
        <p class="text-gray-600 text-sm sm:text-base">Configure sleeping arrangements and room details</p>
    </div>

    <form id="rooms-form" action="{{ route('partner.homes.update.rooms', $property) }}" method="POST" class="space-y-6 md:space-y-8">
        @csrf

        <!-- What can guests use -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-4 sm:p-6 md:p-6 border border-purple-100 mb-6">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="bg-purple-100 p-2 sm:p-3 rounded-xl mr-3 sm:mr-4 flex-shrink-0">
                    <i class="fas fa-home text-purple-600 text-lg sm:text-xl"></i>
                </div>
                <div>
                    <h4 class="text-sm sm:text-lg font-bold text-gray-900">What can guests use at your place?</h4>
                    <p class="text-gray-600 text-xs sm:text-sm">Select areas guests have access to</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 md:gap-3">
                @foreach(['entire_place' => 'Entire place', 'private_room' => 'Private room', 'shared_room' => 'Shared room', 'common_areas' => 'Common areas'] as $access => $label)
                    <label class="access-item flex items-center p-2 sm:p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 cursor-pointer transition-all duration-200" data-access="{{ $access }}">
                        <input type="checkbox" name="guest_access[]" value="{{ $access }}" class="hidden">
                        <span class="font-medium text-xs sm:text-sm">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Sleeping Arrangements -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-4 sm:p-6 md:p-6 border border-blue-100">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="bg-blue-100 p-2 sm:p-3 rounded-xl mr-3 sm:mr-4 flex-shrink-0">
                    <i class="fas fa-bed text-blue-600 text-lg sm:text-xl"></i>
                </div>
                <div>
                    <h4 class="text-sm sm:text-lg font-bold text-gray-900">Where can people sleep?</h4>
                    <p class="text-gray-600 text-xs sm:text-sm">Configure bedrooms and sleeping areas</p>
                </div>
            </div>

            <div class="space-y-3 sm:space-y-4">
                <!-- Default bedroom types -->
                @php
                    $defaultRooms = ['Bedroom', 'Living Room', 'Other Spaces'];
                    $existingRooms = [];
                    
                    // Collect existing room names
                    if(isset($rooms) && $rooms->count() > 0) {
                        foreach($rooms as $roomGroup) {
                            foreach($roomGroup as $room) {
                                $existingRooms[] = $room->name ?: ($room->roomType->name ?? 'Room');
                            }
                        }
                    }
                    if(isset($property->bedrooms) && $property->bedrooms->count() > 0) {
                        foreach($property->bedrooms as $bedroom) {
                            $existingRooms[] = $bedroom->name;
                        }
                    }
                @endphp

                @foreach($defaultRooms as $roomName)
                    <div class="bg-white rounded-xl border-2 border-gray-200 p-3 sm:p-4">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-3">
                            <h5 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $roomName }}</h5>
                            <div class="flex space-x-2 mt-2 sm:mt-0">
                                <button type="button" class="text-blue-600 hover:text-blue-800 font-medium text-xs sm:text-sm">Edit</button>
                                <button type="button" class="text-red-600 hover:text-red-800 font-medium text-xs sm:text-sm">Delete</button>
                            </div>
                        </div>
                        <div class="text-xs sm:text-sm text-gray-600">
                            <strong>Beds:</strong> No beds selected
                        </div>
                    </div>
                @endforeach

                <!-- Existing configured rooms -->
                @if(isset($rooms) && $rooms->count() > 0)
                    @foreach($rooms as $roomTypeId => $roomGroup)
                        @foreach($roomGroup as $room)
                            @php
                                $roomDisplayName = $room->name ?: ($room->roomType->name ?? 'Room');
                            @endphp
                            @if(!in_array($roomDisplayName, $defaultRooms))
                                <div class="bg-white rounded-xl border-2 border-gray-200 p-3 sm:p-4">
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-3">
                                        <h5 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $roomDisplayName }}</h5>
                                        <div class="flex space-x-2 mt-2 sm:mt-0">
                                            <button type="button" class="text-blue-600 hover:text-blue-800 font-medium text-xs sm:text-sm">Edit</button>
                                            <button type="button" class="text-red-600 hover:text-red-800 font-medium text-xs sm:text-sm">Delete</button>
                                        </div>
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600 mb-2">
                                        <span class="inline-block bg-gray-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded mr-2 text-xs sm:text-sm">Max guests: {{ $room->max_guests ?? 'N/A' }}</span>
                                        @if($room->size_sq_m)
                                            <span class="inline-block bg-gray-100 px-1 sm:px-2 py-0.5 sm:py-1 rounded mr-2 text-xs sm:text-sm">{{ $room->size_sq_m }}m²</span>
                                        @endif
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-600">
                                        <strong>Beds:</strong>
                                        @if($room->beds && $room->beds->count() > 0)
                                            @foreach($room->beds as $bed)
                                                {{ $bed->count }}x {{ $bed->bedType->name ?? 'Bed' }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        @else
                                            No beds configured
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                @endif

                @if(isset($property->bedrooms) && $property->bedrooms->count() > 0)
                    @foreach($property->bedrooms as $bedroom)
                        @if(!in_array($bedroom->name, $defaultRooms))
                            <div class="bg-white rounded-xl border-2 border-gray-200 p-3 sm:p-4">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-3">
                                    <h5 class="font-semibold text-gray-900 text-sm sm:text-base">{{ $bedroom->name }}</h5>
                                    <div class="flex space-x-2 mt-2 sm:mt-0">
                                        <button type="button" class="text-blue-600 hover:text-blue-800 font-medium text-xs sm:text-sm">Edit</button>
                                        <button type="button" class="text-red-600 hover:text-red-800 font-medium text-xs sm:text-sm">Delete</button>
                                    </div>
                                </div>
                                <div class="text-xs sm:text-sm text-gray-600">
                                    <strong>Beds:</strong>
                                    @php
                                        $beds = [];
                                        if($bedroom->twin > 0) $beds[] = $bedroom->twin . 'x Twin';
                                        if($bedroom->full > 0) $beds[] = $bedroom->full . 'x Full';
                                        if($bedroom->queen > 0) $beds[] = $bedroom->queen . 'x Queen';
                                        if($bedroom->king > 0) $beds[] = $bedroom->king . 'x King';
                                        if($bedroom->bunk > 0) $beds[] = $bedroom->bunk . 'x Bunk';
                                        if($bedroom->sofa > 0) $beds[] = $bedroom->sofa . 'x Sofa';
                                        if($bedroom->futon > 0) $beds[] = $bedroom->futon . 'x Futon';
                                    @endphp
                                    {{ !empty($beds) ? implode(', ', $beds) : 'No beds selected' }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

                <button type="button" id="add-bedroom-btn" class="w-full bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-medium py-3 px-4 sm:px-6 rounded-xl transition-all duration-200 transform hover:scale-105 text-sm sm:text-base flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Add Bedroom
                </button>
            </div>
        </div>

        <!-- Guest Capacity (responsive tweaks) -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 sm:p-6 md:p-6 border border-green-100">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="bg-green-100 p-2 sm:p-3 rounded-xl mr-3 sm:mr-4 flex-shrink-0">
                    <i class="fas fa-users text-green-600 text-lg sm:text-xl"></i>
                </div>
                <div>
                    <h4 class="text-sm sm:text-lg font-bold text-gray-900">Guest Capacity</h4>
                    <p class="text-gray-600 text-xs sm:text-sm">Set maximum occupancy and policies</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                <!-- Guests input -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">How many guests can stay?</label>
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <button type="button" class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('guests', -1)">
                            <i class="fas fa-minus text-gray-600 text-xs sm:text-sm"></i>
                        </button>
                        <input type="number" name="guests" id="guests" value="{{ $property->additionalDetails?->guests ?? 1 }}" min="1" class="w-16 sm:w-20 text-center px-2 sm:px-3 py-1 sm:py-2 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 text-xs sm:text-sm">
                        <button type="button" class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('guests', 1)">
                            <i class="fas fa-plus text-gray-600 text-xs sm:text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Bathrooms input -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">How many bathrooms are there?</label>
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <button type="button" class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('bathrooms', -1)">
                            <i class="fas fa-minus text-gray-600 text-xs sm:text-sm"></i>
                        </button>
                        <input type="number" name="bathrooms" id="bathrooms" value="{{ $property->additionalDetails?->bathrooms ?? 1 }}" min="1" class="w-16 sm:w-20 text-center px-2 sm:px-3 py-1 sm:py-2 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 text-xs sm:text-sm">
                        <button type="button" class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('bathrooms', 1)">
                            <i class="fas fa-plus text-gray-600 text-xs sm:text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Children & Cribs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6 mt-4 sm:mt-6">
                <!-- Children -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Do you allow children?</label>
                    <div class="flex space-x-2 sm:space-x-4">
                        <label class="radio-item flex items-center p-2 sm:p-3 bg-white rounded-xl border-2 {{ ($property->additionalDetails?->allow_children ?? '') == 'yes' ? 'border-green-500 bg-green-50' : 'border-gray-200' }} hover:border-green-300 cursor-pointer transition-all duration-200" data-value="yes">
                            <input type="radio" name="allow_children" value="yes" {{ ($property->additionalDetails?->allow_children ?? '') == 'yes' ? 'checked' : '' }} class="hidden">
                            <span class="font-medium {{ ($property->additionalDetails?->allow_children ?? '') == 'yes' ? 'text-green-700' : 'text-gray-700' }} text-xs sm:text-sm">Yes</span>
                        </label>
                        <label class="radio-item flex items-center p-2 sm:p-3 bg-white rounded-xl border-2 {{ ($property->additionalDetails?->allow_children ?? '') == 'no' ? 'border-green-500 bg-green-50' : 'border-gray-200' }} hover:border-green-300 cursor-pointer transition-all duration-200" data-value="no">
                            <input type="radio" name="allow_children" value="no" {{ ($property->additionalDetails?->allow_children ?? '') == 'no' ? 'checked' : '' }} class="hidden">
                            <span class="font-medium {{ ($property->additionalDetails?->allow_children ?? '') == 'no' ? 'text-green-700' : 'text-gray-700' }} text-xs sm:text-sm">No</span>
                        </label>
                    </div>
                </div>

                <!-- Cribs -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Do you offer cribs?</label>
                    <div class="flex space-x-2 sm:space-x-4">
                        <label class="radio-item flex items-center p-2 sm:p-3 bg-white rounded-xl border-2 {{ ($property->additionalDetails?->offer_cribs ?? '') == 'yes' ? 'border-green-500 bg-green-50' : 'border-gray-200' }} hover:border-green-300 cursor-pointer transition-all duration-200" data-value="yes">
                            <input type="radio" name="offer_cribs" value="yes" {{ ($property->additionalDetails?->offer_cribs ?? '') == 'yes' ? 'checked' : '' }} class="hidden">
                            <span class="font-medium {{ ($property->additionalDetails?->offer_cribs ?? '') == 'yes' ? 'text-green-700' : 'text-gray-700' }} text-xs sm:text-sm">Yes</span>
                        </label>
                        <label class="radio-item flex items-center p-2 sm:p-3 bg-white rounded-xl border-2 {{ ($property->additionalDetails?->offer_cribs ?? '') == 'no' ? 'border-green-500 bg-green-50' : 'border-gray-200' }} hover:border-green-300 cursor-pointer transition-all duration-200" data-value="no">
                            <input type="radio" name="offer_cribs" value="no" {{ ($property->additionalDetails?->offer_cribs ?? '') == 'no' ? 'checked' : '' }} class="hidden">
                            <span class="font-medium {{ ($property->additionalDetails?->offer_cribs ?? '') == 'no' ? 'text-green-700' : 'text-gray-700' }} text-xs sm:text-sm">No</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Property Size -->
            <div class="mt-4 sm:mt-6">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Property Size (optional)</label>
                <div class="flex flex-col sm:flex-row items-center sm:space-x-4 space-y-2 sm:space-y-0">
                    <input type="number" name="apartment_size" value="{{ $property->additionalDetails?->apartment_size ?? '' }}" class="flex-1 px-3 sm:px-4 py-2 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 text-xs sm:text-sm" placeholder="Size">
                    <select name="apartment_unit" class="px-3 sm:px-4 py-2 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200 text-xs sm:text-sm w-full sm:w-auto">
                        <option value="square_meters" {{ ($property->additionalDetails?->apartment_unit ?? '') == 'square_meters' ? 'selected' : '' }}>Square meters</option>
                        <option value="square_feet" {{ ($property->additionalDetails?->apartment_unit ?? '') == 'square_feet' ? 'selected' : '' }}>Square feet</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end pt-4 sm:pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-6 sm:px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 flex items-center text-sm sm:text-base">
                <i class="fas fa-save mr-2"></i>
                Save Room Configuration
            </button>
        </div>
    </form>
</div>

<script>
function changeValue(fieldId, change) {
    const input = document.getElementById(fieldId);
    const currentValue = parseInt(input.value) || 1;
    const newValue = Math.max(1, currentValue + change);
    input.value = newValue;
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle checkbox and radio styling changes
    document.addEventListener('change', function(e) {
        const input = e.target;
        if (!input.matches('input[type="checkbox"], input[type="radio"]')) return;
        const label = input.closest('label');
        if (!label) return;

        if (input.type === 'checkbox' && label.classList.contains('access-item')) {
            const span = label.querySelector('span');
            if (input.checked) {
                label.classList.remove('border-gray-200');
                label.classList.add('border-purple-500', 'bg-purple-50');
                if (span) span.classList.add('text-purple-700');
            } else {
                label.classList.remove('border-purple-500', 'bg-purple-50');
                label.classList.add('border-gray-200');
                if (span) span.classList.remove('text-purple-700');
            }
        }

        if (input.type === 'radio' && label.classList.contains('radio-item')) {
            document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
                const radioLabel = radio.closest('label');
                const radioSpan = radioLabel?.querySelector('span');
                if (radioLabel) {
                    radioLabel.classList.remove('border-green-500', 'bg-green-50');
                    radioLabel.classList.add('border-gray-200');
                }
                if (radioSpan) {
                    radioSpan.classList.remove('text-green-700');
                    radioSpan.classList.add('text-gray-700');
                }
            });

            const span = label.querySelector('span');
            label.classList.remove('border-gray-200');
            label.classList.add('border-green-500', 'bg-green-50');
            if (span) {
                span.classList.remove('text-gray-700');
                span.classList.add('text-green-700');
            }
        }
    });

    // Initialize selected states
    document.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked').forEach(input => {
        input.dispatchEvent(new Event('change'));
    });

    // Add bedroom functionality
    const addBedroomBtn = document.getElementById('add-bedroom-btn');
    if (addBedroomBtn) {
        addBedroomBtn.addEventListener('click', function() {
            const roomName = prompt('Enter room name (e.g., "Bedroom 2", "Living Room"):');
            if (roomName && roomName.trim() !== '') {
                const sanitizedName = roomName.replace(/[<>]/g, '');
                const roomsContainer = addBedroomBtn.parentElement;
                const newRoom = document.createElement('div');
                newRoom.className = 'bg-white rounded-xl border-2 border-gray-200 p-3 sm:p-4';
                newRoom.innerHTML = `
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 sm:mb-3">
                        <h5 class="font-semibold text-gray-900 text-sm sm:text-base">${sanitizedName}</h5>
                        <div class="flex space-x-2 mt-2 sm:mt-0">
                            <button type="button" class="text-blue-600 hover:text-blue-800 font-medium text-xs sm:text-sm">Edit</button>
                            <button type="button" class="text-red-600 hover:text-red-800 font-medium text-xs sm:text-sm remove-room">Delete</button>
                        </div>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-600">
                        <strong>Beds:</strong> No beds configured
                    </div>
                    <input type="hidden" name="new_rooms[]" value="${sanitizedName}">
                `;
                roomsContainer.insertBefore(newRoom, addBedroomBtn);
            }
        });
    }

    // Remove room functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-room')) {
            e.target.closest('.bg-white').remove();
        }
    });
});
</script>
