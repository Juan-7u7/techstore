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
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    </head>
    <body class="font-sans antialiased bg-fondo text-dark">
        <div class="min-h-screen flex flex-col">
            <livewire:layout.navigation />

            <!-- Encabezado de pagina -->
            @if (isset($header))
                <header class="bg-white border-b border-accent/30 shadow-stack-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Contenido principal -->
            <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-dark text-white/80 py-6 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
                    <p>&copy; {{ date('Y') }} TechStore Explorer. Todos los derechos reservados.</p>
                    <div class="flex gap-4">
                        <a href="{{ route('productos.index') }}" class="hover:text-accent transition">Productos</a>
                        <a href="{{ route('dashboard') }}" class="hover:text-accent transition">Dashboard</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
