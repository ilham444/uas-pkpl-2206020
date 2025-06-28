<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                {{-- Breadcrumbs untuk Navigasi yang Lebih Baik --}}
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li>
                            <a href="{{ route('admin.modul.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">Manajemen Modul</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                                <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2 dark:text-gray-300">{{ Str::limit($modul->title, 40) }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Daftar Materi') }}
                </h2>
            </div>

            <a href="{{ route('admin.modul.materi.create', $modul) }}"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                <span>Tambah Materi Baru</span>
            </a>
        </div>
    </x-slot>

    {{-- Notifikasi Toast (pertahankan, ini sudah bagus) --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="fixed top-24 right-5 bg-green-500 text-white py-2 px-4 rounded-xl text-sm shadow-lg z-50">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200 dark:border-gray-700/50">
                <div class="p-6 md:p-8 space-y-6">
                    <!-- Tabel Data Materi (Desain Baru) -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th scope="col" class="w-12 px-6 py-3"></th>
                                    <th scope="col" class="w-16 px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Urutan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Judul Materi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Dibuat</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($materi as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors group">
                                        {{-- Drag Handle --}}
                                        <td class="px-6 py-4 text-gray-400 cursor-grab">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v1.5a1.5 1.5 0 003 0V4a1 1 0 112 0v1.5a3.5 3.5 0 01-7 0V4a1 1 0 011-1zM5.5 6.5A1.5 1.5 0 004 8v8a1 1 0 102 0V8a1.5 1.5 0 00-1.5-1.5zM10 8a1 1 0 00-1 1v8a1 1 0 102 0V9a1 1 0 00-1-1zM15.5 6.5a1.5 1.5 0 00-1.5 1.5v8a1 1 0 102 0V8a1.5 1.5 0 00-1.5-1.5z" clip-rule="evenodd" /></svg>
                                        </td>
                                        {{-- Urutan --}}
                                        <td class="px-6 py-4">
                                            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg text-lg font-bold text-gray-700 dark:text-gray-200">{{ $item->urutan ?? 'N/A' }}</div>
                                        </td>
                                        {{-- Judul --}}
                                        <td class="px-6 py-4">
                                            <div class="text-base font-bold text-gray-900 dark:text-white">{{ $item->title }}</div>
                                            <div class="text-sm text-gray-500 mt-1">{{ Str::limit($item->description, 70) }}</div>
                                        </td>
                                        {{-- Tanggal --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>
                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 text-right">
                                            <div x-data="{ open: false, deleting: false }" class="relative">
                                                <button @click="open = !open" class="p-2 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition opacity-0 group-hover:opacity-100">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                                                </button>
                                                {{-- Dropdown Menu Aksi --}}
                                                <div x-show="open" @click.away="open = false" x-transition x-cloak class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl py-1 ring-1 ring-black ring-opacity-5 z-20 text-left">
                                                    <a href="{{ route('admin.modul.materi.edit', [$modul, $item]) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Edit Materi</a>
                                                    <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                                    <button @click="deleting = true; open = false" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">Hapus</button>
                                                </div>
                                                {{-- Modal Konfirmasi Hapus --}}
                                                <div x-show="deleting" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                                                    <div @click.away="deleting = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-8 max-w-md w-full">
                                                        <div class="text-center">
                                                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                                                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" /></svg>
                                                            </div>
                                                            <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Konfirmasi Penghapusan</h3>
                                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Anda yakin ingin menghapus materi <span class="font-semibold">"{{ $item->title }}"</span>? Tindakan ini tidak dapat diurungkan.</p>
                                                        </div>
                                                        <div class="mt-6 grid grid-cols-2 gap-4">
                                                            <button @click="deleting = false" type="button" class="w-full px-4 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">Batal</button>
                                                            <form action="{{ route('admin.modul.materi.destroy', [$modul, $item]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">Ya, Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-24 text-center">
                                            <div class="flex flex-col items-center max-w-sm mx-auto">
                                                <svg class="h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>
                                                <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-gray-200">Belum Ada Materi</h3>
                                                <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan materi baru untuk modul ini. Materi yang Anda tambahkan akan muncul di sini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($materi->hasPages())
                        <div class="mt-2">
                            {{ $materi->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>