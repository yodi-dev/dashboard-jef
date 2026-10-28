<x-app-layout>
    <div class="space-y-6 max-w-4xl">

        <!-- Page Title -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Profile Settings
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage your account information and password.
            </p>
        </div>

        <!-- Update Profile Information -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-xl p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-xl p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>
</x-app-layout>
