@extends('frontend.admin.master')

@section('content')
<div class="p-6 bg-[#1F8FB2] rounded shadow space-y-8">

    <!-- Page Title -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-white">Partner Details</h2>

        <a href="{{ url('/admin/partners') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Back to Partners
        </a>
    </div>

    <!-- Profile Section -->
    <div class="bg-white border rounded-lg shadow p-6 flex items-center space-x-6 relative">
        <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#3CC0E9] shadow">
            <img src="{{ asset('storage/profile_photos/partner_logo.jpg') }}" alt="Logo" class="w-full h-full object-cover">
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-800">Tech Solutions Ltd</h3>
            <p class="text-sm text-gray-600">Official Partner</p>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🧾 Basic Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Company Name:</h4>
                <p class="text-gray-700">Tech Solutions Ltd</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">contact@techsolutions.com</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Phone:</h4>
                <p class="text-gray-700">+94 77 987 6543</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Status:</h4>
                <div class="space-x-2 mt-1">
                    <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Active</span>
                </div>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Partner Since:</h4>
                <p class="text-gray-700">2023-05-10</p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="#" class="text-white bg-[#1F8FB2] hover:bg-[#166f8b] px-4 py-2 rounded text-sm font-semibold transition">
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
                <p class="text-gray-700">+94 77 987 6543</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Email:</h4>
                <p class="text-gray-700">contact@techsolutions.com</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Country:</h4>
                <p class="text-gray-700">Sri Lanka</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">City:</h4>
                <p class="text-gray-700">Kandy</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Street:</h4>
                <p class="text-gray-700">45/1 Business Road</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Postcode:</h4>
                <p class="text-gray-700">20000</p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="#" class="text-white bg-[#1F8FB2] hover:bg-[#166f8b] px-4 py-2 rounded text-sm font-semibold transition">
                Edit
            </a>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="bg-white border rounded-lg shadow p-6 relative">
        <h3 class="text-xl font-semibold text-[#1F8FB2] mb-4">🏢 Business Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-gray-800 font-medium">Business Type:</h4>
                <p class="text-gray-700">Software Solutions</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Registration No:</h4>
                <p class="text-gray-700">BR123456789</p>
            </div>
            <div>
                <h4 class="text-gray-800 font-medium">Website:</h4>
                <p class="text-gray-700">www.techsolutions.com</p>
            </div>
        </div>
        <div class="mt-6 text-right">
            <a href="#" class="text-white bg-[#1F8FB2] hover:bg-[#166f8b] px-4 py-2 rounded text-sm font-semibold transition">
                Edit
            </a>
        </div>
    </div>
</div>
@endsection
