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

<nav x-data="{ open: false }" class="bg-surface border-b border-border/50 sticky top-0 z-50 backdrop-blur-lg bg-surface/90">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2.5 shrink-0">
                    <x-application-logo class="block h-7 w-auto fill-current text-primary" />
                    <span class="font-heading font-semibold text-primary text-lg tracking-tight hidden sm:inline">TechStore</span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" wire:navigate>
                        Productos
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-primary bg-fondo/80 rounded-full hover:bg-border/50 transition-colors border border-border/50">
                                    <span class="w-5 h-5 rounded-full bg-primary/10 flex items-center justify-center text-xs font-semibold text-primary">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                    <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                                    <svg class="h-4 w-4 text-muted" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile')" wire:navigate>
                                    Perfil
                                </x-dropdown-link>
                                <button wire:click="logout" class="w-full text-start">
                                    <x-dropdown-link>Cerrar sesion</x-dropdown-link>
                                </button>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('login') }}" wire:navigate class="btn-pill-ghost">Ingresar</a>
                        <a href="{{ route('register') }}" wire:navigate class="btn-pill-primary">Registrarse</a>
                    </div>
                @endauth

                <button @click="open = ! open" class="sm:hidden inline-flex items-center justify-center p-2 rounded-lg text-muted hover:bg-border/50 transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-border/50">
        <div class="pt-3 pb-4 px-4 space-y-1">
            <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')" wire:navigate>
                Productos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                Dashboard
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pb-4 px-4 border-t border-border/50 pt-4">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center text-sm font-semibold text-primary shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </span>
                    <div class="min-w-0">
                        <div class="text-sm font-medium text-primary truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-muted truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        Perfil
                    </x-responsive-nav-link>
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>Cerrar sesion</x-responsive-nav-link>
                    </button>
                </div>
            </div>
        @else
            <div class="pb-4 px-4 border-t border-border/50 pt-4 space-y-2">
                <a href="{{ route('login') }}" wire:navigate class="block w-full text-center btn-pill-ghost">Ingresar</a>
                <a href="{{ route('register') }}" wire:navigate class="block w-full text-center btn-pill-primary">Registrarse</a>
            </div>
        @endauth
    </div>
</nav>
