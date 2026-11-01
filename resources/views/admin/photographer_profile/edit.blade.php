<x-app-layout>
    <div x-data="{ activeTab: 'all' }" class="space-y-6 max-w-5xl mx-auto pb-12">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2.5">
                    <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Photographer Public Profile Settings</span>
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Customize your public portrait, biography story, philosophy pillars, and contact links displayed across the portfolio.
                </p>
            </div>

            {{-- Top Action Buttons --}}
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="http://localhost:3000/about" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm">
                    <span>Preview About Page</span>
                    <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <a href="http://localhost:3000" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg text-xs font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm">
                    <span>Preview Home</span>
                    <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>

                <button type="button" onclick="document.getElementById('profile-form').submit()"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-semibold shadow-sm transition duration-150 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Save Changes</span>
                </button>
            </div>
        </div>

        {{-- Section Navigation Pills --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
            <button type="button" @click="activeTab = 'all'"
                :class="activeTab === 'all' ? 'bg-green-600 text-white font-medium' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3.5 py-1.5 rounded-full border border-gray-200 dark:border-gray-700 transition shadow-xs whitespace-nowrap">
                All Sections
            </button>
            <button type="button" @click="activeTab = 'identity'"
                :class="activeTab === 'identity' ? 'bg-green-600 text-white font-medium' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3.5 py-1.5 rounded-full border border-gray-200 dark:border-gray-700 transition shadow-xs whitespace-nowrap">
                1. Identity & Portrait
            </button>
            <button type="button" @click="activeTab = 'headline'"
                :class="activeTab === 'headline' ? 'bg-green-600 text-white font-medium' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3.5 py-1.5 rounded-full border border-gray-200 dark:border-gray-700 transition shadow-xs whitespace-nowrap">
                2. Homepage Statements
            </button>
            <button type="button" @click="activeTab = 'bio'"
                :class="activeTab === 'bio' ? 'bg-green-600 text-white font-medium' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3.5 py-1.5 rounded-full border border-gray-200 dark:border-gray-700 transition shadow-xs whitespace-nowrap">
                3. Biography & Vision
            </button>
            <button type="button" @click="activeTab = 'philosophy'"
                :class="activeTab === 'philosophy' ? 'bg-green-600 text-white font-medium' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3.5 py-1.5 rounded-full border border-gray-200 dark:border-gray-700 transition shadow-xs whitespace-nowrap">
                4. Philosophy Pillars
            </button>
            <button type="button" @click="activeTab = 'contact'"
                :class="activeTab === 'contact' ? 'bg-green-600 text-white font-medium' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                class="px-3.5 py-1.5 rounded-full border border-gray-200 dark:border-gray-700 transition shadow-xs whitespace-nowrap">
                5. Public Channels
            </button>
        </div>

        {{-- Flash Alerts --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="p-4 bg-green-50 dark:bg-green-950/40 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-xl text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-green-600 dark:text-green-400 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl text-sm space-y-1 shadow-sm">
                <p class="font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Please review the errors below:</span>
                </p>
                <ul class="list-disc pl-5 space-y-0.5 text-xs text-red-700 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profile-form" action="{{ route('admin.photographer-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Card 1: Identity & Portrait Photo --}}
            <div x-show="activeTab === 'all' || activeTab === 'identity'"
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        1. Identity & Portrait Photo
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Your portrait photo is featured on the About hero section, homepage biography teaser, and article author cards.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                    {{-- Avatar Photo Column --}}
                    <div class="md:col-span-4 space-y-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Portrait Photo
                        </label>

                        <div class="space-y-3">
                            <div class="w-40 h-48 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-sm relative group">
                                <img id="avatar-preview"
                                    src="{{ $profile->avatar_url ?: asset('images/jeff-portrait.jpeg') }}"
                                    alt="Avatar Preview"
                                    onerror="this.onerror=null; this.src='{{ asset('images/jeff-portrait.jpeg') }}'"
                                    class="w-full h-full object-cover">
                                
                                <div class="absolute bottom-2 left-2 right-2 px-2 py-1 bg-black/60 backdrop-blur-sm text-[10px] text-white rounded text-center font-mono">
                                    {{ $profile->avatar ? 'Custom Photo' : 'Default Portrait' }}
                                </div>
                            </div>

                            <div>
                                <input type="file" name="avatar" id="avatar-input" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-700 dark:file:text-gray-200 cursor-pointer">
                                <p class="text-[11px] text-gray-400 mt-1">Recommended: 3:4 aspect ratio (JPG, PNG, WEBP, max 5MB)</p>
                            </div>

                            @if ($profile->avatar)
                                <label class="inline-flex items-center gap-2 text-xs text-red-600 dark:text-red-400 cursor-pointer pt-1 hover:underline">
                                    <input type="checkbox" name="remove_avatar" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span>Remove custom photo (revert to default)</span>
                                </label>
                            @endif
                        </div>
                    </div>

                    {{-- Name, Tagline, Location Column --}}
                    <div class="md:col-span-8 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" required
                                placeholder="e.g. Jef Lee"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <p class="text-[11px] text-gray-400 mt-1">Displayed in website header, footer colophon, and copyright statements.</p>
                        </div>

                        <div>
                            <label for="tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Professional Tagline
                            </label>
                            <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $profile->tagline) }}"
                                placeholder="e.g. Portrait & Documentary Photographer"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <p class="text-[11px] text-gray-400 mt-1">Short subtitle appearing under the brand logo in the footer and article colophon.</p>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Studio Base & Location
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location', $profile->location) }}"
                                placeholder="e.g. Australia / Kyoto, Japan"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <p class="text-[11px] text-gray-400 mt-1">Appears on the homepage intro kicker, About bio, and Contact directory.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Headline & Homepage Statements --}}
            <div x-show="activeTab === 'all' || activeTab === 'headline'"
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        2. Homepage Statements & Philosophy Quote
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Curate the prominent editorial statements welcoming visitors on your homepage.
                    </p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Main Headline (Homepage H1)
                        </label>
                        <input type="text" name="headline" id="headline" value="{{ old('headline', $profile->headline) }}"
                            placeholder="e.g. Telling honest stories through natural light and quiet moments."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="sub_headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Sub-Headline / Hero Brief
                        </label>
                        <textarea name="sub_headline" id="sub_headline" rows="2"
                            placeholder="e.g. A portrait and documentary photographer dedicated to capturing genuine human warmth..."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('sub_headline', $profile->sub_headline) }}</textarea>
                    </div>

                    <div>
                        <label for="quote" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Photographer Philosophy Quote
                        </label>
                        <textarea name="quote" id="quote" rows="2"
                            placeholder="e.g. Photography is more than capturing light — it is preserving life itself..."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('quote', $profile->quote) }}</textarea>
                        <p class="text-[11px] text-gray-400 mt-1">Rendered with elegant italic Cormorant Garamond typography in the homepage center banner.</p>
                    </div>
                </div>
            </div>

            {{-- Card 3: Biography & Narrative --}}
            <div x-show="activeTab === 'all' || activeTab === 'bio'"
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        3. Biography & Narrative (About Page)
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Tell your creative journey and personal photographic philosophy on the About page.
                    </p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="about_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Biography Title (About Header)
                        </label>
                        <input type="text" name="about_title" id="about_title" value="{{ old('about_title', $profile->about_title) }}"
                            placeholder="e.g. Documenting the quiet cadence of ordinary life."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="about_journey" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Journey Story (Paragraphs)
                        </label>
                        <textarea name="about_journey" id="about_journey" rows="5"
                            placeholder="Share your beginnings, artistic evolution, and motivations..."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent leading-relaxed">{{ old('about_journey', $profile->about_journey) }}</textarea>
                        <p class="text-[11px] text-gray-400 mt-1">Press Enter twice to start a new paragraph. The first 2 paragraphs are also highlighted on the homepage teaser.</p>
                    </div>

                    <div>
                        <label for="about_philosophy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Working Approach & Philosophy Intro
                        </label>
                        <textarea name="about_philosophy" id="about_philosophy" rows="3"
                            placeholder="Summarize how you work with clients and subject matter..."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent leading-relaxed">{{ old('about_philosophy', $profile->about_philosophy) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Card 4: Three Working Philosophy Pillars --}}
            <div x-show="activeTab === 'all' || activeTab === 'philosophy'"
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        4. Three Working Philosophy Pillars
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        These 3 pillars are showcased side-by-side in a minimalist three-column grid on the About page.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Pillar 1 --}}
                    <div class="space-y-3 p-5 rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase tracking-widest">Pillar 01</span>
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        </div>
                        <div>
                            <label for="philosophy_1_title" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="philosophy_1_title" id="philosophy_1_title" value="{{ old('philosophy_1_title', $profile->philosophy_1_title) }}"
                                placeholder="e.g. Natural Ambient Light"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="philosophy_1_desc" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea name="philosophy_1_desc" id="philosophy_1_desc" rows="4"
                                placeholder="Working strictly with natural morning glow..."
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 leading-relaxed">{{ old('philosophy_1_desc', $profile->philosophy_1_desc) }}</textarea>
                        </div>
                    </div>

                    {{-- Pillar 2 --}}
                    <div class="space-y-3 p-5 rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase tracking-widest">Pillar 02</span>
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        </div>
                        <div>
                            <label for="philosophy_2_title" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="philosophy_2_title" id="philosophy_2_title" value="{{ old('philosophy_2_title', $profile->philosophy_2_title) }}"
                                placeholder="e.g. The Unrehearsed Moment"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="philosophy_2_desc" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea name="philosophy_2_desc" id="philosophy_2_desc" rows="4"
                                placeholder="Avoiding rigid posing in favor of patient observation..."
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 leading-relaxed">{{ old('philosophy_2_desc', $profile->philosophy_2_desc) }}</textarea>
                        </div>
                    </div>

                    {{-- Pillar 3 --}}
                    <div class="space-y-3 p-5 rounded-xl bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase tracking-widest">Pillar 03</span>
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        </div>
                        <div>
                            <label for="philosophy_3_title" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="philosophy_3_title" id="philosophy_3_title" value="{{ old('philosophy_3_title', $profile->philosophy_3_title) }}"
                                placeholder="e.g. Archival Craftsmanship"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="philosophy_3_desc" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea name="philosophy_3_desc" id="philosophy_3_desc" rows="4"
                                placeholder="Each photograph is individually graded with timeless curves..."
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 leading-relaxed">{{ old('philosophy_3_desc', $profile->philosophy_3_desc) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 5: Public Contact & Social Channels --}}
            <div x-show="activeTab === 'all' || activeTab === 'contact'"
                class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        5. Public Contact & Social Channels
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Contact channels displayed on the Contact page, communications directory, and website footer.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Public Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $profile->email) }}"
                            placeholder="e.g. jef@example.com"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-[11px] text-gray-400 mt-1">Direct inquiries email.</p>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            WhatsApp / Direct Line
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}"
                            placeholder="e.g. +61 400 123 456"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-[11px] text-gray-400 mt-1">Include country code for automatic WhatsApp click-to-chat links.</p>
                    </div>

                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Instagram Handle
                        </label>
                        <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $profile->instagram) }}"
                            placeholder="e.g. @jeflee"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-[11px] text-gray-400 mt-1">Username displayed on the site.</p>
                    </div>

                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Instagram Profile URL
                        </label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}"
                            placeholder="https://instagram.com/jeflee"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <p class="text-[11px] text-gray-400 mt-1">Direct URL linked from footer and contact pages.</p>
                    </div>
                </div>
            </div>

            {{-- Sticky / Bottom Submit Bar --}}
            <div class="sticky bottom-4 z-20 bg-white/95 dark:bg-gray-800/95 backdrop-blur-md p-4 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-xl flex items-center justify-between gap-4">
                <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:inline">
                    Changes are synced instantly with your Nuxt portfolio via the public REST API.
                </span>

                <div class="flex items-center gap-3 ml-auto">
                    <button type="submit"
                        class="px-7 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-xl transition duration-150 shadow-md flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Save Profile Changes</span>
                    </button>
                </div>
            </div>
        </form>

    </div>

    {{-- Live Avatar Preview Script --}}
    <script>
        document.getElementById('avatar-input')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const img = document.getElementById('avatar-preview');
                    if (img) img.src = evt.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
