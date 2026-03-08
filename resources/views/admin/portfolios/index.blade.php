<x-app-layout>
    <div class="container mx-auto py-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Portfolio
            </h1>

            <a href="{{ route('admin.portfolios.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 transition duration-200">
                + Add Portfolio
            </a>
            <a href="{{ route('admin.portfolios.trash') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-200">
                🗑️ View Trash
            </a>
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
            class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition duration-200">

            <table class="w-full border-collapse text-gray-900 dark:text-gray-100">

                <thead class="bg-gray-100 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="text-left p-4 text-sm font-semibold">Title</th>
                        <th class="text-left p-4 text-sm font-semibold">Published</th>
                        <th class="text-left p-4 text-sm font-semibold">Created</th>
                        <th class="text-right p-4 text-sm font-semibold">Action</th>
                    </tr>
                </thead>

                {{-- Pakai divide-y biar nggak perlu nulis border-t di tiap tr --}}
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse($portfolios as $portfolio)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">

                            <td class="p-4">
                                <div class="font-medium text-gray-900 dark:text-gray-200">
                                    {{ $portfolio->title }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ $portfolio->slug }}
                                </div>
                            </td>

                            <td class="p-4">
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
                            </td>

                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $portfolio->created_at->format('d M Y') }}
                            </td>

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
                            <td colspan="4" class="text-center p-8 text-gray-500 dark:text-gray-400">
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
