@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-accent/50 bg-white text-dark placeholder-dark/30 focus:border-primary focus:ring-primary/30 rounded-lg shadow-sm transition']) }}>
