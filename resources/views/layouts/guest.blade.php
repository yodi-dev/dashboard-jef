<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-init="if (localStorage.theme === 'dark') {
    document.documentElement.classList.add('dark')
}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-zinc-900 dark:text-zinc-100">
    <div class="min-h-screen flex items-center justify-center bg-stone-50 dark:bg-zinc-950 p-4">

        <div class="w-full max-w-md">
            {{-- Logo / Header --}}
            <div class="text-center mb-8">
                <span class="inline-block text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                    Jef Lee
                </span>
                <p class="mt-1.5 text-xs uppercase tracking-widest text-zinc-500 dark:text-zinc-400 font-medium">
                    Studio Management Console
                </p>
            </div>

            {{-- Auth Card --}}
            <div class="bg-white dark:bg-zinc-900 border border-stone-200 dark:border-zinc-800 shadow-sm rounded-2xl px-8 py-7">
                {{ $slot }}
            </div>

        </div>

    </div>
</body>

</html>
