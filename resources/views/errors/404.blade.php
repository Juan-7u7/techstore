<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>404 — TechStore Explorer</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <style>
            body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        </style>
        @vite(['resources/css/app.css'])
    </head>
    <body class="bg-fondo text-primary antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 text-center">
            <img src="{{ asset('images/logo.svg') }}" alt="TechStore" class="h-14 w-auto mb-6">
            <h1 class="text-7xl sm:text-8xl font-heading font-bold text-accent/60 leading-none">404</h1>
            <p class="text-xl sm:text-2xl font-heading font-semibold text-primary mt-4">Página no encontrada</p>
            <p class="text-sm text-muted mt-2 max-w-md">La página que buscas no existe o fue movida. Revisa la URL o vuelve al inicio.</p>
            <a href="{{ route('productos.index') }}" class="mt-8 btn-pill-primary text-sm">
                ← Volver al inicio
            </a>
        </div>
    </body>
</html>
