@component('mail::message')
# New Booking Received

Dear {{ $partner->name }},

You have received a new booking for your property!

@component('mail::panel')
**Property:** {{ $property->title }}  
**Guest:** {{ $guest->name }}  
**Email:** {{ $guest->email }}  
**Check-in:** {{ $booking->check_in->format('M d, Y') }}  
**Check-out:** {{ $booking->check_out->format('M d, Y') }}  
**Guests:** {{ $booking->guest_count }}  
**Total Amount:** {{ $booking->currency }} {{ number_format($booking->total_price, 2) }}  
**Booking ID:** #{{ $booking->id }}
@endcomponent

Please ensure your property is ready for the guest's arrival.

Thanks,<br>
{{ config('app.name') }}
@endcomponent