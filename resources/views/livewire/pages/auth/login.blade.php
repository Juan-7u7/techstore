<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    {{-- Encabezado del formulario --}}
    <div class="text-center mb-6">
        <h2 class="text-xl font-heading font-bold text-dark">Iniciar sesion</h2>
        <p class="text-sm text-dark/50 mt-1">Accede a tu cuenta para gestionar favoritos</p>
    </div>

    {{-- Mensaje de estado --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        {{-- Correo electronico --}}
        <div>
            <x-input-label for="email" :value="__('Correo electronico')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        {{-- Contrasena --}}
        <div>
            <x-input-label for="password" :value="__('Contrasena')" />
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="********" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        {{-- Recordarme --}}
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center gap-2">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-accent text-primary focus:ring-primary" name="remember">
                <span class="text-sm text-dark/60">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-primary hover:text-primary/70 transition" href="{{ route('password.request') }}" wire:navigate>
                    Olvidaste tu contrasena?
                </a>
            @endif
        </div>

        {{-- Boton de inicio de sesion --}}
        <x-primary-button class="w-full justify-center">
            Ingresar
        </x-primary-button>

        {{-- Enlace a registro --}}
        <p class="text-center text-sm text-dark/50">
            No tienes cuenta?
            <a href="{{ route('register') }}" wire:navigate class="text-primary font-medium hover:text-primary/70 transition">Registrate</a>
        </p>
    </form>
</div>
