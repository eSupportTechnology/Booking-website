@extends('partner.partner-layout')

@section('title', ' Hotels Videos | ' . config('domains.app_name'))

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="{ step: 1, videoUrl: null }" class="  flex items-center justify-center py-10">

    <!-- ✅ White Container -->
    <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg p-8 space-y-6 mx-auto lg:ml-32 lg:mt-6 ">
        <h2 class="text-xl font-semibold">Upload Property Video</h2>
        <p class="text-base text-gray-600">Showcase your property with a short video (max 100MB, MP4 recommended).</p>
        
        <!-- Upload Section -->
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
            <template x-if="!videoUrl">
                <label class="cursor-pointer flex flex-col items-center space-y-2">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16V4m0 0L3 8m4-4l4 4m6 12v-12m0 0l-4 4m4-4l4 4" />
                    </svg>
                    <span class="text-gray-600 font-semibold">Click to upload video</span>
                    <input type="file" accept="video/*" class="hidden"
                        @change="videoUrl = URL.createObjectURL($event.target.files[0])">
                </label>
            </template>

            <!-- Video Preview -->
            <template x-if="videoUrl">
                <div class="relative mt-4">
                    <video controls class="w-full rounded-lg shadow-md">
                        <source :src="videoUrl" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <!-- Delete Button -->
                    <button @click="videoUrl = null"
                        class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600">
                        ✕
                    </button>
                </div>
            </template>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-6 flex justify-between">
            <a href="{{ route('partner.hotels.edit') }}">
                <button class="border border-[#3CC0E9] text-blue-600 hover:bg-blue-50 font-semibold py-2 px-4 rounded">
                    ←
                </button>
            </a>
            <a href="{{ route('partner.hotels.edit') }}">
                <button
                    class="px-6 py-2 bg-[#3CC0E9] font-semibold text-white rounded hover:bg-blue-700">
                    Submit
                </button>
            </a>
        </div>
    </div>
</div>
@endsection
