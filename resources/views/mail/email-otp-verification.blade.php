<x-mail::message>
# Hallo {{ $user?->fullname }}

This is your verification code OTP : {{ $userOtp->otp }}

Thanks<br>
{{ config('app.name') }}
</x-mail::message>
