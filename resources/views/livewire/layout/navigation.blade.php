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

<nav x-data="{ open: false }" class="bg-surface border-b border-border/50 sticky top-0 z-50 backdrop-blur-lg bg-surface/90"
     x-on:keydown.escape.window="open = false">
    <div class="border-t-[3px] border-accent/40"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('productos.index') }}" wire:navigate class="flex items-center gap-2.5 shrink-0">
                    <img src="{{ asset('images/logo.svg') }}" alt="TechStore" class="h-7 w-auto">
                    <span class="font-heading font-semibold text-primary text-lg tracking-tight">TechStore</span>
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

    <template x-teleport="body">
        <div x-show="open" class="relative sm:hidden z-50" x-cloak>
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/30 backdrop-blur-sm" @click="open = false"></div>

            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed top-0 right-0 bottom-0 w-full max-w-sm bg-surface border-l border-border/50 flex flex-col overflow-y-auto">
                <div class="flex items-center justify-between px-5 py-4 border-b border-border/30">
                    <a href="{{ route('productos.index') }}" wire:navigate class="flex items-center gap-2.5" @click="open = false">
                        <img src="{{ asset('images/logo.svg') }}" alt="TechStore" class="h-7 w-auto">
                        <span class="font-heading font-semibold text-primary text-lg tracking-tight">TechStore</span>
                    </a>
                    <button @click="open = false" class="p-2 rounded-lg text-muted hover:bg-border/50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 px-4 py-6 space-y-0.5">
                    <a href="{{ route('productos.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('productos.*') ? 'text-primary bg-primary/5' : 'text-muted hover:text-primary hover:bg-fondo' }} transition-colors" @click="open = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Productos
                    </a>
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'text-primary bg-primary/5' : 'text-muted hover:text-primary hover:bg-fondo' }} transition-colors" @click="open = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                        </svg>
                        Dashboard
                    </a>
                </div>

                <div class="border-t border-border/30 px-4 py-5">
                    @auth
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-10 h-10 rounded-full bg-accent/20 flex items-center justify-center text-sm font-semibold text-accent shrink-0">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-primary truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-muted truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-0.5">
                            <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-3 px-3 py-3 text-sm font-medium text-muted hover:text-primary hover:bg-fondo rounded-lg transition-colors" @click="open = false">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                                Mi perfil
                            </a>
                            <button wire:click="logout" class="w-full flex items-center gap-3 px-3 py-3 text-sm font-medium text-muted hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                </svg>
                                Cerrar sesión
                            </button>
                        </div>
                    @else
                        <div class="space-y-3">
                            <a href="{{ route('login') }}" wire:navigate class="block w-full text-center btn-pill-ghost" @click="open = false">Ingresar</a>
                            <a href="{{ route('register') }}" wire:navigate class="block w-full text-center btn-pill-primary" @click="open = false">Registrarse</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </template>
</nav>
