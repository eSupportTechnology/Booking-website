
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Chat Header -->
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center space-x-4">
                <div class="h-12 w-12 bg-green-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ substr($booking->user->name ?? 'G', 0, 2) }}</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $booking->user->name ?? 'Guest' }}</h3>
                    <p class="text-sm text-gray-600">{{ $booking->property->title ?? 'Property' }} - Booking #{{ $booking->id }}</p>
                    <p class="text-xs text-blue-600">{{ $booking->check_in->format('M d') }} - {{ $booking->check_out->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50 h-96" id="messages-container">
            @foreach($messages as $message)
                @if($message->sender_id == Auth::id())
                    <!-- Partner Message -->
                    <div class="flex justify-end">
                        <div class="bg-blue-500 text-white p-4 rounded-2xl rounded-tr-lg shadow-sm max-w-xs">
                            <p class="text-sm">{{ $message->content }}</p>
                            <span class="text-xs text-blue-200 mt-2 block">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @else
                    <!-- Guest Message -->
                    <div class="flex items-start space-x-3">
                        <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-xs">{{ substr($message->sender->name ?? 'G', 0, 2) }}</span>
                        </div>
                        <div class="bg-white p-4 rounded-2xl rounded-tl-lg shadow-sm max-w-xs">
                            <p class="text-sm text-gray-800">{{ $message->content }}</p>
                            <span class="text-xs text-gray-500 mt-2 block">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Message Input -->
        <div class="p-6 border-t border-gray-100">
            <form id="message-form" class="flex items-center space-x-4">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <input type="text" name="content" placeholder="Type your message..."
                       class="flex-1 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <button type="submit" class="bg-blue-500 text-white p-3 rounded-xl hover:bg-blue-600">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const messageInput = this.querySelector('input[name="content"]');

    fetch('/partner/messages', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const messagesContainer = document.getElementById('messages-container');
            const messageHtml = `
                <div class="flex justify-end">
                    <div class="bg-blue-500 text-white p-4 rounded-2xl rounded-tr-lg shadow-sm max-w-xs">
                        <p class="text-sm">${data.message.content}</p>
                        <span class="text-xs text-blue-200 mt-2 block">Just now</span>
                    </div>
                </div>
            `;
            messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            messageInput.value = '';
        }
    });
});
</script>
