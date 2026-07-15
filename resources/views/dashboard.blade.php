<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Componente React: Favoritos recientes --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div id="react-favoritos"></div>
                </div>

                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-900 dark:text-gray-100">
                        Bienvenido a TechStore Explorer. Explora productos y guarda tus favoritos.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @viteReactRefresh
    @vite('resources/js/app.js')
</x-app-layout>
