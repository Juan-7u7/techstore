<nav class="flex items-center gap-4">
    @auth
        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-primary hover:text-primary/70 transition">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="text-sm font-medium text-dark/70 hover:text-primary transition">Ingresar</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium rounded-lg bg-primary text-white hover:bg-primary/80 transition">Registrarse</a>
        @endif
    @endauth
</nav>
