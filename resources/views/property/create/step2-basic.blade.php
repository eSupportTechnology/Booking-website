@extends('partner.partner-layout')

@section('title', 'Create Property - Basic Info | ' . config('domains.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 2])
    
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">{{ ($mode ?? 'create') === 'edit' ? 'Edit Property Information' : 'Tell us about your property' }}</h2>
        
        <form id="step2Form" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Property Name *</label>
                <input type="text" name="title" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter your property name"
                       value="{{ old('title', $property->title ?? '') }}">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" required rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Describe your property...">{{ old('description', $property->description ?? '') }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                    <input type="text" name="address" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Street address"
                           value="{{ old('address', $property->address ?? '') }}">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                    <input type="text" name="city" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="City"
                           value="{{ old('city', $property->city ?? '') }}">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                    <select name="country" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Country</option>
                        <option value="US" {{ old('country', $property->country ?? '') == 'US' ? 'selected' : '' }}>United States</option>
                        <option value="UK" {{ old('country', $property->country ?? '') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                        <option value="CA" {{ old('country', $property->country ?? '') == 'CA' ? 'selected' : '' }}>Canada</option>
                        <option value="AU" {{ old('country', $property->country ?? '') == 'AU' ? 'selected' : '' }}>Australia</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Apartment Number</label>
                    <input type="text" name="apartment" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Apt 123, Unit A, etc."
                           value="{{ old('apartment', $property->apartment ?? '') }}">
                </div>
            </div>
            
            <div class="flex justify-between mt-8">
                <a href="{{ ($mode ?? 'create') === 'edit' ? '/property/'.$property->id.'/edit' : '/property/create' }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">
                    Back
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Continue
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('step2Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/2" : "/property/create/step/2" }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/3" : "/property/create/step/3" }}';
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
@endsection