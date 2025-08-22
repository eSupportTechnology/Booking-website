@extends('admin.master')

@section('title', 'Review Property')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Review Property</h1>
                <p class="text-blue-100">Review details and make a decision</p>
            </div>
            <div class="flex space-x-4">
                <button onclick="approveProperty({{ $property->id }})"
                        class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                    Approve
                </button>
                <button onclick="rejectProperty({{ $property->id }})"
                        class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors">
                    Reject
                </button>
            </div>
        </div>
    </div>

    <!-- Property Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Basic Information -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Basic Information</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-gray-500">Property Name</label>
                        <p class="text-lg font-medium">{{ $property->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Property Type</label>
                        <p class="text-lg font-medium capitalize">{{ $property->type }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Location</label>
                        <p class="text-lg font-medium">{{ $property->location }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Price Range</label>
                        <p class="text-lg font-medium">${{ $property->price_range_start }} - ${{ $property->price_range_end }}</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Description</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $property->description }}</p>
            </div>

            <!-- Amenities -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Amenities</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($property->amenities as $amenity)
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check text-green-500"></i>
                            <span>{{ $amenity->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Photos -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Photos</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($property->photos as $photo)
                        <div class="relative aspect-video rounded-lg overflow-hidden">
                            <img src="{{ $photo->photo_url }}" alt="Property Image" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Partner Info -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Partner Information</h2>
                <div class="flex items-center mb-6">
                    <img src="{{ $property->partner->avatar }}" alt="{{ $property->partner->name }}"
                         class="w-16 h-16 rounded-full">
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">{{ $property->partner->name }}</h3>
                        <p class="text-gray-500">{{ $property->partner->email }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500">Member Since</label>
                        <p>{{ $property->partner->created_at->format('F Y') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Total Properties</label>
                        <p>{{ $property->partner->properties_count }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Average Rating</label>
                        <p>{{ number_format($property->partner->average_rating, 1) }} / 5.0</p>
                    </div>
                </div>
                <a href="{{ route('admin.partner.view', $property->partner->id) }}"
                   class="block mt-6 text-center text-blue-500 hover:text-blue-600">
                    View Full Profile
                </a>
            </div>

            <!-- Submission Details -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Submission Details</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500">Submitted On</label>
                        <p>{{ $property->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500">Status</label>
                        <p class="inline-flex items-center">
                            <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span>
                            Pending Review
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function approveProperty(id) {
        if (confirm('Are you sure you want to approve this property?')) {
            fetch(`/admin/properties/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            }).then(data => {
                alert('Property approved successfully');
                window.location.href = '/admin/properties/pending';
            }).catch(error => {
                console.error('Error:', error);
                alert('Failed to approve property');
            });
        }
    }

    function rejectProperty(id) {
        const reason = prompt('Please provide a reason for rejection:');
        if (reason) {
            fetch(`/admin/properties/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ reason })
            }).then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            }).then(data => {
                alert('Property rejected successfully');
                window.location.href = '/admin/properties/pending';
            }).catch(error => {
                console.error('Error:', error);
                alert('Failed to reject property');
            });
        }
    }
</script>
@endpush
@endsection
