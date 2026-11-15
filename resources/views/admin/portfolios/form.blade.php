<div class="space-y-6">

    {{-- Title --}}
    <div>
        <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
            Title <span class="text-red-500">*</span>
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $portfolio->title ?? '') }}" required
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">

        @error('title')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category / Theme --}}
    <div>
        <label for="category" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
            Category / Theme <span class="text-red-500">*</span>
        </label>
        <select id="category" name="category" required
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
            @foreach(\App\Models\Portfolio::CATEGORIES as $cat)
                <option value="{{ $cat }}" {{ old('category', $portfolio->category ?? 'Portrait') === $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>

        @error('category')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
            Description
        </label>
        <textarea id="description" name="description" rows="4"
            placeholder="Write a brief narrative or client backstory for this session..."
            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">{{ old('description', $portfolio->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Thumbnail Upload --}}
    <div x-data="{
        preview: null,
        isDragging: false,
        handleDrop(e) {
            this.isDragging = false;
            const file = e.dataTransfer?.files?.[0];
            if (file && file.type.startsWith('image/')) {
                this.$refs.thumbInput.files = e.dataTransfer.files;
                this.preview = URL.createObjectURL(file);
            }
        }
    }" class="space-y-2">
        <label for="thumbnail" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
            Cover Thumbnail <span class="text-xs text-zinc-500 font-normal">(Hero card image, 3:2 or 4:5 ratio recommended)</span>
        </label>

        <div class="flex flex-col sm:flex-row items-start gap-4">
            {{-- Preview box --}}
            <div class="w-36 h-28 rounded-xl overflow-hidden border border-stone-200 dark:border-zinc-700 bg-stone-100 dark:bg-zinc-800 flex-shrink-0 flex items-center justify-center relative shadow-sm">
                <template x-if="preview">
                    <img :src="preview" alt="New Thumbnail Preview" class="w-full h-full object-cover">
                </template>
                <template x-if="!preview">
                    @if (isset($portfolio) && $portfolio->thumbnail_url)
                        <img src="{{ $portfolio->thumbnail_url }}" alt="Current Thumbnail" class="w-full h-full object-cover">
                    @else
                        <div class="text-center p-2">
                            <svg class="mx-auto h-6 w-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[10px] text-zinc-400 block mt-1">No Image</span>
                        </div>
                    @endif
                </template>
            </div>

            {{-- Dropzone / Upload button --}}
            <div class="flex-1 w-full"
                 @dragover.prevent="isDragging = true"
                 @dragleave.prevent="isDragging = false"
                 @drop.prevent="handleDrop($event)">
                <label for="thumbnail"
                    :class="isDragging ? 'border-zinc-900 dark:border-zinc-100 bg-stone-100 dark:bg-zinc-800/80 ring-2 ring-zinc-800' : 'border-stone-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-stone-50/50 dark:bg-zinc-900/50'"
                    class="cursor-pointer border-2 border-dashed rounded-xl p-4 flex flex-col items-center justify-center transition-all text-center">
                    <svg class="w-6 h-6 text-zinc-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <p class="text-xs text-zinc-700 dark:text-zinc-300 font-medium">
                        Click to upload cover, or drag & drop image here
                    </p>
                    <p class="text-[11px] text-zinc-400 mt-0.5">JPG, PNG, or WEBP up to 5MB</p>
                    <input type="file" id="thumbnail" name="thumbnail" accept="image/*" x-ref="thumbInput"
                        @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                        class="hidden">
                </label>
            </div>
        </div>

        @error('thumbnail')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Gallery Drag-and-Drop Uploader (P3_1) --}}
    <div x-data="{
        isDragging: false,
        newPhotos: [],
        lightboxUrl: null,

        handleFiles(fileList) {
            const files = Array.from(fileList);
            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const id = Date.now() + Math.random().toString(36).substring(2, 9);
                this.newPhotos.push({
                    id: id,
                    file: file,
                    name: file.name,
                    size: (file.size / (1024 * 1024)).toFixed(2) + ' MB',
                    preview: URL.createObjectURL(file)
                });
            });
            this.syncInput();
        },

        handleDrop(e) {
            this.isDragging = false;
            if (e.dataTransfer && e.dataTransfer.files) {
                this.handleFiles(e.dataTransfer.files);
            }
        },

        removePhoto(index) {
            this.newPhotos.splice(index, 1);
            this.syncInput();
        },

        clearAll() {
            this.newPhotos = [];
            this.syncInput();
        },

        syncInput() {
            try {
                const dt = new DataTransfer();
                this.newPhotos.forEach(p => dt.items.add(p.file));
                this.$refs.galleryInput.files = dt.files;
            } catch (e) {
                // Fallback for browsers that restrict DataTransfer files
            }
        }
    }" class="space-y-4 pt-2 border-t border-stone-200 dark:border-zinc-800">

        <div class="flex items-center justify-between">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    Gallery Collection
                </label>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                    Batch upload high-resolution images for the full-width portfolio gallery.
                </p>
            </div>
            <span class="text-xs font-mono text-zinc-400" x-show="newPhotos.length > 0">
                <span x-text="newPhotos.length"></span> new selected
            </span>
        </div>

        {{-- Existing Gallery Grid (If Editing) --}}
        @if (isset($portfolio) && !empty($portfolio->gallery) && is_array($portfolio->gallery))
            <div class="space-y-2 p-4 bg-stone-50/50 dark:bg-zinc-800/30 rounded-xl border border-stone-200 dark:border-zinc-800">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">
                        Saved Gallery Photos ({{ count($portfolio->gallery) }})
                    </span>
                    <span class="text-[11px] text-zinc-400">Click photo to zoom</span>
                </div>

                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 pt-1">
                    @foreach ($portfolio->gallery as $idx => $rawPath)
                        @php
                            $displayUrl = \Illuminate\Support\Str::startsWith($rawPath, ['http://', 'https://']) ? $rawPath : \Illuminate\Support\Facades\Storage::url($rawPath);
                        @endphp
                        <div class="relative group aspect-square rounded-lg overflow-hidden border border-stone-200 dark:border-zinc-700 shadow-sm bg-stone-100 dark:bg-zinc-800">
                            <img src="{{ $displayUrl }}"
                                 alt="Gallery photo {{ $idx + 1 }}"
                                 @click="lightboxUrl = '{{ $displayUrl }}'"
                                 class="w-full h-full object-cover cursor-pointer transition-transform duration-200 group-hover:scale-105">

                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </div>

                            <button type="button"
                                onclick="if(confirm('Delete this photo from the gallery?')) { document.getElementById('delete-gallery-form-{{ $idx }}').submit(); }"
                                class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-transform opacity-90 group-hover:opacity-100 z-10"
                                title="Remove photo from gallery">
                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Dropzone Area --}}
        <div @dragover.prevent="isDragging = true"
             @dragleave.prevent="isDragging = false"
             @drop.prevent="handleDrop($event)">
            <label for="gallery"
                :class="isDragging ? 'border-zinc-900 dark:border-zinc-100 bg-stone-100 dark:bg-zinc-800/80 ring-2 ring-zinc-800 scale-[1.005]' : 'border-stone-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 bg-stone-50/50 dark:bg-zinc-900/50'"
                class="cursor-pointer border-2 border-dashed rounded-2xl p-6 sm:p-8 flex flex-col items-center justify-center transition-all text-center">
                <div class="w-12 h-12 rounded-full bg-stone-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                    Drag and drop photos here, or <span class="underline underline-offset-2">browse files</span>
                </p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    Select multiple JPG, PNG, or WEBP photos to add to this portfolio.
                </p>
                <input type="file" id="gallery" name="gallery[]" multiple accept="image/*" x-ref="galleryInput"
                    @change="handleFiles($event.target.files)"
                    class="hidden">
            </label>
        </div>

        {{-- Live Preview Grid for Newly Selected Photos --}}
        <div x-show="newPhotos.length > 0" class="space-y-3 pt-2">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-zinc-800 dark:text-zinc-200">
                    New Photos to Upload (<span x-text="newPhotos.length"></span>)
                </span>
                <button type="button" @click="clearAll()" class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 transition">
                    Clear selection
                </button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                <template x-for="(photo, index) in newPhotos" :key="photo.id">
                    <div class="relative group aspect-square rounded-xl overflow-hidden border-2 border-zinc-800 dark:border-zinc-200 shadow-sm bg-stone-100 dark:bg-zinc-800">
                        <img :src="photo.preview" :alt="photo.name" class="w-full h-full object-cover">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex flex-col justify-end p-2 pointer-events-none">
                            <p class="text-[10px] text-white font-medium truncate" x-text="photo.name"></p>
                            <p class="text-[9px] text-zinc-300 font-mono" x-text="photo.size"></p>
                        </div>

                        <button type="button" @click="removePhoto(index)"
                            class="absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-transform opacity-90 hover:opacity-100"
                            title="Remove photo">
                            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>

        {{-- Lightbox Zoom Modal for Saved Photos --}}
        <div x-show="lightboxUrl"
             x-cloak
             @keydown.escape.window="lightboxUrl = null"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-950/90 backdrop-blur-md"
             style="display: none;">
            <button type="button" @click="lightboxUrl = null"
                class="absolute top-5 right-5 text-white/80 hover:text-white p-2 rounded-full bg-white/10 hover:bg-white/20 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img :src="lightboxUrl" alt="Enlarged photo preview" class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl">
        </div>

        @error('gallery')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
        @error('gallery.*')
            <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- Checkboxes for Status (Published & Highlight) --}}
    <div class="flex flex-col sm:flex-row sm:space-x-8 space-y-3 sm:space-y-0 pt-4 border-t border-stone-200 dark:border-zinc-800">

        {{-- Is Published --}}
        <label class="inline-flex items-center cursor-pointer select-none">
            <input type="checkbox" name="is_published" value="1"
                class="w-5 h-5 rounded border-stone-300 text-zinc-900 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-400 focus:ring-opacity-50 dark:bg-zinc-900 dark:border-zinc-700"
                {{ old('is_published', $portfolio->is_published ?? false) ? 'checked' : '' }}>
            <span class="ml-2.5 text-sm text-zinc-700 dark:text-zinc-300 font-medium">Publish Portfolio (Make public)</span>
        </label>

        {{-- Is Highlight --}}
        <label class="inline-flex items-center cursor-pointer select-none">
            <input type="checkbox" name="is_highlight" value="1"
                class="w-5 h-5 rounded border-stone-300 text-zinc-900 shadow-sm focus:border-zinc-500 focus:ring focus:ring-zinc-400 focus:ring-opacity-50 dark:bg-zinc-900 dark:border-zinc-700"
                {{ old('is_highlight', $portfolio->is_highlight ?? false) ? 'checked' : '' }}>
            <span class="ml-2.5 text-sm text-zinc-700 dark:text-zinc-300 font-medium">Set as Highlight (Landing Page Hero)</span>
        </label>

    </div>

</div>
