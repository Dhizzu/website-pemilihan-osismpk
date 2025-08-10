<x-guest-layout>
    <div class="mb-4 text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Login</h1>
        <p class="text-gray-600 dark:text-gray-400 text-sm">Masuk untuk melanjutkan voting Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- NIS -->
        <div class="mb-4">
            <x-input-label for="nis" :value="__('NIS')" />
            <x-text-input id="nis" class="block mt-1 w-full" type="text" name="nis" :value="old('nis')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('nis')" class="mt-2" />
        </div>

        <!-- Login Token -->
        <div class="mb-4">
            <x-input-label for="login_token" :value="__('Login Token')" />
            <x-text-input id="login_token" class="block mt-1 w-full"
                            type="text"
                            name="login_token"
                            required />
            <x-input-error :messages="$errors->get('login_token')" class="mt-2" />
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex justify-between items-center mb-4">
            {{-- <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label> --}}

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center py-2">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        
    </form>
</x-guest-layout>
