@extends('frontend.master')

@section('content')
<style>
    .messages-container {
        height: calc(100vh - 180px);
        min-height: 500px;
    }
    .conversation-list {
        max-height: calc(100vh - 280px);
        overflow-y: auto;
    }
    .chat-messages {
        max-height: calc(100vh - 380px);
        overflow-y: auto;
    }
    .conversation-item.active {
        background: #EBF5FF;
        border-color: #0071C2;
    }
    .conversation-item:hover {
        background: #F5F5F5;
    }
    .message-bubble-sent {
        background: linear-gradient(135deg, #0071C2, #003B95);
    }
    .message-bubble-received {
        background: #F1F1F1;
    }
</style>

<div class="bg-gray-100 min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
            <p class="text-gray-600">Chat with property hosts about your bookings</p>
        </div>

        <!-- Messages Layout -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden messages-container">
            <div class="grid grid-cols-1 lg:grid-cols-3 h-full">

                <!-- Conversations Sidebar -->
                <div class="lg:col-span-1 border-r border-gray-200 flex flex-col">
                    <!-- Sidebar Header -->
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <h2 class="font-semibold text-gray-800">Conversations</h2>
                            @if($unreadCount > 0)
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $unreadCount }} new</span>
                            @endif
                        </div>
                    </div>

                    <!-- Conversation List -->
                    <div class="conversation-list flex-1">
                        @forelse($conversations as $conversation)
                        <div class="conversation-item p-4 border-b border-gray-100 cursor-pointer transition-all duration-200 {{ isset($booking) && $booking->id == $conversation['booking_id'] ? 'active' : '' }}"
                             data-booking-id="{{ $conversation['booking_id'] }}">
                            <div class="flex items-center gap-3">
                                <!-- Avatar -->
                                <div class="w-12 h-12 bg-[#0071C2] rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($conversation['partner_name'], 0, 2)) }}</span>
                                </div>

                                <!-- Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-semibold text-gray-900 truncate">{{ $conversation['partner_name'] }}</h3>
                                        <span class="text-xs text-gray-500 flex-shrink-0 ml-2">{{ $conversation['time_ago'] }}</span>
                                    </div>
                                    <p class="text-sm text-[#0071C2] truncate">{{ $conversation['property_name'] }}</p>
                                    <p class="text-sm text-gray-500 truncate mt-1">{{ Str::limit($conversation['last_message'], 40) }}</p>
                                </div>

                                <!-- Unread indicator -->
                                @if($conversation['unread'] > 0)
                                <div class="w-3 h-3 bg-red-500 rounded-full flex-shrink-0"></div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-700 mb-2">No conversations yet</h3>
                            <p class="text-sm text-gray-500">Messages will appear here after you make a booking and communicate with the host.</p>
                            <a href="{{ route('home-listing') }}" class="inline-block mt-4 px-4 py-2 bg-[#0071C2] text-white rounded-lg text-sm font-medium hover:bg-[#005B9E] transition">
                                Browse Properties
                            </a>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="lg:col-span-2 flex flex-col bg-white" id="chat-area">
                    @if(isset($booking) && isset($messages))
                        @include('Customer.messages.conversation', ['booking' => $booking, 'messages' => $messages])
                    @else
                    <!-- Empty State -->
                    <div class="flex-1 flex items-center justify-center">
                        <div class="text-center p-8">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Select a conversation</h3>
                            <p class="text-gray-500">Choose a conversation from the left to view messages</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const conversationItems = document.querySelectorAll('.conversation-item');

    conversationItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all
            conversationItems.forEach(i => i.classList.remove('active'));
            // Add active to clicked
            this.classList.add('active');

            const bookingId = this.dataset.bookingId;
            loadConversation(bookingId);
        });
    });

    function loadConversation(bookingId) {
        const chatArea = document.getElementById('chat-area');
        chatArea.innerHTML = '<div class="flex-1 flex items-center justify-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#0071C2]"></div></div>';

        fetch(`/customer/messages/${bookingId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            chatArea.innerHTML = html;
            // Scroll to bottom of messages
            const messagesContainer = document.getElementById('messages-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            chatArea.innerHTML = '<div class="flex-1 flex items-center justify-center text-red-500">Failed to load conversation</div>';
        });
    }
});
</script>
@endsection
