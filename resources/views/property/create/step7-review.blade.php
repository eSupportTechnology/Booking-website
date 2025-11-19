@extends('partner.partner-layout')

@section('title', 'Create Property - Review | ' . config('domains.app_name'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 7])

    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Review & Publish</h2>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-blue-800">Please review all information before publishing your property.</p>
            </div>
        </div>

        <!-- Property Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="lg:col-span-2">
                <h3 class="text-xl font-semibold mb-2">{{ $property->title }}</h3>
                <p class="text-gray-600 mb-4">{{ $property->description }}</p>
                <div class="space-y-2">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $property->address }}, {{ $property->city }}, {{ $property->country }}
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $property->category->name ?? 'N/A' }}
                    </div>
                </div>
            </div>
            <div>
                @php
                    $firstImage = null;
                    if($property->files) {
                        $images = $property->files->where('file_type', 'image');
                        $firstImage = $images->first();
                    }
                @endphp
                @if($firstImage)
                <img src="{{ asset('storage/' . $firstImage->path) }}"
                     class="w-full h-40 object-cover rounded-lg shadow-md">
                @else
                <div class="w-full h-40 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500">No image</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Property Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h4 class="text-lg font-semibold mb-4">Property Details</h4>
                @if($property->additionalDetails)
                <div class="space-y-2">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                        </svg>
                        {{ $property->additionalDetails->guests }} Guests
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                        </svg>
                        {{ $property->additionalDetails->bedrooms }} Bedrooms
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $property->additionalDetails->bathrooms }} Bathrooms
                    </div>
                </div>
                @endif

                @if($property->amenities && $property->amenities->count() > 0)
                <div class="mt-4">
                    <h5 class="font-medium mb-2">Amenities</h5>
                    <div class="flex flex-wrap gap-2">
                        @foreach($property->amenities->take(6) as $amenity)
                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">{{ $amenity->name }}</span>
                        @endforeach
                        @if($property->amenities->count() > 6)
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">+{{ $property->amenities->count() - 6 }} more</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h4 class="text-lg font-semibold mb-4">Services & Host Info</h4>
                @php
                    $services = DB::table('property_services')->where('property_id', $property->id)->first();
                    $hostProfile = DB::table('property_host_profiles')->where('property_id', $property->id)->first();
                @endphp

                @if($services)
                <div class="mb-4">
                    <h5 class="font-medium mb-2">Services</h5>
                    <div class="space-y-1">
                        @if($services->serve_breakfast)
                        <div class="flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            Breakfast Available @if($services->breakfast_price) (${{ $services->breakfast_price }}) @endif
                        </div>
                        @endif
                        @if($services->parking_available === 'yes')
                        <div class="flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 2h2a2 2 0 012 2v4a2 2 0 01-2 2H7a2 2 0 01-2-2V8a2 2 0 012-2z" clip-rule="evenodd"></path>
                            </svg>
                            Parking Available
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($hostProfile)
                <div>
                    <h5 class="font-medium mb-2">Host Information</h5>
                    <div class="space-y-1">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $hostProfile->host_name }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Photos -->
        @php
            $images = $property->files ? $property->files->where('file_type', 'image') : collect();
        @endphp
        @if($images->count() > 0)
        <div class="mb-8">
            <h4 class="text-lg font-semibold mb-4">Photos ({{ $images->count() }})</h4>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                @foreach($images->take(6) as $photo)
                <div>
                    <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-24 object-cover rounded-lg">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Pricing -->
        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
            <h4 class="text-lg font-semibold mb-4">Pricing Information</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Adult Price:</span>
                        <span class="font-semibold text-green-600">${{ $property->adult_price ?? '0.00' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Children Price:</span>
                        <span class="font-semibold text-green-600">${{ $property->children_price ?? '0.00' }}</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Commission Rate:</span>
                        <span class="font-semibold text-red-600">{{ $property->commission_rate ?? 15 }}%</span>
                    </div>
                </div>
                <div class="space-y-2">
                    @php
                        $adultPrice = $property->adult_price ?? 0;
                        $childrenPrice = $property->children_price ?? 0;
                        $commission = $property->commission_rate ?? 15;
                        $adultTotal = $adultPrice / (1 - $commission / 100);
                        $childrenTotal = $childrenPrice / (1 - $commission / 100);
                    @endphp
                    <div class="flex justify-between">
                        <span>Total Adult Price:</span>
                        <span class="font-semibold text-blue-600">${{ number_format($adultTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Children Price:</span>
                        <span class="font-semibold text-blue-600">${{ number_format($childrenTotal, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completion Checklist -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Completion Checklist</h4>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <span id="checkBasic" class="text-2xl">{{ $property->title ? '✓' : '✗' }}</span>
                    <span class="text-sm {{ $property->title ? 'text-gray-700' : 'text-gray-400' }}">Basic Information</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span id="checkDetails" class="text-2xl">{{ $property->additionalDetails ? '✓' : '✗' }}</span>
                    <span class="text-sm {{ $property->additionalDetails ? 'text-gray-700' : 'text-gray-400' }}">Property Details & Amenities</span>
                </div>
                <div class="flex items-center space-x-3">
                    @php
                        $hasHostProfile = $property && DB::table('property_host_profiles')->where('property_id', $property->id)->exists();
                    @endphp
                    <span id="checkHost" class="text-2xl">{{ $hasHostProfile ? '✓' : '✗' }}</span>
                    <span class="text-sm {{ $hasHostProfile ? 'text-gray-700' : 'text-gray-400' }}">Host Profile</span>
                </div>
                <div class="flex items-center space-x-3">
                    @php
                        $photoCount = $property->files ? $property->files->where('file_type', 'image')->count() : 0;
                    @endphp
                    <span id="checkPhotos" class="text-2xl">{{ $photoCount >= 3 ? '✓' : '✗' }}</span>
                    <span class="text-sm {{ $photoCount >= 3 ? 'text-gray-700' : 'text-gray-400' }}">Photos ({{ $photoCount }}/3 minimum)</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span id="checkPricing" class="text-2xl">{{ $property->adult_price && $property->children_price ? '✓' : '✗' }}</span>
                    <span class="text-sm {{ $property->adult_price && $property->children_price ? 'text-gray-700' : 'text-gray-400' }}">Pricing Configuration</span>
                </div>
            </div>
        </div>

        <form id="step7Form">
            @csrf

            <!-- Terms and Conditions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Terms & Conditions</h4>
                <div class="space-y-4 text-sm text-gray-700">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="terms1" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>
                            I certify that this is a legitimate accommodation business with all necessary licenses and permits, which can be shown upon first request. {{ config('domains.app_name') }} reserves the right to verify and investigate any details provided in this registration.
                        </span>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="terms2" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>
                            I have read, accepted, and agreed to the <a href="#" class="text-blue-600 hover:underline">General Delivery Terms</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>.
                        </span>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="terms3" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>
                            I understand that my property will be available for bookings for the next 18 months, and this availability can be adjusted after opening for bookings.
                        </span>
                    </label>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ ($mode ?? 'create') === 'edit' ? '/property/'.$property->id.'/edit/step/6' : '/property/create/step/6' }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Previous</a>
                <button type="submit" id="publishBtn" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ ($mode ?? 'create') === 'edit' ? 'Update Property' : 'Publish Property' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('step7Form');
    const publishBtn = document.getElementById('publishBtn');
    const terms1 = document.getElementById('terms1');
    const terms2 = document.getElementById('terms2');
    const terms3 = document.getElementById('terms3');

    // Validation function
    function validateCompletion() {
        const hasBasic = {{ $property->title ? 'true' : 'false' }};
        const hasDetails = {{ $property->additionalDetails ? 'true' : 'false' }};
        const hasHost = {{ ($property && DB::table('property_host_profiles')->where('property_id', $property->id)->exists()) ? 'true' : 'false' }};
        const photoCount = {{ $property->files ? $property->files->where('file_type', 'image')->count() : 0 }};
        const hasPricing = {{ ($property->adult_price && $property->children_price) ? 'true' : 'false' }};

        const allComplete = hasBasic && hasDetails && hasHost && photoCount >= 3 && hasPricing;
        const allTermsAccepted = terms1.checked && terms2.checked && terms3.checked;

        publishBtn.disabled = !(allComplete && allTermsAccepted);

        if (!allComplete) {
            publishBtn.title = 'Please complete all required steps before publishing';
        } else if (!allTermsAccepted) {
            publishBtn.title = 'Please accept all terms and conditions';
        } else {
            publishBtn.title = '';
        }
    }

    // Check on load
    validateCompletion();

    // Check on terms change
    [terms1, terms2, terms3].forEach(checkbox => {
        checkbox.addEventListener('change', validateCompletion);
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        // Final validation
        if (!terms1.checked || !terms2.checked || !terms3.checked) {
            Swal.fire({
                icon: 'warning',
                title: 'Terms Required',
                text: 'Please accept all terms and conditions to continue.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const hasBasic = {{ $property->title ? 'true' : 'false' }};
        const hasDetails = {{ $property->additionalDetails ? 'true' : 'false' }};
        const hasHost = {{ ($property && DB::table('property_host_profiles')->where('property_id', $property->id)->exists()) ? 'true' : 'false' }};
        const photoCount = {{ $property->files ? $property->files->where('file_type', 'image')->count() : 0 }};
        const hasPricing = {{ ($property->adult_price && $property->children_price) ? 'true' : 'false' }};

        if (!hasBasic || !hasDetails || !hasHost || photoCount < 3 || !hasPricing) {
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Information',
                text: 'Please complete all required steps before publishing your property.',
                confirmButtonText: 'OK'
            });
            return;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="currentColor" viewBox="0 0 20 20"><path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V4a2 2 0 00-2-2H4z"></path></svg> Publishing...';

        fetch('{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/7" : "/property/create/step/7" }}', {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Property published successfully! Your property is now live and ready for bookings.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        window.location.href = '/partner/properties';
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error publishing property',
                    confirmButtonText: 'OK'
                });
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Publish Property';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while publishing the property',
                confirmButtonText: 'OK'
            });
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Publish Property';
        });
    });
});
</script>
@endsection
