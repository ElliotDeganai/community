<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Kalam&display=swap" rel="stylesheet">
        {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="icon" href="/storage/base/ED_2_Noir_Sans_fond_no_space.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">

        <!-- Scripts -->
        <script src="https://js.stripe.com/v3"></script>
        <script src="https://www.paypal.com/sdk/js?client-id=AULhHrRiQcike52hiLTXebHidwX2chUjKVxiF-U6tFL7eU4bGF5aUi5s53ENxz48YbTsZzwp5i7ZOVdY"></script>
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead

        <style>
            body {
                font-family: 'Kalam', cursive;
            }
          </style>
    </head>
    <body class="font-sans antialiased">
        @inertia

        @env ('local')
            <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv
    </body>
</html>
