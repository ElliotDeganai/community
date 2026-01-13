@component('mail::message')
Bonjour {{ $user->name }},

Votre RDV du {{ $rdv }} est bien confirmé.

Pour tous renseignement complémentaire, veuillez consulter le site web : <a href="{{ config('app.url') }}">{{ config('app.url') }}</a><div>

{{ config('app.name') }} Team,
@endcomponent
