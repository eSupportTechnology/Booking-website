@extends('frontend.partner-layout')

@section('title', 'Alternative Places Entire Types')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- ✅ Static Progress Bar (100%) -->
    <div class="w-full bg-gray-200 h-2">
        <div class="bg-[#3CC0E9]  h-2 w-full"></div>
    </div>

    <!-- ✅ Single Step Section (no condition needed) -->
    <div class="px-4 py-8 mt-2 w-full max-w-6xl mx-auto lg:ml-24 space-y-6">

        <section class="px-4 py-6 md:px-8 lg:px-16 flex justify-center" x-data="{
            uploadedPhotos: [],
            handleUpload(event) {
                const files = Array.from(event.target.files).slice(0, 5 - this.uploadedPhotos.length);
                files.forEach(file => {
                    const url = URL.createObjectURL(file);
                    this.uploadedPhotos.push({ file, url });
                });
            },
            handleUploadDrop(event) {
                const dt = event.dataTransfer;
                if (!dt) return;
                const files = Array.from(dt.files).slice(0, 5 - this.uploadedPhotos.length);
                files.forEach(file => {
                    const url = URL.createObjectURL(file);
                    this.uploadedPhotos.push({ file, url });
                });
            },
            removePhoto(index) {
                this.uploadedPhotos.splice(index, 1);
            }
        }">
            <div class="w-full max-w-6xl">
                <h2 class="text-xl md:text-2xl font-bold text-black mb-6 text-left mt-12">What does your luxury tent look like?</h2>

                <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6 items-start">
                    <!-- 📸 Photo Upload Area -->
                    <div class="border rounded-lg p-6 bg-white shadow-sm">
                        <p class="font-semibold text-gray-800 mb-2">Upload at least 5 photos of your property.</p>
                        <p class="text-sm text-gray-600 mb-4">The more you upload, the more likely you are to get
                            bookings. You can add more later.</p>

                        <!-- Upload box with drag and drop -->
                        <div class="border border-dashed border-gray-400 rounded-lg p-6 text-center bg-gray-50 mb-6"
                            @dragover.prevent @drop.prevent="handleUploadDrop($event)">
                            <div class="mb-4">
                                <!-- camera SVG -->
                            </div>
                            <p class="text-gray-700 font-medium mb-2">Drag and drop or</p>

                            <label
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-800 border border-gray-800 rounded cursor-pointer hover:bg-gray-50 hover:text-black transition"
                                for="fileInput">
                                <img src="{{ asset('assets/mdi_camera-outline.svg') }}" alt="Upload"
                                    class="w-4 h-4" />
                                <span>Upload photos</span>
                            </label>
                            <input id="fileInput" type="file" multiple accept="image/*" class="hidden"
                                @change="handleUpload" />


                            <p class="text-xs text-gray-500 mt-2">jpg/jpeg or png, maximum 47MB each, max 5 images</p>
                        </div>

                        <!-- Uploaded photo previews -->
                        <!-- Uploaded photo previews -->
                        <template x-if="uploadedPhotos.length > 0">
                            <div>
                                <!-- 📝 Instructions placed properly above the grid -->
                                <p class="text-sm font-semibold text-gray-700 mb-1">Choose a main photo that will give a
                                    good first impression</p>
                                <p class="text-sm font-semibold text-gray-700 mb-4">Click and drag the photos to arrange
                                    them in the order you would like the guests to see them</p>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    <template x-for="(photo, index) in uploadedPhotos" :key="index">
                                        <div class="relative group border rounded overflow-hidden" draggable="true"
                                            @dragstart="event.dataTransfer.setData('text/plain', index)"
                                            @dragover.prevent
                                            @drop="const from = Number(event.dataTransfer.getData('text/plain'));
                    const to = index;
                    if (from !== to) {
                      const moved = uploadedPhotos.splice(from, 1)[0];
                      uploadedPhotos.splice(to, 0, moved);
                    }">
                                            <!-- Badge for main photo -->
                                            <template x-if="index === 0">
                                                <span
                                                    class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded z-10">Main
                                                    Photo</span>
                                            </template>

                                            <!-- Remove Button -->
                                            <button @click="removePhoto(index)"
                                                class="absolute top-1 right-1 bg-black bg-opacity-50 text-white rounded-full p-1 z-10 hover:bg-opacity-75">
                                                &times;
                                            </button>

                                            <img :src="photo.url" alt="Uploaded photo"
                                                class="w-full h-32 object-cover" />
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>


                    </div>

                    <!-- ℹ️ Tips Box -->
                    <div x-data="{ showTips: true }">
                        <div x-show="showTips" x-transition
                            class="bg-white border rounded-none p-4 shadow-sm relative text-sm">

                            <button @click="showTips = false"
                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg"
                                aria-label="Close">
                                &times;
                            </button>

                            <h3 class="font-semibold text-gray-800 mb-2 text-base">What if I don't have professional
                                photos?</h3>
                            <p class="text-gray-600 mb-2">
                                No problem! You can use a smartphone or a digital camera.Here are some tips for taking
                                great photos of your property
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

                    <!-- Navigation Buttons -->
                    <div class="mt-6 flex justify-between">

                        <a href="#">
                            <button @click="step--"
                                class="border border-[#3CC0E9]  text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">←
                            </button></a>
                        <a href="#">
                            <button :disabled="uploadedPhotos.length < 3"
                                :class="{
                                    'px-4 py-3 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700cursor-pointer opacity-100 hover:bg-blue-700': uploadedPhotos
                                        .length >= 3,
                                    'bg-gray-400 rounded cursor-not-allowed opacity-50': uploadedPhotos.length < 3
                                }"
                                class="px-6 py-2 text-white rounded">
                                Continue
                            </button></a>
                    </div>
                </div>
        </section>


    </div>



@endsection
