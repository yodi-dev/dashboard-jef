<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
                inline-flex items-center justify-center
                px-4 py-2.5
                rounded-lg
                font-medium text-xs tracking-wider uppercase
    
                bg-zinc-900 text-white
                hover:bg-zinc-800
                active:bg-zinc-950
    
                dark:bg-zinc-100 dark:text-zinc-900
                dark:hover:bg-white
                dark:active:bg-zinc-200
    
                focus:outline-none
                focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-100
                focus:ring-offset-2
                dark:focus:ring-offset-zinc-900
    
                disabled:opacity-50 disabled:cursor-not-allowed
                transition ease-in-out duration-150 shadow-sm
            ',
    ]) }}>
    {{ $slot }}
</button>
