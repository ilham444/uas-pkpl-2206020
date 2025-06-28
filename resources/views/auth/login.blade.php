<x-guest-layout>
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-8 max-w-md w-full">
        
        <!-- Header Borang -->
        <div class="text-center mb-6">
            {{-- Logo atau Ikon boleh diletakkan di sini jika mahu --}}
            <svg class="mx-auto h-12 w-auto text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <h2 class="mt-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Welcome Back!
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Log in to continue your English journey.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="font-semibold" />
                <x-text-input 
                    id="email" 
                    class="block mt-1 w-full" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="you@example.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="font-semibold" />
                <x-text-input 
                    id="password" 
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-primary shadow-sm focus:ring-primary dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-primary hover:text-accent dark:text-blue-400 dark:hover:text-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            
            <!-- Tombol Log In -->
            <div class="mt-6">
                <x-primary-button class="w-full flex justify-center py-3 text-base">
                    {{ __('Log In') }}
                </x-primary-button>
            </div>

        </form>

        <!-- Pautan ke Halaman Register -->
        <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
            Don't have an account?
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="font-semibold leading-6 text-primary hover:text-accent dark:text-blue-400 dark:hover:text-blue-300">
                    Sign up
                </a>
            @endif
        </p>
    </div>
</x-guest-layout>