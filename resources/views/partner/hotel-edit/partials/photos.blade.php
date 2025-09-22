<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-6">Property Photos</h3>
    
    <!-- Upload Section -->
    <div class="mb-8">
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
            <input type="file" id="photo-upload" multiple accept="image/*" class="hidden">
            <div class="space-y-2">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="text-gray-600">
                    <label for="photo-upload" class="cursor-pointer text-blue-600 hover:text-blue-500 font-medium">
                        Click to upload photos
                    </label>
                    <span> or drag and drop</span>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG up to 5MB each (max 10 photos)</p>
            </div>
        </div>
        
        <div class="mt-4 flex justify-end">
            <button id="upload-btn" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50" disabled>
                Upload Photos
            </button>
        </div>
    </div>
    
    <!-- Existing Photos -->
    <div class="space-y-4">
        <h4 class="font-medium text-gray-900">Current Photos</h4>
        
        <div id="photos-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @if(isset($property->photos) && $property->photos->count() > 0)
                @foreach($property->photos as $photo)
                    <div class="photo-item relative group" data-photo-id="{{ $photo->id }}">
                        <img src="{{ Storage::url($photo->photo_path) }}" alt="Property Photo" 
                             class="w-full h-32 object-cover rounded-lg">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                            <div class="flex space-x-2">
                                @if(!$photo->is_primary)
                                    <button class="set-primary-btn bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700" 
                                            data-photo-id="{{ $photo->id }}">
                                        Set Primary
                                    </button>
                                @else
                                    <span class="bg-green-600 text-white px-3 py-1 rounded text-sm">Primary</span>
                                @endif
                                
                                <button class="delete-photo-btn bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700" 
                                        data-photo-id="{{ $photo->id }}">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No photos uploaded yet. Add some photos to showcase your property.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoUpload = document.getElementById('photo-upload');
    const uploadBtn = document.getElementById('upload-btn');
    const photosGrid = document.getElementById('photos-grid');
    let selectedFiles = [];
    
    // Handle file selection
    photoUpload.addEventListener('change', function(e) {
        selectedFiles = Array.from(e.target.files);
        updateUploadButton();
    });
    
    function updateUploadButton() {
        uploadBtn.disabled = selectedFiles.length === 0;
        uploadBtn.textContent = selectedFiles.length > 0 ? 
            `Upload ${selectedFiles.length} Photo${selectedFiles.length > 1 ? 's' : ''}` : 
            'Upload Photos';
    }
    
    // Handle photo upload
    uploadBtn.addEventListener('click', function() {
        if (selectedFiles.length === 0) return;
        
        const formData = new FormData();
        selectedFiles.forEach(file => {
            formData.append('photos[]', file);
        });
        
        const originalText = uploadBtn.textContent;
        uploadBtn.disabled = true;
        uploadBtn.textContent = 'Uploading...';
        
        fetch(`/partner/hotels/{{ $property->id }}/photos`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.showMessage(data.message, 'success');
                location.reload(); // Refresh to show new photos
            } else {
                window.showMessage(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.showMessage('An error occurred while uploading photos', 'error');
        })
        .finally(() => {
            uploadBtn.disabled = false;
            uploadBtn.textContent = originalText;
            photoUpload.value = '';
            selectedFiles = [];
            updateUploadButton();
        });
    });
    
    // Handle photo deletion
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-photo-btn')) {
            const photoId = e.target.dataset.photoId;
            
            if (confirm('Are you sure you want to delete this photo?')) {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                
                fetch(`/partner/hotels/{{ $property->id }}/photos/${photoId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.showMessage(data.message, 'success');
                        e.target.closest('.photo-item').remove();
                    } else {
                        window.showMessage(data.message || 'An error occurred', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.showMessage('An error occurred while deleting photo', 'error');
                });
            }
        }
        
        if (e.target.classList.contains('set-primary-btn')) {
            const photoId = e.target.dataset.photoId;
            
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch(`/partner/hotels/{{ $property->id }}/photos/${photoId}/set-primary`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.showMessage(data.message, 'success');
                    location.reload(); // Refresh to update primary photo status
                } else {
                    window.showMessage(data.message || 'An error occurred', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showMessage('An error occurred while setting primary photo', 'error');
            });
        }
    });
    
    // Drag and drop functionality
    const dropZone = document.querySelector('.border-dashed');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    }
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        selectedFiles = Array.from(files);
        updateUploadButton();
    }
});
</script>