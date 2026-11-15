<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ View::hasSection('title') ? View::yieldContent('title') . ' — ' . config('app.name', 'Jef Studio Admin') : (isset($title) ? $title . ' — ' . config('app.name', 'Jef Studio Admin') : config('app.name', 'Jef Studio Admin')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|newsreader:400,500,600,700,400i,600i&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-zinc-900 dark:text-zinc-100 bg-stone-50 dark:bg-zinc-950">
    <div class="min-h-screen bg-stone-50 dark:bg-zinc-950">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Heading --}}
        @isset($header)
            <header class="bg-white dark:bg-zinc-900 border-b border-stone-200 dark:border-zinc-800">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            {{-- Global Success Flash Alert --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-6 px-4 py-3 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-xl relative flex items-center justify-between shadow-sm"
                    role="alert">
                    <div class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" @click="show = false"
                        class="text-emerald-700 dark:text-emerald-400 hover:text-emerald-900 dark:hover:text-emerald-200 focus:outline-none transition-colors"
                        aria-label="Dismiss alert">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Global Error Flash Alert --}}
            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="mb-6 px-4 py-3 bg-red-50 dark:bg-red-950/40 border border-red-300 dark:border-red-800 text-red-800 dark:text-red-200 rounded-xl relative flex items-center justify-between shadow-sm"
                    role="alert">
                    <div class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" @click="show = false"
                        class="text-red-700 dark:text-red-400 hover:text-red-900 dark:hover:text-red-200 focus:outline-none transition-colors"
                        aria-label="Dismiss alert">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    {{-- Reusable Delete Confirmation Modal --}}
    <x-delete-confirmation-modal />

    {{-- Global Toast Notification Stack (Alpine.js) --}}
    <div x-data="{ toasts: [] }"
         @notify.window="toasts.push({ id: Date.now() + Math.random(), message: $event.detail.message, type: $event.detail.type || 'success' }); setTimeout(() => toasts.shift(), 3500)"
         class="fixed bottom-5 right-5 z-50 flex flex-col gap-2.5 pointer-events-none"
         aria-live="polite">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="pointer-events-auto px-4 py-2.5 rounded-xl shadow-xl text-sm font-medium border flex items-center gap-2.5 bg-zinc-900 text-white border-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:border-zinc-200">
                <span class="w-2 h-2 rounded-full flex-shrink-0" :class="toast.type === 'error' ? 'bg-rose-500' : 'bg-emerald-400'"></span>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>
</body>

</html>
