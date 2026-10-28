@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-green-500 text-start text-base font-medium text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-950/40 focus:outline-none focus:text-green-800 dark:focus:text-green-200 focus:bg-green-100 dark:focus:bg-green-900 focus:border-green-600 dark:focus:border-green-400 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-green-700 dark:hover:text-green-300 hover:bg-green-50/50 dark:hover:bg-gray-800 hover:border-green-300 dark:hover:border-green-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
