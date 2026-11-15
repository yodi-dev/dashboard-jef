@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-stone-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:border-zinc-800 focus:ring-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 rounded-lg shadow-sm transition duration-150']) }}>
