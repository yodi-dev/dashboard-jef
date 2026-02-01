<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Page Title -->
            <div class="px-4 sm:px-0">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Profile Settings
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Manage your account information and password.
                </p>
            </div>

            <!-- Update Profile Information -->
            <div
                class="bg-white dark:bg-gray-900
                       border border-green-100 dark:border-gray-700
                       shadow-sm rounded-xl">
                <div class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div
                class="bg-white dark:bg-gray-900
                       border border-green-100 dark:border-gray-700
                       shadow-sm rounded-xl">
                <div class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
