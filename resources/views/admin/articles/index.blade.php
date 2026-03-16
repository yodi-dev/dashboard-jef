<x-app-layout>
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Manage Articles
            </h1>
            <a href="{{ route('admin.articles.create') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Create Article
            </a>
        </div>

        {{-- Flash Message with Close Button (Alpine.js) --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg relative flex items-center justify-between shadow-sm"
                role="alert">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false"
                    class="text-green-700 hover:text-green-900 focus:outline-none transition-colors">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        {{-- Table Section --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Cover</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Title</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($articles as $article)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">

                                {{-- Cover Image --}}
                                <td class="px-6 py-4">
                                    @if ($article->cover_image)
                                        <img src="{{ Storage::url($article->cover_image) }}" alt="Cover"
                                            class="w-16 h-12 object-cover rounded shadow-sm border border-gray-200 dark:border-gray-600">
                                    @else
                                        <div
                                            class="w-16 h-12 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center border border-dashed border-gray-300 dark:border-gray-600">
                                            <span class="text-xs text-gray-400">No Image</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Title & Slug --}}
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white text-base mb-1">
                                        {{ Str::limit($article->title, 40) }}
                                    </div>
                                    <div class="mt-1 text-xs text-gray-400">
                                        Created: {{ $article->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                {{-- Status & Toggles (Sliders) --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        {{-- Toggle Published --}}
                                        <form action="{{ route('admin.articles.toggle', $article->id) }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="field" value="is_published">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer"
                                                    onchange="this.form.submit()"
                                                    {{ $article->is_published ? 'checked' : '' }}>
                                                <div
                                                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-green-500">
                                                </div>
                                                <span class="ml-2 text-xs font-medium text-gray-700 dark:text-gray-300">
                                                    {{ $article->is_published ? 'Published' : 'Draft' }}
                                                </span>
                                            </label>
                                        </form>

                                        {{-- Toggle Highlight --}}
                                        <form action="{{ route('admin.articles.toggle', $article->id) }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="field" value="is_highlight">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer"
                                                    onchange="this.form.submit()"
                                                    {{ $article->is_highlight ? 'checked' : '' }}>
                                                <div
                                                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-purple-500">
                                                </div>
                                                <span class="ml-2 text-xs font-medium text-gray-700 dark:text-gray-300">
                                                    Highlight
                                                </span>
                                            </label>
                                        </form>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.articles.show', $article->id) }}"
                                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        View
                                    </a>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                        class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Edit
                                    </a>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>

                                    {{-- Delete Button (Moves to Trash) --}}
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Move this article to trash?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            Trash
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">No articles found</p>
                                    <p class="text-sm mt-1">Get started by creating a new article.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($articles->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
