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
            <img src="{{ asset('storage/profile_photos/john_doe.jpg') }}" alt="Photo" class="w-full h-full object-cover">
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-800">John Doe</h3>
            <p class="text-sm text-gray-600">Customer Profile</p>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🧾 Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Name:</h4>
                <p class="text-gray-700">John Doe</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">johndoe@example.com</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Phone:</h4>
                <p class="text-gray-700">+94 77 123 4567</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Status:</h4>
                <div class="space-x-2 mt-1">
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Achieve</span>
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Inactive</span>
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Pending Verification</span>
                </div>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Registered On:</h4>
                <p class="text-gray-700">2024-07-01</p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="{{ url('/admin/customers/edit-basic-info') }}" class="text-white bg-[#1F8FB2] hover:bg-[#166f8b] px-4 py-2 rounded text-sm font-semibold transition">
                Edit
            </a>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">📞 Contact Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Phone Number:</h4>
                <p class="text-gray-700">+94 77 123 4567</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">johndoe@example.com</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Country:</h4>
                <p class="text-gray-700">Sri Lanka</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">City:</h4>
                <p class="text-gray-700">Colombo</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Street:</h4>
                <p class="text-gray-700">123 Main Street</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Postcode:</h4>
                <p class="text-gray-700">10100</p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="{{ url('/admin/customers/edit-contact-info') }}" class="text-white bg-[#1F8FB2] hover:bg-[#166f8b] px-4 py-2 rounded text-sm font-semibold transition">
                Edit
            </a>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🎂 Personal Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Date of Birth:</h4>
                <p class="text-gray-700">1990-05-15</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Gender:</h4>
                <p class="text-gray-700">Male</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Nationality:</h4>
                <p class="text-gray-700">Sri Lankan</p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="{{ url('/admin/customers/edit-personal-info') }}" class="text-white bg-[#1F8FB2] hover:bg-[#166f8b] px-4 py-2 rounded text-sm font-semibold transition">
                Edit
            </a>
        </div>
    </div>

    <!-- Passport Details -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🛂 Passport Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Passport Name:</h4>
                <p class="text-gray-700">John Michael Doe</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Passport Number:</h4>
                <p class="text-gray-700">N1234567</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Issuing Country:</h4>
                <p class="text-gray-700">Sri Lanka</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Passport Expiry Date:</h4>
                <p class="text-gray-700">2030-05-14</p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="{{ url('/admin/customers/edit-passport-details') }}" class="text-white bg-[#1F8FB2] hover:bg-[#166f8b] px-4 py-2 rounded text-sm font-semibold transition">
                Edit
            </a>
        </div>
    </div>
</div>
@endsection
