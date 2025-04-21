<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Point of Sale') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-sans antialiased">

<div class="min-h-screen flex bg-gray-100">

    <!-- Sidebar -->
    @include('layouts.navigation')

    <!-- Page Content -->
    <main class="flex-grow bg-cover bg-center relative"
          style="background-image: url({{ asset('storage/images/bg2.png') }});
                 background-size: cover;
                 background-attachment: fixed;">
        <!-- White overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black to-white opacity-70"
             style="background-size: cover; background-attachment: fixed;"></div>

        <div class="max-w-10xl mx-auto py-4 px-4 sm:px-6 lg:px-8 relative z-10">
            {{ $slot }}
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
