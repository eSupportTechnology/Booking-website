@extends('frontend.partner-layout')

@section('title', 'Alternative Places Entire Types')

@section('content')


<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<!-- ✅ Static Progress Bar (100%) -->
<div class="w-full bg-gray-200 h-2">
    <div class="bg-[#3CC0E9]  h-2 w-full"></div>
</div>
<div>
    <input type="hidden" id="propertyId" value="{{ $property->id }}">
</div>

<div class="px-4 py-8 mt-2 w-full max-w-6xl mx-auto lg:ml-24 space-y-6">
    <section class="px-4 py-6 md:px-8 lg:px-16 flex justify-center">
        <div class="w-full max-w-6xl">
            <h2 class="text-xl md:text-2xl font-bold text-black mb-6 text-left mt-12">
                What does your place look like?
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
                <!-- 📸 Upload Area -->
                <div class="border rounded-lg p-6 bg-white shadow-sm">
                    <p class="font-semibold text-gray-800 mb-2">Upload at least 5 photos of your property.</p>
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
                            jpg/jpeg or png, max 5 images, max 5MB each
                        </p>
                    </div>

                    <!-- Uploaded photo previews -->
                    <div id="photoPreview" class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4"></div>

                    <div class="mt-6 flex justify-between">
                        <a href="{{ url('/partner-homes-edit/' . $property->id) }}">
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
        </div>
    </section>
</div>

<!-- ✅ Pure JS Upload Logic -->
<script>
    const urlParams = new URLSearchParams(window.location.search);
    document.addEventListener('DOMContentLoaded', function () {
        const uploadedPhotos = [];
        const fileInput = document.getElementById('fileInput');
        const dropZone = document.getElementById('dropZone');
        const previewContainer = document.getElementById('photoPreview');
        const continueButton = document.getElementById('continueBtn');
        const propertyId = document.getElementById('propertyId').value;
        const propertyType = urlParams.get('propertyType');

        fileInput.addEventListener('change', handleUpload);
        dropZone.addEventListener('dragover', (e) => e.preventDefault());
        dropZone.addEventListener('drop', handleDrop);

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
            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const url = URL.createObjectURL(file);
                uploadedPhotos.push({ file, url });
            });
            renderPreview();
        }

        function renderPreview() {
            previewContainer.innerHTML = '';
            uploadedPhotos.forEach((photo, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'relative group border rounded overflow-hidden';

                if (index === 0) {
                    const mainLabel = document.createElement('span');
                    mainLabel.className = 'absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10';
                    mainLabel.textContent = 'Main Photo';
                    wrapper.appendChild(mainLabel);
                }

                const removeBtn = document.createElement('button');
                removeBtn.className = 'absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75';
                removeBtn.innerHTML = '&times;';
                removeBtn.addEventListener('click', () => {
                    uploadedPhotos.splice(index, 1);
                    renderPreview();
                });

                const img = document.createElement('img');
                img.src = photo.url;
                img.className = 'w-full h-32 object-cover';

                wrapper.appendChild(removeBtn);
                wrapper.appendChild(img);
                previewContainer.appendChild(wrapper);
            });

            continueButton.disabled = uploadedPhotos.length < 3;
            continueButton.className = uploadedPhotos.length < 3
                ? 'px-6 py-2 text-white rounded bg-gray-400 cursor-not-allowed'
                : 'px-6 py-2 text-white rounded bg-[#3CC0E9] hover:bg-blue-700';
        }

        continueButton.addEventListener('click', async (e) => {
            e.preventDefault();
            if (uploadedPhotos.length < 3) return;

            const formData = new FormData();
            formData.append('property_id', propertyId);
            uploadedPhotos.forEach((photo, index) => {
                formData.append(`photos[${index}]`, photo.file);
            });

            try {
                const response = await fetch("{{ url('/partner/property/upload-photos') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    alert("Photos uploaded successfully!");
                    window.location.href = `{{ url('/partner-homes-edit/' . $property->id) }}?uploaded=true&rooms=true&propertyType=${encodeURIComponent(propertyType)}`;
                }
                else {
                    alert("Upload failed.");
                }
            } catch (error) {
                console.error(error);
                alert("An error occurred while uploading.");
            }
        });
    });
</script>


@endsection