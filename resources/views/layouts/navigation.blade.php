<nav x-data="{
    open: false,
    darkMode: localStorage.getItem('theme') === 'dark'
}" x-init="if (darkMode) document.documentElement.classList.add('dark')"
    class="bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-900 dark:to-gray-800 border-b border-green-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}"
                    class="text-xl font-semibold tracking-tight
                          text-green-600 dark:text-green-400">
                    Jef
                </a>

                <!-- Navigation -->
                <div class="hidden sm:flex sm:ms-10 space-x-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-gray-600 dark:text-gray-300
                               hover:text-green-600 dark:hover:text-green-400">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    {{-- <x-nav-link :href="route('portfolio')" :active="request()->routeIs('portfolio')"
                        class="text-gray-600 dark:text-gray-300
                               hover:text-green-600 dark:hover:text-green-400">
                        {{ __('Portfolio') }}
                    </x-nav-link>
                    <x-nav-link :href="route('article')" :active="request()->routeIs('article')"
                        class="text-gray-600 dark:text-gray-300
                               hover:text-green-600 dark:hover:text-green-400">
                        {{ __('Article') }}
                    </x-nav-link>
                    <x-nav-link :href="route('booking')" :active="request()->routeIs('booking')"
                        class="text-gray-600 dark:text-gray-300
                               hover:text-green-600 dark:hover:text-green-400">
                        {{ __('Booking') }}
                    </x-nav-link> --}}
                </div>
            </div>

            <!-- Right -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Dark Mode Toggle -->
                <x-theme-toggle />

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 rounded-md text-sm
                                   text-gray-600 dark:text-gray-300
                                   hover:text-green-600 dark:hover:text-green-400
                                   transition">
                            {{ Auth::user()->name }}
                            <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293
                                       a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4
                                       a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-md text-gray-500 dark:text-gray-400
                           hover:text-green-600 dark:hover:text-green-400
                           hover:bg-green-50 dark:hover:bg-gray-800 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden border-t border-green-100 dark:border-gray-700">
        <div class="px-4 py-3 space-y-2">
            <x-responsive-nav-link :href="route('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <button
                @click="
                    darkMode = !darkMode;
                    document.documentElement.classList.toggle('dark', darkMode);
                    localStorage.setItem('theme', darkMode ? 'dark' : 'light');
                "
                class="w-full flex justify-between px-3 py-2 rounded-lg
                       bg-green-50 dark:bg-gray-800
                       text-sm text-gray-700 dark:text-gray-200">
                <span>Dark Mode</span>
                <span x-text="darkMode ? 'On' : 'Off'"></span>
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
