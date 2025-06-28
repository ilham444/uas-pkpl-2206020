<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Modul: <span class="text-indigo-500">{{ Str::limit($modul->title, 30) }}</span>
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lakukan perubahan pada detail modul di bawah
                    ini.</p>
            </div>
            <div x-data="{ open: false }">
                <button @click="open = true" type="button"
                    class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-500/20 font-semibold py-2 px-4 rounded-lg transition-colors">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.58.22-2.365.468a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193v-.443A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                            clip-rule="evenodd" />
                    </svg>
                    Hapus Modul
                </button>
                <div x-show="open" :class="{'flex': open, 'hidden': !open}" x-cloak
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-40 hidden items-center justify-center bg-black bg-opacity-50">
                    <div @click.away="open = false"
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 max-w-md w-full">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Konfirmasi Penghapusan</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Apakah Anda yakin ingin menghapus modul
                            <span class="font-semibold">"{{ $modul->title }}"</span> secara permanen? Tindakan ini tidak
                            dapat diurungkan.
                        </p>
                        <div class="mt-6 flex justify-end gap-4">
                            <button @click="open = false" type="button"
                                class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-lg">Batal</button>
                            <form action="{{ route('admin.modul.destroy', $modul) }}" method="POST">
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
            <form action="{{ route('admin.modul.update', $modul) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Judul --}}
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <div>
                                <label for="title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul
                                    Modul</label>
                                <input type="text" name="title" id="title"
                                    class="mt-1 block w-full text-lg font-semibold p-3 rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('title', $modul->title) }}" required>
                                @error('title') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        {{-- description --}}
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi
                                    Lengkap</label>
                                <textarea name="description" id="description" rows="10"
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required>{{ old('description', $modul->description) }}</textarea>
                                @error('description') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-1 space-y-6">
                        <div
                            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengaturan</h3>
                            {{-- kategori --}}
                            <div>
                                <label for="kategori_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                                <select name="kategori_id" id="kategori_id"
                                    class="mt-1 block w-full p-3 rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $modul->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                            {{-- estimated --}}
                            <div class="mt-4">
                                <label for="estimated"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estimasi Waktu
                                    (menit)</label>
                                <input type="number" name="estimated" id="estimated"
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('estimated', $modul->estimated) }}" required min="1">
                                @error('estimated') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700"
                            x-data="{ showUploader: false }">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">File Materi</h3>

                            {{-- Tampilan File Saat Ini --}}
                            <div x-show="!showUploader" class="space-y-4">
                                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div
                                        class="flex-shrink-0 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 p-2 rounded-lg">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <a href="{{ Storage::url($modul->thumbnail) }}" target="_blank"
                                            class="text-sm font-semibold text-gray-800 dark:text-gray-200 hover:underline">{{ Str::limit(basename($modul->thumbnail), 25) }}
                                            <p class="text-xs text-gray-500 dark:text-gray-400">File saat ini. Klik
                                                untuk
                                                melihat.</p>
                                        </a>
                                    </div>
                                </div>
                                <button @click="showUploader = true" type="button"
                                    class="w-full text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">Ganti
                                    File</button>
                            </div>

                            {{-- Area Drag & Drop (Muncul saat 'Ganti File' diklik) --}}
                            <div x-show="showUploader" x-cloak>
                                <label x-data="fileDrop()"
                                    class="relative flex flex-col items-center justify-center w-full p-6 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center cursor-pointer hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors">
                                    <input type="file" name="thumbnail" id="thumbnail"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @change="handleFileSelect($event)">
                                    <div x-show="!fileName" class="z-10">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">Seret file baru ke sini</p>
                                    </div>
                                    <div x-show="fileName"
                                        class="z-10 text-sm font-medium text-gray-800 dark:text-gray-200"
                                        x-text="fileName"></div>
                                </label>
                                <p class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengubah file saat ini.
                                </p>
                                <button @click="showUploader = false" type="button"
                                    class="mt-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:underline">Batal
                                    ganti file</button>
                                @error('file') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800/80 backdrop-blur-sm border-t border-gray-200 dark:border-gray-700 z-30">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-3">
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.modul.index') }}"
                                class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Batal</a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded-lg shadow-md transition-colors">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5V4.75z" />
                                </svg>
                                Update Modul
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
                    let file;
                    if (event.type === 'drop' && event.dataTransfer) {
                        file = event.dataTransfer.files[0];
                        document.getElementById('thumbnail').files = event.dataTransfer.files;
                    } else if (event.target.files.length > 0) {
                        file = event.target.files[0];
                    }
                    if (file) {
                        this.fileName = file.name;
                        this.fileSize = this.formatBytes(file.size);
                    }
                },
                removeFile() {
                    const fileInput = document.getElementById('thumbnail');
                    fileInput.value = '';
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
