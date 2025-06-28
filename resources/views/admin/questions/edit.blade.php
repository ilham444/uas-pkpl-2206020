<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Soal Quiz
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Tampilkan Error Jika Ada --}}
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

                    {{-- Form Update Soal --}}
                    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Pertanyaan --}}
                        <div class="mb-4">
                            <label for="question_text" class="block text-sm font-medium text-gray-700">Teks Pertanyaan:</label>
                            <textarea name="question_text" id="question_text" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('question_text', $question->question_text) }}</textarea>
                        </div>

                        {{-- Pilihan A --}}
                        <div class="mb-4">
                            <label for="option_a" class="block text-sm font-medium text-gray-700">Pilihan A:</label>
                            <input type="text" name="option_a" id="option_a" required
                                value="{{ old('option_a', $question->option_a) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- Pilihan B --}}
                        <div class="mb-4">
                            <label for="option_b" class="block text-sm font-medium text-gray-700">Pilihan B:</label>
                            <input type="text" name="option_b" id="option_b" required
                                value="{{ old('option_b', $question->option_b) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- Pilihan C --}}
                        <div class="mb-4">
                            <label for="option_c" class="block text-sm font-medium text-gray-700">Pilihan C:</label>
                            <input type="text" name="option_c" id="option_c" required
                                value="{{ old('option_c', $question->option_c) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- Pilihan D --}}
                        <div class="mb-4">
                            <label for="option_d" class="block text-sm font-medium text-gray-700">Pilihan D:</label>
                            <input type="text" name="option_d" id="option_d" required
                                value="{{ old('option_d', $question->option_d) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm">
                        </div>

                        {{-- Jawaban Benar --}}
                        <div class="mb-4">
                            <label for="correct_answer" class="block text-sm font-medium text-gray-700">Jawaban Benar:</label>
                            <select name="correct_answer" id="correct_answer" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Pilih Jawaban --</option>
                                <option value="a" {{ old('correct_answer', $question->correct_answer) == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('correct_answer', $question->correct_answer) == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('correct_answer', $question->correct_answer) == 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('correct_answer', $question->correct_answer) == 'd' ? 'selected' : '' }}>D</option>
                            </select>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.questions.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
