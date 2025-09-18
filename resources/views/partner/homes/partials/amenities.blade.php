<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Amenities & Facilities</h3>
        <p class="text-gray-600">Select amenities that make your property special</p>
    </div>

    <form id="amenities-form" class="space-y-8" action="{{ route('partner.homes.update.amenities', $property) }}" method="POST">
        @csrf
        
        @php
            $selectedAmenities = $property->amenities ? $property->amenities->pluck('id')->toArray() : [];
        @endphp
        
        {{-- Debug: Show selected amenities --}}
        @if(count($selectedAmenities) > 0)
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">Currently selected: {{ count($selectedAmenities) }} amenities</p>
            </div>
        @endif

        <!-- Amenity Categories -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @if(isset($groupedAmenities) && $groupedAmenities->count() > 0)
                @foreach($groupedAmenities as $category => $amenities)
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-star text-blue-600 mr-2"></i>
                            {{ ucfirst(str_replace('_', ' ', $category)) }}
                        </h4>
                        <div class="grid grid-cols-1 gap-3">
                            @foreach($amenities as $amenity)
                                <label class="flex items-center p-3 bg-white rounded-xl border-2 hover:border-green-300 cursor-pointer transition-all duration-200 group amenity-checkbox {{ in_array($amenity->id, $selectedAmenities) ? 'border-green-500 bg-green-50' : 'border-gray-200' }}">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" {{ in_array($amenity->id, $selectedAmenities) ? 'checked' : '' }} class="hidden amenity-input">
                                    <div class="w-5 h-5 border-2 {{ in_array($amenity->id, $selectedAmenities) ? 'border-green-500 bg-green-500' : 'border-gray-300' }} rounded-md mr-3 flex items-center justify-center group-hover:border-green-500 transition-colors checkbox-indicator">
                                        <i class="fas fa-check text-white text-xs {{ in_array($amenity->id, $selectedAmenities) ? 'opacity-100' : 'opacity-0' }} check-icon"></i>
                                    </div>
                                    <span class="font-medium text-gray-700 group-hover:text-green-700">{{ $amenity->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Custom Facilities -->
        <div class="bg-gradient-to-r from-gray-50 to-slate-50 rounded-2xl p-6 border border-gray-200">
            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-plus-circle text-gray-600 mr-2"></i>
                Custom Facilities
            </h4>
            <div id="facilities-container" class="space-y-3 mb-4">
                @if($property->facilities && $property->facilities->count() > 0)
                    @foreach($property->facilities as $facility)
                        <div class="flex items-center space-x-3">
                            <input type="text" class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" name="facilities[]" value="{{ $facility->facility_name }}" placeholder="Enter facility name">
                            <button type="button" class="remove-facility bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl transition-colors">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-medium py-2 px-6 rounded-xl transition-all duration-200 transform hover:scale-105" id="add-facility">
                <i class="fas fa-plus mr-2"></i>
                Add Custom Facility
            </button>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-blue-600 mt-1 mr-3"></i>
                <div>
                    <p class="text-blue-800 font-medium">Pro Tip</p>
                    <p class="text-blue-700 text-sm">Select amenities that best describe your property to help guests find exactly what they're looking for.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Amenities
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle amenity checkbox selection
    document.addEventListener('click', function(e) {
        if (e.target.closest('.amenity-checkbox')) {
            e.preventDefault();
            const label = e.target.closest('.amenity-checkbox');
            const checkbox = label.querySelector('.amenity-input');
            const indicator = label.querySelector('.checkbox-indicator');
            const checkIcon = label.querySelector('.check-icon');
            
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                indicator.classList.add('bg-green-500', 'border-green-500');
                indicator.classList.remove('border-gray-300');
                checkIcon.classList.remove('opacity-0');
                checkIcon.classList.add('opacity-100');
                label.classList.remove('border-gray-200');
                label.classList.add('border-green-500', 'bg-green-50');
            } else {
                indicator.classList.remove('bg-green-500', 'border-green-500');
                indicator.classList.add('border-gray-300');
                checkIcon.classList.add('opacity-0');
                checkIcon.classList.remove('opacity-100');
                label.classList.remove('border-green-500', 'bg-green-50');
                label.classList.add('border-gray-200');
            }
        }
    });

    // Add facility button
    const addFacilityBtn = document.getElementById('add-facility');
    if (addFacilityBtn) {
        addFacilityBtn.addEventListener('click', function() {
            const container = document.getElementById('facilities-container');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-3';
            div.innerHTML = `
                <input type="text" class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-200" name="facilities[]" placeholder="Enter facility name">
                <button type="button" class="remove-facility bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl transition-colors">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            `;
            container.appendChild(div);
        });
    }

    // Remove facility button
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-facility')) {
            e.preventDefault();
            e.target.closest('.flex').remove();
        }
    });
});
</script>