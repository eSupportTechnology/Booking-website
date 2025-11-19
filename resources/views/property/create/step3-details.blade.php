@extends('partner.partner-layout')

@section('title', 'Create Property - Details | ' . config('domains.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 3])

    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">{{ ($mode ?? 'create') === 'edit' ? 'Edit Property Details & Services' : 'Property Details & Services' }}</h2>

        <form id="step3Form" class="space-y-8">
            @csrf

            <!-- Basic Details -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Basic Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Guests *</label>
                        <input type="number" name="guests" required min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="1"
                               value="{{ old('guests', $property->additionalDetails->guests ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms *</label>
                        <input type="number" name="bedrooms" required min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="1"
                               value="{{ old('bedrooms', $property->additionalDetails->bedrooms ?? '') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bathrooms *</label>
                        <input type="number" name="bathrooms" required min="1"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="1"
                               value="{{ old('bathrooms', $property->additionalDetails->bathrooms ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Property Services</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="breakfast" value="1"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ old('breakfast', ($services && $services->serve_breakfast) ?? false) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Breakfast Available</span>
                        </label>

                        <div id="breakfastPrice" class="{{ (old('breakfast', ($services && $services->serve_breakfast) ?? false)) ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Breakfast Price (per person)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-500">$</span>
                                <input type="number" name="breakfast_price" step="0.01" min="0"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                       placeholder="0.00"
                                       value="{{ old('breakfast_price', ($services && $services->breakfast_price) ? $services->breakfast_price : '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="parking" value="1"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ old('parking', ($services && $services->parking_available === 'yes') ? true : false) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Parking Available</span>
                        </label>

                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="wifi" value="1"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ old('wifi', false) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Free WiFi</span>
                        </label>

                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="pets_allowed" value="1"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                   {{ old('pets_allowed', false) ? 'checked' : '' }}>
                            <span class="text-sm font-medium text-gray-700">Pets Allowed</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Amenities -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Amenities</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @if(isset($amenities))
                        @foreach($amenities as $category => $categoryAmenities)
                            <div class="col-span-full">
                                <h4 class="font-medium text-gray-900 mb-2">{{ ucfirst($category) }}</h4>
                            </div>
                            @foreach($categoryAmenities as $amenity)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       {{ in_array($amenity->id, $selectedAmenities ?? []) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $amenity->name }}</span>
                            </label>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ ($mode ?? 'create') === 'edit' ? '/property/'.$property->id.'/edit/step/2' : '/property/create/step/2' }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">
                    Back
                </a>
                <div class="flex space-x-3">
                    <a href="{{ ($mode ?? 'create') === 'edit' ? '/property/'.$property->id.'/edit/step/3.5' : '/property/create/step/3.5' }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        Configure Rooms (Optional)
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                        Continue
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const breakfastCheckbox = document.querySelector('input[name="breakfast"]');
    const breakfastPriceDiv = document.getElementById('breakfastPrice');

    breakfastCheckbox.addEventListener('change', function() {
        if (this.checked) {
            breakfastPriceDiv.classList.remove('hidden');
        } else {
            breakfastPriceDiv.classList.add('hidden');
            document.querySelector('input[name="breakfast_price"]').value = '';
        }
    });
});

document.getElementById('step3Form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/3" : "/property/create/step/3" }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/4" : "/property/create/step/4" }}';
        } else {
            alert(data.message || 'Error saving details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving details');
    });
});
</script>
@endsection
