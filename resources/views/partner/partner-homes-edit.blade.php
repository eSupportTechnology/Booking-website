@extends('frontend.partner-layout')

@section('title', 'Alternative Places Entire Types')

@section('content')
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const uploaded = urlParams.get('uploaded');
        const details = urlParams.get('details');
        const detailsLink = document.getElementById('detailsEditLink');
        const detailsIcon = document.getElementById('detailsStatusIcon');
        const photoLink = document.getElementById('photoEditLink');
        const icon = document.getElementById('statusIcon');
        if (uploaded === 'true') {
            // Update the icon (optional - if not already done)
        
            if (icon) {
                icon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                icon.className = "w-6 h-6 md:w-7 md:h-7";
            }

            // Update the photo link
            if (photoLink) {
                // Clear previous content
                photoLink.innerHTML = '';
                photoLink.className = ''; // Remove old class if needed

                // Create new button
                const btn = document.createElement('button');
                btn.className = "text-sky-600 font-medium text-sm hover:underline";
                btn.innerText = "Edit";

                photoLink.appendChild(btn);
            }

            // Optional: clean up URL
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('uploaded');
                window.history.replaceState({}, document.title, url.pathname);
            }
        
                        // Optional: clean up URL
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('details');
                window.history.replaceState({}, document.title, url.pathname);
            }
        }
    });
</script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<div class="mt-16">
    <div class="max-w-3xl mx-auto p-4 space-y-4 ">
        <div>
            <input type="hidden" id="propertyId" value="{{ $property->id }}">
        </div>
        <!-- Step 1 - Completed -->
        <div class="border border-gray-300 border rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="detailsStatusIcon" src="{{ asset('assets/flat-color-icons_ok.svg') }}" alt="Icon"
                    class="w-6 h-6 md:w-7 md:h-7" />
                <div>
                    <p class="text-sm text-gray-500">Step 1</p>
                    <h2 class="text-base font-semibold">Property details</h2>
                    <p class="text-xs text-gray-600">The basics, Add your property name, address, facilities and
                        more</p>
                </div>
            </div>
            <a id="detailsEditLink" href="{{ url('/partner-homes-form2/' . $property->id . '/' . $property->subtype_id ) }}"
                                class="text-sky-600 font-medium text-sm hover:underline">Edit</a>
        </div>

        <div class="border border-gray-300 rounded-lg p-4 flex flex-col gap-6">

            <!-- Step 2 Header -->
           <div class="border border-gray-300  rounded-lg p-4 flex justify-between items-center ">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('assets/Group 3926.svg') }}" alt="Icon"
                            class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 2</p>
                            <h2 class="text-base font-semibold">Rooms</h2>
                            <p class="text-xs text-gray-600">Tell us about your first room. Once you’ve set one up you
                                can add more.</p>
                        </div>
                    </div>
                    <a href="{{ url('/partner-homes-rooms/' . $property->id) }}"
                    class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                            Add rooms
                    </a>
                </div>

           
        </div>





        <!-- Step 3 - Photos -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center ">
            <div class="flex items-center gap-4">
                <img id="statusIcon" src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 3</p>
                    <h2 class="text-base font-semibold">Photos</h2>
                    <p class="text-xs text-gray-600">Share some photos of your property so guests know what to
                        expect.</p>
                </div>
            </div>
            <a id="photoEditLink" href="{{ url('/partner-homes-images/' . $property->id) }}"
                 class="mt-4 text-sky-600 text-sm font-semibold px-4 py-2 rounded border border-sky-300 hover:bg-sky-100">Add photos</a>

        </div>

        <!-- Step 4 - Final -->
        <div class=" border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 4</p>
                    <h2 class="text-base font-semibold">Final steps</h2>
                    <p class="text-xs text-gray-600">Set up payments and invoicing before you open for bookings.
                    </p>
                </div>
            </div>

            <a href="{{ url('/partner-homes-payments/' . $property->id) }}"
                class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                        Add final details
                    </a>
        </div>


        <div class="flex justify-center">
            <button
                class="mt-4 w-full  bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow">
                Complete Registration
            </button>
        </div>
    </div>

    @endsection