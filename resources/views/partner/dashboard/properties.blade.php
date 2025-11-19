@extends('partner.partner-layout')

@section('title', 'Property Dashboard | ' . config('domains.app_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-500">Total Properties</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_properties'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-500">Active Properties</h3>
            <p class="text-3xl font-bold text-green-600">{{ $stats['active_properties'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-500">Total Bookings</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_bookings'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-500">Total Earnings</h3>
            <p class="text-3xl font-bold text-purple-600">${{ number_format($stats['total_earnings'], 2) }}</p>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Your Properties</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($properties as $property)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">{{ $property['photo_count'] }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $property['title'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $property['category'] }} • {{ $property['created_at'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select class="status-select text-sm rounded-full px-3 py-1 font-medium" 
                                    data-property-id="{{ $property['id'] }}"
                                    onchange="updatePropertyStatus(this)">
                                <option value="draft" {{ $property['status'] === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ $property['status'] === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $property['status'] === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ $property['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $property['completion'] }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600">{{ $property['completion'] }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>Adult: ${{ number_format($property['adult_price'], 2) }}</div>
                            @if($property['child_price'] > 0)
                            <div>Child: ${{ number_format($property['child_price'], 2) }}</div>
                            @endif
                            <div class="text-xs text-gray-500">Commission: {{ $property['commission_rate'] }}%</div>
                            <div class="font-medium">Total: ${{ number_format($property['total_price'], 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>{{ $property['total_bookings'] }} bookings</div>
                            <div>${{ number_format($property['total_earnings'], 2) }} earned</div>
                            @if($property['avg_rating'] > 0)
                            <div>⭐ {{ $property['avg_rating'] }}/5</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('partner.properties.edit', $property['id']) }}" 
                                   class="text-blue-600 hover:text-blue-900">Edit</a>
                                <button onclick="viewStats({{ $property['id'] }})" 
                                        class="text-green-600 hover:text-green-900">Stats</button>
                                <button onclick="deleteProperty({{ $property['id'] }})" 
                                        class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
async function updatePropertyStatus(select) {
    const propertyId = select.dataset.propertyId;
    const status = select.value;
    
    try {
        const response = await fetch(`/partner/properties/${propertyId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ status })
        });
        
        const result = await response.json();
        if (result.success) {
            window.showNotification('Status updated successfully', 'success');
        }
    } catch (error) {
        window.showNotification('Failed to update status', 'error');
    }
}

async function viewStats(propertyId) {
    try {
        const response = await fetch(`/partner/properties/${propertyId}/stats`);
        const stats = await response.json();
        
        alert(`Property Stats:\nViews: ${stats.views}\nBookings: ${stats.bookings}\nRevenue: $${stats.revenue}\nRating: ${stats.avg_rating}/5\nCompletion: ${stats.completion}%`);
    } catch (error) {
        window.showNotification('Failed to load stats', 'error');
    }
}

function deleteProperty(propertyId) {
    if (confirm('Are you sure you want to delete this property?')) {
        fetch(`/partner/properties/${propertyId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(() => {
            window.location.reload();
        });
    }
}
</script>
@endsection