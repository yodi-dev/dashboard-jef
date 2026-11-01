<x-app-layout>
    <div class="space-y-6 max-w-4xl mx-auto pb-8">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Photographer Public Profile Settings
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Manage your portrait photo, biography story, philosophy pillars, and contact information.
                </p>
            </div>

            <a href="http://localhost:3000/about" target="_blank" rel="noopener noreferrer"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 inline-flex items-center gap-1.5 self-start sm:self-auto">
                <span>View Live Profile</span>
                <span>&rarr;</span>
            </a>
        </div>

        {{-- Flash Message (Alpine.js Dismissible) --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg relative flex items-center justify-between shadow-sm"
                role="alert">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" @click="show = false"
                    class="text-green-700 hover:text-green-900 focus:outline-none transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

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

        {{-- Main Form Card (Single Cohesive Container matching Dashboard Jef Design System) --}}
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.photographer-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                {{-- Section 1: Identity & Portrait Photo --}}
                <div class="space-y-5">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            1. Identity & Portrait Photo
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Displayed on the About hero section, homepage biography teaser, and article author cards.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                        {{-- Photo Preview & Upload --}}
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Portrait Photo
                            </label>

                            <div class="space-y-2">
                                <div class="w-36 h-44 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                                    <img id="avatar-preview"
                                        src="{{ $profile->avatar_url ?: asset('images/jeff-portrait.jpeg') }}"
                                        alt="Portrait Preview"
                                        onerror="this.onerror=null; this.src='{{ asset('images/jeff-portrait.jpeg') }}'"
                                        class="w-full h-full object-cover">
                                </div>

                                <input type="file" id="avatar" name="avatar" accept="image/*"
                                    class="w-full px-3 py-1.5 text-xs border rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-700 dark:file:text-gray-300 transition duration-150">

                                <p class="text-[11px] text-gray-500 dark:text-gray-400">JPG, PNG, WEBP (max 5MB)</p>

                                @if ($profile->avatar)
                                    <label class="inline-flex items-center gap-2 text-xs text-red-600 dark:text-red-400 cursor-pointer pt-1">
                                        <input type="checkbox" name="remove_avatar" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                        <span>Revert to default photo</span>
                                    </label>
                                @endif
                            </div>
                        </div>

                        {{-- Identity Fields --}}
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $profile->name) }}" required
                                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                            </div>

                            <div>
                                <label for="tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Professional Tagline
                                </label>
                                <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $profile->tagline) }}"
                                    placeholder="e.g. Portrait & Documentary Photographer"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Studio Base & Location
                                </label>
                                <input type="text" id="location" name="location" value="{{ old('location', $profile->location) }}"
                                    placeholder="e.g. Australia / Kyoto, Japan"
                                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Homepage Hero Statements & Quote --}}
                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="pb-2">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            2. Homepage Statements & Art Philosophy
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Statements displayed prominently on the portfolio homepage.
                        </p>
                    </div>

                    <div>
                        <label for="headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Main Headline (Homepage H1)
                        </label>
                        <input type="text" id="headline" name="headline" value="{{ old('headline', $profile->headline) }}"
                            placeholder="e.g. Telling honest stories through natural light and quiet moments."
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                    </div>

                    <div>
                        <label for="sub_headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Sub-Headline / Hero Brief
                        </label>
                        <textarea id="sub_headline" name="sub_headline" rows="2"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">{{ old('sub_headline', $profile->sub_headline) }}</textarea>
                    </div>

                    <div>
                        <label for="quote" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Photographer Philosophy Quote
                        </label>
                        <textarea id="quote" name="quote" rows="2"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">{{ old('quote', $profile->quote) }}</textarea>
                    </div>
                </div>

                {{-- Section 3: About Page Biography --}}
                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="pb-2">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            3. Biography & Vision (About Page)
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Personal narrative detailing your background and photographic approach.
                        </p>
                    </div>

                    <div>
                        <label for="about_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Biography Title (About Header)
                        </label>
                        <input type="text" id="about_title" name="about_title" value="{{ old('about_title', $profile->about_title) }}"
                            placeholder="e.g. Documenting the quiet cadence of ordinary life."
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                    </div>

                    <div>
                        <label for="about_journey" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Journey Behind The Lens (Story Paragraphs)
                        </label>
                        <textarea id="about_journey" name="about_journey" rows="5"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150 leading-relaxed">{{ old('about_journey', $profile->about_journey) }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Use an empty line to separate paragraphs.</p>
                    </div>

                    <div>
                        <label for="about_philosophy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Working Approach & Philosophy Overview
                        </label>
                        <textarea id="about_philosophy" name="about_philosophy" rows="3"
                            class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150 leading-relaxed">{{ old('about_philosophy', $profile->about_philosophy) }}</textarea>
                    </div>
                </div>

                {{-- Section 4: Three Working Philosophy Pillars --}}
                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="pb-2">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            4. Three Working Philosophy Pillars
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Showcased side-by-side in a 3-column grid on the About page.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        {{-- Pillar 1 --}}
                        <div class="space-y-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                            <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase">Pillar 01</span>
                            <div>
                                <label for="philosophy_1_title" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                                <input type="text" id="philosophy_1_title" name="philosophy_1_title" value="{{ old('philosophy_1_title', $profile->philosophy_1_title) }}"
                                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500">
                            </div>
                            <div>
                                <label for="philosophy_1_desc" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <textarea id="philosophy_1_desc" name="philosophy_1_desc" rows="4"
                                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 leading-relaxed">{{ old('philosophy_1_desc', $profile->philosophy_1_desc) }}</textarea>
                            </div>
                        </div>

                        {{-- Pillar 2 --}}
                        <div class="space-y-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                            <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase">Pillar 02</span>
                            <div>
                                <label for="philosophy_2_title" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                                <input type="text" id="philosophy_2_title" name="philosophy_2_title" value="{{ old('philosophy_2_title', $profile->philosophy_2_title) }}"
                                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500">
                            </div>
                            <div>
                                <label for="philosophy_2_desc" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <textarea id="philosophy_2_desc" name="philosophy_2_desc" rows="4"
                                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 leading-relaxed">{{ old('philosophy_2_desc', $profile->philosophy_2_desc) }}</textarea>
                            </div>
                        </div>

                        {{-- Pillar 3 --}}
                        <div class="space-y-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                            <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase">Pillar 03</span>
                            <div>
                                <label for="philosophy_3_title" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                                <input type="text" id="philosophy_3_title" name="philosophy_3_title" value="{{ old('philosophy_3_title', $profile->philosophy_3_title) }}"
                                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500">
                            </div>
                            <div>
                                <label for="philosophy_3_desc" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <textarea id="philosophy_3_desc" name="philosophy_3_desc" rows="4"
                                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 leading-relaxed">{{ old('philosophy_3_desc', $profile->philosophy_3_desc) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section 5: Public Contact & Social Channels --}}
                <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="pb-2">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                            5. Public Contact & Social Channels
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                            Displayed on the Contact page, communication directory, and website footer.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Public Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}"
                                placeholder="jef@example.com"
                                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                WhatsApp / Direct Line
                            </label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}"
                                placeholder="+61 400 123 456"
                                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                        </div>

                        <div>
                            <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Instagram Handle
                            </label>
                            <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $profile->instagram) }}"
                                placeholder="@jeflee"
                                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                        </div>

                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Instagram Profile URL
                            </label>
                            <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}"
                                placeholder="https://instagram.com/jeflee"
                                class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 focus:border-green-500 dark:focus:border-green-500 transition duration-150">
                        </div>
                    </div>
                </div>

                {{-- Submit Button (Standard Dashboard Jef Style) --}}
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-150 shadow-sm cursor-pointer">
                        Save Profile Changes
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Live Image Preview Script --}}
    <script>
        document.getElementById('avatar')?.addEventListener('change', function(e) {
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
