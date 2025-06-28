<nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border-b border-gray-100 dark:border-gray-700/50 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            {{-- Bagian Kiri: Logo & Link Navigasi Utama --}}
            <div class="flex items-center gap-6">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 flex-shrink-0">
                    <x-application-logo class="block h-9 w-auto fill-current text-indigo-600 dark:text-indigo-400" />
                    <span class="font-bold text-lg text-indigo-700 dark:text-indigo-300 hidden md:inline">EduPlatform</span>
                </a>

                {{-- Navigation Links (Desktop) --}}
                <div class="hidden sm:flex space-x-1 items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('user.dashboard')">
                        <span class="hidden lg:inline">📊</span> Dashboard
                    </x-nav-link>

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.modul.index')" :active="request()->routeIs('admin.modul.*')">
                           <span class="hidden lg:inline">📚</span> Modul
                        </x-nav-link>
                        <x-nav-link :href="route('admin.kategori.index')" :active="request()->routeIs('admin.kategori.*')">
                           <span class="hidden lg:inline">🗂️</span> Kategori
                        </x-nav-link>
                        <x-nav-link :href="route('admin.questions.index')" :active="request()->routeIs('admin.questions.*')">
                           <span class="hidden lg:inline">✍️</span> Quiz
                        </x-nav-link>
                        <x-nav-link :href="route('admin.quiz_results.index')" :active="request()->routeIs('admin.quiz_results.index')">
                           <span class="hidden lg:inline">🏆</span> Hasil
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- Bagian Kanan: Aksi & Pengaturan Pengguna (Desktop) --}}
            <div class="hidden sm:flex items-center space-x-4">
                {{-- [UPGRADE 1] Tombol Dark Mode Switcher --}}
                <div class="flex items-center">
                    <button @click="setTheme('light')" x-show="theme !== 'light'" class="p-2 rounded-full text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" aria-label="Switch to light mode">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </button>
                    <button @click="setTheme('dark')" x-show="theme !== 'dark'" class="p-2 rounded-full text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" aria-label="Switch to dark mode">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </button>
                </div>

                {{-- [UPGRADE 2] Dropdown Profile yang lebih baik --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none transition-colors">
                            {{-- Anda bisa menambahkan avatar di sini jika ada --}}
                            {{-- <img class="h-8 w-8 rounded-full" src="..." alt="User Avatar"> --}}
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Info Pengguna di Header Dropdown --}}
                        <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                            <div class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                           <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z" clip-rule="evenodd" /></svg>
                           {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2 text-red-600 dark:text-red-400">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z" clip-rule="evenodd" /><path fill-rule="evenodd" d="M16.72 9.22a.75.75 0 011.06 0l2.25 2.25a.75.75 0 010 1.06l-2.25 2.25a.75.75 0 11-1.06-1.06L17.44 11H9.75a.75.75 0 010-1.5h7.69l-1.47-1.47a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger Menu (Mobile) --}}
            <div class="sm:hidden flex items-center">
                {{-- Tombol Dark Mode Switcher (Mobile) --}}
                <button @click="setTheme('light')" x-show="theme !== 'light'" class="p-2 mr-2 rounded-full text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" aria-label="Switch to light mode">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </button>
                <button @click="setTheme('dark')" x-show="theme !== 'dark'" class="p-2 mr-2 rounded-full text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" aria-label="Switch to dark mode">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
                <button @click="open = ! open" class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu (Mobile) --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden" x-transition>
        {{-- ... (kode menu mobile tidak berubah, sudah bagus) ... --}}
    </div>
</nav>