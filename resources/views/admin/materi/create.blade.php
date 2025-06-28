<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Tambah Materi Baru') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Isi detail materi untuk dipublikasikan ke platform.
                </p>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.modul.materi.store', $modul) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Kolom Kiri -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Input Judul -->
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul
                                Materi</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                class="mt-1 block w-full text-lg font-semibold p-3 rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Contoh: Pengenalan Laravel 11" required>
                            @error('title') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Input Deskripsi -->
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi
                                Lengkap</label>
                            <textarea name="description" id="description" rows="10" required
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Jelaskan secara detail apa yang akan dipelajari dalam materi ini...">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-2">Gunakan editor ini untuk memformat teks, list, atau
                                menyisipkan tautan.</p>
                            @error('description') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Pilih Kategori -->
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan</h3>

                            {{-- Urutan Materi --}}
                            <div class="mt-4">
                                <label for="urutan"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urutan Materi
                                </label>
                                <input type="number" name="urutan" id="urutan"
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('urutan', $modul->materis->count() + 1) }}" required min="1">
                                @error('urutan') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Upload File -->
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">File Materi</h3>

                            <div x-data="fileDrop()"
                                class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center cursor-pointer hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors"
                                @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false">

                                <div class="absolute inset-0 bg-indigo-50 dark:bg-indigo-500/10" x-show="dragging">
                                </div>

                                <input type="file" name="file" id="file" required
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    @change="handleFileSelect($event)">

                                <div class="relative z-10" x-show="!fileName">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-4-4V7a4 4 0 014-4h.586a1 1 0 01.707.293l2 2a1 1 0 001.414 0l2-2a1 1 0 01.707-.293H17a4 4 0 014 4v5a4 4 0 01-4 4H7z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                        <span class="font-semibold text-indigo-600 dark:text-indigo-400">Seret
                                            file</span> atau klik untuk upload
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">PDF, MP4, WEBM, OGG (Maks. 50MB)</p>
                                </div>

                                <div class="relative z-10" x-show="fileName">
                                    <div class="flex items-center gap-3">
                                        <svg class="h-10 w-10 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200"
                                                x-text="fileName"></p>
                                            <p class="text-xs text-gray-500" x-text="fileSize"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click="removeFile()"
                                        class="mt-3 text-xs text-red-500 hover:underline">Hapus file</button>
                                </div>
                            </div>
                            @error('file') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Tombol Sticky Bawah -->
                <div
                    class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800/80 backdrop-blur-sm border-t border-gray-200 dark:border-gray-700 z-30">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-3">
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.modul.materi.index', $modul) }}"
                                class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Batal</a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-lg shadow-md transition-colors">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59L7.3 9.24a.75.75 0 00-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z"
                                        clip-rule="evenodd" />
                                </svg>
                                Simpan Materi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function fileDrop() {
            return {
                dragging: false,
                fileName: '',
                fileSize: '',
                handleFileSelect(event) {
                    if (event.target.files.length > 0) {
                        const file = event.target.files[0];
                        this.fileName = file.name;
                        this.fileSize = this.formatBytes(file.size);
                    }
                },
                removeFile() {
                    document.getElementById('file').value = '';
                    this.fileName = '';
                    this.fileSize = '';
                },
                formatBytes(bytes, decimals = 2) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const dm = decimals < 0 ? 0 : decimals;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
                }
            }
        }
    </script>
</x-app-layout>
