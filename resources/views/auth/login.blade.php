<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-lg
                       focus:border-green-500 focus:ring-green-500
                       dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password"
                class="block mt-1 w-full rounded-lg
                       focus:border-green-500 focus:ring-green-500
                       dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-green-600
                           shadow-sm focus:ring-green-500
                           dark:bg-gray-900 dark:border-gray-700"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ __('Remember me') }}
                </span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium
                           text-green-600 hover:text-green-700
                           dark:text-green-400 dark:hover:text-green-300"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <div>
            <x-primary-button
                class="w-full justify-center
                       bg-green-600 hover:bg-green-700
                       focus:bg-green-700 active:bg-green-800">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
