<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Add New Candidate') }}
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

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.candidates.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Candidate Number -->
                        <div class="mb-4">
                            <label for="candidate_number" class="block text-sm font-medium text-gray-300">Candidate Number</label>
                            <input type="number" name="candidate_number" id="candidate_number" value="{{ old('candidate_number') }}" required
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('candidate_number')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-300">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div class="mb-4">
                            <label for="position" class="block text-sm font-medium text-gray-300">Position</label>
                            <select name="position" id="position" required
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Position</option>
                                <option value="OSIS" {{ old('position') == 'OSIS' ? 'selected' : '' }}>OSIS</option>
                                <option value="MPK" {{ old('position') == 'MPK' ? 'selected' : '' }}>MPK</option>
                            </select>
                            @error('position')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Photo -->
                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-300">Photo</label>
                            <input type="file" name="photo" id="photo" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                            <p class="mt-1 text-sm text-gray-400">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</p>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Visi -->
                        <div class="mb-4">
                            <label for="visi" class="block text-sm font-medium text-gray-300">Vision (Visi)</label>
                            <textarea name="visi" id="visi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('visi') }}</textarea>
                            @error('visi')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Misi -->
                        <div class="mb-4">
                            <label for="misi" class="block text-sm font-medium text-gray-300">Mission (Misi)</label>
                            <textarea name="misi" id="misi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('misi') }}</textarea>
                            @error('misi')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.candidates.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Add Candidate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
