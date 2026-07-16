<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    {{-- Encabezado del formulario --}}
    <div class="text-center mb-6">
        <h2 class="text-xl font-heading font-bold text-dark">Crear cuenta</h2>
        <p class="text-sm text-dark/50 mt-1">Registrate para guardar tus productos favoritos</p>
    </div>

    <form wire:submit="register" class="space-y-5">
        {{-- Nombre completo --}}
        <div>
            <x-input-label for="name" :value="__('Nombre completo')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" placeholder="Tu nombre" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Correo electronico --}}
        <div>
            <x-input-label for="email" :value="__('Correo electronico')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Contrasena --}}
        <div>
            <x-input-label for="password" :value="__('Contrasena')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="********" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirmar contrasena --}}
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar contrasena')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="********" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Boton de registro --}}
        <x-primary-button class="w-full justify-center">
            Crear cuenta
        </x-primary-button>

        {{-- Enlace a inicio de sesion --}}
        <p class="text-center text-sm text-dark/50">
            Ya tienes cuenta?
            <a href="{{ route('login') }}" wire:navigate class="text-primary font-medium hover:text-primary/70 transition">Inicia sesion</a>
        </p>
    </form>
</div>
