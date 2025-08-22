@extends('admin.master')

@section('title', 'Pending Properties')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold mb-2">Pending Properties</h1>
                <p class="text-yellow-100">Review and manage properties awaiting approval</p>
            </div>
            <div class="text-right">
                <span class="bg-white/20 px-4 py-2 rounded-xl">
                    {{ $pendingCount }} properties pending
                </span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by property name or partner..."
                       class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <select name="type" class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                <option value="">All Types</option>
                <option value="hotel" {{ request('type') === 'hotel' ? 'selected' : '' }}>Hotels</option>
                <option value="apartment" {{ request('type') === 'apartment' ? 'selected' : '' }}>Apartments</option>
                <option value="home" {{ request('type') === 'home' ? 'selected' : '' }}>Homes</option>
            </select>
            <button type="submit"
                    class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search', 'type']))
                <a href="{{ route('admin.properties.pending') }}"
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Properties Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($properties as $property)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Property Image -->
                <div class="relative h-48">
                    <img src="{{ $property->featured_image }}" alt="{{ $property->name }}"
                         class="w-full h-full object-cover">
                    <span class="absolute top-4 right-4 bg-yellow-500 text-white text-sm px-3 py-1 rounded-full">
                        {{ $property->type }}
                    </span>
                </div>

                <!-- Property Info -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $property->name }}</h3>
                            <p class="text-gray-500">{{ $property->location }}</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">
                            Pending {{ $property->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <div class="flex items-center mb-4">
                            <img src="{{ $property->partner->avatar }}" alt="{{ $property->partner->name }}"
                                 class="w-10 h-10 rounded-full">
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-800">{{ $property->partner->name }}</p>
                                <p class="text-sm text-gray-500">{{ $property->partner->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('admin.properties.review', $property->id) }}"
                           class="flex-1 bg-blue-500 text-white text-center py-2 rounded hover:bg-blue-600 transition-colors">
                            Review
                        </a>
                        <button onclick="approveProperty({{ $property->id }})"
                                class="flex-1 bg-green-500 text-white py-2 rounded hover:bg-green-600 transition-colors">
                            Approve
                        </button>
                        <button onclick="rejectProperty({{ $property->id }})"
                                class="flex-1 bg-red-500 text-white py-2 rounded hover:bg-red-600 transition-colors">
                            Reject
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-clipboard-check text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600">No Pending Properties</h3>
                <p class="text-gray-500">All properties have been reviewed</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="mt-6">
            {{ $properties->links() }}
        </div>
    @endif
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
                window.location.reload();
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
                window.location.reload();
            }).catch(error => {
                console.error('Error:', error);
                alert('Failed to reject property');
            });
        }
    }
</script>
@endpush
@endsection
