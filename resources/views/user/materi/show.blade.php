<x-app-layout>
    {{-- Slot untuk judul halaman dinamis di tab browser --}}
    <x-slot name="title">{{ $materi->title }} - EduPlatform</x-slot>

    {{-- Header Halaman yang Lebih Informatif --}}
    <div class="bg-white dark:bg-gray-800/50 shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumbs untuk Navigasi --}}
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li>
                        <a href="{{ route('user.dashboard') }}"
                            class="text-sm font-medium text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('user.modul.show', $modul->slug) }}"
                                class="ml-1 text-sm font-medium text-gray-700 md:ml-2 dark:text-gray-300">{{ $modul->title }}</a>
                        </div>
                    </li>
                </ol>
            </nav>
            {{-- Judul Utama --}}
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                {{ $materi->title }}
            </h1>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 xl:gap-12">

                <!-- ============================================= -->
                <!-- Kolom Konten Utama (Kiri, 2/3) -->
                <!-- ============================================= -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Player Konten (Video/PDF) -->
                    <div
                        class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                        @php $fileExtension = pathinfo($materi->file_path, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($fileExtension), ['mp4', 'webm', 'ogg']))
                            <div class="aspect-w-16 aspect-h-9 bg-black">
                                <video controls controlsList="nodownload" class="w-full h-full">
                                    <source src="{{ Storage::url($materi->file_path) }}" type="video/{{ $fileExtension }}">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            </div>
                        @elseif(strtolower($fileExtension) == 'pdf')
                            <div class="aspect-w-4 aspect-h-5" style="height: 80vh;">
                                <iframe src="{{ Storage::url($materi->file_path) }}#toolbar=0" class="w-full h-full"
                                    frameborder="0"></iframe>
                            </div>
                        @elseif(in_array(strtolower($fileExtension), ['png', 'jpg', 'jpeg']))
                            <div class="aspect-w-16 aspect-h-9 bg-black">
                                <img src="{{ Storage::url($modul->thumbnail) }}" alt="{{ $modul->title }}" />
                            </div>
                        @else
                            {{-- Tampilan untuk file yang tidak bisa di-preview --}}
                            <div
                                class="p-10 text-center bg-gray-50 dark:bg-gray-800 flex flex-col items-center justify-center min-h-[300px]">
                                <div class="bg-indigo-100 dark:bg-indigo-500/10 p-4 rounded-full">
                                    <svg class="h-12 w-12 text-indigo-600 dark:text-indigo-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-200">Pratinjau Tidak
                                    Tersedia</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">File ini tidak dapat ditampilkan
                                    langsung di browser.</p>
                                <a href="{{ Storage::url($materi->file_path) }}" target="_blank"
                                    class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                        <path
                                            d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                    </svg>
                                    Download File ({{ strtoupper($fileExtension) }})
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Area Deskripsi & Diskusi (dengan Tabs) -->
                    <div x-data="{ tab: 'deskripsi' }"
                        class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <nav class="-mb-px flex space-x-6 px-6" aria-label="Tabs">
                                <button @click="tab = 'deskripsi'"
                                    :class="tab === 'deskripsi' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">Deskripsi</button>
                                <button @click="tab = 'diskusi'"
                                    :class="tab === 'diskusi' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">Diskusi
                                    ({{ $materi->komentars->count() }})</button>
                            </nav>
                        </div>
                        <div class="p-6 md:p-8">
                            {{-- Konten Deskripsi --}}
                            <div x-show="tab === 'deskripsi'" class="prose prose-indigo dark:prose-invert max-w-none">
                                {!! nl2br(e($materi->description)) !!}
                            </div>

                            {{-- Konten Diskusi --}}
                            <div x-show="tab === 'diskusi'" class="space-y-8">
                                <!-- Form Tambah Komentar -->
                                <form action="{{ route('komentar.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="materi_id" value="{{ $materi->id }}">
                                    <div class="flex items-start space-x-4">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff&bold=true"
                                            alt="Avatar">
                                        <div class="min-w-0 flex-1">
                                            <div
                                                class="border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm overflow-hidden focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500">
                                                <textarea name="body" rows="3"
                                                    class="block w-full py-3 px-4 border-0 resize-none focus:ring-0 text-sm dark:bg-gray-800 dark:text-gray-200"
                                                    placeholder="Ada pertanyaan atau ingin berbagi sesuatu?"
                                                    required></textarea>
                                                <div class="py-2 px-3 bg-gray-50 dark:bg-gray-700/50 flex justify-end">
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-md shadow-sm transition-all text-sm">
                                                        Kirim Komentar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- Daftar Komentar -->
                                <div class="space-y-6">
                                    @forelse ($materi->komentars()->latest()->get() as $komentar)
                                        <div class="flex space-x-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                                            <img class="h-10 w-10 rounded-full"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($komentar->user->name) }}&background=random"
                                                alt="Avatar">
                                            <div class="min-w-0 flex-1">
                                                <div class="flex justify-between items-center">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $komentar->user->name }}
                                                        @if($komentar->user_id === Auth::id())
                                                            <span
                                                                class="ml-2 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300 px-2 py-0.5 rounded-full">Anda</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $komentar->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="mt-2 text-sm text-gray-700 dark:text-gray-300 prose prose-sm max-w-none dark:prose-invert">
                                                    {!! nl2br(e($komentar->body)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-10 border-t border-gray-200 dark:border-gray-700">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">Belum Ada
                                                Diskusi</h3>
                                            <p class="mt-1 text-sm text-gray-500">Jadilah yang pertama memulai percakapan!
                                            </p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================= -->
                <!-- Kolom Informasi (Kanan, 1/3) - Sidebar -->
                <!-- ============================================= -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Panel Status & Informasi Materi -->
                    <div
                        class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700">
                        <div class="p-6 space-y-6">
                            <div x-data="{ completed: false }">
                                <button @click="completed = !completed"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 font-semibold rounded-lg transition-all duration-300"
                                    :class="completed ? 'bg-green-600 text-white' : 'bg-indigo-600 hover:bg-indigo-700 text-white'">
                                    <svg x-show="completed" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg x-show="!completed" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="completed ? 'Sudah Selesai!' : 'Tandai Selesai'"></span>
                                </button>
                            </div>
                            <ul class="text-sm space-y-4">
                                <li class="flex items-center justify-between">
                                    <span
                                        class="flex items-center gap-2 font-semibold text-gray-600 dark:text-gray-300"><svg
                                            class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg> Kategori</span>
                                    <span
                                        class="px-2 py-1 bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300 rounded text-xs font-medium">{{ $modul->kategori->name }}</span>
                                </li>
                                <li class="flex items-center justify-between">
                                    <span
                                        class="flex items-center gap-2 font-semibold text-gray-600 dark:text-gray-300"><svg
                                            class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg> Diupload</span>
                                    <span
                                        class="text-gray-800 dark:text-gray-200">{{ $materi->created_at->format('d F Y') }}</span>
                                </li>
                                <li class="flex items-center justify-between">
                                    <span
                                        class="flex items-center gap-2 font-semibold text-gray-600 dark:text-gray-300"><svg
                                            class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg> Tipe File</span>
                                    <span
                                        class="text-gray-800 dark:text-gray-200">{{ strtoupper($fileExtension) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Panel Materi Selanjutnya --}}
                    @isset($nextMateri)
                        <div
                            class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col">
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3
                                        class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">
                                        Materi Selanjutnya
                                    </h3>
                                    <p class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-2">
                                        {{ $nextMateri->title }}
                                    </p>
                                </div>
                                <a href="{{ route('user.modul.materi.show', [$modul, $nextMateri->slug]) }}"
                                    class="mt-4 flex items-center justify-center gap-2 w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2.5 px-4 rounded-lg transition-colors">
                                    Lanjutkan Belajar
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endisset
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
