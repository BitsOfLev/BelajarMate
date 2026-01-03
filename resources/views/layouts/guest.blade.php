<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center px-6 sm:px-6 lg:px-8"
         style="background: linear-gradient(to bottom right, #e0e7ff, #d8b4fe, #fbcfe8);">

        <!-- Logo Above Card -->
        <div class="mb-6">
            <a href="/">
                <x-application-logo class="w-24 h-24 text-purple-600" />
            </a>
        </div>

        <!-- Container Card (Wide & Short) -->
        <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-6 sm:p-8">
            <!-- Auth Slot -->
            <div class="space-y-4 text-gray-700">
                {{ $slot }}
            </div>
        </div>

    </div>

</body>
</html>





