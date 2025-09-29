@extends('partner.partner-layout')

@section('title', 'Edit Hotel | ' . config('domains.app_name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Hotel Property</h1>
        
        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button onclick="showTab('details')" id="details-tab" class="tab-button active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                    Property Details
                </button>
                <button onclick="showTab('amenities')" id="amenities-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                    Amenities
                </button>
                <button onclick="showTab('rooms')" id="rooms-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                    Rooms
                </button>
                <button onclick="showTab('photos')" id="photos-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                    Photos
                </button>
                <button onclick="showTab('payment')" id="payment-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                    Payment
                </button>
                <button onclick="showTab('complete')" id="complete-tab" class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700">
                    Complete
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div id="details-content" class="tab-content">
            @include('partner.hotel-edit.partials.partner-hotels-edit-create-1')
        </div>

        <div id="amenities-content" class="tab-content hidden">
            @include('partner.hotel-edit.partials.partner-hotels-edit-create-2')
        </div>

        <div id="rooms-content" class="tab-content hidden">
            @include('partner.hotel-edit.partials.partner-hotels-edit-rooms')
        </div>

        <div id="photos-content" class="tab-content hidden">
            @include('partner.hotel-edit.partials.partner-hotels-edit-photos')
        </div>

        <div id="payment-content" class="tab-content hidden">
            @include('partner.hotel-edit.partials.partner-hotels-edit-payment')
        </div>

        <div id="complete-content" class="tab-content hidden">
            @include('partner.hotel-edit.partials.partner-hotels-edit-complete-registration')
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(tab => {
        tab.classList.remove('active', 'border-blue-500', 'text-blue-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}
</script>
@endsection