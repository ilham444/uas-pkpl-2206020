<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil Quiz
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    @if(session('quiz_result'))
                        @php
                            $result = session('quiz_result');
                            $percentage = ($result['total'] > 0) ? ($result['score'] / $result['total']) * 100 : 0;
                        @endphp
                        <h3 class="text-2xl font-bold mb-4">Quiz Selesai!</h3>
                        <p class="text-lg">Anda menjawab benar <strong>{{ $result['score'] }}</strong> dari <strong>{{ $result['total'] }}</strong> soal.</p>
                        <p class="text-xl font-semibold mt-2">Skor Akhir Anda:</p>
                        <p class="text-4xl font-bold text-blue-600 my-4">{{ number_format($percentage, 2) }}</p>
                        
                        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Dashboard
                        </a>
                    @else
                        <p>Tidak ada hasil untuk ditampilkan.</p>
                        <a href="{{ route('dashboard') }}" class="mt-4 inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Dashboard
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>