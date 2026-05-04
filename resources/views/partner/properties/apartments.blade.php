@extends('partner.master')
@section('title', 'Apartments')
@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Apartments</h1>
                <p class="text-gray-500 text-sm">Manage your apartment listings</p>
            </div>
            <a href="{{ route('partner.property.category') }}" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99] transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Apartment
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search apartments..."
                class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#1F8FB2]">
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-[#1F8FB2]">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="bg-[#1F8FB2] text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-[#1a7a99]">Search</button>
            @if(request('search') || request('status'))
            <a href="{{ route('partner.properties.apartments') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Clear</a>
            @endif
        </form>
    </div>

    <!-- Bulk Action Bar -->
    <div id="bulkActionBar" class="hidden bg-[#1F8FB2] rounded-lg p-4 border border-[#1a7a99] shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
            <div class="flex items-center gap-2 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="selectedCount">0</span> item(s) selected
            </div>
            <div class="flex items-center gap-2">
                <button onclick="bulkActivate()" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:bg-green-600 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Activate
                </button>
                <button onclick="bulkDeactivate()" class="px-4 py-2 bg-yellow-500 text-white rounded-lg text-sm font-medium hover:bg-yellow-600 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    Deactivate
                </button>
                <button onclick="bulkDelete()" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
                <button onclick="clearSelection()" class="px-4 py-2 bg-white/20 text-white rounded-lg text-sm font-medium hover:bg-white/30 transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        @if($properties->total() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="w-4 h-4 rounded border-gray-300 text-[#1F8FB2] focus:ring-[#1F8FB2] cursor-pointer">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Property</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($properties as $property)
                    <tr class="hover:bg-gray-50 transition property-row">
                        <td class="px-4 py-3">
                            <input type="checkbox" class="property-checkbox w-4 h-4 rounded border-gray-300 text-[#1F8FB2] focus:ring-[#1F8FB2] cursor-pointer" value="{{ $property['id'] }}" onchange="updateSelection()">
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                    @if($property['image'])
                                    <img src="{{ asset('storage/' . $property['image']) }}" alt="{{ $property['title'] }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('partner.properties.views', $property['id']) }}" class="text-sm font-medium text-gray-800 hover:text-[#1F8FB2] truncate block max-w-[200px]">
                                        {{ $property['title'] ?? 'Untitled' }}
                                    </a>
                                    <p class="text-xs text-gray-400 mt-0.5">ID: #{{ $property['id'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $property['city'] ?? 'Not specified' }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-semibold text-green-600">${{ number_format($property['adult_price_usd'] ?? 0, 2) }}</div>
                            <div class="text-xs text-gray-400">per night</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ ($property['status'] ?? 'active') === 'active' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ ($property['status'] ?? 'active') === 'active' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                                {{ ucfirst($property['status'] ?? 'Active') }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('partner.properties.views', $property['id']) }}" class="p-2 text-gray-500 hover:text-[#1F8FB2] hover:bg-blue-50 rounded-lg transition" title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('partner.properties.edit', $property['id']) }}" class="p-2 text-gray-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="deleteProperty({{ $property['id'] }})" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Table Footer with Pagination -->
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3">
                <p class="text-sm text-gray-500">
                    Showing {{ $properties->firstItem() ?? 0 }} to {{ $properties->lastItem() ?? 0 }} of {{ $properties->total() }} apartment(s)
                </p>
                @if($properties->hasPages())
                <div class="flex items-center gap-1">
                    @if($properties->onFirstPage())
                        <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $properties->previousPageUrl() }}&search={{ request('search') }}&status={{ request('status') }}" class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Previous</a>
                    @endif

                    @foreach($properties->getUrlRange(max(1, $properties->currentPage() - 2), min($properties->lastPage(), $properties->currentPage() + 2)) as $page => $url)
                        @if($page == $properties->currentPage())
                            <span class="px-3 py-1.5 text-sm text-white bg-[#1F8FB2] rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}&search={{ request('search') }}&status={{ request('status') }}" class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($properties->hasMorePages())
                        <a href="{{ $properties->nextPageUrl() }}&search={{ request('search') }}&status={{ request('status') }}" class="px-3 py-1.5 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Next</a>
                    @else
                        <span class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">Next</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <p class="text-gray-500 text-sm mb-3">No apartments found</p>
            <a href="{{ route('partner.list-your-property') }}" class="text-[#1F8FB2] text-sm hover:underline">Add your first apartment</a>
        </div>
        @endif
    </div>
</div>

<script>
// Selection Management
function getSelectedIds() {
    return Array.from(document.querySelectorAll('.property-checkbox:checked')).map(cb => parseInt(cb.value));
}

function updateSelection() {
    const checkboxes = document.querySelectorAll('.property-checkbox');
    const checkedBoxes = document.querySelectorAll('.property-checkbox:checked');
    const selectAll = document.getElementById('selectAll');
    const bulkActionBar = document.getElementById('bulkActionBar');
    const selectedCount = document.getElementById('selectedCount');

    selectAll.checked = checkboxes.length > 0 && checkboxes.length === checkedBoxes.length;
    selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < checkboxes.length;

    if (checkedBoxes.length > 0) {
        bulkActionBar.classList.remove('hidden');
        selectedCount.textContent = checkedBoxes.length;
    } else {
        bulkActionBar.classList.add('hidden');
    }
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    document.querySelectorAll('.property-checkbox').forEach(cb => cb.checked = selectAll.checked);
    updateSelection();
}

function clearSelection() {
    document.getElementById('selectAll').checked = false;
    document.querySelectorAll('.property-checkbox').forEach(cb => cb.checked = false);
    updateSelection();
}

// Bulk Actions
function bulkAction(action, confirmTitle, confirmText, successMessage) {
    const selectedIds = getSelectedIds();
    if (selectedIds.length === 0) return;

    Swal.fire({
        title: confirmTitle,
        text: confirmText.replace('{count}', selectedIds.length),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: action === 'delete' ? '#ef4444' : '#1F8FB2',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Proceed',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/partner/properties/bulk-update', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    property_ids: selectedIds,
                    action: action
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message || successMessage,
                        icon: 'success',
                        confirmButtonColor: '#1F8FB2'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Operation failed.',
                        icon: 'error',
                        confirmButtonColor: '#1F8FB2'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#1F8FB2'
                });
            });
        }
    });
}

function bulkDelete() {
    bulkAction('delete', 'Delete Selected Properties?', 'Are you sure you want to delete {count} properties? This action cannot be undone.', 'Properties deleted successfully.');
}

function bulkActivate() {
    bulkAction('activate', 'Activate Selected Properties?', 'Are you sure you want to activate {count} properties?', 'Properties activated successfully.');
}

function bulkDeactivate() {
    bulkAction('deactivate', 'Deactivate Selected Properties?', 'Are you sure you want to deactivate {count} properties?', 'Properties deactivated successfully.');
}

// Single Delete
function deleteProperty(propertyId) {
    Swal.fire({
        title: 'Delete Property?',
        text: 'Are you sure you want to delete this property? This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
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
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Property has been deleted successfully.',
                        icon: 'success',
                        confirmButtonColor: '#1F8FB2'
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Failed to delete property.',
                        icon: 'error',
                        confirmButtonColor: '#1F8FB2'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#1F8FB2'
                });
            });
        }
    });
}
</script>
@endsection
