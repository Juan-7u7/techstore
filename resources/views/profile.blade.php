<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-8 pb-12">
        <div class="flex items-center gap-4">
            <span class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-accent/20 flex items-center justify-center text-lg sm:text-xl font-semibold text-accent shrink-0">
                {{ substr(auth()->user()->name, 0, 2) }}
            </span>
            <div class="min-w-0">
                <h1 class="text-heading text-primary">{{ auth()->user()->name }}</h1>
                <p class="text-sm text-muted truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <livewire:profile.update-profile-information-form />

        <livewire:profile.update-password-form />

        <livewire:profile.delete-user-form />
    </div>
</x-app-layout>
