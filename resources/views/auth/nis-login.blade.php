<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('nis.login.post') }}">
        @csrf

        <!-- NIS -->
        <div>
            <x-input-label for="nis" :value="__('NIS')" />

            <x-text-input id="nis" class="block mt-1 w-full" type="text" name="nis" :value="old('nis')" required autofocus />
        </div>

        <!-- Login Token -->
        <div class="mt-4">
            <x-input-label for="login_token" :value="__('Login Token')" />

            <x-text-input id="login_token" class="block mt-1 w-full" type="password" name="login_token" required autocomplete="current-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

