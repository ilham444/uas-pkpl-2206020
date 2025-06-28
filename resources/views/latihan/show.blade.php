{{-- Layout Utama Non-Admin --}}
<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white p-10 rounded-2xl shadow-xl">
            
            {{-- Judul Latihan --}}
            <h1 class="text-4xl font-extrabold text-blue-700 mb-4">{{ $latihan->judul }}</h1>
            <p class="text-gray-600 text-lg mb-8">{{ $latihan->deskripsi }}</p>

            {{-- Form Jawaban --}}
            <form action="{{ route('latihan.submit', $latihan->id) }}" method="POST">
                @csrf

                {{-- Loop Soal --}}
                @foreach($latihan->soals as $index => $soal)
                    <div class="mb-10 p-6 border-l-4 border-blue-600 bg-blue-50 rounded-r-xl shadow-sm">
                        <div class="flex items-start mb-3">
                            <div class="font-semibold text-lg text-blue-700 mr-4">{{ $index + 1 }}.</div>
                            <p class="text-lg text-gray-800 leading-relaxed">{{ $soal->pertanyaan }}</p>
                        </div>

                        {{-- Media jika tersedia --}}
                        @if($soal->tipe_media != 'none' && $soal->url_media)
                            <div class="my-4">
                                @if($soal->tipe_media == 'video')
                                    <video controls class="w-full rounded-lg shadow-md">
                                        <source src="{{ asset('storage/' . $soal->url_media) }}" type="video/mp4">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                @elseif($soal->tipe_media == 'audio')
                                    <audio controls class="w-full mt-2">
                                        <source src="{{ asset('storage/' . $soal->url_media) }}" type="audio/mpeg">
                                        Browser Anda tidak mendukung tag audio.
                                    </audio>
                                @endif
                            </div>
                        @endif

                        {{-- Pilihan Jawaban --}}
                        <div class="space-y-3 mt-4 ml-8">
                            @foreach($soal->pilihanJawabans as $pilihan)
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg bg-white hover:bg-gray-100 transition duration-200 cursor-pointer shadow-sm">
                                    <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $pilihan->id }}" class="h-5 w-5 text-blue-600 mr-4 focus:ring-blue-500" required>
                                    <span class="text-gray-800">{{ $pilihan->jawaban }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                {{-- Tombol Submit --}}
                <div class="mt-10">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-3 px-6 rounded-lg transition duration-300 shadow-md">
                        Selesai & Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
