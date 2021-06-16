@component('mail::message')
# Hello {{$student->name}}
We would like to inform you that your transaction has been approved

@component('mail::panel')
# Congratulations
# You now have full access to the course {{$course->course_name}}
You woun't regret this. You can also check the other courses in CariTau.
<br>
Wishing you all The best. Selamat belajar :)
@endcomponent
# From CariTau Team:
{{$msg}}
@component('mail::subcopy')
Best regards,
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
