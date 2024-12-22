<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? "$title - Casa Alba" : 'Casa Alba' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-neutral-100 text-neutral-800 min-h-screen w-full">
    @include('components.layout.header')
    <main class="min-h-screen w-full container mx-auto">
        @if(isset($slot))
            {{ $slot }}
        @endif
    </main>

    @include('components.layout.footer')

    @livewireScripts
</body>
</html>
