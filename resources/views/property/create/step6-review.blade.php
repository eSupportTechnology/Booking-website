@extends('partner.partner-layout')

@section('title', 'Create Property - Review | ' . config('domains.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 6])
    
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Review Your Property</h2>
        <p class="text-gray-600 mb-8">Please review all the information before publishing your property</p>
        
        @if($property)
        <div class="space-y-8">
            <!-- Basic Information -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Property Name:</span>
                        <span class="ml-2">{{ $property->title }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">City:</span>
                        <span class="ml-2">{{ $property->city }}</span>
                    </div>
                    <div class="col-span-full">
                        <span class="font-medium text-gray-700">Address:</span>
                        <span class="ml-2">{{ $property->address }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Property Details -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold mb-4">Property Details</h3>
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Guests:</span>
                        <span class="ml-2">{{ $property->additionalDetails->guests ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Bedrooms:</span>
                        <span class="ml-2">{{ $property->additionalDetails->bedrooms ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Bathrooms:</span>
                        <span class="ml-2">{{ $property->additionalDetails->bathrooms ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Photos -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold mb-4">Photos</h3>
                <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($property->files()->where('file_type', 'image')->get() as $photo)
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Property Photo" 
                         class="w-full h-24 object-cover rounded-lg">
                    @endforeach
                </div>
            </div>
            
            <!-- Pricing -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold mb-4">Pricing & Commission</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-700">Your Adult Earnings (per night):</span>
                                <span class="font-semibold">${{ number_format($property->adult_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-700">Your Children Earnings (per night):</span>
                                <span class="font-semibold">${{ number_format($property->children_price, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Commission Rate:</span>
                                <span class="font-semibold text-red-600">{{ $property->commission_rate }}%</span>
                            </div>
                        </div>
                        <div>
                            @php
                                $adultTotalPrice = $property->adult_price / (1 - $property->commission_rate / 100);
                                $childrenTotalPrice = $property->children_price / (1 - $property->commission_rate / 100);
                            @endphp
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-700">Total Adult Price (customers pay):</span>
                                <span class="font-semibold text-blue-600">
                                    ${{ number_format($adultTotalPrice, 2) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700">Total Children Price (customers pay):</span>
                                <span class="font-semibold text-blue-600">
                                    ${{ number_format($childrenTotalPrice, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <form id="step6Form" class="mt-8">
            @csrf
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex items-start">
                    <input type="checkbox" id="terms" required 
                           class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="terms" class="ml-3 text-sm text-gray-700">
                        I confirm that all the information provided is accurate and I agree to the 
                        <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and 
                        <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>.
                    </label>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="/property/create/step/5" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">
                    Back
                </a>
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                    Publish Property
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('step6Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/property/create/step/6', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.completed) {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.href = '/partner/properties';
            }
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>
@endsection