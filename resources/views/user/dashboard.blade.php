<x-app-layout>
    {{-- [MAX UPGRADE] Menambahkan Font Awesome & Aksen Warna Sekunder --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --color-primary: 63 66 241;
            /* Indigo-600 */
            --color-primary-dark: 79 70 229;
            /* Indigo-500 */
            --color-accent: 6 182 212;
            /* Cyan-500 */
            --color-accent-secondary: 219 39 119;
            /* Fuchsia-600 */
        }

        .bg-accent-secondary {
            background-color: rgb(var(--color-accent-secondary));
        }

        .text-accent-secondary {
            color: rgb(var(--color-accent-secondary));
        }

        .hover\:bg-accent-secondary-dark:hover {
            background-color: rgb(190 24 93);
        }

        .text-primary {
            color: rgb(var(--color-primary));
        }

        .bg-primary {
            background-color: rgb(var(--color-primary));
        }

        .border-primary {
            border-color: rgb(var(--color-primary));
        }

        .ring-primary {
            --tw-ring-color: rgb(var(--color-primary));
        }

        .hover\:bg-primary-dark:hover {
            background-color: rgb(var(--color-primary-dark));
        }

        .dark .text-primary {
            color: rgb(var(--color-primary-dark));
        }

        .dark .bg-primary {
            background-color: rgb(var(--color-primary-dark));
        }

        .dark .border-primary {
            border-color: rgb(var(--color-primary-dark));
        }

        .dark .ring-primary {
            --tw-ring-color: rgb(var(--color-primary-dark));
        }

        .dark .hover\:bg-primary-dark:hover {
            background-color: rgb(63 66 241);
        }

        .progress-ring__circle {
            transition: stroke-dashoffset 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>

    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
        {{-- [MAX UPGRADE] Header dengan sapaan yang lebih memotivasi --}}
        <header class="relative bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="absolute inset-0 -z-0">
                <div class="absolute inset-0 bg-gradient-to-r from-white via-indigo-50 to-white dark:from-gray-800 dark:via-gray-800/50 dark:to-gray-800"></div>
                <svg class="absolute bottom-0 right-0 text-gray-200/50 dark:text-gray-700/50" width="404" height="404" fill="none" viewBox="0 0 404 404" role="img">
                    <defs>
                        <pattern id="d1d9e662-35a7-4cfc-a49d-5dc09428ad28" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <rect x="0" y="0" width="4" height="4" class="text-gray-200 dark:text-gray-700/80" fill="currentColor"></rect>
                        </pattern>
                    </defs>
                    <rect width="404" height="404" fill="url(#d1d9e662-35a7-4cfc-a49d-5dc09428ad28)"></rect>
                </svg>
            </div>
            <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div>
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                            Halo, <span class="text-primary">{{ Auth::user()->name }}</span>!
                        </h1>
                        <p class="mt-3 text-lg text-gray-600 dark:text-gray-400">
                            Siap menaklukkan materi baru hari ini? Ayo mulai petualangan belajarmu.
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="#materi-list" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 shadow-lg shadow-indigo-500/40 transform hover:scale-105">
                            <i class="fa-solid fa-rocket"></i>
                            Mulai Belajar
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                    <div class="lg:col-span-2 space-y-8" x-data="{ activeFilter: 'all' }" id="materi-list">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Jelajahi Materi</h2>
                            <div class="flex items-center gap-2 overflow-x-auto pb-2 -mb-2">
                                <button @click="activeFilter = 'all'" :class="activeFilter === 'all' ? 'bg-primary text-white border-primary' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-primary hover:text-primary'" class="px-4 py-2 text-sm font-semibold rounded-lg transition-all border whitespace-nowrap">Semua</button>
                                @foreach($kategoris as $kategori)
                                <button @click="activeFilter = '{{ $kategori->id }}'" :class="activeFilter === '{{ $kategori->id }}' ? 'bg-primary text-white border-primary' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:border-primary hover:text-primary'" class="px-4 py-2 text-sm font-semibold rounded-lg transition-all border whitespace-nowrap">{{ $kategori->name }}</button>
                                @endforeach
                            </div>
                        </div>

                        @if($kategoris->isEmpty() || $kategoris->every(fn($kategori) => $kategori->moduls->isEmpty()))
                        <div class="text-center py-20 px-6 bg-white dark:bg-gray-800/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                            <i class="fa-solid fa-folder-open text-5xl text-gray-400 mx-auto"></i>
                            <h3 class="mt-6 text-xl font-semibold text-gray-900 dark:text-gray-200">Koleksi Materi Kosong</h3>
                            <p class="mt-2 text-md text-gray-500">Kami sedang menyiapkan materi baru yang luar biasa. Cek kembali segera!</p>
                        </div>
                        @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($kategoris->pluck('moduls')->flatten() as $item)
                            {{-- [MAX UPGRADE] Kartu Materi dengan Progress Bar & Status Tag Dinamis --}}
                            @php
                            // DUMMY DATA untuk simulasi progres. Ganti dengan data asli Anda.
                            $progress = rand(0, 100);
                            @endphp
                            <div x-show="activeFilter === 'all' || activeFilter === '{{ $item->kategori->id }}'"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="group flex flex-col bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 transform hover:-translate-y-1.5 hover:ring-2 hover:ring-primary hover:ring-offset-2 dark:hover:ring-offset-gray-900">
                                <div class="relative overflow-hidden">
                                    <img src="{{ $item->thumbnail ? Storage::url($item->thumbnail) : 'https://via.placeholder.com/400x200.png?text=EduPlatform' }}" alt="{{ $item->title }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out">
                                    @if($progress > 0 && $progress < 100)
                                        <div class="absolute top-3 right-3 bg-accent-secondary text-white text-xs font-bold py-1 px-2.5 rounded-full shadow-lg">LANJUTKAN
                                </div>
                                @elseif($progress == 100)
                                <div class="absolute top-3 right-3 bg-emerald-500 text-white text-xs font-bold py-1 px-2.5 rounded-full shadow-lg">SELESAI</div>
                                @else
                                <div class="absolute top-3 right-3 bg-sky-500 text-white text-xs font-bold py-1 px-2.5 rounded-full shadow-lg">BARU</div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <span class="inline-block bg-indigo-100 dark:bg-indigo-900/50 text-primary dark:text-indigo-300 text-xs font-semibold py-1 px-2.5 rounded-full mb-3 self-start">{{ $item->kategori->name }}</span>
                                <h4 class="font-bold text-lg text-gray-900 dark:text-white flex-grow group-hover:text-primary transition-colors">{{ $item->title }}</h4>

                                {{-- Progress Bar --}}
                                <div class="mt-4 mb-5">
                                    <div class="flex justify-between text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                        <span>Progres</span>
                                        <span>{{ $progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('user.modul.show', $item->slug) }}" class="mt-auto w-full text-center bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 rounded-lg transition-all duration-300 inline-flex items-center justify-center gap-2">
                                    @if($progress > 0 && $progress < 100)
                                        <i class="fa-solid fa-circle-play"></i> Lanjutkan Belajar
                                        @elseif($progress == 100)
                                        <i class="fa-solid fa-rotate-left"></i> Ulas Kembali
                                        @else
                                        <i class="fa-solid fa-book-open"></i> Mulai Belajar
                                        @endif
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <aside class="space-y-8 lg:sticky lg:top-24">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
    {{-- Judul Tantangan --}}
    <h3 class="text-xl font-extrabold text-gray-900 dark:text-white mb-2">Tantangan Harian</h3>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Uji nyalimu dan raih poin ekstra setiap hari!
    </p>

    {{-- Tombol Aksi --}}
    <a href="{{ route('quiz.start') }}"
       class="group block w-full text-center p-5 bg-gradient-to-br from-purple-600 via-fuchsia-500 to-pink-500 
              rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 
              hover:shadow-2xl hover:shadow-fuchsia-500/40 focus:outline-none focus:ring-2 focus:ring-fuchsia-400">
        <div class="flex items-center justify-center gap-3">
            <i class="fa-solid fa-bolt-lightning text-3xl transition-transform duration-500 group-hover:scale-125"></i>
            <span class="text-lg">Ikuti Kuis Kilat</span>
        </div>
    </a>



                        <div class="space-y-3">
                            @forelse($latihans as $latihan)
                            <a href="{{ route('latihan.show', $latihan->id) }}" class="group block p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-primary dark:hover:border-primary-dark hover:bg-indigo-50 dark:hover:bg-gray-700/50 transition-all duration-300">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-gray-100 dark:bg-gray-700 p-2 rounded-md"><i class="fa-solid fa-file-lines text-gray-500 dark:text-gray-400 w-5 text-center"></i></div>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-primary transition-colors">{{ $latihan->judul }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $latihan->soals_count }} Soal</p>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-primary transition-all duration-300 transform group-hover:translate-x-1"></i>
                                </div>
                            </a>
                            @empty
                            <div class="text-center py-4 px-3 text-sm text-gray-500 dark:text-gray-400">Belum ada latihan spesifik tersedia.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- [MAX UPGRADE] Kartu Pencapaian dengan Lencana (Badges) --}}
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-bold mb-5 text-gray-900 dark:text-white">Pencapaian & Lencana</h3>
                        <div class="space-y-6">
                            @php
                            $progressPercent = 75;
                            $radius = 52;
                            $circumference = 2 * M_PI * $radius;
                            $offset = $circumference - ($progressPercent / 100) * $circumference;
                            @endphp
                            <div>
                                <div class="relative flex items-center justify-center mb-2">
                                    <svg class="h-32 w-32">
                                        <circle class="text-gray-200 dark:text-gray-700" stroke-width="10" stroke="currentColor" fill="transparent" r="{{$radius}}" cx="64" cy="64" />
                                        <circle class="progress-ring__circle text-primary" stroke-width="10" stroke-linecap="round" stroke="currentColor" fill="transparent" r="{{$radius}}" cx="64" cy="64" style="stroke-dasharray: {{$circumference}}; stroke-dashoffset: {{$offset}};" />
                                    </svg>
                                    <span class="absolute text-2xl font-bold text-primary">{{ $progressPercent }}%</span>
                                </div>
                                <a href="#" class="block text-center text-sm font-semibold text-primary hover:underline">Lihat Detail Progres</a>
                            </div>

                            <div class="bg-indigo-50 dark:bg-gray-700/50 p-4 rounded-lg flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Poin Belajar</p>
                                    <p class="text-2xl font-bold text-gray-800 dark:text-white">1,250</p>
                                </div>
                                <i class="fa-solid fa-trophy text-4xl text-amber-400"></i>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">Lencana Terbaru</h4>
                                <div class="flex items-center gap-3">
                                    <div class="relative group" title="Penyelesai Cepat">
                                        <div class="bg-gray-200 dark:bg-gray-700 p-2.5 rounded-full"><i class="fa-solid fa-forward text-xl text-indigo-500 w-6 text-center"></i></div>
                                    </div>
                                    <div class="relative group" title="Rajin Belajar (7 hari beruntun)">
                                        <div class="bg-gray-200 dark:bg-gray-700 p-2.5 rounded-full"><i class="fa-solid fa-calendar-check text-xl text-teal-500 w-6 text-center"></i></div>
                                    </div>
                                    <div class="relative group" title="Perfeksionis (Skor 100% di kuis)">
                                        <div class="bg-gray-200 dark:bg-gray-700 p-2.5 rounded-full"><i class="fa-solid fa-bullseye text-xl text-rose-500 w-6 text-center"></i></div>
                                    </div>
                                    <div class="relative group" title="Lainnya">
                                        <a href="#" class="bg-gray-300 dark:bg-gray-600 w-11 h-11 flex items-center justify-center rounded-full text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white transition-colors">+5</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>
    </div>
    </main>
    </div>
</x-app-layout>