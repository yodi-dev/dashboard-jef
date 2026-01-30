<button type="button"
    class="p-2 rounded-full bg-white shadow hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 transition"
    onclick="
        const html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            html.classList.add('dark');
            localStorage.theme = 'dark';
        }
    "
    aria-label="Toggle dark mode">
    <span class="block w-5 h-5 text-gray-700 dark:text-gray-300">
        🌙
    </span>
</button>
