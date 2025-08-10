<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-200 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-200">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" class="text-gray-300" />
                            <x-text-input id="name" class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                        </div>

                        <!-- NIS -->
                        <div class="mt-4">
                            <x-input-label for="nis" :value="__('NIS')" class="text-gray-300" />
                            <x-text-input id="nis" class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="nis" :value="old('nis')" required />
                            <x-input-error :messages="$errors->get('nis')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                            <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Class -->
                        <div class="mt-4">
                            <x-input-label for="class" :value="__('Class')" class="text-gray-300" />
                            <x-text-input id="class" class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="text" name="class" :value="old('class')" />
                            <x-input-error :messages="$errors->get('class')" class="mt-2 text-red-400" />
                        </div>

                        <!-- Generate Password Token Button -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                            <div class="flex items-center space-x-2">
                                <x-text-input id="password" class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password" />
                                <button type="button" onclick="generatePassword()" class="px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-150 text-sm">
                                    {{ __('Generate Token') }}
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-150">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button class="ml-4 bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function generatePassword() {
    // Generate a random token (8 characters)
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let token = '';
    for (let i = 0; i < 8; i++) {
        token += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    
    // Set the password field value to the generated token
    document.getElementById('password').value = token;
    
    // Optionally, show a success message
    const button = event.target;
    const originalText = button.textContent;
    button.textContent = 'Token Generated!';
    button.classList.add('bg-green-600');
    
    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('bg-green-600');
    }, 2000);
}
</script>
