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

            <footer class="border-t border-border/50 mt-16">
                <div class="border-t-[3px] border-accent/30 w-full"></div>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                    <div class="grid grid-cols-1 sm:grid-cols-3 text-center sm:text-left">
                        <div class="flex flex-col items-center sm:items-start gap-3 pb-6 sm:pb-0 border-b border-border/30 sm:border-0">
                            <a href="{{ route('productos.index') }}" wire:navigate class="flex items-center gap-2.5">
                                <img src="{{ asset('images/logo.svg') }}" alt="TechStore" class="h-7 w-auto">
                                <span class="font-heading font-semibold text-primary text-lg tracking-tight">TechStore</span>
                            </a>
                            <p class="text-xs text-muted">&copy; {{ date('Y') }} TechStore Explorer</p>
                        </div>

                        <div class="flex flex-col items-center sm:items-start gap-2 py-6 sm:py-0 border-b border-border/30 sm:border-0">
                            <p class="text-xs font-medium text-muted uppercase tracking-wider">Desarrollador</p>
                            <p class="text-sm text-primary font-medium">Juan Carlos Hernandez Trujillo</p>
                            <a href="https://github.com/Juan-7u7" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 text-sm text-muted hover:text-primary transition-colors py-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                                </svg>
                                github.com/Juan-7u7
                            </a>
                        </div>

                        <div class="flex flex-col items-center sm:items-start gap-2 pt-6 sm:pt-0">
                            <p class="text-xs font-medium text-muted uppercase tracking-wider">Navegación</p>
                            <div class="flex flex-wrap justify-center sm:flex-col gap-x-4 gap-y-1">
                                <a href="{{ route('productos.index') }}" class="text-sm text-muted hover:text-primary transition-colors py-1">Productos</a>
                                <a href="{{ route('dashboard') }}" class="text-sm text-muted hover:text-primary transition-colors py-1">Dashboard</a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-border/30 text-center">
                        <p class="text-xs text-muted/60 leading-relaxed">
                            Hecho con Laravel, Livewire, Tailwind CSS y React
                            <br class="sm:hidden">
                            <span class="hidden sm:inline"> &middot; </span>
                            Datos: Platzi Fake Store API
                        </p>
                    </div>
                </div>
            </footer>
        </div>
        @stack('scripts')
    </body>
</html>
