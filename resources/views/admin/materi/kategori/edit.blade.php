<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Kategori: <span class="text-indigo-500">{{ Str::limit($kategori->name, 30) }}</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lakukan perubahan pada kategoti di bawah ini.
                </p>
            </div>
            {{-- Tombol Hapus dengan Konfirmasi Modal --}}
            <div x-data="{ open: false }">
                <button @click="open = true" type="button"
                    class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-500/20 font-semibold py-2 px-4 rounded-lg transition-colors">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                            clip-rule="evenodd" />
                    </svg>
                    Hapus Kategori
                </button>

                {{-- Modal Konfirmasi --}}
                <div x-show="open" :class="{'flex': open, 'hidden': !open}" x-cloak
                    class="fixed inset-0 z-40 hidden items-center justify-center bg-black bg-opacity-50">
                    <div @click.away="open = false"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 max-w-md w-full">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Konfirmasi Penghapusan</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 text-wrap">Apakah Anda yakin ingin
                            menghapus
                            kategori <span class="font-semibold">"{{ $kategori->name }}"</span> secara permanen?
                            Tindakan ini tidak dapat diurungkan.</p>
                        <div class="mt-6 flex justify-end gap-4">
                            <button @click="open = false" type="button"
                                class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-lg">Batal</button>
                            <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg">Ya,
                                    Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST"
                x-data="{ name: '{{ $kategori->name }}', slug: '{{ $kategori->slug }}' }"
                class="text-gray-800 dark:text-gray-200">
                @csrf
                @method('PUT')
                <div class="flex gap-8 flex-col">

                    <!-- Kolom Utama -->
                    <div class="flex-1 space-y-6">
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <!-- Judul Kategori -->
                            <div>
                                <label for="title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    kategori</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full text-lg font-semibold p-3 rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:text-"
                                    x-model="name"
                                    @input="slug = name.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-')"
                                    value="{{ old('name', $kategori->name) }}" required>
                                @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Slug Kategori -->
                    <div class="flex-1">
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 space-y-6">
                            <div>
                                <label for="slug"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                                <input type="text" name="slug" id="slug"
                                    class="mt-1 block w-full text-lg font-semibold p-3 rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('slug', $kategori->name) }}" placeholder="Contoh: enslish" required
                                    x-model="slug">
                                @error('slug') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Aksi "Sticky" -->
                <div
                    class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800/80 backdrop-blur-sm border-t border-gray-200 dark:border-gray-700 z-30">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-3">
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.kategori.index') }}"
                                class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Batal</a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-lg shadow-md transition-colors">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5V4.75z" />
                                </svg>
                                Update Kategori
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
