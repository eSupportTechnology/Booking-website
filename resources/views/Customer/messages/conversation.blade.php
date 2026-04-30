<!-- Chat Header -->
<div class="p-4 border-b border-gray-200 bg-gray-50 flex-shrink-0">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-[#0071C2] rounded-full flex items-center justify-center">
            <span class="text-white font-bold">{{ strtoupper(substr($booking->property->user->name ?? 'H', 0, 2)) }}</span>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-gray-900">{{ $booking->property->user->name ?? 'Host' }}</h3>
            <p class="text-sm text-[#0071C2]">{{ $booking->property->title ?? 'Property' }}</p>
            <div class="flex items-center gap-2 mt-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                       ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                       ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                    {{ ucfirst($booking->status) }}
                </span>
                <span class="text-xs text-gray-500">Booking #{{ $booking->id }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Messages Container -->
<div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" id="messages-container" style="max-height: calc(100vh - 380px);">
    @if($messages->count() > 0)
        @foreach($messages as $message)
            @if($message->sender_id == Auth::guard('customer')->id())
                <!-- Sent Message -->
                <div class="flex justify-end">
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-[#0071C2] text-white p-3 rounded-2xl rounded-br-md shadow-sm">
                            <p class="text-sm">{{ $message->content }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 text-right">{{ $message->created_at->format('M d, h:i A') }}</p>
                    </div>
                </div>
            @else
                <!-- Received Message -->
                <div class="flex justify-start">
                    <div class="flex items-end gap-2 max-w-xs lg:max-w-md">
                        <div class="w-8 h-8 bg-[#0071C2] rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-semibold text-xs">{{ strtoupper(substr($message->sender->name ?? 'H', 0, 2)) }}</span>
                        </div>
                        <div>
                            <div class="bg-white p-3 rounded-2xl rounded-bl-md shadow-sm border border-gray-200">
                                <p class="text-sm text-gray-800">{{ $message->content }}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('M d, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="flex items-center justify-center h-full">
            <div class="text-center">
                <p class="text-gray-500">No messages yet</p>
                <p class="text-sm text-gray-400 mt-1">Start the conversation!</p>
            </div>
        </div>
    @endif
</div>

<!-- Message Input -->
<div class="p-4 border-t border-gray-200 bg-white flex-shrink-0">
    <form id="message-form" class="flex items-center gap-3">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
        <div class="flex-1">
            <input type="text"
                   name="content"
                   placeholder="Type your message..."
                   class="w-full border border-gray-300 rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#0071C2] focus:border-transparent"
                   autocomplete="off"
                   required>
        </div>
        <button type="submit"
                class="w-12 h-12 bg-[#0071C2] text-white rounded-full flex items-center justify-center hover:bg-[#005B9E] transition shadow-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
        </button>
    </form>
</div>

<script>
(function() {
    const messageForm = document.getElementById('message-form');
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const messageInput = this.querySelector('input[name="content"]');
            const submitBtn = this.querySelector('button[type="submit"]');
            const content = messageInput.value.trim();

            if (!content) return;

            // Disable button while sending
            submitBtn.disabled = true;

            fetch('/customer/messages', {
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
                    const now = new Date();
                    const timeStr = now.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ', ' +
                                   now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

                    const messageHtml = `
                        <div class="flex justify-end">
                            <div class="max-w-xs lg:max-w-md">
                                <div class="bg-[#0071C2] text-white p-3 rounded-2xl rounded-br-md shadow-sm">
                                    <p class="text-sm">${data.message.content}</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 text-right">${timeStr}</p>
                            </div>
                        </div>
                    `;
                    messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    messageInput.value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to send message. Please try again.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                messageInput.focus();
            });
        });
    }

    // Scroll to bottom on load
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
})();
</script>
