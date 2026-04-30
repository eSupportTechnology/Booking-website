@extends('partner.master')
@section('title', 'Messages')
@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Messages</h1>
                <p class="text-gray-500 text-sm">Communicate with your guests</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">{{ $unreadCount }} unread</span>
                <button class="text-[#1F8FB2] text-sm hover:underline">Search</button>
            </div>
        </div>
    </div>

    <!-- Messages Interface -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 h-auto lg:h-[500px]">
        <!-- Conversations List -->
        <div class="lg:col-span-1 bg-white rounded-lg border border-gray-200 shadow-sm flex flex-col">
            <div class="px-4 py-3 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-800">Conversations</h2>
            </div>
            <div class="flex-1 overflow-y-auto p-2 space-y-1 max-h-[350px] lg:max-h-none">
                @forelse($conversations as $conversation)
                <div class="p-3 border {{ $loop->first ? 'border-[#1F8FB2] bg-blue-50' : 'border-gray-100' }} rounded-lg cursor-pointer hover:bg-gray-50 transition conversation-item"
                    data-booking-id="{{ $conversation['booking_id'] }}">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-[#1F8FB2] rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-xs font-medium">{{ substr($conversation['customer_name'], 0, 2) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h3 class="text-sm font-medium text-gray-900 truncate">{{ $conversation['customer_name'] }}</h3>
                                <span class="text-[10px] text-gray-400">{{ $conversation['time_ago'] }}</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $conversation['property_name'] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $conversation['last_message'] }}</p>
                        </div>
                        @if($conversation['unread'] > 0)
                        <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400 text-sm">No conversations</div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="lg:col-span-3 bg-white rounded-lg border border-gray-200 shadow-sm flex flex-col min-h-[350px] lg:min-h-0" id="chat-area">
            <div class="flex-1 flex items-center justify-center text-gray-400 p-4">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <p class="text-sm">Select a conversation to start messaging</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.conversation-item').forEach(item => {
        item.addEventListener('click', function() {
            fetch(`/partner/messages/${this.dataset.bookingId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('chat-area').innerHTML = html;
            });
        });
    });
});
</script>
@endsection
