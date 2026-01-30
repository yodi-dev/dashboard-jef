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

<body class="font-sans antialiased text-gray-900">
    <div
        class="min-h-screen flex items-center justify-center
            bg-gradient-to-br
            from-green-50 to-green-100
            dark:from-gray-900 dark:to-gray-800">

        <div class="w-full max-w-md">
            <div class="absolute top-6 right-6">
                <x-theme-toggle />
            </div>

            {{-- Logo / Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-green-700">
                    Welcome Jef!
                </h1>
                <p class="mt-2 text-sm text-gray-500">
                    Admin Dashboard Login
                </p>
            </div>

            {{-- Auth Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl px-8 py-6">
                {{ $slot }}
            </div>

        </div>

    </div>
</body>

</html>
