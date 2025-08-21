@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Settings</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Account Settings</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" value="{{ Auth::user()->name ?? 'Partner Name' }}" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" value="{{ Auth::user()->email ?? 'partner@example.com' }}" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="tel" placeholder="+1 234 567 8900" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Update Profile</button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Notification Preferences</h2>
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-2">
                    <span class="text-sm">New booking notifications</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-2">
                    <span class="text-sm">Message notifications</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="mr-2">
                    <span class="text-sm">Review notifications</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" checked class="mr-2">
                    <span class="text-sm">Payment notifications</span>
                </label>
                <button class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600">Save Preferences</button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Security</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="w-full bg-red-500 text-white py-2 rounded-md hover:bg-red-600">Change Password</button>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Payout Settings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Bank Name</label>
                <input type="text" placeholder="Enter bank name" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Account Number</label>
                <input type="text" placeholder="Enter account number" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Account Holder Name</label>
                <input type="text" placeholder="Enter account holder name" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Swift Code</label>
                <input type="text" placeholder="Enter swift code" class="mt-1 block w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
        <button class="mt-4 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Save Payout Details</button>
    </div>
</div>
@endsection