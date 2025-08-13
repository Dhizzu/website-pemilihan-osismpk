<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-200 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="mb-8 flex justify-between items-center border-b border-gray-700 pb-4">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('admin.results') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Voting Results</a>
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-gray-800">Manage Users</a>
                    <a href="{{ route('admin.candidates.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Manage Candidates</a>
                </div>
                
                <!-- Admin Logout Button -->
                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex-1 mr-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="w-full p-2 rounded bg-gray-700 text-gray-200 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </form>
                    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-150">
                        <i class="fas fa-plus mr-2"></i>Add User
                    </a>
                </div>

                <table class="min-w-full divide-y divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">NISN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Login Token</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-900 divide-y divide-gray-700">
                        @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->nisn }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->class }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->nis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->login_token ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form method="POST" action="{{ route('admin.users.generate-token', $user) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-indigo-600 rounded text-white hover:bg-indigo-700">Generate Token</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
