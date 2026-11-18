<section class="space-y-6">
    <header class="space-y-1">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-sm text-zinc-500 dark:text-zinc-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-lg"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-lg"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3 space-y-2">
                    <p class="text-sm text-zinc-700 dark:text-zinc-300">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button form="send-verification"
                        class="text-sm font-medium text-emerald-600 dark:text-emerald-400
                               hover:text-emerald-700 dark:hover:text-emerald-300
                               underline transition">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="flex items-center gap-1.5 text-sm font-medium text-emerald-600 dark:text-emerald-400"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ __('Profile saved successfully.') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
