<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Soal Quiz Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Validasi Error --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops! Terjadi kesalahan validasi.</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Tambah Soal --}}
                    <form action="{{ route('admin.questions.store') }}" method="POST">
                        @csrf

                        {{-- Teks Pertanyaan --}}
                        <div class="mb-4">
                            <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Teks Pertanyaan:</label>
                            <textarea name="question_text" id="question_text" rows="3" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('question_text') }}</textarea>
                        </div>
                         <!-- TAMBAHKAN DROPDOWN INI -->
    <div class="mb-4">
        <label for="materi_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Materi:</label>
        <select name="materi_id" id="materi_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
            <option value="">-- Pilih Materi Terkait --</option>
            @foreach($materis as $materi)
                <option value="{{ $materi->id }}">{{ $materi->title }}</option> {{-- Asumsi kolom judul materi adalah 'title' --}}
            @endforeach
        </select>
    </div>

                        {{-- Pilihan A --}}
                        <div class="mb-4">
                            <label for="option_a" class="block text-gray-700 text-sm font-bold mb-2">Pilihan A:</label>
                            <input type="text" name="option_a" id="option_a" value="{{ old('option_a') }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        {{-- Pilihan B --}}
                        <div class="mb-4">
                            <label for="option_b" class="block text-gray-700 text-sm font-bold mb-2">Pilihan B:</label>
                            <input type="text" name="option_b" id="option_b" value="{{ old('option_b') }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        {{-- Pilihan C --}}
                        <div class="mb-4">
                            <label for="option_c" class="block text-gray-700 text-sm font-bold mb-2">Pilihan C:</label>
                            <input type="text" name="option_c" id="option_c" value="{{ old('option_c') }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        {{-- Pilihan D --}}
                        <div class="mb-4">
                            <label for="option_d" class="block text-gray-700 text-sm font-bold mb-2">Pilihan D:</label>
                            <input type="text" name="option_d" id="option_d" value="{{ old('option_d') }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                        </div>

                        {{-- Jawaban Benar --}}
                        <div class="mb-4">
                            <label for="correct_answer" class="block text-gray-700 text-sm font-bold mb-2">Jawaban Benar:</label>
                            <select name="correct_answer" id="correct_answer" required
                                class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                <option value="a" {{ old('correct_answer') == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('correct_answer') == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('correct_answer') == 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('correct_answer') == 'd' ? 'selected' : '' }}>D</option>
                            </select>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Soal
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
