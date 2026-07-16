<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-dark border-b border-white/10 shadow-lg">
    <!-- Barra de navegacion principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                        <x-application-logo class="block h-8 w-auto fill-current text-accent" />
                        <span class="font-bold text-white hidden sm:inline">TechStore</span>
                    </a>
                </div>

                <!-- Links de navegacion -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex items-center">
                    <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" wire:navigate>
                        Productos
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            @auth
                <!-- Menu de usuario autenticado -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-4 py-2 border border-accent/20 text-sm font-medium rounded-lg text-white bg-primary/20 hover:bg-primary/30 focus:outline-none transition">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                                <svg class="fill-current h-4 w-4 text-accent" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                Perfil
                            </x-dropdown-link>

                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    Cerrar sesion
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <!-- Botones para invitados -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                    <a href="{{ route('login') }}" wire:navigate class="px-4 py-2 text-sm font-medium text-white hover:text-accent transition">Ingresar</a>
                    <a href="{{ route('register') }}" wire:navigate class="px-4 py-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary/80 transition">Registrarse</a>
                </div>
            @endauth

            <!-- Boton hamburguesa responsive -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-accent hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu responsive movil -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-dark/95 border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" wire:navigate>
                Productos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                Dashboard
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-white/10 px-4">
                <div class="text-white font-medium">{{ auth()->user()->name }}</div>
                <div class="text-sm text-white/60">{{ auth()->user()->email }}</div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        Perfil
                    </x-responsive-nav-link>
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            Cerrar sesion
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-white/10 px-4 space-y-2">
                <a href="{{ route('login') }}" wire:navigate class="block px-3 py-2 text-sm font-medium text-white hover:text-accent transition">Ingresar</a>
                <a href="{{ route('register') }}" wire:navigate class="block px-3 py-2 text-sm font-medium text-center rounded-lg bg-primary text-white hover:bg-primary/80 transition">Registrarse</a>
            </div>
        @endauth
    </div>
</nav>
