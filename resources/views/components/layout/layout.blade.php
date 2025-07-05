<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="casaalba" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ isset($title) ? "$title - Casa Alba" : 'Casa Alba' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Casa Alba" />
    <link rel="manifest" href="{{ asset('/site.webmanifest') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit"></script>
</head>
<body class="font-pacifico subpixel-antialiased h-screen">
<noscript class="flex items-center justify-center bg-red-300 text-red-900 w-full h-10">Por favor activa el JavaScript, ya que es necesario para acceder a la tienda!</noscript>
<main class="min-h-screen md:p-0">
    @if(isset($slot))
        {{ $slot }}
    @endif
</main>
<livewire:toasts/>
@livewireScriptConfig
</body>
</html>
