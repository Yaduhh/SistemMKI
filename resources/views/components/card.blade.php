@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-zinc-800 overflow-hiddenp-4' . $class]) }}>
    {{ $slot }}
</div> 