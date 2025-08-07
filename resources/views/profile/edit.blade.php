<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 space-y-6">
            <!-- Hero Section -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-2xl overflow-hidden">
                    <div class="px-6 py-10 sm:px-10 sm:py-12 text-center">
                        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">
                            {{ __('Your Profile') }}
                        </h1>
                        <p class="text-md sm:text-lg text-blue-100 max-w-2xl mx-auto">
                            {{ __("Manage your account settings and information.") }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("View your account's profile information.") }}
                    </p>

                    <div class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                        </div>

                        @if (isset($user->nis))
                            <div>
                                <x-input-label for="nis" :value="__('NIS')" />
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->nis }}</p>
                            </div>
                        @endif

                        @if (isset($user->nisn))
                            <div>
                                <x-input-label for="nisn" :value="__('NISN')" />
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->nisn }}</p>
                            </div>
                        @endif

                        @if (isset($user->class))
                            <div>
                                <x-input-label for="class" :value="__('Class')" />
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $user->class }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
