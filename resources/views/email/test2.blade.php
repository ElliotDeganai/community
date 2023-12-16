@component('mail::message')
# Introduction

The body of your message.

Thanks {{ $user->name }},<br>
{{ config('app.name') }}
@endcomponent
