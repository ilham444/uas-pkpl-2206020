<!DOCTYPE html>
{{-- [UPGRADE] Tambahkan x-data untuk manajemen tema global dengan Alpine.js --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
          theme: localStorage.getItem('theme') || 'system',
          init() {
              this.setTheme(this.theme);
              window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                  if (this.theme === 'system') {
                      this.setTheme('system');
                  }
              });
          },
          setTheme(newTheme) {
              this.theme = newTheme;
              localStorage.setItem('theme', newTheme);
              if (newTheme === 'dark' || (newTheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
    x-init="init()">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- [UPGRADE] Meta description yang bisa di-override per halaman untuk SEO --}}
    <meta name="description" content="{{ $metaDescription ?? 'EduPlatform adalah platform pembelajaran online interaktif untuk masa depan.' }}">

    {{-- [UPGRADE] Favicon untuk branding yang lebih baik --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    {{-- <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}"> --}}

    <title>{{ $title ?? config('app.name', 'EduPlatform') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">

    <div class="min-h-screen flex flex-col">

        {{-- Navbar sudah termasuk logic untuk mobile menu dan dark mode switcher --}}
        @include('layouts.navigation')

        {{-- Header Halaman --}}
        @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    {{-- Bagian Kiri: Slot untuk judul & deskripsi halaman --}}
                    <div>
                        {{ $header }}
                    </div>

                    {{-- [UPGRADE UTAMA] Menggunakan slot 'actions' untuk fleksibilitas --}}
                    {{-- Tombol-tombol aksi sekarang didefinisikan di setiap halaman, bukan di sini --}}
                    @if (isset($actions))
                    <div class="flex items-center gap-3 flex-shrink-0">
                        {{ $actions }}
                    </div>
                    @endif
                </div>
            </div>
        </header>
        @endif

        {{-- Konten Utama --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-white dark:bg-gray-800 text-center text-sm py-4 mt-auto border-t border-gray-200 dark:border-gray-700">
            <span class="text-gray-500 dark:text-gray-400">© {{ date('Y') }} EduPlatform. All rights reserved.</span>
        </footer>

    </div>

    @stack('scripts')
</body>

</html>