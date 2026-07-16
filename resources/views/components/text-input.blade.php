@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-border/70 bg-surface text-primary placeholder-muted/50 focus:border-accent focus:ring-accent/30 rounded-xl transition-colors']) }}>
