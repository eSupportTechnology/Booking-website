@extends('partner.partner-layout')

@section('title', 'Apartment Edit | ' . config('domains.app_name'))

@section('content')
<script>
    window.isEditMode = true;
</script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const uploaded = urlParams.get('uploaded');
        const details = urlParams.get('details');
        const rooms = urlParams.get('rooms');
        const paymentDetails = urlParams.get('paymentDetails');
        const propertyType = urlParams.get('propertyType');

        const detailsLink = document.getElementById('detailsEditLink');
        const photoLink = document.getElementById('photoEditLink');
        const icon = document.getElementById('statusIcon');
        const finalicon = document.getElementById('finalStatusIcon');
        const roomsStatusIcon = document.getElementById('roomsStatusIcon');
        const paymenEditLink = document.getElementById('paymentEditLink');
        const paymentEditLinkBtn = document.getElementById('paymentEditLinkBtn');
        const roomsEditLink = document.getElementById('roomsEditLink');
        const propertyIdElement = document.getElementById('propertyId');
        const completeRegistrationBtn = document.getElementById('completeRegistrationBtn');

        if (!propertyIdElement) {
            console.error('Property ID element not found');
            return;
        }

        const propertyId = propertyIdElement.value;

        // Set up links for all 5 steps
        if (detailsLink) {
            detailsLink.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = `/partner/property/apartment/step2/${propertyId}`;
            });
        }

        if (roomsEditLink) {
            roomsEditLink.href = `/partner/apartment/bedrooms/${propertyId}?details=true&propertyType=${encodeURIComponent(propertyType)}`;
        }

        if (photoLink) {
            photoLink.href = `/partner-homes-images/${propertyId}?details=true&propertyType=${encodeURIComponent(propertyType)}`;
        }

        const pricingEditLink = document.getElementById('pricingEditLink');
        if (pricingEditLink) {
            pricingEditLink.href = `/partner/property/apartment/step2/${propertyId}`;
        }

        if (paymenEditLink) {
            paymenEditLink.href = `/partner-homes-payments/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
        }

        // Handle UI updates based on completion status
        if (uploaded === 'true') {
            if (icon) {
                icon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                icon.className = "w-6 h-6 md:w-7 md:h-7";
            }
            if (photoLink) {
                photoLink.innerHTML = '<button class="text-sky-600 font-medium text-sm hover:underline">Edit</button>';
            }
        }

        if (paymentDetails === 'true') {
            if (paymentEditLinkBtn) {
                paymentEditLinkBtn.innerText = "Edit";
                paymentEditLinkBtn.className = "text-sky-600 font-medium text-sm hover:underline";
            }
            if (finalicon) {
                finalicon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                finalicon.className = "w-6 h-6 md:w-7 md:h-7";
            }
        }

        if (rooms === 'true') {
            if (roomsStatusIcon) {
                roomsStatusIcon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                roomsStatusIcon.className = "w-6 h-6 md:w-7 md:h-7";
            }
            if (roomsEditLink) {
                roomsEditLink.innerText = "Edit";
                roomsEditLink.className = "text-sky-600 font-medium text-sm hover:underline";
            }
        }

        // Check if all steps are completed (now 5 steps)
        const pricing = urlParams.get('pricing');
        const allStepsCompleted = uploaded === 'true' && paymentDetails === 'true' && rooms === 'true' && pricing === 'true' && details === 'true';

        if (completeRegistrationBtn) {
            if (allStepsCompleted) {
                completeRegistrationBtn.disabled = false;
                completeRegistrationBtn.className = "mt-4 w-full bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow";
                completeRegistrationBtn.addEventListener('click', () => {
                    window.location.href = `/partner-apartments-final/${propertyId}`;
                });
            } else {
                completeRegistrationBtn.disabled = true;
                completeRegistrationBtn.className = "mt-4 w-full bg-gray-400 font-semibold text-white rounded text-sm font-semibold px-6 py-2 rounded shadow cursor-not-allowed";
            }
        }

        // Add progress indicator (now 5 steps)
        let completedSteps = 0;
        if (details === 'true') completedSteps++;
        if (rooms === 'true') completedSteps++;
        if (uploaded === 'true') completedSteps++;
        if (pricing === 'true') completedSteps++;
        if (paymentDetails === 'true') completedSteps++;
        const completionPercentage = (completedSteps / 5) * 100;

        const progressSection = document.createElement('div');
        progressSection.className = 'mb-4';
        progressSection.innerHTML = `
            <div class="text-center mb-2">
                <span class="text-sm text-gray-600">Registration Progress: ${completedSteps}/5 steps completed</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-[#3CC0E9] h-2 rounded-full transition-all duration-300" style="width: ${completionPercentage}%"></div>
            </div>
        `;

        const completeRegistrationSection = document.querySelector('.flex.justify-center');
        if (completeRegistrationSection) {
            completeRegistrationSection.parentNode.insertBefore(progressSection, completeRegistrationSection);
        }
    });
</script>

<div class="mt-16">
    <div class="max-w-3xl mx-auto p-4 space-y-4">
        <div>
            <input type="hidden" id="propertyId" value="{{ $property->id }}">
        </div>

        <!-- Step 1 - Basic Information -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="detailsStatusIcon" src="{{ asset('assets/flat-color-icons_ok.svg') }}" alt="Icon"
                    class="w-6 h-6 md:w-7 md:h-7" />
                <div>
                    <p class="text-sm text-gray-500">Step 1</p>
                    <h2 class="text-base font-semibold">Basic information</h2>
                    <p class="text-xs text-gray-600">Property name, location, and basic details</p>
                </div>
            </div>
            <button type="button" id="detailsEditLink"
                class="text-sky-600 font-medium text-sm hover:underline">Edit</button>
        </div>

        <!-- Step 2 - Property Setup -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="roomsStatusIcon" src="{{ asset('assets/Group 3926.svg') }}" alt="Icon"
                    class="w-6 h-6 md:w-7 md:h-7" />
                <div>
                    <p class="text-sm text-gray-500">Step 2</p>
                    <h2 class="text-base font-semibold">Property setup</h2>
                    <p class="text-xs text-gray-600">Rooms, amenities, and property features</p>
                </div>
            </div>
            <a id="roomsEditLink" href="#"
                class="bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                Set up property
            </a>
        </div>

        <!-- Step 3 - Photos -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="statusIcon" src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 3</p>
                    <h2 class="text-base font-semibold">Photos</h2>
                    <p class="text-xs text-gray-600">Upload property images to attract guests</p>
                </div>
            </div>
            <a id="photoEditLink" href="#"
                class="mt-4 text-sky-600 text-sm font-semibold px-4 py-2 rounded border border-sky-300 hover:bg-sky-100">Add photos</a>
        </div>

        <!-- Step 4 - Pricing and Calendar -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="pricingStatusIcon" src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 4</p>
                    <h2 class="text-base font-semibold">Pricing and calendar</h2>
                    <p class="text-xs text-gray-600">Set your rates and availability</p>
                </div>
            </div>
            <a id="pricingEditLink" href="#">
                <button type="button" id="pricingEditLinkBtn"
                    class="bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                    Set pricing
                </button>
            </a>
        </div>

        <!-- Step 5 - Legal Information -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="finalStatusIcon" src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 5</p>
                    <h2 class="text-base font-semibold">Legal information</h2>
                    <p class="text-xs text-gray-600">Payment details and legal requirements</p>
                </div>
            </div>
            <a id="paymentEditLink" href="#">
                <button type="button" id="paymentEditLinkBtn"
                    class="bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                    Complete setup
                </button>
            </a>
        </div>

        <div class="flex justify-center">
            <button type="button" id="completeRegistrationBtn"
                class="mt-4 w-full bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow">
                Complete Registration
            </button>
        </div>
    </div>
</div>

@endsection
