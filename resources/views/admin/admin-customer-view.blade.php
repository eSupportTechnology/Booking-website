@extends('admin.master')

@section('content')
<div class="p-6 bg-[#1F8FB2] rounded shadow space-y-8">


    <!-- Page Title -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-white">Customer Details</h2>

        <a href="{{ url('/admin/customers') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Back to Customers
        </a>
    </div>

    <!-- Profile Section -->
    <div class="bg-white border rounded-lg shadow p-6 flex items-center space-x-6 relative">
        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#3CC0E9] shadow">
            @if($customer->customerPersonalDetail && $customer->customerPersonalDetail->profile_image)
                <img src="{{ asset('storage/' . $customer->customerPersonalDetail->profile_image) }}" alt="Profile Photo" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-2xl">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                </div>
            @endif
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-800">{{ $customer->customerPersonalDetail->display_name ?? $customer->name }}</h3>
            <p class="text-sm text-gray-600">Customer Profile</p>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🧾 Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Name:</h4>
                <p class="text-gray-700">{{ $customer->name }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">{{ $customer->email }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Phone:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->phone_number ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Status:</h4>
                <div class="space-x-2 mt-1">
                    @if($customer->email_verified_at)
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                    @else
                        <span class="inline-block px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Pending Verification</span>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Registered On:</h4>
                <p class="text-gray-700">{{ $customer->created_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Display Name:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->display_name ?? 'Not set' }}</p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">📞 Contact Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Phone Number:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->phone_number ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">{{ $customer->email }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Country:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->country ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">City:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->city ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Address:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->address ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Postcode:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->postal_code ?? 'Not provided' }}</p>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🎂 Personal Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Date of Birth:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->date_of_birth ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Gender:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->gender ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Nationality:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->nationality ?? 'Not provided' }}</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Language:</h4>
                <p class="text-gray-700">{{ $customer->customerPersonalDetail->language ?? 'Not provided' }}</p>
            </div>
        </div>
    </div>

    <!-- Passport Details -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🛂 Passport Details</h3>
        <div class="bg-gray-50 p-4 rounded">
            @if($customer->customerPersonalDetail && $customer->customerPersonalDetail->passport_details)
                <div class="whitespace-pre-line text-gray-700">{{ $customer->customerPersonalDetail->passport_details }}</div>
            @else
                <p class="text-gray-500 italic">No passport details available</p>
            @endif
        </div>
    </div>
</div>
@endsection
