@extends('frontend.partner-layout')

@section('title', 'Alternative Places Entire Types')

@section('content')
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const uploaded = urlParams.get('uploaded');
        const details = urlParams.get('details');
        const paymentDetails = urlParams.get('paymentDetails');
        const detailsLink = document.getElementById('detailsEditLink');
        const detailsIcon = document.getElementById('detailsStatusIcon');
        const photoLink = document.getElementById('photoEditLink');
        const icon = document.getElementById('statusIcon');
        const finalicon = document.getElementById('finalStatusIcon');
        const paymenEditLink = document.getElementById('paymentEditLink');
        const paymentEditLinkBtn = document.getElementById('paymentEditLinkBtn');
        const propertyType = urlParams.get('propertyType');
        const propertyId = document.getElementById('propertyId').value;
        const subtypeId = document.getElementById('subtypeId').value;

        const baseUrl = `/partner-homes-images/${propertyId}`;
        const url = `${baseUrl}?details=true&propertyType=${encodeURIComponent(propertyType)}`;
        const paymentUrl = `/partner-homes-payments/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
        photoLink.href = url;
        paymenEditLink.href = paymentUrl;
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

            if(paymentDetails === 'true') {
                // Update the icon (optional - if not already done)
                if (paymentEditLinkBtn) {
                    paymentEditLinkBtn.innerText = "Edit";  
                    paymentEditLinkBtn.className = "text-sky-600 font-medium text-sm hover:underline";
                }
                if (finalicon) {
                    finalicon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                    finalicon.className = "w-6 h-6 md:w-7 md:h-7";
                }
            }

            // Optional: clean up URL
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('uploaded');
                url.searchParams.delete('details');
                url.searchParams.delete('paymentDetails');
                window.history.replaceState({}, document.title, url.pathname);
            }        
        
        }

        let actionUrl = '';

        if (propertyType === 'multiple') {
            actionUrl = '/partner-homes-multiple';
        } else if (propertyType === 'single') {
            actionUrl = '/partner-homes-single';
        } else {
            alert('Unknown property type');
            return;
        }

        const form = document.getElementById('editForm');
        form.action = actionUrl;
           document.getElementById('formPropertyId').value = propertyId;
        document.getElementById('formSubtypeId').value = subtypeId;

        detailsLink.addEventListener('click', () => {
            form.submit();
        })
    });
</script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<div class="mt-16">
    <div class="max-w-3xl mx-auto p-4 space-y-4 ">
        <div>
            <input type="hidden" id="propertyId" value="{{ $property->id }}">
            <input type="hidden" id="subtypeId" value="{{ $property->subtype_id }}">
        </div>
        <form id="editForm" method="POST">
            @csrf
            <input type="hidden" name="propertyId" id="formPropertyId">
            <input type="hidden" name="subtypeId" id="formSubtypeId">
        </form>

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
            <button id="detailsEditLink" 
                                class="text-sky-600 font-medium text-sm hover:underline">Edit</button>
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
            <a id="photoEditLink" href="#"
                 class="mt-4 text-sky-600 text-sm font-semibold px-4 py-2 rounded border border-sky-300 hover:bg-sky-100">Add photos</a>

        </div>

        <!-- Step 4 - Final -->
        <div class=" border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="finalStatusIcon" src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 4</p>
                    <h2 class="text-base font-semibold">Final steps</h2>
                    <p class="text-xs text-gray-600">Set up payments and invoicing before you open for bookings.
                    </p>
                </div>
            </div>

            <a id="paymentEditLink" href="#">
                <button id="paymentEditLinkBtn" class=" bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                        Add final details
                </button>
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