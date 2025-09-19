<div class="p-8">
    <div class="mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Property Photos</h3>
        <p class="text-gray-600">Showcase your property with stunning photos</p>
    </div>

    <form id="photos-form" action="{{ route('partner.homes.update.photos', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Upload Area -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl p-8 border-2 border-dashed border-blue-300 text-center hover:border-blue-500 transition-all duration-300">
            <div class="mb-4">
                <i class="fas fa-cloud-upload-alt text-6xl text-blue-500 mb-4"></i>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Upload Your Photos</h4>
                <p class="text-gray-600 mb-4">Drag & drop or click to select photos (minimum 3-5 required)</p>
            </div>
            <input type="file" class="hidden" name="photos[]" multiple accept="image/*" id="photo-upload">
            <label for="photo-upload" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl cursor-pointer inline-block transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                Choose Photos
            </label>
            <p class="text-sm text-gray-500 mt-4">
                <i class="fas fa-info-circle mr-1"></i>
                Supported: JPG, PNG, WebP • Max: 5MB per image
            </p>
        </div>

        <!-- Photo Gallery -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="photo-gallery">
            @if($property->files && $property->files->where('file_type', 'image')->count() > 0)
                @foreach($property->files->where('file_type', 'image') as $photo)
                    <div class="photo-item group relative bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl" data-photo-id="{{ $photo->id }}">
                        <div class="aspect-w-4 aspect-h-3 relative">
                            <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-48 object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <button type="button" class="delete-photo opacity-0 group-hover:opacity-100 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full transform transition-all duration-200 hover:scale-110" data-photo-id="{{ $photo->id }}">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer main-photo-radio peer-checked:text-orange-600">
                                    <input type="radio" name="main_photo" value="{{ $photo->id }}" class="sr-only peer">
                                    <div class="radio-indicator w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-gradient-to-r peer-checked:from-yellow-400 peer-checked:to-orange-500 peer-checked:border-orange-500">
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-600">Set as Main</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Preview for new uploads -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="photo-preview"></div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Photos
            </button>
        </div>
    </form>
</div>

<script>
// Handle photo upload preview
document.getElementById('photo-upload').addEventListener('change', function(e) {
    const files = e.target.files;
    const preview = document.getElementById('photo-preview');
    preview.innerHTML = ''; // Clear previous previews

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        // Validate file size and type
        if (file.size > 5 * 1024 * 1024) {
            alert(`File ${file.name} is too large. Maximum size is 5MB.`);
            continue;
        }

        if (!file.type.startsWith('image/')) {
            alert(`File ${file.name} is not a valid image.`);
            continue;
        }

        reader.onerror = function() {
            console.error('Error reading file:', file.name);
        };

        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'photo-item group relative bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl';

            const container = document.createElement('div');
            container.className = 'aspect-w-4 aspect-h-3 relative';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-48 object-cover';
            img.alt = 'Photo preview';

            const badge = document.createElement('div');
            badge.className = 'absolute top-2 right-2';
            badge.innerHTML = '<span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium"><i class="fas fa-plus mr-1"></i>New</span>';

            container.appendChild(img);
            container.appendChild(badge);

            const controls = document.createElement('div');
            controls.className = 'p-4';
            controls.innerHTML = `<div class="flex items-center justify-between"><label class="flex items-center cursor-pointer"><input type="radio" name="main_photo_new" value="${i}" class="sr-only"><div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div><span class="ml-2 text-sm font-medium text-gray-600">Set as Main</span></label></div>`;

            div.appendChild(container);
            div.appendChild(controls);
            preview.appendChild(div);
        };

        reader.readAsDataURL(file);
    }
});

// Main photo radio selection works natively

// Handle photo deletion
document.addEventListener('click', function(e) {
    if (e.target.closest('.delete-photo')) {
        const button = e.target.closest('.delete-photo');
        const photoId = button.dataset.photoId;
        const photoItem = button.closest('.photo-item');

        if (confirm('Are you sure you want to delete this photo?')) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                alert('CSRF token not found');
                return;
            }

            fetch(`{{ route('partner.homes.delete.photo', ['property' => $property->id, 'photo' => '__PHOTO_ID__']) }}`.replace('__PHOTO_ID__', photoId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    photoItem.remove();
                    showNotification('Photo deleted successfully', 'success');
                } else {
                    showNotification('Failed to delete photo', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to delete photo', 'error');
            });
        }
    }
});
</script>
