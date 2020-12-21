@component('mail::message')
# Hello {{$client->name}}
Your Pin Code is {{$client->pin_code}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
