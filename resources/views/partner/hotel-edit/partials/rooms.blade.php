<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold">Hotel Rooms</h3>
        <button id="add-room-btn" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            Add New Room
        </button>
    </div>
    
    <div id="rooms-container" class="space-y-6">
        @if(isset($rooms) && $rooms->count() > 0)
            @foreach($rooms as $roomTypeId => $roomGroup)
                @php $firstRoom = $roomGroup->first(); @endphp
                <div class="room-card border border-gray-200 rounded-lg p-4" data-room-type-id="{{ $roomTypeId }}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $firstRoom->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $roomGroup->count() }} room(s) of this type</p>
                        </div>
                        <div class="flex space-x-2">
                            <button class="edit-room-btn text-blue-600 hover:text-blue-800 text-sm font-medium" data-room-type-id="{{ $roomTypeId }}">
                                Edit
                            </button>
                            <button class="delete-room-btn text-red-600 hover:text-red-800 text-sm font-medium" data-room-type-id="{{ $roomTypeId }}">
                                Delete
                            </button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Max Guests:</span>
                            <span class="font-medium">{{ $firstRoom->max_guests }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Beds:</span>
                            <span class="font-medium">{{ $firstRoom->bed_count }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Bathroom:</span>
                            <span class="font-medium capitalize">{{ $firstRoom->bathroom_type }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Price:</span>
                            <span class="font-medium">{{ $firstRoom->currency }} {{ $firstRoom->price_per_night }}/night</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No rooms added yet. Click "Add New Room" to get started.</p>
            </div>
        @endif
    </div>
</div>

<!-- Add/Edit Room Modal -->
<div id="room-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b">
                <h3 id="modal-title" class="text-lg font-semibold">Add New Room</h3>
            </div>
            
            <form id="room-form" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="room-id" name="room_id">
                
                <div>
                    <label for="room-name" class="block text-sm font-medium text-gray-700 mb-1">Room Name *</label>
                    <input type="text" id="room-name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="max-guests" class="block text-sm font-medium text-gray-700 mb-1">Max Guests *</label>
                        <input type="number" id="max-guests" name="max_guests" min="1" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="bed-count" class="block text-sm font-medium text-gray-700 mb-1">Bed Count *</label>
                        <input type="number" id="bed-count" name="bed_count" min="1" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <label for="bathroom-type" class="block text-sm font-medium text-gray-700 mb-1">Bathroom Type *</label>
                    <select id="bathroom-type" name="bathroom_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Type</option>
                        <option value="private">Private</option>
                        <option value="shared">Shared</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price-per-night" class="block text-sm font-medium text-gray-700 mb-1">Price per Night *</label>
                        <input type="number" id="price-per-night" name="price_per_night" min="0" step="0.01" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 mb-1">Currency *</label>
                        <select id="currency" name="currency" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="LKR">LKR</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" id="cancel-room-btn" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Save Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('room-modal');
    const form = document.getElementById('room-form');
    const addBtn = document.getElementById('add-room-btn');
    const cancelBtn = document.getElementById('cancel-room-btn');
    
    // Show modal for adding new room
    addBtn.addEventListener('click', function() {
        document.getElementById('modal-title').textContent = 'Add New Room';
        form.reset();
        document.getElementById('room-id').value = '';
        modal.classList.remove('hidden');
    });
    
    // Hide modal
    function hideModal() {
        modal.classList.add('hidden');
    }
    
    cancelBtn.addEventListener('click', hideModal);
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            hideModal();
        }
    });
    
    // Handle room form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving...';
        
        const url = document.getElementById('room-id').value ? 
            `/partner/hotels/{{ $property->id }}/rooms/${document.getElementById('room-id').value}` :
            `/partner/hotels/{{ $property->id }}/rooms`;
        
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showMessage(data.message, 'success');
                hideModal();
                location.reload(); // Refresh to show updated rooms
            } else {
                window.showMessage(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showMessage('An error occurred while saving room', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
    
    // Handle edit room buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-room-btn')) {
            const roomTypeId = e.target.dataset.roomTypeId;
            // In a real implementation, you would fetch room data and populate the form
            document.getElementById('modal-title').textContent = 'Edit Room';
            document.getElementById('room-id').value = roomTypeId;
            modal.classList.remove('hidden');
        }
        
        if (e.target.classList.contains('delete-room-btn')) {
            const roomTypeId = e.target.dataset.roomTypeId;
            
            if (confirm('Are you sure you want to delete this room type? This action cannot be undone.')) {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                
                fetch(`/partner/hotels/{{ $property->id }}/rooms/${roomTypeId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.showMessage(data.message, 'success');
                        e.target.closest('.room-card').remove();
                    } else {
                        window.showMessage(data.message || 'An error occurred', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.showMessage('An error occurred while deleting room', 'error');
                });
            }
        }
    });
});
</script>