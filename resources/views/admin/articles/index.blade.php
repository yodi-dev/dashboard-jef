@section('title', 'Manage Articles')

<x-app-layout>
    <div class="space-y-6">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-zinc-100">
                    Journal Stories & Essays
                </h1>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage essays, behind-the-scenes stories, and creative reflections.
                </p>
            </div>
            <a href="{{ route('admin.articles.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white font-medium py-2 px-4 rounded-lg shadow-sm transition duration-150 ease-in-out text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Create Article
            </a>
        </div>

        {{-- Main Container Card --}}
        <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl overflow-hidden border border-stone-200 dark:border-zinc-800">

            {{-- 1. MOBILE CARD LIST VIEW (Visible on mobile/tablet < md) --}}
            <div class="md:hidden divide-y divide-stone-200 dark:divide-zinc-800">
                @forelse($articles as $article)
                    <div class="p-4 space-y-3">
                        {{-- Top: Cover Image & Title --}}
                        <div class="flex items-start gap-3">
                            @if ($article->cover_image_url)
                                <img src="{{ $article->cover_image_url }}" alt="Cover"
                                    class="w-16 h-16 rounded-lg object-cover flex-shrink-0 border border-stone-200 dark:border-zinc-700 shadow-sm">
                            @else
                                <div class="w-16 h-16 bg-stone-100 dark:bg-zinc-800 rounded-lg flex items-center justify-center flex-shrink-0 border border-dashed border-stone-300 dark:border-zinc-700 text-xs text-zinc-400">
                                    No Image
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <span class="text-xs text-zinc-400 block mb-1">
                                    {{ $article->created_at->format('d M Y') }}
                                </span>
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                            </div>
                        </div>

                        {{-- Middle: Toggles (Published & Highlight) --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-stone-200 dark:border-zinc-800">
                            {{-- Toggle Published --}}
                            <form action="{{ route('admin.articles.toggle', $article->id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="field" value="is_published">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" onchange="this.form.submit()" {{ $article->is_published ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900"></div>
                                    <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                        {{ $article->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </label>
                            </form>

                            {{-- Toggle Highlight --}}
                            <form action="{{ route('admin.articles.toggle', $article->id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="field" value="is_highlight">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" onchange="this.form.submit()" {{ $article->is_highlight ? 'checked' : '' }}>
                                    <div class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900"></div>
                                    <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                        Highlight
                                    </span>
                                </label>
                            </form>
                        </div>

                        {{-- Bottom: Action Buttons --}}
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-200 dark:border-zinc-800 text-xs font-medium">
                            <a href="{{ route('admin.articles.show', $article->id) }}"
                                class="px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                View
                            </a>
                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                class="px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}"
                                method="POST" class="inline-block"
                                onsubmit="return confirm('Move this article to trash?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2.5 py-1.5 rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800 transition">
                                    Trash
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-lg font-medium">No articles found</p>
                        <p class="text-sm mt-1">Get started by creating a new article.</p>
                    </div>
                @endforelse
            </div>

            {{-- 2. DESKTOP DATA TABLE (Visible on screen >= md) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm text-zinc-500 dark:text-zinc-400">
                    <thead class="bg-stone-50 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold">Cover</th>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold">Title</th>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 dark:divide-zinc-800">
                        @forelse($articles as $article)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition duration-150">

                                {{-- Cover Image --}}
                                <td class="px-6 py-4">
                                    @if ($article->cover_image_url)
                                        <img src="{{ $article->cover_image_url }}" alt="Cover"
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
                                                    class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900">
                                                </div>
                                                <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300">
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
                                                    class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900">
                                                </div>
                                                <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                                    Highlight
                                                </span>
                                            </label>
                                        </form>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.articles.show', $article->id) }}"
                                        class="inline-flex items-center text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                        View
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                        class="inline-flex items-center text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Move this article to trash?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center text-xs font-semibold px-2.5 py-1.5 rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800 transition">
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
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
