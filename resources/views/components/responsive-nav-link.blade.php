@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-zinc-900 dark:border-zinc-100 text-start text-base font-semibold text-zinc-900 dark:text-zinc-100 bg-stone-100 dark:bg-zinc-800/60 focus:outline-none transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 hover:bg-stone-50 dark:hover:bg-zinc-800/40 hover:border-zinc-300 dark:hover:border-zinc-600 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
