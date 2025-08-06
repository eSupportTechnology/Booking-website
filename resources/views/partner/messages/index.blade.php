@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Messages</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Conversations</h2>
            <div class="space-y-3">
                <div class="p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Sarah Johnson</h3>
                            <p class="text-sm text-gray-600">Ocean View Apartment</p>
                            <p class="text-xs text-gray-500 mt-1">What time is check-in?</p>
                        </div>
                        <span class="text-xs text-gray-400">2h ago</span>
                    </div>
                </div>
                <div class="p-3 border rounded hover:bg-gray-50 cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium">Mike Chen</h3>
                            <p class="text-sm text-gray-600">City Center Studio</p>
                            <p class="text-xs text-gray-500 mt-1">Is parking available?</p>
                        </div>
                        <span class="text-xs text-gray-400">1d ago</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
            <div class="border-b pb-4 mb-4">
                <h3 class="font-medium">Sarah Johnson</h3>
                <p class="text-sm text-gray-600">Ocean View Apartment - Booking #BK10234</p>
            </div>
            
            <div class="space-y-4 mb-4 h-64 overflow-y-auto">
                <div class="flex">
                    <div class="bg-gray-100 p-3 rounded-lg max-w-xs">
                        <p class="text-sm">Hi! What time is check-in for tomorrow?</p>
                        <span class="text-xs text-gray-500">2h ago</span>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="bg-blue-500 text-white p-3 rounded-lg max-w-xs">
                        <p class="text-sm">Check-in is from 3:00 PM onwards. I'll be available to meet you.</p>
                        <span class="text-xs text-blue-200">1h ago</span>
                    </div>
                </div>
            </div>

            <div class="flex space-x-2">
                <input type="text" placeholder="Type your message..." class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Send</button>
            </div>
        </div>
    </div>
</div>
@endsection