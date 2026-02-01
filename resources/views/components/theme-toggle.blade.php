<button
    @click="
                        darkMode = !darkMode;
                        document.documentElement.classList.toggle('dark', darkMode);
                        localStorage.setItem('theme', darkMode ? 'dark' : 'light');
                    "
    class="me-3 w-9 h-9 flex items-center justify-center rounded-lg
                           bg-green-50 dark:bg-gray-800
                           text-green-600 dark:text-green-400
                           hover:bg-green-100 dark:hover:bg-gray-700
                           transition">
    <!-- Sun -->
    <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3
                               m15.364-6.364l-1.414 1.414
                               M7.05 16.95l-1.414 1.414
                               m0-11.314l1.414 1.414
                               m11.314 11.314l1.414 1.414" />
    </svg>

    <!-- Moon -->
    <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3
                               a7 7 0 009.79 9.79z" />
    </svg>
</button>
