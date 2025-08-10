<x-guest-layout>

    <div>
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Admin Login
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-gray-800 py-8 px-6 shadow rounded-lg sm:px-10">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4">
                        <div class="font-medium text-red-600">Whoops! Something went wrong.</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                        <input id="username" class="block mt-1 w-full bg-gray-700 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2" type="text" name="username" value="{{ old('username') }}" required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <input id="password" class="block mt-1 w-full bg-gray-700 text-white border border-gray-600 rounded-md focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
