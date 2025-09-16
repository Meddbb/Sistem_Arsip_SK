@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 text-start text-base font-bold text-yellow-400 nav-underline-animated active focus:outline-none focus:text-yellow-300 transition-all duration-500 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 text-start text-base font-bold text-white nav-underline-animated hover:text-yellow-300 focus:outline-none focus:text-yellow-400 transition-all duration-500 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
