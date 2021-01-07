@props(['href' => '#', 'size' => 'medium'])

@php
    $classes = 'leading-none bg-indigo-600 hover:bg-blue-dark text-white font-bold hover:bg-indigo-500 transition ease-in-out duration-300';

    if($size === 'medium') {
        $classes .= ' py-3 px-6 rounded-lg';
    }

    if($size === 'small') {
        $classes .= ' py-2 px-3 rounded text-sm';
    }
@endphp

<a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
    {{ $slot }}
</a>
