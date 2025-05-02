@component('mail::message')
# Confirmation

Congratulation your payment for <b>{{$examInfo->exam_name}}</b>  is success.

@component('mail::panel')
Attendance Date: {{$examInfo->exam_date}} at {{$examInfo->exam_start_at}}
@endcomponent
{{--@component('mail::button', ['url' => ''])
Button Text
@endcomponent
--}}


Thanks,<br>
<a href="{{env("APP_URL")}}">{{ config('app.name') }}</a>
@endcomponent
