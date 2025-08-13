<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-200 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Tabs -->
            <nav class="mb-8 flex justify-between items-center border-b border-gray-700 pb-4">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-gray-800 hover:bg-gray-700">Dashboard</a>
                    <a href="{{ route('admin.results') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Voting Results</a>
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Manage Users</a>
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
                <h3 class="text-lg font-medium text-gray-200 mb-4">Welcome to Admin Dashboard</h3>
                <p class="text-gray-300">You are logged in as an admin! Use the navigation tabs above to access different sections.</p>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-300">Quick Actions</h4>
                        <div class="mt-2 space-y-2">
                            <a href="{{ route('admin.results') }}" class="block text-blue-400 hover:text-blue-300">View Voting Results</a>
                            <a href="{{ route('admin.users.index') }}" class="block text-blue-400 hover:text-blue-300">Manage Users</a>
                            <a href="{{ route('admin.users.create') }}" class="block text-blue-400 hover:text-blue-300">Add New User</a>
                        </div>
                    </div>
                    
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-300">Statistics</h4>
                        <div class="mt-2 space-y-1 text-sm text-gray-300">
                            <p>Total Users: {{ \App\Models\User::count() }}</p>
                            <p>Total Votes: {{ \App\Models\Vote::count() }}</p>
                            <p>Total Candidates: {{ \App\Models\Candidate::count() }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-700 p-4 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-300">System Status</h4>
                        <div class="mt-2 space-y-1 text-sm text-gray-300">
                            <p>Status: <span class="text-green-400">Active</span></p>
                            <p>Last Update: {{ now()->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
