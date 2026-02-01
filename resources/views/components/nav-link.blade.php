@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 border-b-2
       border-green-500 dark:border-green-400
       text-sm font-medium leading-5
       text-gray-900 dark:text-gray-100
       focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent
       text-sm font-medium leading-5
       text-gray-500 dark:text-gray-400
       hover:text-green-600 dark:hover:text-green-400
       hover:border-green-300 dark:hover:border-green-600
       focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
