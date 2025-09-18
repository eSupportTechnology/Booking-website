<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Room Configuration</h3>
        <p class="text-gray-600">Configure sleeping arrangements and room details</p>
    </div>

    <form id="rooms-form" action="{{ route('partner.homes.update.rooms', $property) }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- What can guests use -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-purple-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-home text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">What can guests use at your place?</h4>
                    <p class="text-gray-600 text-sm">Select areas guests have access to</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['entire_place' => 'Entire place', 'private_room' => 'Private room', 'shared_room' => 'Shared room', 'common_areas' => 'Common areas'] as $access => $label)
                    <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 cursor-pointer transition-all duration-200">
                        <input type="checkbox" name="guest_access[]" value="{{ $access }}" class="hidden peer">
                        <div class="w-5 h-5 border-2 border-gray-300 rounded mr-3 flex items-center justify-center transition-all duration-200">
                            <i class="fas fa-check text-white text-xs opacity-0"></i>
                        </div>
                        <span class="font-medium text-sm">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Sleeping Arrangements -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-bed text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Where can people sleep?</h4>
                    <p class="text-gray-600 text-sm">Configure bedrooms and sleeping areas</p>
                </div>
            </div>

            <div class="space-y-4">
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
                    <div class="bg-white rounded-xl border-2 border-gray-200 p-4">
                        <div class="flex items-center justify-between mb-3">
                            <h5 class="font-semibold text-gray-900">{{ $roomName }}</h5>
                            <div class="flex space-x-2">
                                <button type="button" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                <button type="button" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <strong>Beds:</strong> No beds selected
                        </div>
                    </div>
                @endforeach
                
                <!-- Existing configured rooms -->
                @if(isset($rooms) && $rooms->count() > 0)
                    @foreach($rooms as $roomTypeId => $roomGroup)
                        @foreach($roomGroup as $room)
                            @if(!in_array($room->name ?: ($room->roomType->name ?? 'Room'), $defaultRooms))
                                <div class="bg-white rounded-xl border-2 border-gray-200 p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="font-semibold text-gray-900">{{ $room->name ?: ($room->roomType->name ?? 'Room') }}</h5>
                                        <div class="flex space-x-2">
                                            <button type="button" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                            <button type="button" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600 mb-2">
                                        <span class="inline-block bg-gray-100 px-2 py-1 rounded mr-2">Max guests: {{ $room->max_guests ?? 'N/A' }}</span>
                                        @if($room->size_sq_m)
                                            <span class="inline-block bg-gray-100 px-2 py-1 rounded mr-2">{{ $room->size_sq_m }}m²</span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-600">
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
                            <div class="bg-white rounded-xl border-2 border-gray-200 p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h5 class="font-semibold text-gray-900">{{ $bedroom->name }}</h5>
                                    <div class="flex space-x-2">
                                        <button type="button" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                                        <button type="button" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600">
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
                
                <button type="button" id="add-bedroom-btn" class="w-full bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-medium py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Add Bedroom
                </button>
            </div>
        </div>

        <!-- Guest Capacity -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-xl mr-4">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-gray-900">Guest Capacity</h4>
                    <p class="text-gray-600 text-sm">Set maximum occupancy and policies</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">How many guests can stay?</label>
                    <div class="flex items-center space-x-4">
                        <button type="button" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('guests', -1)">
                            <i class="fas fa-minus text-gray-600"></i>
                        </button>
                        <input type="number" name="guests" id="guests" value="{{ $property->additionalDetails->guests ?? 1 }}" min="1" class="w-20 text-center px-3 py-2 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200">
                        <button type="button" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('guests', 1)">
                            <i class="fas fa-plus text-gray-600"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">How many bathrooms are there?</label>
                    <div class="flex items-center space-x-4">
                        <button type="button" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('bathrooms', -1)">
                            <i class="fas fa-minus text-gray-600"></i>
                        </button>
                        <input type="number" name="bathrooms" id="bathrooms" value="{{ $property->additionalDetails->bathrooms ?? 1 }}" min="1" class="w-20 text-center px-3 py-2 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200">
                        <button type="button" class="w-10 h-10 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" onclick="changeValue('bathrooms', 1)">
                            <i class="fas fa-plus text-gray-600"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Do you allow children?</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-green-300 cursor-pointer transition-all duration-200">
                            <input type="radio" name="allow_children" value="yes" {{ $property->additionalDetails->allow_children == 'yes' ? 'checked' : '' }} class="hidden">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                <div class="w-2 h-2 bg-green-600 rounded-full opacity-0"></div>
                            </div>
                            <span class="font-medium">Yes</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-green-300 cursor-pointer transition-all duration-200">
                            <input type="radio" name="allow_children" value="no" {{ $property->additionalDetails->allow_children == 'no' ? 'checked' : '' }} class="hidden">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                <div class="w-2 h-2 bg-green-600 rounded-full opacity-0"></div>
                            </div>
                            <span class="font-medium">No</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Do you offer cribs?</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-green-300 cursor-pointer transition-all duration-200">
                            <input type="radio" name="offer_cribs" value="yes" {{ $property->additionalDetails->offer_cribs == 'yes' ? 'checked' : '' }} class="hidden">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                <div class="w-2 h-2 bg-green-600 rounded-full opacity-0"></div>
                            </div>
                            <span class="font-medium">Yes</span>
                        </label>
                        <label class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-green-300 cursor-pointer transition-all duration-200">
                            <input type="radio" name="offer_cribs" value="no" {{ $property->additionalDetails->offer_cribs == 'no' ? 'checked' : '' }} class="hidden">
                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full mr-3 flex items-center justify-center">
                                <div class="w-2 h-2 bg-green-600 rounded-full opacity-0"></div>
                            </div>
                            <span class="font-medium">No</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Property Size (optional)</label>
                <div class="flex items-center space-x-4">
                    <input type="number" name="apartment_size" value="{{ $property->additionalDetails->apartment_size }}" class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200" placeholder="Size">
                    <select name="apartment_unit" class="px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all duration-200">
                        <option value="square_meters" {{ $property->additionalDetails->apartment_unit == 'square_meters' ? 'selected' : '' }}>Square meters</option>
                        <option value="square_feet" {{ $property->additionalDetails->apartment_unit == 'square_feet' ? 'selected' : '' }}>Square feet</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
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

// Handle radio button selections
document.addEventListener('click', function(e) {
    const target = e.target.closest('label');
    if (!target) return;
    
    const input = target.querySelector('input[type="radio"]');
    if (!input) return;
    
    // Clear all radio buttons in the same group
    document.querySelectorAll(`input[name="${input.name}"]`).forEach(radio => {
        radio.checked = false;
        const radioLabel = radio.closest('label');
        const radioIndicator = radioLabel.querySelector('.w-5.h-5');
        const radioDot = radioIndicator ? radioIndicator.querySelector('div') : null;
        
        if (radioDot) {
            radioDot.classList.add('opacity-0');
            radioDot.classList.remove('opacity-100');
        }
        radioLabel.classList.remove('border-green-500', 'bg-green-50');
        radioLabel.classList.add('border-gray-200');
    });
    
    // Select current radio
    input.checked = true;
    const indicator = target.querySelector('.w-5.h-5');
    const dot = indicator ? indicator.querySelector('div') : null;
    
    if (dot) {
        dot.classList.remove('opacity-0');
        dot.classList.add('opacity-100');
    }
    target.classList.remove('border-gray-200');
    target.classList.add('border-green-500', 'bg-green-50');
});

// Initialize selected states on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
        const label = radio.closest('label');
        const indicator = label.querySelector('.w-5.h-5');
        const dot = indicator ? indicator.querySelector('div') : null;
        
        if (dot) {
            dot.classList.remove('opacity-0');
            dot.classList.add('opacity-100');
        }
        label.classList.remove('border-gray-200');
        label.classList.add('border-green-500', 'bg-green-50');
    });
    
    // Add bedroom functionality
    const addBedroomBtn = document.getElementById('add-bedroom-btn');
    if (addBedroomBtn) {
        addBedroomBtn.addEventListener('click', function() {
            const roomName = prompt('Enter room name (e.g., "Bedroom 2", "Living Room"):');
            if (roomName) {
                // Create a simple room entry
                const roomsContainer = document.querySelector('.space-y-4');
                const newRoom = document.createElement('div');
                newRoom.className = 'bg-white rounded-xl border-2 border-gray-200 p-4';
                newRoom.innerHTML = `
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="font-semibold text-gray-900">${roomName}</h5>
                        <div class="flex space-x-2">
                            <button type="button" class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                            <button type="button" class="text-red-600 hover:text-red-800 font-medium remove-room">Delete</button>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600">
                        <strong>Beds:</strong> No beds configured
                    </div>
                    <input type="hidden" name="new_rooms[]" value="${roomName}">
                `;
                
                // Insert before the "No rooms" message or add button
                const noRoomsMsg = roomsContainer.querySelector('.text-center');
                if (noRoomsMsg) {
                    roomsContainer.insertBefore(newRoom, noRoomsMsg);
                    noRoomsMsg.style.display = 'none';
                } else {
                    const addBtn = roomsContainer.querySelector('button');
                    roomsContainer.insertBefore(newRoom, addBtn);
                }
            }
        });
    }
    
    // Remove room functionality
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-room')) {
            e.target.closest('.bg-white').remove();
        }
    });
    
    // Handle guest access checkboxes
    document.addEventListener('click', function(e) {
        const label = e.target.closest('label');
        if (!label || !label.querySelector('input[name="guest_access[]"]')) return;
        
        const input = label.querySelector('input');
        const indicator = label.querySelector('.w-5.h-5');
        const icon = indicator ? indicator.querySelector('i') : null;
        
        input.checked = !input.checked;
        
        if (input.checked) {
            if (indicator) {
                indicator.classList.add('bg-green-500', 'border-green-500');
                indicator.classList.remove('border-gray-300');
            }
            if (icon) {
                icon.classList.remove('opacity-0');
                icon.classList.add('opacity-100');
            }
            label.classList.remove('border-gray-200');
            label.classList.add('border-green-500', 'bg-green-50');
        } else {
            if (indicator) {
                indicator.classList.remove('bg-green-500', 'border-green-500');
                indicator.classList.add('border-gray-300');
            }
            if (icon) {
                icon.classList.add('opacity-0');
                icon.classList.remove('opacity-100');
            }
            label.classList.remove('border-green-500', 'bg-green-50');
            label.classList.add('border-gray-200');
        }
    });
});
</script>