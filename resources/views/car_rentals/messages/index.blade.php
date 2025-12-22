@extends('car_rentals.master')
@section('title', 'Messages')

@section('content')
<div class="space-y-4">

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
        <h1 class="text-3xl font-bold">Messages</h1>
        <p class="text-blue-100">Chat with your customers</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 h-[600px]">

        <!-- Conversation List -->
        <div class="lg:col-span-1 bg-white rounded-2xl shadow border">
            <div class="p-4 border-b">
                <h2 class="font-bold">Conversations</h2>
            </div>

            <div class="overflow-y-auto p-3 space-y-3">
                @foreach($conversations as $conversation)
                <div class="conversation-item p-4 border rounded-xl cursor-pointer hover:bg-gray-50"
                     data-booking-id="{{ $conversation['booking_id'] }}">
                    <div class="flex space-x-3">
                        <div class="h-10 w-10 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold">
                                {{ substr($conversation['customer_name'], 0, 2) }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">{{ $conversation['customer_name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $conversation['last_message'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="lg:col-span-3 bg-white rounded-2xl shadow border flex flex-col"
             id="chat-area">
            <div class="flex-1 flex items-center justify-center text-gray-400">
                Select a conversation
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.conversation-item').forEach(item => {
    item.addEventListener('click', function () {
        fetch(`/car-rentals/messages/${this.dataset.bookingId}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('chat-area').innerHTML = html;
            });
    });
});
</script>
@endsection
