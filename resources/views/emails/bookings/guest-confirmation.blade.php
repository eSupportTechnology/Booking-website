@component('mail::message')
# Booking Confirmation

Dear {{ $guest->name }},

Your booking has been confirmed! Here are your booking details:

@component('mail::panel')
**Property:** {{ $property->title }}  
**Check-in:** {{ $booking->check_in->format('M d, Y') }}  
**Check-out:** {{ $booking->check_out->format('M d, Y') }}  
**Guests:** {{ $booking->guest_count }}  
**Total Amount:** {{ $booking->currency }} {{ number_format($booking->total_price, 2) }}  
**Booking ID:** #{{ $booking->id }}
@endcomponent

**Property Address:**  
{{ $property->address }}, {{ $property->city }}, {{ $property->country }}

We look forward to hosting you!

Thanks,<br>
{{ config('app.name') }}
@endcomponent