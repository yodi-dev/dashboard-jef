<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-zinc-700 dark:text-zinc-300" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700
                       focus:border-zinc-800 focus:ring-zinc-800
                       dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-zinc-200 dark:focus:ring-zinc-200"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-zinc-700 dark:text-zinc-300" />
            <x-text-input id="password"
                class="block mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700
                       focus:border-zinc-800 focus:ring-zinc-800
                       dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-zinc-200 dark:focus:ring-zinc-200"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-sm">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-zinc-300 text-zinc-900
                           shadow-sm focus:ring-zinc-800
                           dark:bg-zinc-900 dark:border-zinc-700"
                    name="remember">
                <span class="ms-2 text-sm text-zinc-600 dark:text-zinc-400">
                    {{ __('Remember me') }}
                </span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200 underline underline-offset-4"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Sign In to Dashboard') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
