@component('mail::message')
Bonjour {{ $user->name }},

Tu trouveras dans cet email les informations qui te permettront de te connecter pour renseigner les détails de ton projet sur notre site.

Voici l'url de notre site : <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>

Voici les identifiants qui te permettront de te connecter :

Identifiant : {{ $user->email }}

Mot de passe :  {{ $password }}

Une dois connecté, clique sur "Ajouter un nouveau projet" pour commencer à documenter un nouveau projet.

{{ config('app.name') }} Team,
@endcomponent
