@component('mail::message')
# Verify your new email address

Dear {{ $name }},

You've requested to log in or change the email address linked to your Booking.com account. For security reasons, we need to first verify your new email address.

### Your unique login code:

@component('mail::panel')
{{ $code }}
@endcomponent

> This code can only be used once and will expire in 10 minutes.
**Do not share this code with anyone else.**

If you didn’t request a verification code for the account linked to **{{ $email }}**, you can safely ignore this email.

Thanks,
The Booking Team
@endcomponent
