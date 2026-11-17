<x-app-layout>
    @section('title', 'Photographer Public Profile')

    <div x-data="{
        submitting: false,
        isDirty: false,
        activeSection: 'identity',
        previewUrl: '{{ $profile->avatar_url ?: asset('images/jeff-portrait.jpeg') }}',
        heroPreviewUrl: '{{ $profile->hero_image_url ?: '' }}',
        heroPosition: '{{ old('hero_position', $profile->hero_position ?? 'center') }}',
        removeHeroImage: false,
        revertHero() {
            this.heroPreviewUrl = '';
            if (this.$refs.heroInput) {
                this.$refs.heroInput.value = '';
            }
            this.removeHeroImage = true;
            this.isDirty = true;
        },
        isDragging: false,
        isHeroDragging: false,
        init() {
            const sections = ['identity', 'statements', 'biography', 'philosophy', 'contact'];
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.activeSection = entry.target.id.replace('section-', '');
                    }
                });
            }, { rootMargin: '-20% 0px -65% 0px' });

            sections.forEach(id => {
                const el = document.getElementById('section-' + id);
                if (el) observer.observe(el);
            });
        },
        scrollTo(id) {
            this.activeSection = id;
            const el = document.getElementById('section-' + id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        handleAvatarDrop(e) {
            this.isDragging = false;
            const files = e.dataTransfer.files;
            if (files && files.length > 0 && files[0].type.startsWith('image/')) {
                this.$refs.avatarInput.files = files;
                this.updateAvatarPreview(files[0]);
                this.isDirty = true;
            }
        },
        handleAvatarChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.updateAvatarPreview(file);
                this.isDirty = true;
            }
        },
        updateAvatarPreview(file) {
            const reader = new FileReader();
            reader.onload = (evt) => {
                this.previewUrl = evt.target.result;
            };
            reader.readAsDataURL(file);
        },
        handleHeroDrop(e) {
            this.isHeroDragging = false;
            const files = e.dataTransfer.files;
            if (files && files.length > 0 && files[0].type.startsWith('image/')) {
                this.$refs.heroInput.files = files;
                this.updateHeroPreview(files[0]);
                this.isDirty = true;
            }
        },
        handleHeroChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.updateHeroPreview(file);
                this.isDirty = true;
            }
        },
        updateHeroPreview(file) {
            const reader = new FileReader();
            reader.onload = (evt) => {
                this.heroPreviewUrl = evt.target.result;
            };
            reader.readAsDataURL(file);
        }
    }" class="space-y-6 max-w-5xl mx-auto pb-12">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-serif font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">
                    Photographer Public Profile Settings
                </h1>
                <p class="text-xs font-mono text-zinc-500 dark:text-zinc-400 mt-1 uppercase tracking-wider">
                    Author identity, biography essay, working philosophy & contact channels
                </p>
            </div>

            <a href="{{ rtrim(config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000')), '/') . '/about' }}" target="_blank" rel="noopener noreferrer"
                class="px-3.5 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-200 rounded-lg text-xs font-mono font-medium border border-stone-200 dark:border-zinc-700 transition duration-150 inline-flex items-center gap-1.5 self-start sm:self-auto">
                <span>View Live Profile</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>

        {{-- Sticky Navigation & Action Toolbar --}}
        <div class="sticky top-2 z-20 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md rounded-xl border border-stone-200 dark:border-zinc-800 p-2 sm:p-2.5 shadow-sm transition-all">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5">
                {{-- Section Navigation Pills --}}
                <div class="flex items-center gap-1 overflow-x-auto no-scrollbar py-0.5">
                    <button type="button" @click="scrollTo('identity')"
                        :class="activeSection === 'identity'
                            ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 shadow-sm font-medium'
                            : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800'"
                        class="px-3 py-1.5 rounded-lg text-xs font-mono transition-all duration-150 whitespace-nowrap inline-flex items-center gap-1.5">
                        <span class="opacity-60">1.</span> Identity
                    </button>
                    <button type="button" @click="scrollTo('statements')"
                        :class="activeSection === 'statements'
                            ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 shadow-sm font-medium'
                            : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800'"
                        class="px-3 py-1.5 rounded-lg text-xs font-mono transition-all duration-150 whitespace-nowrap inline-flex items-center gap-1.5">
                        <span class="opacity-60">2.</span> Statements
                    </button>
                    <button type="button" @click="scrollTo('biography')"
                        :class="activeSection === 'biography'
                            ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 shadow-sm font-medium'
                            : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800'"
                        class="px-3 py-1.5 rounded-lg text-xs font-mono transition-all duration-150 whitespace-nowrap inline-flex items-center gap-1.5">
                        <span class="opacity-60">3.</span> Biography
                    </button>
                    <button type="button" @click="scrollTo('philosophy')"
                        :class="activeSection === 'philosophy'
                            ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 shadow-sm font-medium'
                            : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800'"
                        class="px-3 py-1.5 rounded-lg text-xs font-mono transition-all duration-150 whitespace-nowrap inline-flex items-center gap-1.5">
                        <span class="opacity-60">4.</span> Philosophy
                    </button>
                    <button type="button" @click="scrollTo('contact')"
                        :class="activeSection === 'contact'
                            ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 shadow-sm font-medium'
                            : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-stone-100 dark:hover:bg-zinc-800'"
                        class="px-3 py-1.5 rounded-lg text-xs font-mono transition-all duration-150 whitespace-nowrap inline-flex items-center gap-1.5">
                        <span class="opacity-60">5.</span> Contact
                    </button>
                </div>

                {{-- Status & Persistent Save Action --}}
                <div class="flex items-center justify-between sm:justify-end gap-3 border-t sm:border-t-0 pt-2 sm:pt-0 border-stone-200 dark:border-zinc-800">
                    <div class="flex items-center">
                        <span x-show="isDirty" x-cloak class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-mono text-amber-700 bg-amber-50 dark:text-amber-400 dark:bg-amber-950/40 rounded-full border border-amber-200 dark:border-amber-900/60">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Unsaved changes
                        </span>
                        <span x-show="!isDirty" class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-mono text-zinc-400 dark:text-zinc-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            All changes saved
                        </span>
                    </div>

                    <button type="button"
                        @click="$refs.profileForm.requestSubmit()"
                        :disabled="submitting"
                        :class="submitting ? 'opacity-70 cursor-not-allowed' : ''"
                        class="px-4 py-1.5 bg-zinc-900 text-white font-mono text-xs font-medium rounded-lg hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white dark:focus:ring-offset-zinc-900 transition duration-150 shadow-sm inline-flex items-center gap-1.5">
                        <svg x-show="submitting" class="animate-spin h-3.5 w-3.5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="submitting ? 'Saving...' : 'Save Profile Changes'">Save Profile Changes</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Errors Alert --}}
        @if ($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl text-sm space-y-1">
                <p class="font-semibold">Please correct the following errors:</p>
                <ul class="list-disc pl-5 space-y-0.5 text-xs text-red-700 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Main Form Container --}}
        <form id="profile-form" x-ref="profileForm"
            @input="isDirty = true"
            @change="isDirty = true"
            @submit="submitting = true"
            action="{{ route('admin.photographer-profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Section 1: Identity & Portrait Photo --}}
            <div id="section-identity" class="scroll-mt-28 bg-white dark:bg-zinc-900 shadow-sm rounded-xl p-6 sm:p-8 border border-stone-200 dark:border-zinc-800 space-y-6">
                <div class="border-b border-stone-200 dark:border-zinc-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">01</span>
                        <h3 class="text-base font-serif font-bold text-zinc-900 dark:text-zinc-100">
                            Identity & Portrait Photo
                        </h3>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        Displayed on the About hero section, homepage biography teaser, and journal article author cards.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                    {{-- Photo Preview & Dropzone --}}
                    <div class="space-y-3">
                        <label class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider">
                            Portrait Photo
                        </label>

                        <div class="space-y-2.5">
                            {{-- Interactive Dropzone Card --}}
                            <div @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleAvatarDrop($event)"
                                @click="$refs.avatarInput.click()"
                                :class="isDragging ? 'border-zinc-900 dark:border-zinc-100 bg-stone-100 dark:bg-zinc-800' : 'border-stone-200 dark:border-zinc-800 hover:border-zinc-400 dark:hover:border-zinc-600'"
                                class="relative w-40 h-52 rounded-xl overflow-hidden bg-stone-100 dark:bg-zinc-950 border-2 border-dashed transition-all cursor-pointer group shadow-sm flex flex-col items-center justify-center">
                                
                                <img id="avatar-preview"
                                    :src="previewUrl"
                                    alt="Portrait Preview"
                                    class="w-full h-full object-cover transition-opacity duration-200 group-hover:opacity-80">

                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-3 text-center text-white">
                                    <svg class="w-6 h-6 mb-1 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-[11px] font-mono leading-tight">Replace Photo</span>
                                </div>
                            </div>

                            <input type="file" id="avatar" name="avatar" x-ref="avatarInput" accept="image/*"
                                @change="handleAvatarChange($event)"
                                class="hidden">

                            <div class="flex flex-col gap-1">
                                <button type="button" @click="$refs.avatarInput.click()"
                                    class="text-xs font-mono text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 underline text-left">
                                    Browse from computer
                                </button>
                                <p class="text-[11px] text-zinc-500 dark:text-zinc-400 font-mono">JPG, PNG, WEBP (max 5MB)</p>
                            </div>

                            @if ($profile->avatar)
                                <label class="inline-flex items-center gap-2 text-xs text-red-600 dark:text-red-400 cursor-pointer pt-1">
                                    <input type="checkbox" name="remove_avatar" value="1" class="rounded border-stone-300 dark:border-zinc-700 text-red-600 focus:ring-red-500">
                                    <span>Revert to default photo</span>
                                </label>
                            @endif
                        </div>
                    </div>

                    {{-- Identity Fields --}}
                    <div class="md:col-span-2 space-y-4">
                        <div>
                            <label for="name" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name', $profile->name) }}" required
                                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                        </div>

                        <div>
                            <label for="tagline" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                                Professional Tagline
                            </label>
                            <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $profile->tagline) }}"
                                placeholder="e.g. Portrait & Documentary Photographer"
                                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                        </div>

                        <div>
                            <label for="location" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                                Studio Base & Location
                            </label>
                            <input type="text" id="location" name="location" value="{{ old('location', $profile->location) }}"
                                placeholder="e.g. Australia / Kyoto, Japan"
                                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Homepage Hero Statements & Quote --}}
            <div id="section-statements" class="scroll-mt-28 bg-white dark:bg-zinc-900 shadow-sm rounded-xl p-6 sm:p-8 border border-stone-200 dark:border-zinc-800 space-y-5">
                <div class="border-b border-stone-200 dark:border-zinc-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">02</span>
                        <h3 class="text-base font-serif font-bold text-zinc-900 dark:text-zinc-100">
                            Homepage Statements & Art Philosophy
                        </h3>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        Primary headlines and philosophical reflections displayed prominently on the portfolio homepage hero.
                    </p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="headline" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Main Headline (Homepage H1)
                        </label>
                        <input type="text" id="headline" name="headline" value="{{ old('headline', $profile->headline) }}"
                            placeholder="e.g. Telling honest stories through natural light and quiet moments."
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                    </div>

                    <div>
                        <label for="sub_headline" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Sub-Headline / Hero Brief
                        </label>
                        <textarea id="sub_headline" name="sub_headline" rows="2"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150 leading-relaxed">{{ old('sub_headline', $profile->sub_headline) }}</textarea>
                    </div>

                    <div>
                        <label for="quote" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Photographer Philosophy Quote
                        </label>
                        <textarea id="quote" name="quote" rows="2"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150 leading-relaxed italic">{{ old('quote', $profile->quote) }}</textarea>
                    </div>

                    {{-- Homepage Hero Photograph & Framing --}}
                    <div class="pt-5 border-t border-stone-200 dark:border-zinc-800 space-y-3">
                        <div>
                            <label class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider">
                                Homepage Hero Photograph (Cinematic Banner)
                            </label>
                            <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-0.5">
                                Ultra-wide 21:9 format. If left empty, the homepage automatically features your top Highlighted Portfolio work.
                            </p>
                        </div>

                        {{-- 21:9 Aspect Ratio Live Preview Box --}}
                        <div class="relative overflow-hidden rounded-xl border-2 border-dashed transition-all duration-200 aspect-[21/9] bg-stone-100 dark:bg-zinc-800/60"
                            :class="isHeroDragging ? 'border-zinc-900 bg-stone-200 dark:border-zinc-100 dark:bg-zinc-800' : 'border-stone-300 dark:border-zinc-700'"
                            @dragover.prevent="isHeroDragging = true"
                            @dragleave.prevent="isHeroDragging = false"
                            @drop.prevent="handleHeroDrop($event)">
                            
                            <template x-if="heroPreviewUrl">
                                <div class="relative w-full h-full group">
                                    <img :src="heroPreviewUrl"
                                        alt="Hero Banner Preview"
                                        class="w-full h-full object-cover transition-all duration-300"
                                        :class="{
                                            'object-top': heroPosition === 'top',
                                            'object-center': heroPosition === 'center',
                                            'object-bottom': heroPosition === 'bottom'
                                        }">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                        <button type="button" @click="$refs.heroInput.click()"
                                            class="px-3 py-1.5 bg-white/95 hover:bg-white text-zinc-900 rounded-lg text-xs font-mono font-medium shadow-sm transition">
                                            Replace Image
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <template x-if="!heroPreviewUrl">
                                <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center cursor-pointer"
                                    @click="$refs.heroInput.click()">
                                    <svg class="w-8 h-8 text-zinc-400 dark:text-zinc-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-xs font-mono text-zinc-700 dark:text-zinc-300 font-medium">Click to upload or drag & drop high-res banner photo</span>
                                    <span class="text-[10px] font-mono text-zinc-400 dark:text-zinc-500 mt-1">Preserves 100% full quality. (JPG, PNG, WEBP max 10MB)</span>
                                </div>
                            </template>
                        </div>

                        <input type="file" id="hero_image" name="hero_image" x-ref="heroInput" accept="image/*"
                            @change="handleHeroChange($event)"
                            class="hidden">

                        {{-- Framing Focal Point Selector (Pilihan 1) --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-mono text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Framing Focal Point:</span>
                                <div class="inline-flex rounded-lg p-0.5 bg-stone-100 dark:bg-zinc-800 border border-stone-200 dark:border-zinc-700">
                                    <button type="button" @click="heroPosition = 'top'; isDirty = true"
                                        :class="heroPosition === 'top' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 font-medium shadow-sm' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'"
                                        class="px-2.5 py-1 text-[11px] font-mono rounded-md transition-all">
                                        Top (Sky / Head)
                                    </button>
                                    <button type="button" @click="heroPosition = 'center'; isDirty = true"
                                        :class="heroPosition === 'center' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 font-medium shadow-sm' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'"
                                        class="px-2.5 py-1 text-[11px] font-mono rounded-md transition-all">
                                        Center (Balanced)
                                    </button>
                                    <button type="button" @click="heroPosition = 'bottom'; isDirty = true"
                                        :class="heroPosition === 'bottom' ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 font-medium shadow-sm' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200'"
                                        class="px-2.5 py-1 text-[11px] font-mono rounded-md transition-all">
                                        Bottom (Foreground)
                                    </button>
                                </div>
                                <input type="hidden" name="hero_position" :value="heroPosition">
                            </div>

                            {{-- Revert / Remove Custom Photo Button --}}
                            <div>
                                <input type="hidden" name="remove_hero_image" :value="removeHeroImage ? '1' : '0'">
                                <template x-if="heroPreviewUrl">
                                    <button type="button" @click="revertHero()"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-mono font-medium text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 bg-red-50 dark:bg-red-950/40 hover:bg-red-100 dark:hover:bg-red-900/60 rounded-lg transition duration-150">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Remove Custom & Revert to Highlight</span>
                                    </button>
                                </template>
                                <template x-if="!heroPreviewUrl">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-mono text-emerald-600 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Active: Highlight Portfolio Banner</span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 3: About Page Biography --}}
            <div id="section-biography" class="scroll-mt-28 bg-white dark:bg-zinc-900 shadow-sm rounded-xl p-6 sm:p-8 border border-stone-200 dark:border-zinc-800 space-y-5">
                <div class="border-b border-stone-200 dark:border-zinc-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">03</span>
                        <h3 class="text-base font-serif font-bold text-zinc-900 dark:text-zinc-100">
                            Biography & Narrative Vision (About Page)
                        </h3>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        Personal long-form narrative detailing your artistic journey, background, and photographic ethos.
                    </p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="about_title" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Biography Title (About Header)
                        </label>
                        <input type="text" id="about_title" name="about_title" value="{{ old('about_title', $profile->about_title) }}"
                            placeholder="e.g. Documenting the quiet cadence of ordinary life."
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                    </div>

                    <div>
                        <label for="about_journey" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Journey Behind The Lens (Story Paragraphs)
                        </label>
                        <textarea id="about_journey" name="about_journey" rows="6"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150 font-serif leading-relaxed">{{ old('about_journey', $profile->about_journey) }}</textarea>
                        <p class="text-[11px] text-zinc-500 dark:text-zinc-400 mt-1 font-mono">Separate paragraphs with blank lines.</p>
                    </div>

                    <div>
                        <label for="about_philosophy" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Working Approach & Philosophy Overview
                        </label>
                        <textarea id="about_philosophy" name="about_philosophy" rows="3"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150 leading-relaxed">{{ old('about_philosophy', $profile->about_philosophy) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Section 4: Three Working Philosophy Pillars --}}
            <div id="section-philosophy" class="scroll-mt-28 bg-white dark:bg-zinc-900 shadow-sm rounded-xl p-6 sm:p-8 border border-stone-200 dark:border-zinc-800 space-y-5">
                <div class="border-b border-stone-200 dark:border-zinc-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">04</span>
                        <h3 class="text-base font-serif font-bold text-zinc-900 dark:text-zinc-100">
                            Three Working Philosophy Pillars
                        </h3>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        Showcased in a 3-column philosophical framework on the About page.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    {{-- Pillar 1 --}}
                    <div class="space-y-3 p-4 rounded-xl bg-stone-50 dark:bg-zinc-800/40 border border-stone-200 dark:border-zinc-800">
                        <span class="text-xs font-mono font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-wider">Pillar 01</span>
                        <div>
                            <label for="philosophy_1_title" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 mb-1">Title</label>
                            <input type="text" id="philosophy_1_title" name="philosophy_1_title" value="{{ old('philosophy_1_title', $profile->philosophy_1_title) }}"
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200">
                        </div>
                        <div>
                            <label for="philosophy_1_desc" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                            <textarea id="philosophy_1_desc" name="philosophy_1_desc" rows="4"
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 leading-relaxed">{{ old('philosophy_1_desc', $profile->philosophy_1_desc) }}</textarea>
                        </div>
                    </div>

                    {{-- Pillar 2 --}}
                    <div class="space-y-3 p-4 rounded-xl bg-stone-50 dark:bg-zinc-800/40 border border-stone-200 dark:border-zinc-800">
                        <span class="text-xs font-mono font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-wider">Pillar 02</span>
                        <div>
                            <label for="philosophy_2_title" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 mb-1">Title</label>
                            <input type="text" id="philosophy_2_title" name="philosophy_2_title" value="{{ old('philosophy_2_title', $profile->philosophy_2_title) }}"
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200">
                        </div>
                        <div>
                            <label for="philosophy_2_desc" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                            <textarea id="philosophy_2_desc" name="philosophy_2_desc" rows="4"
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 leading-relaxed">{{ old('philosophy_2_desc', $profile->philosophy_2_desc) }}</textarea>
                        </div>
                    </div>

                    {{-- Pillar 3 --}}
                    <div class="space-y-3 p-4 rounded-xl bg-stone-50 dark:bg-zinc-800/40 border border-stone-200 dark:border-zinc-800">
                        <span class="text-xs font-mono font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-wider">Pillar 03</span>
                        <div>
                            <label for="philosophy_3_title" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 mb-1">Title</label>
                            <input type="text" id="philosophy_3_title" name="philosophy_3_title" value="{{ old('philosophy_3_title', $profile->philosophy_3_title) }}"
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200">
                        </div>
                        <div>
                            <label for="philosophy_3_desc" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                            <textarea id="philosophy_3_desc" name="philosophy_3_desc" rows="4"
                                class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 leading-relaxed">{{ old('philosophy_3_desc', $profile->philosophy_3_desc) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 5: Public Contact & Social Channels --}}
            <div id="section-contact" class="scroll-mt-28 bg-white dark:bg-zinc-900 shadow-sm rounded-xl p-6 sm:p-8 border border-stone-200 dark:border-zinc-800 space-y-5">
                <div class="border-b border-stone-200 dark:border-zinc-800 pb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-stone-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">05</span>
                        <h3 class="text-base font-serif font-bold text-zinc-900 dark:text-zinc-100">
                            Public Contact & Social Channels
                        </h3>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                        Displayed on the Contact page, communication directory, and website footer.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Public Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}"
                            placeholder="jef@example.com"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            WhatsApp / Direct Line
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}"
                            placeholder="+61 400 123 456"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                    </div>

                    <div>
                        <label for="instagram" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Instagram Handle
                        </label>
                        <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $profile->instagram) }}"
                            placeholder="@jeflee"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                    </div>

                    <div>
                        <label for="instagram_url" class="block text-xs font-mono font-medium text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Instagram Profile URL
                        </label>
                        <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}"
                            placeholder="https://instagram.com/jeflee"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-800 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 border-stone-300 dark:border-zinc-700 focus:border-zinc-800 dark:focus:border-zinc-200 dark:focus:ring-zinc-200 transition duration-150">
                    </div>
                </div>
            </div>

            {{-- Bottom Submit Row --}}
            <div class="pt-2 flex items-center justify-between border-t border-stone-200 dark:border-zinc-800">
                <span class="text-xs font-mono text-zinc-400 dark:text-zinc-500">
                    Studio Profile Configuration
                </span>

                <button type="submit"
                    :disabled="submitting"
                    :class="submitting ? 'opacity-70 cursor-not-allowed' : ''"
                    class="px-6 py-2.5 bg-zinc-900 text-white font-mono text-xs font-medium rounded-lg hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-white dark:focus:ring-offset-zinc-800 transition duration-150 shadow-sm cursor-pointer inline-flex items-center gap-2">
                    <svg x-show="submitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white dark:text-zinc-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="submitting ? 'Saving Profile...' : 'Save Profile Changes'">Save Profile Changes</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
