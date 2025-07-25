@extends('frontend.admin.master')

@section('content')
<div class="p-6 bg-white rounded shadow space-y-8">

    <!-- Page Title -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-[#1F8FB2]">⚙️ Settings</h2>
        <a href="{{ url('/admin/dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Tabs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sidebar Navigation -->
        <div class="space-y-4">
            <a href="#profile" class="block px-4 py-2 bg-[#E6F7FC] text-[#1F8FB2] rounded hover:bg-[#d0effb] font-medium">Profile</a>
            <a href="#business" class="block px-4 py-2 bg-[#E6F7FC] text-[#1F8FB2] rounded hover:bg-[#d0effb] font-medium">Business Info</a>
            <a href="#security" class="block px-4 py-2 bg-[#E6F7FC] text-[#1F8FB2] rounded hover:bg-[#d0effb] font-medium">Security</a>
            <a href="#notifications" class="block px-4 py-2 bg-[#E6F7FC] text-[#1F8FB2] rounded hover:bg-[#d0effb] font-medium">Notifications</a>
        </div>

        <!-- Settings Content -->
        <div class="md:col-span-2 space-y-8">

            <!-- Profile Settings -->
            <div id="profile" class="bg-gray-50 border rounded-lg shadow p-6 space-y-4">
                <h3 class="text-xl font-semibold text-gray-700">👤 Profile Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Full Name</label>
                        <input type="text" class="mt-1 w-full border rounded px-3 py-2" value="John Partner">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email Address</label>
                        <input type="email" class="mt-1 w-full border rounded px-3 py-2" value="john@example.com">
                    </div>
                </div>
                <button class="mt-4 bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">Save Profile</button>
            </div>

            <!-- Business Info -->
            <div id="business" class="bg-gray-50 border rounded-lg shadow p-6 space-y-4">
                <h3 class="text-xl font-semibold text-gray-700">🏢 Business Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Business Name</label>
                        <input type="text" class="mt-1 w-full border rounded px-3 py-2" value="Partner Properties Ltd">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Phone Number</label>
                        <input type="text" class="mt-1 w-full border rounded px-3 py-2" value="+94 71 123 4567">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">City</label>
                        <input type="text" class="mt-1 w-full border rounded px-3 py-2" value="Colombo">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Country</label>
                        <input type="text" class="mt-1 w-full border rounded px-3 py-2" value="Sri Lanka">
                    </div>
                </div>
                <button class="mt-4 bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">Save Business Info</button>
            </div>

            <!-- Security -->
            <div id="security" class="bg-gray-50 border rounded-lg shadow p-6 space-y-4">
                <h3 class="text-xl font-semibold text-gray-700">🔒 Security Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Current Password</label>
                        <input type="password" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">New Password</label>
                        <input type="password" class="mt-1 w-full border rounded px-3 py-2">
                    </div>
                </div>
                <button class="mt-4 bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">Update Password</button>
            </div>

            <!-- Notifications -->
            <div id="notifications" class="bg-gray-50 border rounded-lg shadow p-6 space-y-4">
                <h3 class="text-xl font-semibold text-gray-700">🔔 Notification Preferences</h3>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox" checked>
                        <span>Send booking alerts via email</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="form-checkbox">
                        <span>Send promotional updates</span>
                    </label>
                </div>
                <button class="mt-4 bg-[#1F8FB2] text-white px-4 py-2 rounded hover:bg-[#157799] transition">Save Preferences</button>
            </div>

        </div>
    </div>
</div>
@endsection
