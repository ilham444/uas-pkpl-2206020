<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
                <div class="text-center">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
                        Selamat datang, {{ Auth::user()->name }}! 🎉
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Anda berhasil login sebagai <strong>{{ Auth::user()->role }}</strong>.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('user.dashboard') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded shadow transition">
                            Lanjut ke Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
