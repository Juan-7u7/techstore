<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TechStore Explorer') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    </head>
    <body class="font-sans bg-fondo text-primary">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
            <div class="text-center mb-8">
                <a href="/" wire:navigate class="inline-flex items-center gap-3">
                    <x-application-logo class="w-10 h-10 fill-current text-primary" />
                    <span class="text-xl font-heading font-semibold text-primary tracking-tight hidden sm:inline">TechStore</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-surface border border-border/60 shadow-soft-lg rounded-2xl px-8 py-8">
                {{ $slot }}
            </div>

            <footer class="mt-8 text-sm text-muted">
                &copy; {{ date('Y') }} TechStore Explorer
            </footer>
        </div>
    </body>
</html>
