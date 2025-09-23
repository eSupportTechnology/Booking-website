@extends('partner.partner-layout')

@section('title', 'Edit Hotel | ' . config('domains.app_name'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Hotel Property</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Basic Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Basic Details</h3>
                <p class="text-gray-600 mb-4">Edit property name, description, and location</p>
                <a href="/partner/hotels/{{ $property->id }}/edit-comprehensive" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit Details</a>
            </div>
            
            <!-- Photos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Photos</h3>
                <p class="text-gray-600 mb-4">Manage property photos</p>
                <a href="/partner/hotels/{{ $property->id }}/photos" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Manage Photos</a>
            </div>
            
            <!-- Rooms -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Rooms</h3>
                <p class="text-gray-600 mb-4">Add and manage room types</p>
                <a href="/partner/hotels/{{ $property->id }}/rooms" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Manage Rooms</a>
            </div>
            
            <!-- Payment -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Payment Setup</h3>
                <p class="text-gray-600 mb-4">Configure payment methods</p>
                <a href="/partner/hotels/{{ $property->id }}/payment" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Setup Payment</a>
            </div>
            
            <!-- Complete Registration -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Complete Registration</h3>
                <p class="text-gray-600 mb-4">Finalize your hotel listing</p>
                <a href="/partner/hotels/{{ $property->id }}/complete" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Complete</a>
            </div>
        </div>
    </div>
</div>
@endsection