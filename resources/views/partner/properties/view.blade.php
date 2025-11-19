@extends('partner.master')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
            <p class="text-gray-600 mt-1">Property ID: #{{ $property->id }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('property.edit', $property->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Edit Property
            </a>
            <a href="{{ route('partner.properties') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Back to Properties
            </a>
        </div>
    </div>

    <!-- Property Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-dollar-sign text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Adult Price</p>
                    <p class="text-2xl font-bold">${{ number_format($property->adult_price, 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-child text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Children Price</p>
                    <p class="text-2xl font-bold">${{ number_format($property->children_price, 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-percentage text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Commission</p>
                    <p class="text-2xl font-bold">{{ $property->commission_rate }}%</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-calendar-check text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Bookings</p>
                    <p class="text-2xl font-bold">{{ $property->bookings()->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Property Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Property Type:</span>
                    <span class="font-medium">{{ $property->category->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($property->status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Location:</span>
                    <span class="font-medium">{{ $property->city }}, {{ $property->country }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Address:</span>
                    <span class="font-medium">{{ $property->address }}</span>
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Property Details</h3>
            <div class="space-y-3">
                @if($property->additionalDetails)
                <div class="flex justify-between">
                    <span class="text-gray-600">Guests:</span>
                    <span class="font-medium">{{ $property->additionalDetails->guests_capacity ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Bedrooms:</span>
                    <span class="font-medium">{{ $property->additionalDetails->bedrooms_count ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Bathrooms:</span>
                    <span class="font-medium">{{ $property->additionalDetails->bathrooms_count ?? 'N/A' }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">Created:</span>
                    <span class="font-medium">{{ $property->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($property->description)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Description</h3>
        <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
    </div>
    @endif

    <!-- Photos -->
    @if($property->files()->where('file_type', 'image')->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Photos</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($property->files()->where('file_type', 'image')->get() as $photo)
            <img src="{{ asset('storage/' . $photo->path) }}" alt="Property Photo" 
                 class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-75 transition-opacity"
                 onclick="openImageModal('{{ asset('storage/' . $photo->path) }}')">
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center" onclick="closeImageModal()">
    <div class="max-w-4xl max-h-full p-4">
        <img id="modalImage" src="" alt="Property Photo" class="max-w-full max-h-full object-contain">
    </div>
</div>

<script>
function openImageModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>
@endsection