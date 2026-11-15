<x-app-layout>
    <div class="space-y-6 max-w-4xl">

        <!-- Page Title -->
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">
                Profile Settings
            </h1>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Manage your account information and password.
            </p>
        </div>

        <!-- Update Profile Information -->
        <div class="bg-white dark:bg-zinc-900 border border-stone-200 dark:border-zinc-800 shadow-sm rounded-xl p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white dark:bg-zinc-900 border border-stone-200 dark:border-zinc-800 shadow-sm rounded-xl p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>
</x-app-layout>
