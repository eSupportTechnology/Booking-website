@extends('partner.master')
@section('title', 'Alternative Places')
@section('content')
    <div class="space-y-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-2xl p-6 md:p-8 text-white">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Alternative Places</h1>
                    <p class="text-orange-100 text-base md:text-lg">Manage your unique property listings</p>
                </div>
                <a href="{{ route('partner.property.category') }}"
                    class="w-full sm:w-auto text-center bg-white text-orange-600 px-6 py-3 rounded-xl font-semibold hover:bg-orange-50 transition-all duration-200 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Add Property
                </a>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white rounded-2xl p-4 md:p-6 shadow-lg">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search alternative places by title, city, or address..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm md:text-base">
                </div>
                <select name="status"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm md:text-base">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200 text-sm md:text-base">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                    @if (request('search') || request('status'))
                        <a href="{{ route('partner.properties.alternative-places') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200 text-center text-sm md:text-base">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Properties Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($properties as $property)
                <div
                    class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 overflow-hidden hover:scale-[1.02]">
                    <a href="{{ route('partner.properties.views', $property['id']) }}">
                        <div class="h-48 md:h-56 bg-gray-200 relative">
                            @if ($property['image'])
                                <img src="{{ asset('storage/' . $property['image']) }}"
                                    alt="{{ $property['title'] ?? 'Property' }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                    <i class="fas fa-campground text-gray-500 text-4xl"></i>
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
                    <div class="p-4 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-2">{{ $property['title'] ?? 'Untitled Property' }}
                        </h3>
                        <p class="text-gray-600 mb-2 text-sm md:text-base">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ $property['city'] ?? 'Location not specified' }}
                        </p>
                        <div class="text-xs md:text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar-alt mr-2"></i>0 bookings this month
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-sm font-bold text-green-600">
                                Adult: USD {{ number_format($property['adult_price_usd'] ?? 0, 2) }}<br>
                                Child: USD {{ number_format($property['child_price_usd'] ?? 0, 2) }}
                            </div>
                            <span
                                class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-xs font-semibold">Alternative</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:space-x-2 gap-2">
                            <a href="{{ route('partner.properties.views', $property['id']) }}"
                                class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-center text-sm transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <a href="{{ route('partner.properties.edit', $property['id']) }}"
                                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-center text-sm transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <button onclick="deleteProperty({{ $property['id'] }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition-colors duration-200 w-full sm:w-auto">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-campground text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Alternative Places Found</h3>
                    <p class="text-gray-500 mb-6">Start by adding your first unique property listing</p>
                    <a href="{{ route('partner.list-your-property') }}"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200 inline-block">
                        <i class="fas fa-plus mr-2"></i>Add Property
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
