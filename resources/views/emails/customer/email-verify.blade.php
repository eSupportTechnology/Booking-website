@component('mail::message')
# Your Verification Code

Your verification code is: **{{ $otp }}**

This code will expire in 10 minutes.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
