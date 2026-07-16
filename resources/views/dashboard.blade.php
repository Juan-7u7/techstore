<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-semibold text-xl text-dark leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Componente React: Favoritos recientes --}}
            <div class="bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6">
                <h3 class="text-lg font-heading font-semibold text-dark mb-4">Favoritos recientes</h3>
                <div id="react-favoritos"></div>
            </div>

            {{-- Bienvenida --}}
            <div class="md:col-span-2 bg-white rounded-2xl border border-accent/20 shadow-stack-sm p-6 flex flex-col justify-center">
                <h3 class="text-lg font-heading font-semibold text-dark">Bienvenido a TechStore Explorer</h3>
                <p class="text-dark/60 mt-2">
                    Explora productos desde la Fake Store API y guarda tus favoritos para verlos despues.
                </p>
                <a href="{{ route('productos.index') }}" wire:navigate
                   class="mt-4 inline-flex items-center gap-2 text-primary font-medium hover:text-primary/70 transition self-start">
                    Explorar productos &rarr;
                </a>
            </div>
        </div>
    </div>

    @viteReactRefresh
    @vite('resources/js/app.jsx')
</x-app-layout>
