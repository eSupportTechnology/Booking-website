@extends('partner.master')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800">Reviews</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow border-l-4" style="border-color: #1F8FB2;">
            <h2 class="text-sm text-gray-500">Overall Rating</h2>
            <p class="text-2xl font-bold text-gray-800">4.8 ⭐</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-sm text-gray-500">Total Reviews</h2>
            <p class="text-2xl font-bold text-gray-800">127</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-sm text-gray-500">This Month</h2>
            <p class="text-2xl font-bold text-gray-800">8</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
            <h2 class="text-sm text-gray-500">Response Rate</h2>
            <p class="text-2xl font-bold text-gray-800">95%</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Reviews</h2>
        <div class="space-y-4">
            <div class="border-b pb-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="font-medium">Sarah Johnson</h3>
                        <p class="text-sm text-gray-600">Ocean View Apartment</p>
                    </div>
                    <div class="text-right">
                        <div class="text-yellow-500">⭐⭐⭐⭐⭐</div>
                        <span class="text-xs text-gray-500">2 days ago</span>
                    </div>
                </div>
                <p class="text-gray-700">"Amazing apartment with stunning ocean views! The host was very responsive and helpful. Highly recommended!"</p>
                <button class="text-blue-600 text-sm mt-2 hover:underline">Reply</button>
            </div>
            
            <div class="border-b pb-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="font-medium">Mike Chen</h3>
                        <p class="text-sm text-gray-600">City Center Studio</p>
                    </div>
                    <div class="text-right">
                        <div class="text-yellow-500">⭐⭐⭐⭐</div>
                        <span class="text-xs text-gray-500">1 week ago</span>
                    </div>
                </div>
                <p class="text-gray-700">"Great location and clean apartment. Perfect for business trips."</p>
                <div class="mt-2 p-2 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600"><strong>Your reply:</strong> Thank you for staying with us! We're glad you enjoyed your stay.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection