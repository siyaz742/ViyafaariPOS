<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ViyafaariPOS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-main-dark antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white bg-cover bg-center bg-opacity-10 relative" style="background-image: url({{ asset('storage/images/bg2guest.png') }})">
        <div class="relative z-10">
            <div class="w-full h-full bg-gradient-to-t from-black to-tpwhite opacity-90"></div>
        </div>

        <div class="w-full sm:max-w-md mt-6 p-8 bg-gradient-to-l from-accent-light85 to-accent-dark85 shadow-md overflow-hidden rounded-3xl z-20">
            {{ $slot }}
        </div>
    </div>

    </body>

</html>
