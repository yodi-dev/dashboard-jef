<x-app-layout>
    @section('title', 'Create Article')

    <div class="space-y-6 max-w-4xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Create New Article</h1>
            <a href="{{ route('admin.articles.index') }}"
                class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 rounded-lg text-sm font-medium border border-stone-200 dark:border-zinc-700 transition duration-150">
                &larr; Back to List
            </a>
        </div>

        <div
            class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl overflow-hidden border border-stone-200 dark:border-zinc-800">
            @if ($errors->any())
                <div class="m-6 sm:m-8 p-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg text-sm">
                    <strong>Please correct the following errors:</strong>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form x-data="{ submitting: false }" @submit="submitting = true" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8">
                @csrf

                {{-- Panggil form component --}}
                @include('admin.articles.form')

            </form>
        </div>
    </div>
</x-app-layout>
