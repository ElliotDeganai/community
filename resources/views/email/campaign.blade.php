@component('mail::message')
Salut {{ $user->name }},

Le secret santa  {{ $campaign->name }} vient d'etre lancé !

Pour renseigner tes vœux, tu dois aller sur le site web : <a href="{{ config('app.url') }}">{{ config('app.url') }}</a><div>

Voici les identifiants qui te permettront de te connecter :

Identifiant : {{ $user->email }}

Mot de passe :  {{ $password }}

Une fois connecté, tu verras sur la page d’accueil le nom de ton tiré au sort et sa liste (si il a commencé à ajouter des vœux).
Pour voir ta propre liste et commencer à y ajouter des vœux clique sur « Wishlist » et grâce au bouton « Ajouter une idée », tu pourras ouvrir le formulaire qui te permettra d’ajouter tes vœux,

Contacte moi si il y a le moindre soucis d’utilisation,

{{ config('app.name') }} Team,
@endcomponent
