<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="kpi-card border border-red-200/60">
    <header>
        <h2 class="font-heading font-semibold text-red-600">Zona de peligro</h2>
        <p class="mt-1 text-sm text-muted">Una vez eliminada tu cuenta, no podrás recuperarla</p>
    </header>

    <div class="mt-5">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold text-white bg-red-500 hover:bg-red-600 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Eliminar cuenta
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6 space-y-5">
            <h2 class="font-heading font-semibold text-primary">¿Eliminar tu cuenta?</h2>

            <p class="text-sm text-muted leading-relaxed">
                Esta acción es irreversible. Todos tus datos y favoritos se eliminarán permanentemente.
                Ingresa tu contraseña para confirmar.
            </p>

            <div>
                <x-input-label for="password" value="Contraseña" />
                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1.5 block w-full"
                    placeholder="Ingresa tu contraseña"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" x-on:click="$dispatch('close')" class="btn-pill-ghost text-sm">
                    Cancelar
                </button>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-semibold text-white bg-red-500 hover:bg-red-600 transition-colors">
                    Eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>
