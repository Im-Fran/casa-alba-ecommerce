<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="casaalba" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? "$title - Casa Alba" : 'Casa Alba' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-50 text-neutral-800 min-h-screen w-full">
<noscript>Por favor activa el JavaScript, ya que es necesario para acceder a la tienda!</noscript>
<main class="min-h-screen w-full bg-neutral-50 p-2 md:p-0">
    @if(isset($slot))
        {{ $slot }}
    @endif
</main>
<livewire:toasts/>
<x-layout.footer/>
@livewireScriptConfig
</body>
</html>
