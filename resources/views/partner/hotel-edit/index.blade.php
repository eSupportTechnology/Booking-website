@extends('partner.partner-layout')

@section('title', 'Edit Hotel Property | ' . config('domains.app_name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Hotel Property</h1>
            <p class="text-gray-600 mt-2">{{ $property->title }}</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 mb-8">
            <nav class="-mb-px flex space-x-8">
                <button class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="basic">
                    Basic Details
                </button>
                <button class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="amenities">
                    Amenities
                </button>
                <button class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="rooms">
                    Rooms
                </button>
                <button class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="photos">
                    Photos
                </button>
                <button class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="pricing">
                    Pricing
                </button>
                <button class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700" data-tab="policies">
                    Policies
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Basic Details Tab -->
            <div id="basic-tab" class="tab-pane active">
                @include('partner.hotel-edit.partials.basic-details')
            </div>

            <!-- Amenities Tab -->
            <div id="amenities-tab" class="tab-pane hidden">
                @include('partner.hotel-edit.partials.amenities')
            </div>

            <!-- Rooms Tab -->
            <div id="rooms-tab" class="tab-pane hidden">
                @include('partner.hotel-edit.partials.rooms')
            </div>

            <!-- Photos Tab -->
            <div id="photos-tab" class="tab-pane hidden">
                @include('partner.hotel-edit.partials.photos')
            </div>

            <!-- Pricing Tab -->
            <div id="pricing-tab" class="tab-pane hidden">
                @include('partner.hotel-edit.partials.pricing')
            </div>

            <!-- Policies Tab -->
            <div id="policies-tab" class="tab-pane hidden">
                @include('partner.hotel-edit.partials.policies')
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
                pane.classList.remove('active');
            });
            
            // Add active class to clicked button and corresponding pane
            this.classList.add('active', 'border-blue-500', 'text-blue-600');
            this.classList.remove('border-transparent', 'text-gray-500');
            
            const targetPane = document.getElementById(tabName + '-tab');
            if (targetPane) {
                targetPane.classList.remove('hidden');
                targetPane.classList.add('active');
            }
        });
    });

    // Success/Error message handling
    function showMessage(message, type = 'success') {
        const alertClass = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `${alertClass} px-4 py-3 rounded border mb-4`;
        alertDiv.innerHTML = `
            <span class="block sm:inline">${message}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.remove()">
                <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </span>
        `;
        
        document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.max-w-4xl'));
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Make showMessage globally available
    window.showMessage = showMessage;
});
</script>
@endsection