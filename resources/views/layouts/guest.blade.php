<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TechStore Explorer') }}</title>

        <!-- Fuentes -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    </head>
    <body class="font-sans antialiased bg-accent/20 text-dark">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
            <!-- Logo y titulo -->
            <div class="text-center mb-6">
                <a href="/" wire:navigate class="inline-flex items-center gap-3">
                    <x-application-logo class="w-12 h-12 fill-current text-primary" />
                    <span class="text-2xl font-bold text-primary hidden sm:inline">TechStore</span>
                </a>
            </div>

            <!-- Tarjeta del formulario -->
            <div class="w-full sm:max-w-md bg-white border border-accent/50 shadow-lg rounded-2xl px-8 py-6">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="mt-8 text-sm text-dark/50">
                &copy; {{ date('Y') }} TechStore Explorer
            </footer>
        </div>
    </body>
</html>
