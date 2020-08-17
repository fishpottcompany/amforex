@component('mail::message')
# One-Time Passcode


A login attempt has been made on your AM Forex account. 
Use this {{ $data['pass_code'] }} passcode to complete your login.


If you did not login, <a href="{{ config('app.url') }}/admin/hold">click here</a> to temporarily lock your account. 

Thanks,<br>
{{ config('app.name') }}
@endcomponent
