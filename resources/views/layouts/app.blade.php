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
        <div class="min-h-screen flex flex-col">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-surface border-b border-border/50">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1 w-full mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                {{ $slot }}
            </main>

            <footer class="border-t border-border/50 mt-16 py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-muted">
                    <p>&copy; {{ date('Y') }} TechStore Explorer</p>
                    <div class="flex gap-6">
                        <a href="{{ route('productos.index') }}" class="hover:text-primary transition-colors">Productos</a>
                        <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                    </div>
                </div>
            </footer>
        </div>
        @stack('scripts')
    </body>
</html>
