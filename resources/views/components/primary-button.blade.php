<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
                inline-flex items-center justify-center
                px-4 py-2
                rounded-lg
                font-semibold text-xs uppercase tracking-widest
    
                bg-green-600 text-white
                hover:bg-green-700
                active:bg-green-800
    
                dark:bg-green-500 dark:text-gray-900
                dark:hover:bg-green-400
                dark:active:bg-green-600
    
                focus:outline-none
                focus:ring-2 focus:ring-green-500
                focus:ring-offset-2
                dark:focus:ring-offset-gray-900
    
                transition ease-in-out duration-150
            ',
    ]) }}>
    {{ $slot }}
</button>
