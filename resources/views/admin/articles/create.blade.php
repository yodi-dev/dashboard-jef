<x-app-layout>
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 max-w-4xl">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Create New Article</h1>
            <a href="{{ route('admin.articles.index') }}"
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition flex items-center gap-1 text-sm font-medium">
                &larr; Back to List
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            @if ($errors->any())
                <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong>Oops! Ada yang salah:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8">
                @csrf

                {{-- Panggil form component --}}
                @include('admin.articles.form')

            </form>
        </div>
    </div>
</x-app-layout>
