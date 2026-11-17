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

        {{-- Filter & Search Toolbar --}}
        <div class="space-y-4">
            {{-- Status Tabs --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none border-b border-stone-200 dark:border-zinc-800"
                 x-data="{ counts: {{ json_encode($counts) }} }"
                 @article-counts-updated.window="counts = $event.detail">
                @php
                    $activeStatus = request('status', 'all');
                @endphp
                <a href="{{ route('admin.articles.index', array_merge(request()->except('page', 'status'), ['status' => 'all'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'all' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span>All Stories</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'all' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}"
                          x-text="counts.all">
                        {{ $counts['all'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.articles.index', array_merge(request()->except('page', 'status'), ['status' => 'published'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'published' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Published</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'published' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}"
                          x-text="counts.published">
                        {{ $counts['published'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.articles.index', array_merge(request()->except('page', 'status'), ['status' => 'draft'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'draft' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400"></span>
                    <span>Drafts</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'draft' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}"
                          x-text="counts.draft">
                        {{ $counts['draft'] ?? 0 }}
                    </span>
                </a>
                <a href="{{ route('admin.articles.index', array_merge(request()->except('page', 'status'), ['status' => 'highlight'])) }}"
                    class="inline-flex items-center gap-2 px-3 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-all whitespace-nowrap {{ $activeStatus === 'highlight' ? 'border-zinc-900 text-zinc-900 dark:border-zinc-100 dark:text-zinc-100 font-semibold' : 'border-transparent text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <svg class="w-3 h-3 text-amber-500 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span>Featured</span>
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === 'highlight' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'bg-stone-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}"
                          x-text="counts.highlight">
                        {{ $counts['highlight'] ?? 0 }}
                    </span>
                </a>
            </div>

            {{-- Search Input --}}
            <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
                <input type="hidden" name="status" value="{{ request('status', 'all') }}">

                <div class="flex-1 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search articles by title, content..."
                            class="block w-full pl-9 pr-9 py-2 text-xs sm:text-sm rounded-lg border-stone-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-800 dark:focus:ring-zinc-200 transition">
                        @if (request('search'))
                            <a href="{{ route('admin.articles.index', request()->except('search', 'page')) }}"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200" title="Clear search">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 text-xs sm:text-sm font-medium rounded-lg border border-stone-200 dark:border-zinc-700 transition">
                        Search
                    </button>

                    @if (request('search') || (request('status') && request('status') !== 'all'))
                        <a href="{{ route('admin.articles.index') }}"
                            class="px-3 py-2 text-xs sm:text-sm text-zinc-500 hover:text-red-600 dark:text-zinc-400 dark:hover:text-red-400 transition inline-flex items-center gap-1 self-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Main Container Card --}}
        <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl overflow-hidden border border-stone-200 dark:border-zinc-800">

            {{-- 1. MOBILE CARD LIST VIEW (Visible on mobile/tablet < md) --}}
            <div class="md:hidden divide-y divide-stone-200 dark:divide-zinc-800">
                @forelse($articles as $article)
                    <div x-data="{
                        isPublished: {{ $article->is_published ? 'true' : 'false' }},
                        isHighlight: {{ $article->is_highlight ? 'true' : 'false' }},
                        loading: false,
                        visible: true,
                        async toggle(field) {
                            if (this.loading) return;
                            this.loading = true;
                            const oldPublished = this.isPublished;
                            const oldHighlight = this.isHighlight;
                            if (field === 'is_published') {
                                this.isPublished = !this.isPublished;
                                if (!this.isPublished) this.isHighlight = false;
                            } else if (field === 'is_highlight') {
                                this.isHighlight = !this.isHighlight;
                                if (this.isHighlight) this.isPublished = true;
                            }
                            try {
                                const res = await fetch('{{ route('admin.articles.toggle', $article->id) }}', {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ field })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    this.isPublished = data.is_published;
                                    this.isHighlight = data.is_highlight;
                                    if (data.counts) {
                                        window.dispatchEvent(new CustomEvent('article-counts-updated', { detail: data.counts }));
                                    }
                                    window.dispatchEvent(new CustomEvent('notify', { detail: { message: data.message } }));

                                    const activeTab = '{{ $activeStatus }}';
                                    if (activeTab === 'highlight' && !this.isHighlight) {
                                        setTimeout(() => { this.visible = false; }, 250);
                                    } else if (activeTab === 'draft' && this.isPublished) {
                                        setTimeout(() => { this.visible = false; }, 250);
                                    } else if (activeTab === 'published' && !this.isPublished) {
                                        setTimeout(() => { this.visible = false; }, 250);
                                    }
                                } else {
                                    throw new Error();
                                }
                            } catch (e) {
                                this.isPublished = oldPublished;
                                this.isHighlight = oldHighlight;
                                window.dispatchEvent(new CustomEvent('notify', { detail: { message: 'Failed to update status', type: 'error' } }));
                            } finally {
                                this.loading = false;
                            }
                        }
                    }" x-show="visible" x-transition.opacity.duration.300ms class="p-4 space-y-3">
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

                        {{-- Middle: Asynchronous Toggles --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 pt-2 border-t border-stone-200 dark:border-zinc-800">
                            {{-- Toggle Published --}}
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" class="sr-only" :checked="isPublished" @click.prevent="toggle('is_published')">
                                <div class="w-9 h-5 rounded-full transition-colors relative"
                                     :class="isPublished ? 'bg-zinc-900 dark:bg-zinc-100' : 'bg-stone-200 dark:bg-zinc-700'">
                                    <div class="absolute top-[2px] left-[2px] bg-white dark:bg-zinc-900 rounded-full h-4 w-4 transition-transform shadow-sm"
                                         :class="isPublished ? 'translate-x-4 border border-zinc-900 dark:border-zinc-100' : 'border border-stone-300 dark:border-zinc-600'"></div>
                                </div>
                                <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300"
                                      x-text="isPublished ? 'Published' : 'Draft'"></span>
                            </label>

                            {{-- Toggle Highlight --}}
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" class="sr-only" :checked="isHighlight" @click.prevent="toggle('is_highlight')">
                                <div class="w-9 h-5 rounded-full transition-colors relative"
                                     :class="isHighlight ? 'bg-zinc-900 dark:bg-zinc-100' : 'bg-stone-200 dark:bg-zinc-700'">
                                    <div class="absolute top-[2px] left-[2px] bg-white dark:bg-zinc-900 rounded-full h-4 w-4 transition-transform shadow-sm"
                                         :class="isHighlight ? 'translate-x-4 border border-zinc-900 dark:border-zinc-100' : 'border border-stone-300 dark:border-zinc-600'"></div>
                                </div>
                                <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                    Highlight
                                </span>
                            </label>
                        </div>

                        {{-- Bottom: Action Buttons --}}
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-200 dark:border-zinc-800 text-xs font-medium">
                            <a href="{{ route('admin.articles.show', $article->id) }}"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>View</span>
                            </a>
                            <a href="{{ route('admin.articles.edit', $article->id) }}"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Edit</span>
                            </a>
                            <button type="button"
                                @click.prevent="$dispatch('confirm-delete', { action: '{{ route('admin.articles.destroy', $article->id) }}', title: '{{ addslashes($article->title) }}', itemType: 'article' })"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-zinc-500 hover:text-red-600 hover:bg-red-50 dark:text-zinc-400 dark:hover:text-red-400 dark:hover:bg-red-950/30 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Trash</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto w-12 h-12 rounded-full bg-stone-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 mb-3">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">No articles found</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">
                            @if(request('search') || request('status'))
                                No stories matched your active search or filters. Try clearing your search parameters.
                            @else
                                You have not written any journal stories yet.
                            @endif
                        </p>
                        <div class="mt-4">
                            @if(request('search') || request('status'))
                                <a href="{{ route('admin.articles.index') }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs font-medium hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                    Clear all filters
                                </a>
                            @else
                                <a href="{{ route('admin.articles.create') }}"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white text-xs font-medium transition shadow-sm">
                                    Write First Article
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- 2. DESKTOP DATA TABLE (Visible on screen >= md) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full whitespace-nowrap text-left text-sm text-zinc-500 dark:text-zinc-400">
                    <thead class="bg-stone-50 dark:bg-zinc-800/60 text-zinc-700 dark:text-zinc-300 border-b border-stone-200 dark:border-zinc-800">
                        <tr>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold">Cover</th>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold">Title</th>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold">Visibility</th>
                            <th scope="col" class="px-6 py-3.5 text-xs uppercase tracking-wider font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 dark:divide-zinc-800">
                        @forelse($articles as $article)
                            <tr x-data="{
                                isPublished: {{ $article->is_published ? 'true' : 'false' }},
                                isHighlight: {{ $article->is_highlight ? 'true' : 'false' }},
                                loading: false,
                                visible: true,
                                async toggle(field) {
                                    if (this.loading) return;
                                    this.loading = true;
                                    const oldPublished = this.isPublished;
                                    const oldHighlight = this.isHighlight;
                                    if (field === 'is_published') {
                                        this.isPublished = !this.isPublished;
                                        if (!this.isPublished) this.isHighlight = false;
                                    } else if (field === 'is_highlight') {
                                        this.isHighlight = !this.isHighlight;
                                        if (this.isHighlight) this.isPublished = true;
                                    }
                                    try {
                                        const res = await fetch('{{ route('admin.articles.toggle', $article->id) }}', {
                                            method: 'PATCH',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({ field })
                                        });
                                        const data = await res.json();
                                        if (data.success) {
                                            this.isPublished = data.is_published;
                                            this.isHighlight = data.is_highlight;
                                            if (data.counts) {
                                                window.dispatchEvent(new CustomEvent('article-counts-updated', { detail: data.counts }));
                                            }
                                            window.dispatchEvent(new CustomEvent('notify', { detail: { message: data.message } }));

                                            const activeTab = '{{ $activeStatus }}';
                                            if (activeTab === 'highlight' && !this.isHighlight) {
                                                setTimeout(() => { this.visible = false; }, 250);
                                            } else if (activeTab === 'draft' && this.isPublished) {
                                                setTimeout(() => { this.visible = false; }, 250);
                                            } else if (activeTab === 'published' && !this.isPublished) {
                                                setTimeout(() => { this.visible = false; }, 250);
                                            }
                                        } else {
                                            throw new Error();
                                        }
                                    } catch (e) {
                                        this.isPublished = oldPublished;
                                        this.isHighlight = oldHighlight;
                                        window.dispatchEvent(new CustomEvent('notify', { detail: { message: 'Failed to update status', type: 'error' } }));
                                    } finally {
                                        this.loading = false;
                                    }
                                }
                            }" x-show="visible" x-transition.opacity.duration.300ms class="hover:bg-stone-50 dark:hover:bg-zinc-800/40 transition duration-150">

                                {{-- Cover Image --}}
                                <td class="px-6 py-4">
                                    @if ($article->cover_image_url)
                                        <img src="{{ $article->cover_image_url }}" alt="Cover"
                                            class="w-16 h-12 object-cover rounded shadow-sm border border-stone-200 dark:border-zinc-700">
                                    @else
                                        <div
                                            class="w-16 h-12 bg-stone-100 dark:bg-zinc-800 rounded flex items-center justify-center border border-dashed border-stone-300 dark:border-zinc-700">
                                            <span class="text-xs text-zinc-400">No Image</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Title & Slug --}}
                                <td class="px-6 py-4">
                                    <div class="font-medium text-zinc-900 dark:text-white text-base mb-0.5">
                                        {{ Str::limit($article->title, 55) }}
                                    </div>
                                    <div class="text-xs text-zinc-400">
                                        Created: {{ $article->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                {{-- Status & Toggles --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        {{-- Toggle Published --}}
                                        <label class="relative inline-flex items-center cursor-pointer select-none">
                                            <input type="checkbox" class="sr-only" :checked="isPublished" @click.prevent="toggle('is_published')">
                                            <div class="w-9 h-5 rounded-full transition-colors relative"
                                                 :class="isPublished ? 'bg-zinc-900 dark:bg-zinc-100' : 'bg-stone-200 dark:bg-zinc-700'">
                                                <div class="absolute top-[2px] left-[2px] bg-white dark:bg-zinc-900 rounded-full h-4 w-4 transition-transform shadow-sm"
                                                     :class="isPublished ? 'translate-x-4 border border-zinc-900 dark:border-zinc-100' : 'border border-stone-300 dark:border-zinc-600'"></div>
                                            </div>
                                            <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300"
                                                  x-text="isPublished ? 'Published' : 'Draft'"></span>
                                        </label>

                                        {{-- Toggle Highlight --}}
                                        <label class="relative inline-flex items-center cursor-pointer select-none">
                                            <input type="checkbox" class="sr-only" :checked="isHighlight" @click.prevent="toggle('is_highlight')">
                                            <div class="w-9 h-5 rounded-full transition-colors relative"
                                                 :class="isHighlight ? 'bg-zinc-900 dark:bg-zinc-100' : 'bg-stone-200 dark:bg-zinc-700'">
                                                <div class="absolute top-[2px] left-[2px] bg-white dark:bg-zinc-900 rounded-full h-4 w-4 transition-transform shadow-sm"
                                                     :class="isHighlight ? 'translate-x-4 border border-zinc-900 dark:border-zinc-100' : 'border border-stone-300 dark:border-zinc-600'"></div>
                                            </div>
                                            <span class="ml-2 text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                                Highlight
                                            </span>
                                        </label>
                                    </div>
                                </td>

                                {{-- Modern Action Buttons --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1 bg-stone-100 dark:bg-zinc-800 p-1 rounded-lg border border-stone-200 dark:border-zinc-700">
                                        <a href="{{ route('admin.articles.show', $article->id) }}"
                                            class="p-1.5 rounded-md text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-white dark:hover:bg-zinc-700 transition"
                                            title="View Article Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('admin.articles.edit', $article->id) }}"
                                            class="p-1.5 rounded-md text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-white dark:hover:bg-zinc-700 transition"
                                            title="Edit Article">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button"
                                            @click.prevent="$dispatch('confirm-delete', { action: '{{ route('admin.articles.destroy', $article->id) }}', title: '{{ addslashes($article->title) }}', itemType: 'article' })"
                                            class="p-1.5 rounded-md text-zinc-500 hover:text-red-600 hover:bg-white dark:hover:bg-zinc-700 dark:text-zinc-400 dark:hover:text-red-400 transition"
                                            title="Move to Trash">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="mx-auto w-12 h-12 rounded-full bg-stone-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 mb-3">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-base font-semibold text-zinc-900 dark:text-zinc-100">No articles found</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 max-w-sm mx-auto">
                                        @if(request('search') || request('status'))
                                            No stories matched your active search or filters. Try clearing your search parameters.
                                        @else
                                            You have not written any journal stories yet.
                                        @endif
                                    </p>
                                    <div class="mt-4">
                                        @if(request('search') || request('status'))
                                            <a href="{{ route('admin.articles.index') }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 text-xs font-medium hover:bg-stone-200 dark:hover:bg-zinc-700 transition">
                                                Clear all filters
                                            </a>
                                        @else
                                            <a href="{{ route('admin.articles.create') }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white text-xs font-medium transition shadow-sm">
                                                Write First Article
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($articles->hasPages())
                <div class="px-6 py-4 border-t border-stone-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
