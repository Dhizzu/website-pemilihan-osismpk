<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __("View your account's profile information.") }}
                    </p>

                    <div class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>

                        @if (isset($user->nis))
                            <div>
                                <x-input-label for="nis" :value="__('NIS')" />
                                <p class="mt-1 text-sm text-gray-900">{{ $user->nis }}</p>
                            </div>
                        @endif

                        @if (isset($user->nisn))
                            <div>
                                <x-input-label for="nisn" :value="__('NISN')" />
                                <p class="mt-1 text-sm text-gray-900">{{ $user->nisn }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
