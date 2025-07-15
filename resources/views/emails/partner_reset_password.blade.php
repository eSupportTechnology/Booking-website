@component('mail::message')
# Password Reset Request

Hello Partner,

We received a request to reset your password for your partner account.

Click the button below to reset your password:

@component('mail::button', ['url' => url(route('partner.password.reset', ['token' => $token, 'email' => $email], false))])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
