@extends('partner.partner-layout')

@section('title', ' Homes Edit | ' . config('domains.app_name'))

@section('content')
<script>
    console.log('Script tag loaded...');
    window.addEventListener('DOMContentLoaded', () => {
        console.log('DOM loaded, initializing script...');
        console.log('Script is running...');
        
        // Add error handling to catch any JavaScript errors
        window.addEventListener('error', (e) => {
            console.error('JavaScript error caught:', e.error);
        });
        
        try {
            console.log('Try block started...');
        
            const urlParams = new URLSearchParams(window.location.search);
        console.log('URLSearchParams created successfully');
        
        const uploaded = urlParams.get('uploaded');
        console.log('uploaded parameter read:', uploaded);
// Step-by-step debugging with error catching
console.log('=== STEP 1: URL ANALYSIS ===');
try {
    console.log('Full URL:', window.location.href);
    console.log('Search string:', window.location.search);
} catch (e) {
    console.error('Error accessing window.location:', e);
}

console.log('=== STEP 2: URLSearchParams CREATION ===');
let urlParams;
try {
    urlParams = new URLSearchParams(window.location.search);
    console.log('URLSearchParams created successfully');
} catch (e) {
    console.error('Error creating URLSearchParams:', e);
    return;
}

console.log('=== STEP 3: ALL PARAMETERS ITERATION ===');
try {
    let paramCount = 0;
    for (const [key, value] of urlParams.entries()) {
        paramCount++;
        console.log(`Param ${paramCount}: ${key} = "${value}"`);
    }
    console.log(`Total parameters found: ${paramCount}`);
} catch (e) {
    console.error('Error iterating parameters:', e);
}

console.log('=== STEP 4: INDIVIDUAL PARAMETER READING ===');

// Test each parameter individually with try-catch
let uploaded, details, rooms, paymentDetails, propertyType;

try {
    uploaded = urlParams.get('uploaded');
    console.log('✓ uploaded read successfully:', uploaded);
} catch (e) {
    console.error('✗ Error reading uploaded:', e);
}

try {
    details = urlParams.get('details');
    console.log('✓ details read successfully:', details);
} catch (e) {
    console.error('✗ Error reading details:', e);
}

try {
    rooms = urlParams.get('rooms');
    console.log('✓ rooms read successfully:', rooms);
} catch (e) {
    console.error('✗ Error reading rooms:', e);
}

try {
    paymentDetails = urlParams.get('paymentDetails');
    console.log('✓ paymentDetails read successfully:', paymentDetails);
} catch (e) {
    console.error('✗ Error reading paymentDetails:', e);
}

try {
    propertyType = urlParams.get('propertyType');
    console.log('✓ propertyType read successfully:', propertyType);
} catch (e) {
    console.error('✗ Error reading propertyType:', e);
}

console.log('=== STEP 5: MANUAL URL PARSING ===');
try {
    const queryString = window.location.search;
    console.log('Query string:', queryString);
    
    if (queryString) {
        const params = queryString.substring(1).split('&');
        console.log('Split parameters:', params);
        
        params.forEach((param, index) => {
            const [key, value] = param.split('=');
            console.log(`Manual param ${index + 1}: ${key} = ${value}`);
        });
    }
} catch (e) {
    console.error('Error in manual parsing:', e);
}

console.log('=== STEP 6: FINAL VALUES SUMMARY ===');
console.log('uploaded:', uploaded, '(type:', typeof uploaded, ')');
console.log('details:', details, '(type:', typeof details, ')');
console.log('rooms:', rooms, '(type:', typeof rooms, ')');
console.log('paymentDetails:', paymentDetails, '(type:', typeof paymentDetails, ')');
console.log('propertyType:', propertyType, '(type:', typeof propertyType, ')');
        
        // Test if we can continue
        console.log('Parameters read successfully, continuing...');
        
        // Get all DOM elements with null checks
        const detailsLink = document.getElementById('detailsEditLink');
        const detailsIcon = document.getElementById('detailsStatusIcon');
        const photoLink = document.getElementById('photoEditLink');
        const icon = document.getElementById('statusIcon');
        const finalicon = document.getElementById('finalStatusIcon');
        const roomsStatusIcon = document.getElementById('roomsStatusIcon');
        const paymenEditLink = document.getElementById('paymentEditLink');
        const paymentEditLinkBtn = document.getElementById('paymentEditLinkBtn');
        const roomsEditLink = document.getElementById('roomsEditLink');
        const propertyIdElement = document.getElementById('propertyId');
        const subtypeIdElement = document.getElementById('subtypeId');
        const completeRegistrationBtn = document.getElementById('completeRegistrationBtn');
        const form = document.getElementById('editForm');

        // Check if essential elements exist
        if (!propertyIdElement || !subtypeIdElement) {
            console.error('Property ID or Subtype ID elements not found');
            return;
        }

        if (!form) {
            console.error('Edit form not found');
            return;
        }

        if (!completeRegistrationBtn) {
            console.error('Complete registration button not found');
            return;
        }

        const propertyId = propertyIdElement.value;
        const subtypeId = subtypeIdElement.value;

        console.log('Property ID:', propertyId);
        console.log('Property Type:', propertyType);

        // Set up photo and rooms links immediately
        if (photoLink) {
            photoLink.href = `/partner-homes-images/${propertyId}?details=true&propertyType=${encodeURIComponent(propertyType)}`;
        }
        
        if (roomsEditLink) {
            roomsEditLink.href = `/partner-homes-rooms/${propertyId}?details=true&propertyType=${encodeURIComponent(propertyType)}`;
        }

        // Function to set up complete registration button
        function setupCompleteRegistrationButton(categoryId = 1) {
            // Remove any existing event listeners by cloning the button
            const newBtn = completeRegistrationBtn.cloneNode(true);
            completeRegistrationBtn.parentNode.replaceChild(newBtn, completeRegistrationBtn);
            
            // Check if all required steps are completed
            const allStepsCompleted = uploaded === 'true' && paymentDetails === 'true' && rooms === 'true';
            
            if (allStepsCompleted) {
                // Enable the complete registration button
                newBtn.disabled = false;
                newBtn.className = "mt-4 w-full bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow";
                console.log('All steps completed - enabling complete registration button');
            } else {
                // Disable the complete registration button
                newBtn.disabled = true;
                newBtn.className = "mt-4 w-full bg-gray-400 font-semibold text-white rounded text-sm font-semibold px-6 py-2 rounded shadow cursor-not-allowed";
                console.log('Steps not completed - disabling complete registration button');
                console.log('Uploaded:', uploaded, 'Payment Details:', paymentDetails, 'Rooms:', rooms);
            }
            
            if (categoryId == 1) {
                // Homes routes
                console.log('Setting up homes routes');
                if (paymenEditLink) {
                    paymenEditLink.href = `/partner-homes-payments/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
                }
                // Property details edit navigates via form submit to homes details
                if (detailsLink && form) {
                    const newDetailsLink = detailsLink.cloneNode(true);
                    detailsLink.parentNode.replaceChild(newDetailsLink, detailsLink);
                    newDetailsLink.addEventListener('click', (e) => {
                        e.preventDefault();
                        form.submit();
                    });
                }
                
                newBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (!allStepsCompleted) {
                        console.log('Cannot proceed - not all steps are completed');
                        return;
                    }
                    console.log('Complete registration clicked - navigating to homes route');
                    window.location.href = `/partner/partner-homes-complete-registration/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
                });
            } else {
                // Hotels routes
                console.log('Setting up hotels routes');
                if (paymenEditLink) {
                    paymenEditLink.href = `/partner/partner-hotels-payment/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
                }
                // Property details edit should go to hotels wizard with prefill by propertyId
                if (detailsLink) {
                    const newDetailsLink = detailsLink.cloneNode(true);
                    detailsLink.parentNode.replaceChild(newDetailsLink, detailsLink);
                    newDetailsLink.addEventListener('click', (e) => {
                        e.preventDefault();
                        window.location.href = `/partner/partner-hotels-create-1/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
                    });
                }
                
                newBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (!allStepsCompleted) {
                        console.log('Cannot proceed - not all steps are completed');
                        return;
                    }
                    console.log('Complete registration clicked - navigating to hotels route');
                    window.location.href = `/partner/partner-hotels-complete-registration/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
                });
            }
            
            console.log('Complete registration button set up successfully');
        }

        // Set up default button behavior immediately (homes route as fallback)
        setupCompleteRegistrationButton(1);

        // Then try to fetch the actual category and update if needed
        fetch(`/api/property/${propertyId}/category`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Property category data:', data);
                if (data.category_id) {
                    setupCompleteRegistrationButton(data.category_id);
                }
            })
            .catch(error => {
                console.error('Error fetching property category:', error);
                // Keep the default homes route setup
                console.log('Using default homes routes due to fetch error');
            });

        // Handle UI updates based on URL parameters
        if (uploaded === 'true') {
            if (icon) {
                icon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                icon.className = "w-6 h-6 md:w-7 md:h-7";
            }

            if (photoLink) {
                photoLink.innerHTML = '';
                photoLink.className = '';

                const btn = document.createElement('button');
                btn.className = "text-sky-600 font-medium text-sm hover:underline";
                btn.innerText = "Edit";
                photoLink.appendChild(btn);
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

        // Add completion status indicator
        const allStepsCompleted = uploaded === 'true' && paymentDetails === 'true' && rooms === 'true';
        
        // Calculate completion percentage
        let completedSteps = 0;
        if (uploaded === 'true') completedSteps++;
        if (paymentDetails === 'true') completedSteps++;
        if (rooms === 'true') completedSteps++;
        const completionPercentage = (completedSteps / 3) * 100;
        
        // Add progress bar above the complete registration button
        const progressSection = document.createElement('div');
        progressSection.className = 'mb-4';
        progressSection.innerHTML = `
            <div class="text-center mb-2">
                <span class="text-sm text-gray-600">Registration Progress: ${completedSteps}/3 steps completed</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-[#3CC0E9] h-2 rounded-full transition-all duration-300" style="width: ${completionPercentage}%"></div>
            </div>
        `;
        
        if (allStepsCompleted) {
            // Add a success message above the complete registration button
            const successMessage = document.createElement('div');
            successMessage.className = 'text-center p-4 bg-green-50 border border-green-200 rounded-lg mb-4';
            successMessage.innerHTML = `
                <div class="flex items-center justify-center gap-2 text-green-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">All steps completed! You can now complete your registration.</span>
                </div>
            `;
            
            const completeRegistrationSection = document.querySelector('.flex.justify-center');
            if (completeRegistrationSection) {
                completeRegistrationSection.parentNode.insertBefore(progressSection, completeRegistrationSection);
                completeRegistrationSection.parentNode.insertBefore(successMessage, completeRegistrationSection);
            }
        } else {
            // Add progress bar without success message
            const completeRegistrationSection = document.querySelector('.flex.justify-center');
            if (completeRegistrationSection) {
                completeRegistrationSection.parentNode.insertBefore(progressSection, completeRegistrationSection);
            }
        }

        // Now update the complete registration button based on completion status
        console.log('Final completion check - Uploaded:', uploaded, 'Payment Details:', paymentDetails, 'Rooms:', rooms);
        console.log('All steps completed:', allStepsCompleted);
        
        if (allStepsCompleted) {
            // Re-enable the button since all steps are completed
            const currentBtn = document.getElementById('completeRegistrationBtn');
            if (currentBtn) {
                currentBtn.disabled = false;
                currentBtn.className = "mt-4 w-full bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow";
                console.log('Button re-enabled after UI updates');
            }
        }

        // Set up form action
        let actionUrl = '';
        if (propertyType === 'multiple') {
            actionUrl = '/partner-homes-multiple/' + propertyId;
        } else if (propertyType === 'single') {
            actionUrl = '/partner-homes-single/' + propertyId;
        } else {
            console.error('Unknown property type:', propertyType);
            return;
        }

        form.action = actionUrl;
        
        const formPropertyId = document.getElementById('formPropertyId');
        const formSubtypeId = document.getElementById('formSubtypeId');
        
        if (formPropertyId) {
            formPropertyId.value = propertyId;
        }
        if (formSubtypeId) {
            formSubtypeId.value = subtypeId;
        }

        // Set up details link click handler; will be overridden by setupCompleteRegistrationButton
        if (detailsLink && form) {
            const initialDetailsLink = detailsLink.cloneNode(true);
            detailsLink.parentNode.replaceChild(initialDetailsLink, detailsLink);
            initialDetailsLink.addEventListener('click', (e) => {
                e.preventDefault();
                form.submit();
            });
        }

        console.log('Script initialization complete');
        
        // Debug function to check button state
        function debugButtonState() {
            const btn = document.getElementById('completeRegistrationBtn');
            if (btn) {
                console.log('Button current state:');
                console.log('- Disabled:', btn.disabled);
                console.log('- Class:', btn.className);
                console.log('- Text:', btn.textContent);
            }
        }
        
        // Check button state after a short delay to ensure all updates are complete
        setTimeout(() => {
            debugButtonState();
        }, 1000);
        
        } catch (error) {
            console.error('Error in script execution:', error);
        }
    });
</script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="mt-16">
    <div class="max-w-3xl mx-auto p-4 space-y-4">
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
                    <p class="text-sm text-gray-500">Step 1 hiiii</p>
                    <h2 class="text-base font-semibold">Property details</h2>
                    <p class="text-xs text-gray-600">The basics, Add your property name, address, facilities and more</p>
                </div>
            </div>
            <button type="button" id="detailsEditLink"
                class="text-sky-600 font-medium text-sm hover:underline">Edit</button>
        </div>

        <div class="border border-gray-300 rounded-lg p-4 flex flex-col gap-6">
            <!-- Step 2 Header -->
            <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img id="roomsStatusIcon" src="{{ asset('assets/Group 3926.svg') }}" alt="Icon"
                        class="w-6 h-6 md:w-7 md:h-7" />
                    <div>
                        <p class="text-sm text-gray-500">Step 2</p>
                        <h2 class="text-base font-semibold">Rooms</h2>
                        <p class="text-xs text-gray-600">Tell us about your first room. Once you've set one up you can add more.</p>
                    </div>
                </div>
                <a id="roomsEditLink"
                    href="#"
                    class="bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                    Add rooms
                </a>
            </div>
        </div>

        <!-- Step 3 - Photos -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="statusIcon" src="{{ asset('assets/Vector (40).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 3</p>
                    <h2 class="text-base font-semibold">Photos</h2>
                    <p class="text-xs text-gray-600">Share some photos of your property so guests know what to expect.</p>
                </div>
            </div>
            <a id="photoEditLink" href="#"
                class="mt-4 text-sky-600 text-sm font-semibold px-4 py-2 rounded border border-sky-300 hover:bg-sky-100">Add photos</a>
        </div>

        <!-- Step 4 - Final -->
        <div class="border border-gray-300 rounded-lg p-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img id="finalStatusIcon" src="{{ asset('assets/Vector (41).svg') }}" alt="Icon"
                    class="w-4 h-4 md:w-5 md:h-5 cursor-pointer" />
                <div>
                    <p class="text-sm text-gray-500">Step 4</p>
                    <h2 class="text-base font-semibold">Final steps</h2>
                    <p class="text-xs text-gray-600">Set up payments and invoicing before you open for bookings.</p>
                </div>
            </div>

            <a id="paymentEditLink" href="#">
                <button type="button" id="paymentEditLinkBtn" 
                    class="bg-sky-400 border border-sky-400 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-sky-500">
                    Add final details
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