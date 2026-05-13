<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title Dinamis (Default: My Kas) -->
    <title inertia>{{ config('app.name', 'My Kas') }}</title>

    <!-- Favicon Online -->
    <link rel="icon" href="https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/72x72/1f4b0.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
