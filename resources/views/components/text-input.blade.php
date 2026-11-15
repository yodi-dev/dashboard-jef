@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:outline-none focus:border-zinc-800 focus:ring-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 rounded-md shadow-sm']) }}>
