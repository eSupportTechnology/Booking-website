@extends('partner.partner-layout')

@section('title', 'Create Property - Photos | ' . config('domains.app_name'))

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="max-w-6xl mx-auto px-4 py-8">
    @include('property.components.progress-bar', ['currentStep' => 5])

    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Property Photos</h2>
        <form id="step5Form" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <h3 class="text-lg font-semibold mb-4">Upload Photos</h3>
                <p class="text-gray-600 mb-2">Upload at least 3 high-quality photos of your property</p>
                <p class="text-sm text-gray-500 mb-6">The more you upload, the more likely you are to get bookings. You can add more later.</p>

                <div class="mb-6">
                    <div id="dropZone" class="border-2 border-dashed border-gray-400 rounded-lg p-8 text-center bg-gray-50 hover:border-blue-500 transition-colors">
                        <div class="mb-4">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <p class="text-gray-700 font-medium mb-2">Drag and drop or</p>
                        <label for="photos" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 border border-gray-800 rounded hover:bg-gray-50 hover:text-black transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Upload photos</span>
                            <input type="file" class="hidden" id="photos" name="photos[]" multiple accept="image/jpeg,image/jpg,image/png,image/webp">
                        </label>
                        <p class="text-xs text-gray-500 mt-2">jpg/jpeg, png, or webp, max 5MB each</p>
                        <p class="text-xs text-red-500 mt-1">⚠️ Large files may take longer to upload</p>
                    </div>
                </div>

                <div id="photoPreview" class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6"></div>

                @if(isset($existingPhotos) && $existingPhotos->count() > 0)
                <div class="mt-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-1">Choose a main photo that will give a good first impression</h4>
                    <p class="text-sm font-semibold text-gray-700 mb-4">Click and drag the photos to arrange them in the order you would like the guests to see them</p>
                </div>
                @endif
            </div>

            @if(isset($existingPhotos) && $existingPhotos->count() > 0)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4">Existing Photos ({{ $existingPhotos->count() }})</h3>
                <div id="existingPhotosContainer" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($existingPhotos as $index => $photo)
                    <div class="relative group border rounded overflow-hidden existing-photo" data-photo-id="{{ $photo->id }}" draggable="true">
                        @if($index === 0)
                        <span class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10">Main Photo</span>
                        @endif
                        <img src="{{ asset('storage/' . $photo->path) }}" class="w-full h-32 object-cover">
                        <button type="button" class="absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75" onclick="deletePhoto({{ $photo->id }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex justify-between mt-8">
                <a href="{{ route('property.create.step', 4) }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition-colors">Previous</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Next Step</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadedPhotos = [];
    const photoInput = document.getElementById('photos');
    const dropZone = document.getElementById('dropZone');
    const previewContainer = document.getElementById('photoPreview');
    const continueButton = document.querySelector('button[type="submit"]');
    const existingCount = {{ isset($existingPhotos) ? $existingPhotos->count() : 0 }};
    const maxSize = 5 * 1024 * 1024; // 5MB

    // File input change handler
    photoInput.addEventListener('change', handleUpload);

    // Drag and drop handlers
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        addFiles(files);
    });

    function handleUpload(event) {
        const files = Array.from(event.target.files);
        addFiles(files);
    }

    function addFiles(files) {
        let validFilesAdded = 0;

        files.forEach(file => {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: `${file.name} is not an image file. Please select only image files.`,
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Validate file size (5MB)
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: `${file.name} is too large (${(file.size / (1024 * 1024)).toFixed(2)} MB). Maximum file size is 5MB.`,
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Check if we already have too many photos
            if (uploadedPhotos.length >= 20) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maximum Photos Reached',
                    text: 'You can only upload a maximum of 20 photos.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const url = URL.createObjectURL(file);
            uploadedPhotos.push({
                file,
                url
            });
            validFilesAdded++;
        });

        if (validFilesAdded > 0) {
            renderPreview();
        }
    }

    function renderPreview() {
        previewContainer.innerHTML = '';

        uploadedPhotos.forEach((photo, index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative group border rounded overflow-hidden';
            wrapper.draggable = true;
            wrapper.dataset.index = index;

            if (index === 0 && existingCount === 0) {
                const mainLabel = document.createElement('span');
                mainLabel.className = 'absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10';
                mainLabel.textContent = 'Main Photo';
                wrapper.appendChild(mainLabel);
            }

            // Add file size indicator
            const sizeLabel = document.createElement('span');
            sizeLabel.className = 'absolute bottom-1 left-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded';
            sizeLabel.textContent = `${(photo.file.size / (1024 * 1024)).toFixed(2)} MB`;
            wrapper.appendChild(sizeLabel);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75';
            removeBtn.innerHTML = '&times;';
            removeBtn.addEventListener('click', () => {
                uploadedPhotos.splice(index, 1);
                renderPreview();
            });

            const img = document.createElement('img');
            img.src = photo.url;
            img.className = 'w-full h-32 object-cover';

            // Drag and drop for reordering
            wrapper.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', index);
            });

            wrapper.addEventListener('dragover', (e) => {
                e.preventDefault();
            });

            wrapper.addEventListener('drop', (e) => {
                e.preventDefault();
                const from = parseInt(e.dataTransfer.getData('text/plain'));
                const to = index;
                if (from !== to) {
                    const moved = uploadedPhotos.splice(from, 1)[0];
                    uploadedPhotos.splice(to, 0, moved);
                    renderPreview();
                }
            });

            wrapper.appendChild(removeBtn);
            wrapper.appendChild(img);
            previewContainer.appendChild(wrapper);
        });

        // Enable/disable continue button
        const totalPhotos = uploadedPhotos.length + existingCount;
        const hasValidFiles = totalPhotos >= 3 && uploadedPhotos.every(photo => photo.file.size <= maxSize);

        if (continueButton) {
            continueButton.disabled = !hasValidFiles;
            continueButton.className = !hasValidFiles ?
                'bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed' :
                'bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors';
        }
    }

    // Form submission
    document.getElementById('step5Form').addEventListener('submit', function(e) {
        e.preventDefault();

        const totalPhotos = uploadedPhotos.length + existingCount;

        if (totalPhotos < 3) {
            Swal.fire({
                icon: 'warning',
                title: 'Not Enough Photos',
                text: 'Please upload at least 3 photos total.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Check if any files are too large
        const oversizedFiles = uploadedPhotos.filter(photo => photo.file.size > maxSize);

        if (oversizedFiles.length > 0) {
            const fileNames = oversizedFiles.map(photo => photo.file.name).join(', ');
            Swal.fire({
                icon: 'error',
                title: 'Files Too Large',
                text: `The following files exceed 5MB: ${fileNames}. Please resize them and try again.`,
                confirmButtonText: 'OK'
            });
            return;
        }

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        uploadedPhotos.forEach((photo, index) => {
            formData.append('photos[]', photo.file);
        });

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Uploading...';

        fetch('{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/5" : "/property/create/step/5" }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Photos uploaded successfully',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '{{ ($mode ?? "create") === "edit" ? "/property/{$property->id}/edit/step/6" : "/property/create/step/6" }}';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: data.message || 'Upload failed. Please try again.',
                    confirmButtonText: 'OK'
                });
                submitBtn.disabled = false;
                submitBtn.textContent = 'Next Step';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Upload Error',
                text: 'An error occurred while uploading. Please try again.',
                confirmButtonText: 'OK'
            });
            submitBtn.disabled = false;
            submitBtn.textContent = 'Next Step';
        });
    });

    // Initial render
    renderPreview();
});

function deletePhoto(photoId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/property/photos/${photoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Photo has been deleted.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to delete photo.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the photo.',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}
</script>
@endsection
