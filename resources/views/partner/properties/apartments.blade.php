@extends('partner.master')
@section('title', 'Apartments')
@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 md:p-8 text-white">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Apartments</h1>
                    <p class="text-blue-100 text-base md:text-lg">Manage your apartment listings</p>
                </div>
                <a href="{{ route('partner.property.category') }}"
                    class="w-full sm:w-auto text-center bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Add Apartment
                </a>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-2xl p-6 shadow-lg">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search apartments by title, city, or address..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex flex-col sm:flex-row gap-4 sm:items-center w-full md:w-auto">
                    <select name="status"
                        class="w-full sm:w-auto px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200 text-center">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        @if (request('search') || request('status'))
                            <a href="{{ route('partner.properties.apartments') }}"
                                class="flex-1 sm:flex-none bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200 text-center">
                                <i class="fas fa-times mr-2"></i>Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Properties Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($properties as $property)
                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden hover:scale-[1.02]">
                    <a href="{{ route('partner.properties.views', $property['id']) }}">
                        <div class="h-48 bg-gray-200 relative">
                            @if ($property['image'])
                                <img src="{{ asset('storage/' . $property['image']) }}"
                                    alt="{{ $property['title'] ?? 'Property' }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                    <i class="fas fa-building text-gray-500 text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <span
                                    class="bg-{{ ($property['status'] ?? 'active') === 'active' ? 'green' : 'yellow' }}-100 text-{{ ($property['status'] ?? 'active') === 'active' ? 'green' : 'yellow' }}-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($property['status'] ?? 'Active') }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="p-6">
                        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2 truncate">
                            {{ $property['title'] ?? 'Untitled Property' }}
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm md:text-base">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ $property['city'] ?? 'Location not specified' }}
                        </p>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">0 bookings</span>
                            <span
                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Apartment</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('partner.properties.views', $property['id']) }}"
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center text-sm transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <a href="{{ route('partner.properties.edit', $property['id']) }}"
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-center text-sm transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <button onclick="deleteProperty({{ $property['id'] }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-building text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Apartments Found</h3>
                    <p class="text-gray-500 mb-6">Start by adding your first apartment listing</p>
                    <a href="{{ route('partner.list-your-property') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200 inline-block">
                        <i class="fas fa-plus mr-2"></i>Add Apartment
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection

<script>
function deleteProperty(propertyId) {
    if (confirm('Are you sure you want to delete this property? This action cannot be undone.')) {
        fetch(`/partner/properties/${propertyId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting property: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error deleting property');
        });
    }
}
</script>
