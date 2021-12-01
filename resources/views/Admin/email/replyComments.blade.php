@component('mail::message')
# Hello {{$c->name}}
We would like to reply to your message
@component('mail::panel')
# This is your message
{{$c->message}}
@endcomponent
# From CariTau Team:
{{$msg}}
{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}
@component('mail::subcopy')
Best regards,
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent