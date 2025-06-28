<x-app-layout>
     {{-- Latar belakang abu-abu lembut untuk seluruh halaman --}}
    <div class="bg-gray-100 min-h-screen font-sans">
        <div class="container mx-auto px-4 py-12">

            {{-- KARTU HASIL UTAMA --}}
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        
                        {{-- Bagian Kiri: Grafik Donat & Skor --}}
                        <div class="relative flex justify-center items-center">
                            {{-- SVG untuk Donut Chart --}}
                            <svg class="transform -rotate-90 w-48 h-48 sm:w-64 sm:h-64" viewBox="0 0 120 120">
                                {{-- Lingkaran latar belakang --}}
                                <circle cx="60" cy="60" r="54" fill="none" stroke="#e6e6e6" stroke-width="12" />
                                {{-- Lingkaran progres (nilai) --}}
                                <circle 
                                    cx="60" 
                                    cy="60" 
                                    r="54" 
                                    fill="none" 
                                    stroke="url(#grade-gradient)" 
                                    stroke-width="12"
                                    stroke-linecap="round"
                                    stroke-dasharray="{{ 2 * 3.14159 * 54 }}" {{-- Keliling lingkaran --}}
                                    stroke-dashoffset="{{ (2 * 3.14159 * 54) * (1 - ($nilaiAkhir / 100)) }}" {{-- Bagian yang kosong --}}
                                    class="transition-all duration-1000 ease-out"
                                />
                                {{-- Definisi Gradient untuk stroke --}}
                                <defs>
                                    <linearGradient id="grade-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                        <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#1D4ED8;stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            {{-- Teks Nilai di tengah --}}
                            <div class="absolute flex flex-col items-center justify-center">
                                <span class="text-5xl sm:text-6xl font-bold text-blue-800">{{ round($nilaiAkhir) }}</span>
                                <span class="text-gray-500 font-medium">Poin</span>
                            </div>
                        </div>

                        {{-- Bagian Kanan: Teks & Tombol --}}
                        <div class="text-center md:text-left">
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Kerja Bagus!</h1>
                            <p class="text-lg text-gray-600 mb-4">Anda telah menyelesaikan latihan <strong class="text-gray-700">{{ $latihan->judul }}</strong>.</p>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center mb-6">
                                <p class="text-lg font-semibold text-blue-800">
                                    Anda menjawab benar {{ $skor }} dari {{ $totalSoal }} soal.
                                </p>
                            </div>
                            
                            <a href="{{ url('/') }}" class="inline-flex items-center bg-blue-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors duration-300 shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KARTU RINCIAN JAWABAN --}}
            <div class="max-w-4xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-xl mt-10">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Rincian Jawaban</h2>
                    <p class="text-gray-500 mt-1">Lihat kembali jawaban Anda untuk setiap soal.</p>
                </div>

                <div class="space-y-8">
                    @foreach($hasilJawaban as $hasil)
                        <div class="p-5 border rounded-xl {{ $hasil['is_benar'] ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                            {{-- Pertanyaan --}}
                            <div class="flex items-start">
                                <span class="font-bold text-gray-700 mr-3">{{ $loop->iteration }}.</span>
                                <p class="font-semibold text-gray-800">{{ $hasil['soal']->pertanyaan }}</p>
                            </div>
                            
                            {{-- Pilihan Jawaban --}}
                            <ul class="mt-4 space-y-3 pl-8">
                                @foreach($hasil['soal']->pilihanJawabans as $pilihan)
                                    <li class="flex items-center text-gray-700 p-3 rounded-lg
                                        {{-- Style untuk jawaban yang benar --}}
                                        @if($pilihan->is_benar) bg-green-100 border border-green-300 @endif
                                        {{-- Style untuk jawaban pengguna yang salah --}}
                                        @if(!$hasil['is_benar'] && $pilihan->id == $hasil['jawaban_pengguna_id']) bg-red-100 border border-red-300 @endif
                                    ">
                                        
                                        @if($pilihan->id == $hasil['jawaban_pengguna_id'])
                                            @if($hasil['is_benar'])
                                                {{-- Jawaban Pengguna (Benar) --}}
                                                <svg class="h-6 w-6 text-green-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span class="flex-grow">{{ $pilihan->jawaban }}</span>
                                                <span class="text-xs font-bold text-green-700 ml-2">(Jawaban Anda)</span>
                                            @else
                                                {{-- Jawaban Pengguna (Salah) --}}
                                                <svg class="h-6 w-6 text-red-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span class="flex-grow line-through">{{ $pilihan->jawaban }}</span>
                                                <span class="text-xs font-bold text-red-700 ml-2">(Jawaban Anda)</span>
                                            @endif
                                        @elseif($pilihan->is_benar)
                                            {{-- Jawaban Benar (tidak dipilih pengguna) --}}
                                            <svg class="h-6 w-6 text-green-500 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="flex-grow font-bold">{{ $pilihan->jawaban }}</span>
                                            <span class="text-xs font-semibold text-green-700 ml-2">(Jawaban Benar)</span>
                                        @else
                                            {{-- Pilihan lain (tidak dipilih & tidak benar) --}}
                                            <svg class="h-6 w-6 text-gray-300 mr-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="flex-grow text-gray-600">{{ $pilihan->jawaban }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>

</x-app-layout>

   