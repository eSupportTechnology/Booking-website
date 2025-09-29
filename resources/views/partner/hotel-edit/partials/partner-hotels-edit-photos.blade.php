@extends('partner.partner-layout')

@section('title', ' Hotels Photos | ' . config('domains.app_name'))

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="{ step: 1 }">
    <!-- ✅ Static Progress Bar (100%) -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9]  h-2 w-full"></div>
    </div>
    <div>
        <input type="hidden" id="propertyId" value="{{ $property->id }}">
    </div>
    <!-- ✅ Single Step Section (no condition needed) -->
    <div class="px-4 py-8 mt-2 w-full max-w-6xl mx-auto lg:ml-24 space-y-6">

        <section class="px-4 py-6 md:px-8 lg:px-16 flex justify-center">
            <div class="w-full max-w-6xl">
                <h2 class="text-xl md:text-2xl font-bold text-black mb-6 text-left mt-12">What does your place look
                    like?</h2>

               <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
                <!-- 📸 Upload Area -->
                <div class="border rounded-lg p-6 bg-white shadow-sm">
                    <!-- Existing photos -->
                    @php
                        $photos = $property->files()->where('file_type', 'image')->get();
                    @endphp
                    @if($photos->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Current Photos ({{ $photos->count() }})</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($photos as $index => $photo)
                            <div class="relative group border rounded overflow-hidden">
                                @if($index === 0)
                                <span class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10">Main Photo</span>
                                @else
                                <button onclick="setPrimaryPhoto({{ $photo->id }})"
                                    class="absolute bottom-1 right-1 bg-blue-600 text-white text-xs px-2 py-1 rounded hover:bg-blue-700">
                                    Set Main
                                </button>
                                @endif
                                
                                <button onclick="deletePhoto({{ $photo->id }})"
                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-700">
                                    ×
                                </button>
                                
                                <img src="{{ asset('storage/' . $photo->path) }}" 
                                     alt="Property Photo" 
                                     class="w-full h-32 object-cover">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <p class="font-semibold text-gray-800 mb-2">Upload at least 3 photos of your property.</p>
                    <p class="text-sm text-gray-600 mb-4">
                        The more you upload, the more likely you are to get bookings. You can add more later.
                    </p>

                    <!-- Drag and drop area -->
                    <div class="border border-dashed border-gray-400 rounded-lg p-6 text-center bg-gray-50 mb-6"
                         id="dropZone">
                        <div class="mb-4">
                            <!-- Optionally add a camera SVG -->
                        </div>
                        <p class="text-gray-700 font-medium mb-2">Drag and drop or</p>

                        <label
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 border border-gray-800 rounded cursor-pointer hover:bg-gray-50 hover:text-black transition"
                            for="fileInput">
                            <img src="{{ asset('assets/mdi_camera-outline.svg') }}" alt="Upload" class="w-4 h-4" />
                            <span>Upload photos</span>
                        </label>
                        <input id="fileInput" type="file" multiple accept="image/*" class="hidden" />
                        <p class="text-xs text-gray-500 mt-2">
                            jpg/jpeg, png, or webp, max 5 images, max 5MB each
                        </p>
                        <p class="text-xs text-red-500 mt-1">
                            ⚠️ Large files may take longer to upload
                        </p>
                    </div>

                    <!-- New photo previews -->
                    <div id="photoPreview" class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4"></div>

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('partner.hotels.edit.overview', $property->id) }}">
                            <button
                                class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                                ←
                            </button>
                        </a>

                        <button id="continueBtn" disabled
                            class="px-6 py-2 text-white rounded bg-gray-400 cursor-not-allowed">
                            Continue
                        </button>
                    </div>
                </div>

                <!-- ℹ️ Tips Box -->
                <div>
                    <div class="bg-white border rounded-none p-4 shadow-sm relative text-sm">
                        <h3 class="font-semibold text-gray-800 mb-2 text-base">
                            What if I don't have professional photos?
                        </h3>
                        <p class="text-gray-600 mb-2">
                            No problem! You can use a smartphone or a digital camera. Here are some tips for taking great photos.
                        </p>
                        <a href="#" class="text-[#3CC0E9] hover:underline block mb-2">
                            Here are some tips for taking great photos of your property
                        </a>
                        <p class="text-gray-600">
                            If you don’t know who took a photo, it's best not to use it. Only use photos others have
                            taken if you have permission.
                        </p>
                    </div>
                </div>
            </div>
        </section>


    </div>

</div>
<script>
    const urlParams = new URLSearchParams(window.location.search);

    document.addEventListener('DOMContentLoaded', function() {
        // Check if user is authenticated
        if (!document.querySelector('meta[name="csrf-token"]')) {
            console.error('CSRF token not found. User may not be authenticated.');
            Swal.fire({
                icon: 'warning',
                title: 'Authentication Required',
                text: 'Please log in to continue.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '{{ url("/partner/login") }}';
            });
            return;
        }

        const uploadedPhotos = [];
        const fileInput = document.getElementById('fileInput');
        const dropZone = document.getElementById('dropZone');
        const previewContainer = document.getElementById('photoPreview');
        const continueButton = document.getElementById('continueBtn');
        const propertyId = document.getElementById('propertyId').value;
        const propertyType = urlParams.get('propertyType');

        // Initialize with empty array for new photos only
        // Existing photos are shown separately above

        // Function to clean up oversized files
        function cleanupOversizedFiles() {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const oversizedCount = uploadedPhotos.filter(photo => photo.file.size > maxSize).length;

            if (oversizedCount > 0) {
                // Remove oversized files
                uploadedPhotos = uploadedPhotos.filter(photo => photo.file.size <= maxSize);

                Swal.fire({
                    icon: 'warning',
                    title: 'Large Files Removed',
                    text: `${oversizedCount} file(s) exceeded 5MB and were automatically removed.`,
                    confirmButtonText: 'OK'
                });

                renderPreview();
            }
        }

        fileInput.addEventListener('change', handleUpload);
        dropZone.addEventListener('dragover', (e) => e.preventDefault());
        dropZone.addEventListener('drop', handleDrop);

        // Clean up any oversized files that might exist
        cleanupOversizedFiles();

        function handleUpload(event) {
            const files = Array.from(event.target.files).slice(0, 5 - uploadedPhotos.length);
            addFiles(files);
        }

        function handleDrop(event) {
            event.preventDefault();
            const files = Array.from(event.dataTransfer.files).slice(0, 5 - uploadedPhotos.length);
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

                // Validate file size (5MB = 5 * 1024 * 1024 bytes)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: `${file.name} is too large (${(file.size / (1024 * 1024)).toFixed(2)} MB). Maximum file size is 5MB.`,
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Check if we already have 5 photos
                if (uploadedPhotos.length >= 5) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maximum Photos Reached',
                        text: 'You can only upload a maximum of 5 photos.',
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
            const maxSize = 5 * 1024 * 1024; // 5MB

            uploadedPhotos.forEach((photo, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative group border rounded overflow-hidden';

                if ((photo.existing && photo.isPrimary) || (!photo.existing && index === 0)) {
                    const mainLabel = document.createElement('span');
                    mainLabel.className = 'absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10';
                    mainLabel.textContent = 'Main Photo';
                    wrapper.appendChild(mainLabel);
                }

                // Add set as primary button for existing photos
                if (photo.existing && !photo.isPrimary) {
                    const primaryBtn = document.createElement('button');
                    primaryBtn.className = 'absolute bottom-1 right-1 bg-blue-600 text-white text-xs px-2 py-1 rounded hover:bg-blue-700';
                    primaryBtn.textContent = 'Set Main';
                    primaryBtn.addEventListener('click', async () => {
                        try {
                            const response = await fetch(`/partner/hotels/${propertyId}/photos/${photo.id}/primary`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });
                            const result = await response.json();
                            if (result.success) {
                                // Update primary status in local array
                                uploadedPhotos.forEach(p => p.isPrimary = false);
                                photo.isPrimary = true;
                                renderPreview();
                            }
                        } catch (error) {
                            console.error('Error setting primary photo:', error);
                        }
                    });
                    wrapper.appendChild(primaryBtn);
                }

                // Add file size indicator only for new files
                if (photo.file) {
                    const sizeLabel = document.createElement('span');
                    sizeLabel.className = 'absolute bottom-1 left-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded';
                    sizeLabel.textContent = `${(photo.file.size / (1024 * 1024)).toFixed(2)} MB`;
                    wrapper.appendChild(sizeLabel);
                }

                const removeBtn = document.createElement('button');
                removeBtn.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-700';
                removeBtn.innerHTML = '×';
                removeBtn.addEventListener('click', async () => {
                    if (photo.existing) {
                        // Delete existing photo from server
                        try {
                            const response = await fetch(`/partner/hotels/${propertyId}/photos/${photo.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });
                            const result = await response.json();
                            if (result.success) {
                                uploadedPhotos.splice(index, 1);
                                renderPreview();
                            }
                        } catch (error) {
                            console.error('Error deleting photo:', error);
                        }
                    } else {
                        uploadedPhotos.splice(index, 1);
                        renderPreview();
                    }
                });

                const img = document.createElement('img');
                img.src = photo.url;
                img.className = 'w-full h-32 object-cover';

                wrapper.appendChild(removeBtn);
                wrapper.appendChild(img);
                previewContainer.appendChild(wrapper);
            });

            // Check if all files are valid and we have at least 3 photos total
            const existingPhotosCount = {{ $property->files()->where('file_type', 'image')->count() }};
            const totalPhotos = existingPhotosCount + uploadedPhotos.length;
            const hasValidFiles = totalPhotos >= 3 &&
                                uploadedPhotos.every(photo => !photo.file || photo.file.size <= maxSize);

            continueButton.disabled = !hasValidFiles;
            continueButton.className = !hasValidFiles ?
                'px-6 py-2 text-white rounded bg-gray-400 cursor-not-allowed' :
                'px-6 py-2 text-white rounded bg-[#3CC0E9] hover:bg-blue-700';
        }

        continueButton.addEventListener('click', async (e) => {
            e.preventDefault();
            if (uploadedPhotos.length < 3) return;

            // Check if any files are too large before uploading
            const maxSize = 5 * 1024 * 1024; // 5MB
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

            // Check if we have existing photos or new photos
            const existingPhotosCount = {{ $property->files()->where('file_type', 'image')->count() }};
            const newPhotos = uploadedPhotos.filter(photo => !photo.existing && photo.file);
            const totalPhotos = existingPhotosCount + newPhotos.length;

            if (totalPhotos < 3) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Minimum 3 photos required',
                    text: 'Please add more photos. You need at least 3 photos total.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (newPhotos.length === 0) {
                // No new photos to upload, just redirect
                window.location.href = `{{ route('partner.hotels.edit.overview', $property->id) }}?uploaded=true&rooms=true&propertyType=${encodeURIComponent(propertyType)}`;
                return;
            }

            const formData = new FormData();
            formData.append('property_id', propertyId);
            newPhotos.forEach((photo, index) => {
                formData.append(`photos[${index}]`, photo.file);
            });

            try {
                console.log('Sending request to:', "{{ url('/partner/property/upload-photos') }}");
                console.log('CSRF Token:', '{{ csrf_token() }}');
                console.log('Property ID:', propertyId);
                console.log('Photos count:', uploadedPhotos.length);

                // Log file details for debugging
                uploadedPhotos.forEach((photo, index) => {
                    console.log(`Photo ${index}:`, {
                        name: photo.file.name,
                        size: photo.file.size,
                        type: photo.file.type,
                        lastModified: photo.file.lastModified
                    });
                });

                const response = await fetch("{{ url('/partner/property/upload-photos') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', Object.fromEntries(response.headers.entries()));

                // Check if response is ok and content type is JSON
                if (!response.ok) {
                    if (response.status === 401 || response.status === 419) {
                        // Authentication or CSRF token error
                        throw new Error('Authentication failed. Please refresh the page and try again.');
                    }

                    // For 422 validation errors, try to get the detailed error message
                    if (response.status === 422) {
                        const errorData = await response.json();
                        console.error('Validation errors:', errorData);

                        if (errorData.errors) {
                            const errorMessages = Object.values(errorData.errors).flat().join(', ');
                            throw new Error(`Validation failed: ${errorMessages}`);
                        } else if (errorData.message) {
                            throw new Error(errorData.message);
                        } else {
                            throw new Error('Validation failed. Please check your input and try again.');
                        }
                    }

                    // For other error statuses, try to get error details
                    if (response.status >= 400) {
                        try {
                            const errorData = await response.json();
                            console.error('Error response:', errorData);
                            if (errorData.message) {
                                throw new Error(errorData.message);
                            }
                        } catch (parseError) {
                            // If we can't parse JSON, use the status text
                            throw new Error(`Request failed: ${response.statusText}`);
                        }
                    }

                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const contentType = response.headers.get('content-type');
                console.log('Content-Type:', contentType);

                if (!contentType || !contentType.includes('application/json')) {
                    // If response is not JSON, get the text and show error
                    const textResponse = await response.text();
                    console.error('Non-JSON response:', textResponse);

                    // Check if it's an authentication page
                    if (textResponse.includes('login') || textResponse.includes('Login') || textResponse.includes('auth')) {
                        throw new Error('Your session has expired. Please log in again.');
                    }

                    throw new Error('Server returned non-JSON response. Please try again.');
                }

                const result = await response.json();
                console.log('Response data:', result);

                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Photos uploaded successfully',
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        timer: 3000
                    });
                    setTimeout(() => {
                        window.location.href = `{{ route('partner.hotels.edit.overview', $property->id) }}?uploaded=true&rooms=true&propertyType=${encodeURIComponent(propertyType)}`;
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: result.message || 'Upload failed. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            } catch (error) {
                console.error('Upload error:', error);

                // Handle specific authentication errors
                if (error.message.includes('Authentication failed') || error.message.includes('session has expired')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Authentication Required',
                        text: error.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirect to login page
                        window.location.href = '{{ url("/partner/login") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Error',
                        text: error.message || 'An error occurred while uploading. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
</script>

<script>
function deletePhoto(photoId) {
    Swal.fire({
        title: 'Delete Photo?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/partner/hotels/{{ $property->id }}/photos/${photoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', 'Photo has been deleted.', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error!', 'Failed to delete photo.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Network error occurred.', 'error');
            });
        }
    });
}

function setPrimaryPhoto(photoId) {
    fetch(`/partner/hotels/{{ $property->id }}/photos/${photoId}/primary`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Primary photo updated!',
                showConfirmButton: false,
                timer: 1500,
                toast: true,
                position: 'top-end'
            }).then(() => location.reload());
        } else {
            Swal.fire('Error!', 'Failed to set primary photo.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'Network error occurred.', 'error');
    });
}
</script>
@endsection
