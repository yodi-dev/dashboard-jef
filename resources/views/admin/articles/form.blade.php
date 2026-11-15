{{-- Title --}}
<div class="mb-6">
    <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
        Article Title <span class="text-red-500">*</span>
    </label>
    <input type="text" name="title" id="title" value="{{ old('title', $article->title ?? '') }}" required
        class="w-full rounded-xl border-stone-300 shadow-sm focus:border-zinc-800 focus:ring-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 dark:bg-zinc-900 dark:border-zinc-700 dark:text-zinc-100 text-base py-3 px-4"
        placeholder="Enter an engaging journal or essay title...">
    @error('title')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Cover Image --}}
<div class="mb-6" x-data="{
    preview: null,
    isDragging: false,
    handleDrop(e) {
        this.isDragging = false;
        const file = e.dataTransfer?.files?.[0];
        if (file && file.type.startsWith('image/')) {
            this.$refs.coverInput.files = e.dataTransfer.files;
            this.preview = URL.createObjectURL(file);
        }
    }
}">
    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
        Header Cover Image <span class="text-xs text-zinc-500 font-normal">(Recommended 16:9 or 1200x630px, max 5MB)</span>
    </label>

    <div class="flex flex-col sm:flex-row items-start gap-4">
        {{-- Preview Box --}}
        <div class="w-48 h-32 rounded-xl overflow-hidden border border-stone-200 dark:border-zinc-700 bg-stone-100 dark:bg-zinc-800 flex-shrink-0 flex items-center justify-center relative shadow-sm">
            <template x-if="preview">
                <div class="w-full h-full relative">
                    <img :src="preview" alt="New Cover" class="w-full h-full object-cover">
                    <span class="absolute top-1.5 right-1.5 bg-zinc-900 text-white text-[10px] px-2 py-0.5 rounded font-mono">New</span>
                </div>
            </template>
            <template x-if="!preview">
                @if (isset($article) && $article->cover_image_url)
                    <div class="w-full h-full relative">
                        <img src="{{ $article->cover_image_url }}" alt="Current Cover" class="w-full h-full object-cover">
                        <span class="absolute top-1.5 right-1.5 bg-zinc-900/80 text-white text-[10px] px-2 py-0.5 rounded font-mono">Current</span>
                    </div>
                @else
                    <div class="text-center p-3">
                        <svg class="mx-auto h-7 w-7 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs text-zinc-400 block mt-1">No Cover</span>
                    </div>
                @endif
            </template>
        </div>

        {{-- Dropzone --}}
        <div class="flex-1 w-full"
             @dragover.prevent="isDragging = true"
             @dragleave.prevent="isDragging = false"
             @drop.prevent="handleDrop($event)">
            <label for="cover_image"
                :class="isDragging ? 'border-zinc-900 dark:border-zinc-100 bg-stone-100 dark:bg-zinc-800/80 ring-2 ring-zinc-800' : 'border-stone-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-stone-50/50 dark:bg-zinc-900/50'"
                class="cursor-pointer border-2 border-dashed rounded-xl p-5 flex flex-col items-center justify-center transition-all text-center">
                <svg class="w-6 h-6 text-zinc-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <p class="text-xs text-zinc-700 dark:text-zinc-300 font-medium">
                    Click to select cover photo, or drag & drop here
                </p>
                <p class="text-[11px] text-zinc-400 mt-0.5">
                    @if (isset($article))
                        <em>Leave empty to keep existing cover</em>
                    @else
                        JPG, PNG, WEBP (up to 5MB)
                    @endif
                </p>
                <input type="file" name="cover_image" id="cover_image" accept="image/*" x-ref="coverInput"
                    @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                    class="hidden">
            </label>
        </div>
    </div>

    @error('cover_image')
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Editorial Writing Studio (P3_2) --}}
<div class="mb-6 space-y-2" x-data="{
    content: @js(old('content', $article->content ?? '')),
    mode: 'visual', // 'visual' or 'html'
    wordCount: 0,
    readTime: '1 min read',

    init() {
        this.updateStats();
        // Initial sync to visual editor if starting in visual mode
        if (this.$refs.visualEditor) {
            this.$refs.visualEditor.innerHTML = this.content || '';
        }
    },

    format(cmd, value = null) {
        document.execCommand(cmd, false, value);
        this.syncFromVisual();
    },

    formatBlock(tag) {
        document.execCommand('formatBlock', false, tag);
        this.syncFromVisual();
    },

    insertLink() {
        const url = prompt('Enter link URL (e.g. https://...):');
        if (url) {
            this.format('createLink', url);
        }
    },

    syncFromVisual() {
        if (this.$refs.visualEditor) {
            this.content = this.$refs.visualEditor.innerHTML;
            this.updateStats();
        }
    },

    syncFromHtml() {
        this.updateStats();
        if (this.$refs.visualEditor) {
            this.$refs.visualEditor.innerHTML = this.content || '';
        }
    },

    updateStats() {
        const text = (this.content || '').replace(/<[^>]*>/g, ' ').trim();
        const words = text ? text.split(/\s+/).length : 0;
        this.wordCount = words;
        const minutes = Math.max(1, Math.ceil(words / 200));
        this.readTime = `~${minutes} min read`;
    }
}">
    <div class="flex items-center justify-between">
        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
            Essay Content <span class="text-red-500">*</span>
        </label>
        <div class="flex items-center gap-2">
            <button type="button" @click="mode = mode === 'visual' ? 'html' : 'visual'"
                class="px-2.5 py-1 text-xs font-mono rounded-lg border border-stone-200 dark:border-zinc-700 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-300 transition">
                <span x-text="mode === 'visual' ? '&lt;/&gt; Edit HTML Source' : '&para; Visual Editor'"></span>
            </button>
        </div>
    </div>

    {{-- Editor Container --}}
    <div class="border border-stone-300 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-900 shadow-sm focus-within:ring-2 focus-within:ring-zinc-800 dark:focus-within:ring-zinc-200 transition">

        {{-- Toolbar (Visible in Visual Mode) --}}
        <div x-show="mode === 'visual'" class="p-2 border-b border-stone-200 dark:border-zinc-800 bg-stone-50/80 dark:bg-zinc-800/50 flex flex-wrap items-center gap-1 text-xs text-zinc-700 dark:text-zinc-300">
            <button type="button" @click.prevent="format('bold')" class="p-1.5 rounded hover:bg-stone-200 dark:hover:bg-zinc-700 font-bold" title="Bold (Ctrl+B)">B</button>
            <button type="button" @click.prevent="format('italic')" class="p-1.5 rounded hover:bg-stone-200 dark:hover:bg-zinc-700 italic" title="Italic (Ctrl+I)">I</button>
            <span class="w-px h-4 bg-stone-300 dark:bg-zinc-700 mx-1"></span>

            <button type="button" @click.prevent="formatBlock('h2')" class="px-2 py-1 rounded hover:bg-stone-200 dark:hover:bg-zinc-700 font-semibold" title="Heading 2">H2</button>
            <button type="button" @click.prevent="formatBlock('h3')" class="px-2 py-1 rounded hover:bg-stone-200 dark:hover:bg-zinc-700 font-medium" title="Heading 3">H3</button>
            <button type="button" @click.prevent="formatBlock('p')" class="px-2 py-1 rounded hover:bg-stone-200 dark:hover:bg-zinc-700" title="Paragraph">Text</button>
            <span class="w-px h-4 bg-stone-300 dark:bg-zinc-700 mx-1"></span>

            <button type="button" @click.prevent="formatBlock('blockquote')" class="px-2 py-1 rounded hover:bg-stone-200 dark:hover:bg-zinc-700 italic" title="Quote Block">&ldquo;Quote&rdquo;</button>
            <button type="button" @click.prevent="format('insertUnorderedList')" class="p-1.5 rounded hover:bg-stone-200 dark:hover:bg-zinc-700" title="Bullet List">&bull; List</button>
            <button type="button" @click.prevent="format('insertOrderedList')" class="p-1.5 rounded hover:bg-stone-200 dark:hover:bg-zinc-700" title="Numbered List">1. List</button>
            <span class="w-px h-4 bg-stone-300 dark:bg-zinc-700 mx-1"></span>

            <button type="button" @click.prevent="insertLink()" class="px-2 py-1 rounded hover:bg-stone-200 dark:hover:bg-zinc-700 inline-flex items-center gap-1" title="Insert Link">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <span>Link</span>
            </button>
            <button type="button" @click.prevent="format('insertHorizontalRule')" class="px-2 py-1 rounded hover:bg-stone-200 dark:hover:bg-zinc-700" title="Horizontal Divider">&mdash; Rule</button>
        </div>

        {{-- Visual ContentEditable Area --}}
        <div x-show="mode === 'visual'"
             x-ref="visualEditor"
             contenteditable="true"
             @input="syncFromVisual()"
             @blur="syncFromVisual()"
             class="p-5 min-h-[320px] focus:outline-none prose dark:prose-invert max-w-none text-zinc-900 dark:text-zinc-100 font-serif leading-relaxed text-base"
             style="min-height: 320px;"></div>

        {{-- Raw HTML Textarea Mode --}}
        <div x-show="mode === 'html'">
            <textarea x-model="content"
                      @input="syncFromHtml()"
                      rows="14"
                      class="w-full p-4 font-mono text-xs text-zinc-900 dark:text-zinc-100 bg-stone-50 dark:bg-zinc-950 border-0 focus:ring-0 leading-relaxed"
                      placeholder="Write or edit HTML source directly..."></textarea>
        </div>

        {{-- Hidden Input for Standard Laravel Form Post --}}
        <textarea name="content" x-ref="contentInput" :value="content" required class="hidden"></textarea>

        {{-- Footer Telemetry --}}
        <div class="px-4 py-2 border-t border-stone-200 dark:border-zinc-800 bg-stone-50/50 dark:bg-zinc-800/30 flex items-center justify-between text-xs text-zinc-400">
            <span x-text="mode === 'visual' ? 'Visual Editorial Mode' : 'HTML Source Mode'"></span>
            <div class="flex items-center gap-3">
                <span x-text="wordCount + ' words'"></span>
                <span>&bull;</span>
                <span x-text="readTime"></span>
            </div>
        </div>

    </div>

    @error('content')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Options (Published & Highlight) --}}
<div class="mb-6 flex flex-wrap gap-8 p-4 bg-stone-50 dark:bg-zinc-800/40 border border-stone-200 dark:border-zinc-800 rounded-xl">

    {{-- Toggle Published --}}
    <label class="relative inline-flex items-center cursor-pointer select-none">
        <input type="checkbox" name="is_published" value="1" class="sr-only peer"
            {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }}>
        <div
            class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900">
        </div>
        <span class="ml-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">Publish Immediately</span>
    </label>

    {{-- Toggle Highlight --}}
    <label class="relative inline-flex items-center cursor-pointer select-none">
        <input type="checkbox" name="is_highlight" value="1" class="sr-only peer"
            {{ old('is_highlight', $article->is_highlight ?? false) ? 'checked' : '' }}>
        <div
            class="w-9 h-5 bg-stone-200 peer-focus:outline-none rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-600 peer-checked:bg-zinc-900 dark:peer-checked:bg-zinc-100 dark:peer-checked:after:bg-zinc-900">
        </div>
        <span class="ml-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">Set as Featured Story</span>
    </label>

</div>

{{-- Submit Button --}}
<div class="flex justify-end pt-4 border-t border-stone-200 dark:border-zinc-800 mt-6">
    <button type="submit"
        :disabled="submitting"
        :class="submitting ? 'opacity-70 cursor-not-allowed' : ''"
        class="bg-zinc-900 hover:bg-zinc-800 text-white dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white font-semibold py-2.5 px-6 rounded-lg shadow-sm transition duration-150 ease-in-out inline-flex items-center gap-2">
        <svg x-show="submitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span x-text="submitting ? 'Saving Article...' : '{{ isset($article) ? 'Update Article' : 'Save Article' }}'">{{ isset($article) ? 'Update Article' : 'Save Article' }}</span>
    </button>
</div>
