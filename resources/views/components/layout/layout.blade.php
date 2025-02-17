<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="casaalba" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? "$title - Casa Alba" : 'Casa Alba' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-100 text-neutral-800 min-h-screen w-full">
<noscript>Por favor activa el JavaScript, ya que es necesario para acceder a la tienda!</noscript>
@persist('loading_wall')
<div id="loading_wall" class="absolute top-0 left-0 w-full h-full bg-white/90 z-50">
    <div class="flex relative items-center justify-center h-full">
        <x-loading class="w-36 text-primary"/>
        <img src="{{ asset('images/casaalba.webp') }}" alt="Cargando..." class="absolute w-32 border rounded-full"/>
    </div>
</div>
@endpersist
<main class="min-h-screen w-full container mx-auto bg-neutral-100 p-2 md:p-0">
    @if(isset($slot))
        {{ $slot }}
    @endif
</main>
<livewire:toasts/>
<x-layout.footer/>
@livewireScriptConfig
</body>
</html>
