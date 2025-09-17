@extends('partner.partner-layout')

@section('title', 'Hotels Edit | ' . config('domains.app_name'))

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
        console.log('paymentDetails param:', paymentDetails);
        const detailsLink = document.getElementById('detailsEditLink');
        const detailsIcon = document.getElementById('detailsStatusIcon');
        const photoLink = document.getElementById('photoEditLink');
        const icon = document.getElementById('statusIcon');
        const finalicon = document.getElementById('finalStatusIcon');
        const roomsStatusIcon = document.getElementById('roomsStatusIcon');
        const paymenEditLink = document.getElementById('paymentEditLink');
        const paymentEditLinkBtn = document.getElementById('paymentEditLinkBtn');
        const roomsEditLink = document.getElementById('roomsEditLink');
        const propertyType = urlParams.get('propertyType');
        const propertyId = document.getElementById('propertyId').value;
        const subtypeId = document.getElementById('subtypeId').value;
        const completeRegistrationBtn = document.getElementById('completeRegistrationBtn');
        
        // Check if in edit mode
        const isEditMode = typeof window.isEditMode !== 'undefined' ? window.isEditMode : false;
        if (isEditMode) {
            console.log('Hotel edit mode detected');
        }


        // Set up links immediately
        if (photoLink) {
            photoLink.href = `/partner-homes-images/${propertyId}?details=true&propertyType=${encodeURIComponent(propertyType)}`;
        }
        
        if (roomsEditLink) {
            roomsEditLink.href = `/partner-homes-rooms/${propertyId}?details=true&propertyType=${encodeURIComponent(propertyType)}`;
        }

        if (paymenEditLink) {
            paymenEditLink.href = `/partner/partner-hotels-payment/${propertyId}?propertyType=${encodeURIComponent(propertyType)}`;
        }
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

            if (paymentDetails === 'true') {
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

                

        }
      
        if (paymentDetails === 'true') {
            if (paymentEditLinkBtn) {
                paymentEditLinkBtn.innerText = "Edit";
                paymentEditLinkBtn.className = "text-sky-600 font-medium text-sm hover:underline";
            } else {
                console.warn('paymentEditLinkBtn element NOT found');
            }
            if (finalicon) {
                finalicon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                finalicon.className = "w-6 h-6 md:w-7 md:h-7";
            } else {
                console.warn('finalicon element NOT found');
            }
        }


        if (rooms === 'true') {
            if (roomsStatusIcon) {
                roomsStatusIcon.src = "{{ asset('assets/flat-color-icons_ok.svg') }}";
                roomsStatusIcon.className = "w-6 h-6 md:w-7 md:h-7";
            }
            if (roomsEditLink) {
                roomsEditLink.innerText = "Add more rooms";
                roomsEditLink.className = "text-sky-600 font-medium text-sm hover:underline";
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

        // Check if all required steps are completed
        const allStepsCompleted = paymentDetails === 'true' && rooms === 'true' && uploaded === 'true';
        
        console.log('=== HOTELS EDIT COMPLETION CHECK ===');
        console.log('paymentDetails:', paymentDetails);
        console.log('rooms:', rooms);
        console.log('uploaded:', uploaded);
        console.log('All steps completed:', allStepsCompleted);
        console.log('=== END CHECK ===');
        
        if (!allStepsCompleted) {
            console.log('One or more required steps are not completed. Complete all steps before proceeding.');
            completeRegistrationBtn.disabled = true;
            completeRegistrationBtn.classList.add('cursor-not-allowed', 'opacity-50');
            completeRegistrationBtn.innerText = 'Complete all steps to proceed';
            completeRegistrationBtn.className = "mt-4 w-full bg-gray-400 font-semibold text-white rounded text-sm font-semibold px-6 py-2 rounded shadow cursor-not-allowed opacity-50";
        } else {
            console.log('All steps completed! Enabling complete registration button.');
            completeRegistrationBtn.disabled = false;
            completeRegistrationBtn.classList.remove('cursor-not-allowed', 'opacity-50');
            completeRegistrationBtn.innerText = 'Complete Registration';
            completeRegistrationBtn.className = "mt-4 w-full bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow";
        }


        completeRegistrationBtn.addEventListener('click', () => {
            if (!allStepsCompleted) {
                console.log('Cannot proceed - not all steps are completed');
                return;
            }
            
            console.log('Registration completed successfully! Redirecting to list-your-property page.');
            
            // Show success toast message
            Swal.fire({
                icon: 'success',
                title: 'Registration Completed!',
                text: 'Your property has been successfully registered. You can now list more properties or manage your existing ones.',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-end'
            }).then(() => {
                // Redirect to list-your-property page
                window.location.href = '{{ url("/list-your-property") }}';
            });
        });
        
        // Add progress indicator and success message
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

    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-rooms-btn').forEach(button => {
            button.addEventListener('click', function() {
                let propertyId = this.dataset.propertyId;
                let roomTypeId = this.dataset.roomTypeId;
                let parentCard = this.closest('.flex'); // To remove element without reload later

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete all rooms of this type for the selected property.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/rooms/${propertyId}/${roomTypeId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        'All rooms of this type have been deleted.',
                                        'success'
                                    );
                                    // Remove card from DOM without reloading
                                    parentCard.remove();
                                } else {
                                    Swal.fire('Error', 'Something went wrong.', 'error');
                                }
                            });
                    }
                });
            });
        });
        document.querySelectorAll('.edit-room-btn').forEach(button => {
            button.addEventListener('click', function() {
                const roomTypeId = this.getAttribute('data-room-type-id');
                const row = document.querySelector(`tr[data-room-type-id="${roomTypeId}"]`);
                const editables = row.querySelectorAll('.editable');
                const saveButton = document.querySelector(`.save-room-btn[data-room-type-id="${roomTypeId}"]`);
                const editButton = this;

                // Make fields editable
                editables.forEach(cell => {
                    const field = cell.getAttribute('data-field');
                    const value = field === 'price_per_night' ?
                        cell.textContent.split(' ')[1] :
                        cell.textContent;

                    if (field === 'max_guests' || field === 'bed_count' || field === 'room_count') {
                        cell.innerHTML = `<input type="number" value="${value}" class="w-full border border-gray-300 rounded p-1 text-xs" step="1" min="1">`;
                    } else if (field === 'price_per_night') {
                        cell.innerHTML = `<input type="number" value="${value}" class="w-full border border-gray-300 rounded p-1 text-xs" step="0.01" min="0">`;
                    } else if (field === 'bathroom_type') {
                        cell.innerHTML = `
                            <select class="w-full border border-gray-300 rounded p-1 text-xs">
                                <option value="private" ${value === 'private' ? 'selected' : ''}>Private</option>
                                <option value="shared" ${value === 'shared' ? 'selected' : ''}>Shared</option>
                            </select>`;
                    }
                });

                // Toggle buttons
                editButton.classList.add('hidden');
                saveButton.classList.remove('hidden');
            });
        });

        document.querySelectorAll('td[data-field="room_count"]').forEach(td => {
            td.setAttribute('data-old-value', td.textContent.trim());
        });

        document.querySelectorAll('.save-room-btn').forEach(button => {
            button.addEventListener('click', function() {
                const roomTypeId = this.getAttribute('data-room-type-id');
                const row = document.querySelector(`tr[data-room-type-id="${roomTypeId}"]`);
                const editables = row.querySelectorAll('.editable');
                const propertyId = row.getAttribute('data-property-id');
                const saveButton = this;
                const editButton = document.querySelector(`.edit-room-btn[data-room-type-id="${roomTypeId}"]`);

                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('property_id', propertyId);

                let reductionPromise = Promise.resolve(true);

                editables.forEach(cell => {
                    const field = cell.getAttribute('data-field');
                    let value;

                    if (field === 'room_count') {
                        let input = cell.querySelector('input');
                        let newValue = parseInt(input.value) || 0;
                        let oldValue = parseInt(cell.getAttribute('data-old-value')) || 0;

                        if (newValue < oldValue) {
                            reductionPromise = Swal.fire({
                                title: 'Reduce room count?',
                                text: 'Reducing the room count will delete existing rooms. This cannot be undone.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, reduce',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (!result.isConfirmed) {
                                    input.value = oldValue;
                                    saveButton.classList.add('hidden');
                                    editButton.classList.remove('hidden');
                                    window.location.reload();
                                    return false;
                                }
                                return true;
                            });

                        } else if (newValue === 0) {
                            Swal.fire('Error', 'Room count cannot be zero.', 'error');
                            input.value = oldValue;
                        }

                        value = input.value;
                    } else if (field === 'bathroom_type') {
                        value = cell.querySelector('select').value;
                    } else {
                        value = cell.querySelector('input').value;
                    }

                    if (field === 'price_per_night') {
                        const currency = cell.getAttribute('data-currency');
                        formData.append('currency', currency);
                        formData.append(field, value);
                        cell.textContent = `${currency} ${value}`;
                    } else {
                        formData.append(field, value);
                        cell.textContent = value;
                    }
                });

                reductionPromise.then((proceed) => {
                    if (!proceed) return;

                    axios.post(`/rooms/${roomTypeId}`, formData)
                        .then(() => {
                            Swal.fire(
                                'Success',
                                'Room details updated successfully.',
                                'success'
                            );
                            document.querySelectorAll('td[data-field="room_count"]').forEach(td => {
                                td.setAttribute('data-old-value', td.textContent.trim());
                            });
                            saveButton.classList.add('hidden');
                            editButton.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error updating room:', error);
                            Swal.fire(
                                'Error',
                                'Failed to update room details. Please try again.',
                                'error'
                            );
                        });
                });
            });
        });

    });
</script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<div>
    <input type="hidden" id="propertyId" value="{{ $property->id }}">
    <input type="hidden" id="subtypeId" value="{{ $property->subtype_id }}">
</div>

<div x-data="{ step: 1 }">
    <div class="mt-16">
        <div class="max-w-3xl mx-auto p-4 space-y-4 ">

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
                <!-- <a href="{{ url('/partner/property_subcategory/' . $property->category_id . '/' . $property->id) }}"
                    class="text-sky-600 font-medium text-sm hover:underline">Edit</a> -->

            </div>

            <div class="border border-gray-300 rounded-lg p-4 flex flex-col gap-6">

                <!-- Step 2 Header -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img id="roomsStatusIcon" src="{{ asset('assets/Group 3926.svg') }}" alt="Icon"
                            class="w-6 h-6 md:w-7 md:h-7" />
                        <div>
                            <p class="text-sm text-gray-500">Step 2</p>
                            <h2 class="text-base font-semibold">Rooms</h2>
                            <p class="text-xs text-gray-600">Tell us about your first room. Once you’ve set one up you
                                can add more.</p>
                        </div>
                    </div>

                </div>

                <!-- Room Cards Container -->
                <div class="space-y-4">
                    @foreach ($rooms as $roomTypeId => $roomGroup)
                    @php
                    $firstRoom = $roomGroup->first();
                    @endphp

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 border border-gray-200 rounded-lg shadow-sm bg-gray-100">
                        <!-- Room Image -->
                        <img src="{{ asset('images/room.jpg') }}" alt="Room Image"
                            class="w-24 h-24 object-cover rounded-md" />

                        <!-- Info Table -->
                        <div class="flex-1 overflow-x-auto">
                            <p class="text-sm text-gray-600 font-semibold mb-2">{{ $firstRoom->name }}</p>
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="text-gray-500 text-left whitespace-nowrap">
                                        <th class="pr-6 border-r border-gray-300">Guests</th>
                                        <th class="pr-6 border-r border-gray-300">Beds</th>
                                        <th class="pr-6 border-r border-gray-300">Bathroom</th>
                                        <th class="pr-6 border-r border-gray-300">Price</th>
                                        <th class="pr-6">Rooms of this type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-gray-800 text-xs" data-room-type-id="{{ $firstRoom->room_type_id }}"
                                        data-property-id="{{ $firstRoom->property_id }}">
                                        <td class="pr-6 border-r border-gray-300 editable" data-field="max_guests">{{ $firstRoom->max_guests }}</td>
                                        <td class="pr-6 border-r border-gray-300 editable" data-field="bed_count">{{ $firstRoom->bed_count }}</td>
                                        <td class="pr-6 border-r border-gray-300 editable" data-field="bathroom_type">{{ $firstRoom->bathroom_type }}</td>
                                        <td class="pr-6 border-r border-gray-300 editable" data-field="price_per_night"
                                            data-currency="{{ $firstRoom->currency }}">{{ $firstRoom->currency }} {{ $firstRoom->price_per_night }}</td>
                                        <td class="pr-6 editable" data-field="room_count">{{ $roomGroup->count() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-4">
                            <!-- <button class="text-sky-600 font-medium text-sm hover:underline edit-room-btn"
                                data-room-type-id="{{ $firstRoom->room_type_id }}">Edit</button> -->
                            <button class="text-sky-600 font-medium text-sm hover:underline save-room-btn hidden"
                                data-room-type-id="{{ $firstRoom->room_type_id }}">Save</button>
                            <button class="text-red-600 font-medium danger text-sm hover:underline delete-rooms-btn"
                                data-property-id="{{ $firstRoom->property_id }}"
                                data-room-type-id="{{ $firstRoom->room_type_id }}">Delete</button>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Add Another Room -->
                <div class="text-right">

                    <a id="roomsEditLink"
                        href="#"
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


            <!-- <div class="flex justify-center">
                <a href="{{ route('partner.hotels.complete.registration') }}"

                    class="mt-4 w-full  bg-[#3CC0E9] font-semibold text-white text-center rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow">
                    Complete Registration

                </a>
            </div> -->
            <div class="flex justify-center">
                <button id="completeRegistrationBtn"
                    class="mt-4 w-full  bg-[#3CC0E9] font-semibold text-white rounded hover:bg-sky-500 text-sm font-semibold px-6 py-2 rounded shadow">
                    Complete Registration
                </button>
            </div>
        </div>
    </div>
    @endsection