<x-app-layout>
    <div class="space-y-6 max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Edit Portfolio: <span class="text-green-600 dark:text-green-400">{{ $portfolio->title }}</span>
            </h1>

            {{-- Tombol Back --}}
            <a href="{{ route('admin.portfolios.index') }}"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                &larr; Back to List
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700">

            <form action="{{ route('admin.portfolios.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Include Form Partial --}}
                @include('admin.portfolios.form')

                {{-- Submit Button --}}
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 shadow-sm">
                        Update Portfolio
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
