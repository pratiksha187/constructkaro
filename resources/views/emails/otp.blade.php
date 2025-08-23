@component('mail::message')
# Your OTP

Use this code to continue:

@component('mail::panel')
<h2 style="text-align:center; letter-spacing:4px; margin:0;">{{ $code }}</h2>
@endcomponent

This code expires in {{ config('otp.expires_minutes', 10) }} minutes.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
