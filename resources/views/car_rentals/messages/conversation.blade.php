<div class="flex flex-col h-full">

    <!-- Header -->
    <div class="p-4 border-b">
        <h3 class="font-bold">{{ $booking->user->name ?? 'Customer' }}</h3>
        <p class="text-sm text-gray-500">Booking #{{ $booking->id }}</p>
    </div>

    <!-- Messages -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" id="messages-container">
        @foreach($messages as $message)
            @if($message->sender_type === 'car_renter')
                <div class="flex justify-end">
                    <div class="bg-blue-500 text-white p-3 rounded-xl max-w-xs">
                        {{ $message->content }}
                    </div>
                </div>
            @else
                <div class="flex">
                    <div class="bg-white p-3 rounded-xl max-w-xs shadow">
                        {{ $message->content }}
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Input -->
    <div class="p-4 border-t">
        <form id="message-form" class="flex gap-2">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <input name="content" class="flex-1 border rounded-xl px-4 py-2" placeholder="Type message..." required>
            <button class="bg-blue-500 text-white px-4 rounded-xl">Send</button>
        </form>
    </div>
</div>

<script>
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('{{ route('car_rentals.messages.store') }}', {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('messages-container').insertAdjacentHTML(
            'beforeend',
            `<div class="flex justify-end">
                <div class="bg-blue-500 text-white p-3 rounded-xl max-w-xs">
                    ${data.message.content}
                </div>
            </div>`
        );
        this.reset();
    });
});
</script>
