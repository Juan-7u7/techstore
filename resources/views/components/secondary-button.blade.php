<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-surface border border-border/70 rounded-full font-medium text-sm text-muted hover:text-primary hover:border-border focus:outline-none focus:ring-2 focus:ring-accent/40 focus:ring-offset-2 disabled:opacity-40 transition-all duration-200']) }}>
    {{ $slot }}
</button>
