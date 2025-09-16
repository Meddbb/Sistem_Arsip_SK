@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 text-sm font-bold text-yellow-400 nav-underline-animated active transition-all duration-500 ease-in-out'
            : 'inline-flex items-center px-3 py-2 text-sm font-bold text-white nav-underline-animated transition-all duration-500 ease-in-out hover:text-yellow-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
