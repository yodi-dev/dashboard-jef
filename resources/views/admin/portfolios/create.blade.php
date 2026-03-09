<x-app-layout>
    <div class="container mx-auto py-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Create Portfolio
            </h1>

            {{-- Tombol Back --}}
            <a href="{{ route('admin.portfolios.index') }}"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                &larr; Back to List
            </a>
        </div>

        {{-- Form Card --}}
        <div
            class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700 transition duration-200">

            {{-- WAJIB TAMBAH ENCTYPE UNTUK UPLOAD FILE --}}
            <form action="{{ route('admin.portfolios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Include Form Partial --}}
                @include('admin.portfolios.form')

                {{-- Submit Button --}}
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-200">
                        Save Portfolio
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
