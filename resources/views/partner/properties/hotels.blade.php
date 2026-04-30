@extends('partner.master')
@section('title', 'Hotels')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Hotels</h1>
                <p class="text-gray-500 text-sm">Manage your hotel listings</p>
            </div>
            <a href="{{ route('partner.property.category') }}" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99] transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Hotel
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search hotels..."
                class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#1F8FB2]">
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#1F8FB2]">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99]">Search</button>
            @if(request('search') || request('status'))
            <a href="{{ route('partner.properties.hotels') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Clear</a>
            @endif
        </form>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($properties as $property)
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition">
            <a href="{{ route('partner.properties.views', $property['id']) }}">
                <div class="h-40 bg-gray-100 relative">
                    @if($property['image'])
                    <img src="{{ asset('storage/' . $property['image']) }}" alt="{{ $property['title'] }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    @endif
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-0.5 rounded text-xs font-medium {{ ($property['status'] ?? 'active') === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($property['status'] ?? 'Active') }}
                        </span>
                    </div>
                </div>
            </a>
            <div class="p-4">
                <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $property['title'] ?? 'Untitled' }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $property['city'] ?? 'Location not specified' }}</p>
                <div class="flex items-center justify-between mt-3">
                    <div class="text-sm font-medium text-green-600">${{ number_format($property['adult_price_usd'] ?? 0, 2) }}</div>
                    <span class="text-xs text-gray-400">per night</span>
                </div>
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('partner.properties.views', $property['id']) }}" class="flex-1 bg-[#1F8FB2] text-white px-3 py-1.5 rounded text-xs text-center hover:bg-[#1a7a99]">View</a>
                    <a href="{{ route('partner.properties.edit', $property['id']) }}" class="flex-1 bg-gray-100 text-gray-700 px-3 py-1.5 rounded text-xs text-center hover:bg-gray-200">Edit</a>
                    <button onclick="deleteProperty({{ $property['id'] }})" class="bg-red-50 text-red-600 px-3 py-1.5 rounded text-xs hover:bg-red-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <p class="text-gray-500 text-sm mb-3">No hotels found</p>
            <a href="{{ route('partner.list-your-property') }}" class="text-[#1F8FB2] text-sm hover:underline">Add your first hotel</a>
        </div>
        @endforelse
    </div>
</div>

<script>
function deleteProperty(propertyId) {
    if (confirm('Delete this property?')) {
        fetch(`/partner/properties/${propertyId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Error: ' + data.message);
        });
    }
}
</script>
@endsection
