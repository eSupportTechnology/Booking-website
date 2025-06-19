@component('mail::message')
# Welcome to Our Platform!

Hello {{ $userName }},

Thank you for joining our platform using Google authentication. We're excited to have you on board!

## What's Next?

You can now access all the features available on our platform. Here are some things you can do:

- Explore your dashboard
- Set up your profile
- Start using our services

@component('mail::button', ['url' => config('app.url')])
Get Started
@endcomponent

If you have any questions or need assistance, feel free to reach out to our support team.

Thanks,<br>
{{ config('app.name') }}

---

*This email was sent because you successfully authenticated with Google on our platform.*
@endcomponent
