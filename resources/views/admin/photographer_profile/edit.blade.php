<x-app-layout>
    <div class="space-y-6 max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Pengaturan Profil Publik Fotografer
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Kelola foto profil, narasi biografi, kutipan, dan kontak publik yang tampil secara dinamis di website portfolio.
                </p>
            </div>

            <a href="http://localhost:3000" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 self-start sm:self-auto">
                <span>Lihat Web Portfolio</span>
                <span>&rarr;</span>
            </a>
        </div>

        {{-- Flash Alerts --}}
        @if (session('success'))
            <div class="p-4 bg-green-50 dark:bg-green-950/40 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl text-sm space-y-1 shadow-sm">
                <p class="font-semibold">Terjadi beberapa kesalahan input:</p>
                <ul class="list-disc pl-5 space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.photographer-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Card 1: Identitas & Foto Profil --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        1. Identitas & Foto Potret
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Foto potret ini akan tampil di bagian hero About, thumbnail bio homepage, dan kartu penulis di detail artikel.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                    {{-- Foto Avatar --}}
                    <div class="md:col-span-4 space-y-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Foto Potret / Avatar
                        </label>

                        <div class="space-y-3">
                            <div class="w-36 h-44 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 relative">
                                <img id="avatar-preview"
                                    src="{{ $profile->avatar_url ?: asset('images/jeff-portrait.jpeg') }}"
                                    alt="Avatar Preview"
                                    class="w-full h-full object-cover">
                            </div>

                            <div>
                                <input type="file" name="avatar" id="avatar-input" accept="image/*"
                                    class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-gray-700 dark:file:text-gray-200 cursor-pointer">
                                <p class="text-[11px] text-gray-400 mt-1">Maks. 5MB (JPG, PNG, WEBP)</p>
                            </div>

                            @if ($profile->avatar)
                                <label class="inline-flex items-center gap-2 text-xs text-red-600 dark:text-red-400 cursor-pointer pt-1">
                                    <input type="checkbox" name="remove_avatar" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span>Hapus foto kustom (gunakan default)</span>
                                </label>
                            @endif
                        </div>
                    </div>

                    {{-- Nama, Tagline, Lokasi --}}
                    <div class="md:col-span-8 space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nama Lengkap Fotografer <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="tagline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tagline Profesi
                            </label>
                            <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $profile->tagline) }}"
                                placeholder="e.g. Portrait & Documentary Photographer"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Lokasi / Basis Studio
                            </label>
                            <input type="text" name="location" id="location" value="{{ old('location', $profile->location) }}"
                                placeholder="e.g. Australia / Kyoto, Japan"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Headline & Pernyataan Seni Homepage --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        2. Headline & Kutipan Filosofi (Homepage)
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Pernyataan pembuka di halaman depan website portfolio.
                    </p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Headline Utama (H1 Homepage)
                        </label>
                        <input type="text" name="headline" id="headline" value="{{ old('headline', $profile->headline) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="sub_headline" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Sub-Headline / Deskripsi Singkat Hero
                        </label>
                        <textarea name="sub_headline" id="sub_headline" rows="2"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('sub_headline', $profile->sub_headline) }}</textarea>
                    </div>

                    <div>
                        <label for="quote" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Kutipan Seni / Filosofi Fotografi
                        </label>
                        <textarea name="quote" id="quote" rows="2"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('quote', $profile->quote) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Card 3: Biografi & Narasi About --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        3. Biografi & Cerita (Halaman About)
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Narasi personal tentang perjalanan fotografi dan filosofi berkarya.
                    </p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="about_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Judul Biografi (About Header)
                        </label>
                        <input type="text" name="about_title" id="about_title" value="{{ old('about_title', $profile->about_title) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="about_journey" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Paragraf Perjalanan (My Journey Behind The Lens)
                        </label>
                        <textarea name="about_journey" id="about_journey" rows="4"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('about_journey', $profile->about_journey) }}</textarea>
                        <p class="text-[11px] text-gray-400 mt-1">Gunakan baris baru (Enter) untuk memisahkan antar paragraf.</p>
                    </div>

                    <div>
                        <label for="about_philosophy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Paragraf Pendekatan & Filosofi Berkarya
                        </label>
                        <textarea name="about_philosophy" id="about_philosophy" rows="3"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('about_philosophy', $profile->about_philosophy) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Card 4: 3 Pilar Filosofi Kerja --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        4. Tiga Pilar Filosofi Kerja (Working Philosophy)
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Ditampilkan dalam 3 kolom elegan pada halaman About.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Pilar 1 --}}
                    <div class="space-y-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase">Pilar 01</span>
                        <div>
                            <label for="philosophy_1_title" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Pilar</label>
                            <input type="text" name="philosophy_1_title" id="philosophy_1_title" value="{{ old('philosophy_1_title', $profile->philosophy_1_title) }}"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-xs focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="philosophy_1_desc" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat</label>
                            <textarea name="philosophy_1_desc" id="philosophy_1_desc" rows="3"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-xs focus:ring-2 focus:ring-green-500">{{ old('philosophy_1_desc', $profile->philosophy_1_desc) }}</textarea>
                        </div>
                    </div>

                    {{-- Pilar 2 --}}
                    <div class="space-y-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase">Pilar 02</span>
                        <div>
                            <label for="philosophy_2_title" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Pilar</label>
                            <input type="text" name="philosophy_2_title" id="philosophy_2_title" value="{{ old('philosophy_2_title', $profile->philosophy_2_title) }}"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-xs focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="philosophy_2_desc" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat</label>
                            <textarea name="philosophy_2_desc" id="philosophy_2_desc" rows="3"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-xs focus:ring-2 focus:ring-green-500">{{ old('philosophy_2_desc', $profile->philosophy_2_desc) }}</textarea>
                        </div>
                    </div>

                    {{-- Pilar 3 --}}
                    <div class="space-y-3 p-4 rounded-lg bg-gray-50 dark:bg-gray-900/60 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs font-mono font-bold text-green-600 dark:text-green-400 uppercase">Pilar 03</span>
                        <div>
                            <label for="philosophy_3_title" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Judul Pilar</label>
                            <input type="text" name="philosophy_3_title" id="philosophy_3_title" value="{{ old('philosophy_3_title', $profile->philosophy_3_title) }}"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-xs focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label for="philosophy_3_desc" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi Singkat</label>
                            <textarea name="philosophy_3_desc" id="philosophy_3_desc" rows="3"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-xs focus:ring-2 focus:ring-green-500">{{ old('philosophy_3_desc', $profile->philosophy_3_desc) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 5: Kontak Publik & Sosial Media --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-700 space-y-6">
                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        5. Kontak Publik & Sosial Media
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Informasi ini ditampilkan di halaman Contact, direktori komunikasi, dan footer website.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Email Publik
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $profile->email) }}"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nomor WhatsApp / Telepon
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}"
                            placeholder="e.g. +61 400 123 456"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="instagram" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Handle Instagram
                        </label>
                        <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $profile->instagram) }}"
                            placeholder="e.g. @jeflee"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            URL Profil Instagram
                        </label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ old('instagram_url', $profile->instagram_url) }}"
                            placeholder="https://instagram.com/jeflee"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            {{-- Submit Sticky / Bottom Bar --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit"
                    class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium text-sm rounded-xl transition duration-150 shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan Profil</span>
                </button>
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

