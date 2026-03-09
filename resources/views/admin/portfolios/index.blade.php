<x-app-layout>
    <div class="container mx-auto py-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Portfolio
            </h1>

            <div class="flex gap-2">
                <a href="{{ route('admin.portfolios.create') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 transition duration-200 shadow-sm font-medium">
                    + Add Portfolio
                </a>
                <a href="{{ route('admin.portfolios.trash') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200 shadow-sm font-medium flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Trash
                </a>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="mb-4 p-4 bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300 border border-green-200 dark:border-green-800/50 rounded transition">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div
            class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto border border-gray-200 dark:border-gray-700 transition duration-200">

            <table class="w-full border-collapse text-gray-900 dark:text-gray-100 min-w-max">

                <thead class="bg-gray-100 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="text-left p-4 text-sm font-semibold w-24">Image</th>
                        <th class="text-left p-4 text-sm font-semibold">Title</th>
                        <th class="text-left p-4 text-sm font-semibold">Status</th>
                        <th class="text-left p-4 text-sm font-semibold">Created</th>
                        <th class="text-right p-4 text-sm font-semibold">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($portfolios as $portfolio)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">

                            {{-- Thumbnail --}}
                            <td class="p-4">
                                @if ($portfolio->thumbnail)
                                    <div
                                        class="w-16 h-12 rounded overflow-hidden border border-gray-200 dark:border-gray-700">
                                        <img src="{{ Storage::url($portfolio->thumbnail) }}"
                                            alt="{{ $portfolio->title }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div
                                        class="w-16 h-12 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-600">
                                        No Img
                                    </div>
                                @endif
                            </td>

                            {{-- Title & Slug --}}
                            <td class="p-4">
                                <div class="font-medium text-gray-900 dark:text-gray-200">
                                    {{ $portfolio->title }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $portfolio->slug }}
                                </div>
                            </td>

                            {{-- Status & Highlight --}}
                            <td class="p-4">
                                <div class="flex flex-col gap-1.5 items-start">
                                    {{-- Published Status --}}
                                    @if ($portfolio->is_published)
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-full">
                                            Published
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800 rounded-full">
                                            Draft
                                        </span>
                                    @endif

                                    {{-- Highlight Status --}}
                                    @if ($portfolio->is_highlight)
                                        <span
                                            class="px-2.5 py-1 text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 border border-purple-200 dark:border-purple-800 rounded-full flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Highlight
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Created Date --}}
                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $portfolio->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.portfolios.edit', $portfolio) }}"
                                        class="px-3 py-1.5 text-sm font-medium bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150">
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" method="POST"
                                        onsubmit="return confirm('Delete this portfolio?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-1.5 text-sm font-medium bg-red-500 dark:bg-red-600 text-white rounded hover:bg-red-600 dark:hover:bg-red-700 transition duration-150">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center p-8 text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 mb-3 text-gray-400 dark:text-gray-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    <span>No portfolio found.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $portfolios->links() }}
        </div>

    </div>
</x-app-layout>
