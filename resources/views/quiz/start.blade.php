<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mulai Quiz
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($questions->isEmpty())
                        <p>Belum ada soal yang tersedia. Silakan hubungi admin.</p>
                    @else
                        <form action="{{ route('quiz.submit') }}" method="POST">
                            @csrf
                            @foreach($questions as $index => $question)
                                <div class="mb-6">
                                    <p class="font-bold">{{ $index + 1 }}. {{ $question->question_text }}</p>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="answers[{{ $question->id }}]" value="a">
                                            <span class="ml-2">{{ $question->option_a }}</span>
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="answers[{{ $question->id }}]" value="b">
                                            <span class="ml-2">{{ $question->option_b }}</span>
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="answers[{{ $question->id }}]" value="c">
                                            <span class="ml-2">{{ $question->option_c }}</span>
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" class="form-radio" name="answers[{{ $question->id }}]" value="d">
                                            <span class="ml-2">{{ $question->option_d }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Kumpulkan Jawaban
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>