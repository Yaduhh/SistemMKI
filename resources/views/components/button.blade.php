@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'class' => ''
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200';
    
    $variants = [
        'primary' => 'bg-primary-600 hover:bg-primary-700 text-white focus:ring-primary-500',
        'secondary' => 'bg-zinc-100 hover:bg-zinc-200 text-zinc-900 focus:ring-zinc-500 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:text-zinc-100',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
    ];
    
    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
    
    $classes = $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size] . ' ' . $class;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif 