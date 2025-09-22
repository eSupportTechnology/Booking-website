<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-6">Basic Property Details</h3>
    
    <form id="basic-details-form" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Property Name *</label>
                <input type="text" id="title" name="title" value="{{ $property->title }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
            
            <div>
                <label for="stars" class="block text-sm font-medium text-gray-700 mb-2">Star Rating</label>
                <select id="stars" name="stars" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Rating</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ $property->stars == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
        </div>
        
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
            <textarea id="description" name="description" rows="4" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                      required>{{ $property->description }}</textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                <input type="text" id="address" name="address" value="{{ $property->address }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
            
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                <input type="text" id="city" name="city" value="{{ $property->city }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                <input type="text" id="country" name="country" value="{{ $property->country }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                       required>
            </div>
            
            <div>
                <label for="zipcode" class="block text-sm font-medium text-gray-700 mb-2">Zip Code</label>
                <input type="text" id="zipcode" name="zipcode" value="{{ $property->zipcode }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Update Basic Details
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('basic-details-form');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        fetch(`/partner/hotels/{{ $property->id }}/basic-details`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showMessage(data.message, 'success');
            } else {
                window.showMessage(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showMessage('An error occurred while updating', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
});
</script>