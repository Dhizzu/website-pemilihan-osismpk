<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 sm:p-8">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Ini adalah halaman dashboard Anda. Di sini Anda dapat melihat ringkasan aktivitas dan informasi penting.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card 1: Total Candidates -->
                    <div class="bg-blue-500 text-white rounded-lg shadow-md p-5 flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80">Total Kandidat</p>
                            <p class="text-3xl font-bold">{{ $totalCandidates }}</p>
                        </div>
                        <svg class="w-10 h-10 opacity-70" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z" />
                        </svg>
                    </div>

                    <!-- Card 2: Total Votes -->
                    <div class="bg-green-500 text-white rounded-lg shadow-md p-5 flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80">Total Suara Masuk</p>
                            <p class="text-3xl font-bold">{{ $totalVotes }}</p>
                        </div>
                        <svg class="w-10 h-10 opacity-70" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <!-- Card 3: Your Voting Status -->
                    <div class="bg-purple-500 text-white rounded-lg shadow-md p-5 flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-80">Status Voting Anda</p>
                            @if ($hasVotedOSIS && $hasVotedMPK)
                                <p class="text-xl font-bold">Sudah Memilih OSIS & MPK</p>
                            @elseif ($hasVotedOSIS)
                                <p class="text-xl font-bold">Sudah Memilih OSIS</p>
                            @elseif ($hasVotedMPK)
                                <p class="text-xl font-bold">Sudah Memilih MPK</p>
                            @else
                                <p class="text-xl font-bold">Belum Memilih</p>
                            @endif
                        </div>
                        <svg class="w-10 h-10 opacity-70" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2h2a1 1 0 000-2H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('voting.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                        Mulai Voting Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>