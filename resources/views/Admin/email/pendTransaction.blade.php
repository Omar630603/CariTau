@component('mail::message')
# Hello {{$student->name}}
We would like to inform you that your transaction has been pended
This might happen because of some issues with the transcation
@component('mail::panel')
# We Are Sorry
# You now have preview access to the course {{$course->course_name}}<br>
feel free to email us or send a comment in the contac us page in CariTau
The Team will let you know what was the reason behind the pending<br>
In the time being, you can also check the other courses in CariTau.
<br>
Wishing you all The best, hear from you soon. Selamat belajar :)
@endcomponent
# From CariTau Team:
{{$msg}}
@component('mail::subcopy')
Best regards,
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent