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
    <div class="text-center mb-6">
        <h2 class="text-heading text-primary">Iniciar sesion</h2>
        <p class="text-sm text-muted mt-1">Accede a tu cuenta para gestionar favoritos</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <div>
            <x-input-label for="email" :value="__('Correo electronico')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Contrasena')" />
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="********" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center gap-2">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-border/70 text-accent focus:ring-accent" name="remember">
                <span class="text-sm text-muted">Recordarme</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-accent hover:text-accent/80 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                    Olvidaste tu contrasena?
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center">
            Ingresar
        </x-primary-button>

        <p class="text-center text-sm text-muted">
            No tienes cuenta?
            <a href="{{ route('register') }}" wire:navigate class="text-accent font-medium hover:text-accent/80 transition-colors">Registrate</a>
        </p>
    </form>
</div>
