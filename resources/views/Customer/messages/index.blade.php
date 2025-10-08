@extends('Customer.master')

@section('content')
<section class="min-h-screen p-4 bg-white">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-2" >
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">Messages</h1>
                        <p class="text-blue-100 text-lg">Chat with your hosts</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 px-4 py-2 rounded-xl">
                            <span class="text-sm font-medium">{{ $unreadCount }} Unread</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages Interface -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 h-[600px]">
                <!-- Conversations List -->
                <div class="lg:col-span-1 bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800">Conversations</h2>
                        <p class="text-sm text-gray-600 mt-1">Your bookings</p>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-3">
                        @forelse($conversations as $conversation)
                        <div class="p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors duration-200 conversation-item"
                            data-booking-id="{{ $conversation['booking_id'] }}">
                            <div class="flex items-start space-x-3">
                                <div class="h-10 w-10 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr($conversation['partner_name'], 0, 2) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-semibold text-gray-900 truncate">{{ $conversation['partner_name'] }}</h3>
                                        <span class="text-xs text-gray-500">{{ $conversation['time_ago'] }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 truncate">{{ $conversation['property_name'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1 truncate">{{ $conversation['last_message'] }}</p>
                                </div>
                                @if($conversation['unread'] > 0)
                                <div class="bg-red-500 h-2 w-2 rounded-full"></div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-comments text-gray-300 text-4xl mb-4"></i>
                            <p class="text-gray-500">No conversations yet</p>
                            <p class="text-sm text-gray-400 mt-2">Messages will appear here after you make a booking</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="lg:col-span-3 bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col" id="chat-area">
                    <div class="flex-1 flex items-center justify-center text-gray-500">
                        <div class="text-center">
                            <i class="fas fa-comment-dots text-6xl mb-4 text-gray-300"></i>
                            <p class="text-xl">Select a conversation to start messaging</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const conversationItems = document.querySelectorAll('.conversation-item');

    conversationItems.forEach(item => {
        item.addEventListener('click', function() {
            const bookingId = this.dataset.bookingId;
            loadConversation(bookingId);
        });
    });

    function loadConversation(bookingId) {
        fetch(`/customer/messages/${bookingId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('chat-area').innerHTML = html;
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>
@endsection
