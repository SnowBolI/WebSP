<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="w-full py-2 px-4 bg-red-500 text-white text-center font-bold rounded hover:bg-red-700">
                <span style="margin:auto">
                    {{ __('Log in') }}
                </span>
            </x-primary-button>

            <div class="flex justify-between w-full mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-white hover:text-blue-900" href="{{ route('password.request') }}">
                        {{ __('Lupa Password') }}
                    </a>
                @endif

                <a class="text-sm text-white hover:text-blue-900" href="{{ route('register') }}">
                    {{ __('Tidak Punya Akun?') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
