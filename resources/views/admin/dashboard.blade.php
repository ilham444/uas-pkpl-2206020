<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selamat datang kembali, Admin!</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- STATISTIK GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                <x-admin.stat-card title="Pengguna Aktif" value="{{ $stats['activeUsers']['value'] }}" icon="users"
                    change="{{ $stats['activeUsers']['change'] }}" trend="{{ $stats['activeUsers']['trend'] }}"
                    :chart-data="$stats['activeUsers']['chartData']" />

                <x-admin.stat-card title="Materi Dilihat" value="{{ $stats['views']['value'] }}" icon="eye"
                    change="{{ $stats['views']['change'] }}" trend="{{ $stats['views']['trend'] }}"
                    :chart-data="$stats['views']['chartData']" />

                <x-admin.stat-card title="Jumlah Soal Quiz" value="{{ $questionCount ?? 0 }}" icon="question-mark-circle"
                    change="Klik untuk mengelola" trend="neutral" :chart-data="[]" url="{{ route('admin.questions.index') }}" />

                <x-admin.stat-card title="Paket Latihan" value="{{ $latihanCount ?? 0 }}" icon="clipboard-document-list"
                    change="Klik untuk membuat" trend="neutral" :chart-data="[]" url="{{ route('admin.latihan.create') }}" />

                <x-admin.stat-card title="Total Pengerjaan Quiz" value="{{ $quizSubmissionsCount ?? 0 }}" icon="clipboard-check"
                    change="Lihat semua riwayat" trend="neutral" :chart-data="[]" url="{{ route('admin.quiz_results.index') }}" />
            </div>

            {{-- TABEL PENGGUNA TERBARU --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700/50 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-5">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pengguna Terbaru</h3>
                        <a href="#" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                            Lihat Semua Pengguna
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/80 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3 rounded-l-lg">Nama</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Materi Diikuti</th>
                                    <th class="px-6 py-3">Bergabung</th>
                                    <th class="px-6 py-3 rounded-r-lg text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentUsers as $user)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/60">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff"
                                                    alt="{{ $user->name }}">
                                                <div>
                                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                                                {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-300">
                                            {{ $user->completed_materi_count }} Materi
                                        </td>
                                        <td class="px-6 py-4">{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                                                <button @click="open = !open" class="p-2 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                    </svg>
                                                </button>
                                                <div x-show="open" x-transition
                                                    class="absolute z-10 right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border dark:border-gray-700 py-1">
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Lihat Profil</a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</a>
                                                    <a href="#" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10">Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">
                                            Belum ada data pengguna.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART.JS --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Tambahkan script Chart.js jika dibutuhkan
        </script>
    @endpush

</x-app-layout>
