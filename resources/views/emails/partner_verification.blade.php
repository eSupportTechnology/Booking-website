@component('mail::message')
# Hello Partner,

Click the button below to verify your email and complete your registration:

@component('mail::button', ['url' => $verificationUrl])
Verify Email
@endcomponent

If you did not request this, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
