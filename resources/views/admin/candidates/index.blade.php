<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Manage Candidates') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-200 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Tabs -->
            <nav class="mb-8 flex space-x-4 border-b border-gray-700 pb-4">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.results') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Voting Results</a>
                <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Manage Users</a>
                <a href="{{ route('admin.candidates.index') }}" class="px-3 py-2 rounded-md text-sm font-medium bg-gray-800 hover:bg-gray-700">Manage Candidates</a>
            </nav>

            <!-- Add Candidate Button -->
            <div class="mb-6">
                <a href="{{ route('admin.candidates.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Add New Candidate
                </a>
            </div>

            <!-- Candidates List -->
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($candidates->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-300">No candidates yet</h3>
                            <p class="mt-1 text-sm text-gray-400">Get started by adding a new candidate.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.candidates.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Add Candidate
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Photo</th>
                                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Position</th>
                                        <th class="px-6 py-3 bg-gray-700 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    @foreach($candidates as $candidate)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($candidate->photo_path)
                                                    <img src="{{ asset('storage/' . $candidate->photo_path) }}" alt="{{ $candidate->name }}" class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center">
                                                        <span class="text-gray-300 text-sm">{{ substr($candidate->name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-white">{{ $candidate->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $candidate->position }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.candidates.edit', $candidate) }}" class="text-blue-400 hover:text-blue-300">Edit</a>
                                                    <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure you want to delete this candidate?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $candidates->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
