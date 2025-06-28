{{-- File: resources/views/admin/quiz_results/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Hasil Quiz Pengguna
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Pengguna</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Skor</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Mengerjakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($results as $result)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $result->user->name ?? 'Pengguna Dihapus' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $result->user->email ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 font-semibold">
                                            {{ $result->score }} / {{ $result->total_questions }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $result->created_at->format('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center">
                                            Belum ada pengguna yang mengerjakan quiz.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-6">
                        {{ $results->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>