@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 text-sm font-medium text-primary bg-primary/5 rounded-lg transition-colors'
            : 'inline-flex items-center px-3 py-2 text-sm font-medium text-muted hover:text-primary hover:bg-fondo rounded-lg transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
