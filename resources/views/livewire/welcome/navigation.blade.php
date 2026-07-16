<nav class="flex items-center gap-3">
    @auth
        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-muted hover:text-primary transition-colors">Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="text-sm font-medium text-muted hover:text-primary transition-colors">Ingresar</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn-pill-primary text-sm">Registrarse</a>
        @endif
    @endauth
</nav>
