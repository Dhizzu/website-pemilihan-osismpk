<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-200 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Tabs -->
            <nav class="mb-8 flex space-x-4 border-b border-gray-700 pb-4">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-gray-800 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.results') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Voting Results</a>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Manage Users</a>
                <a href="{{ route('admin.candidates.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Manage Candidates</a>
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
