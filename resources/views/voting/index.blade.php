<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pemilihan OSIS & MPK') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <!-- Hero Section -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-2xl overflow-hidden">
                    <div class="px-6 py-10 sm:px-10 sm:py-12 text-center">
                        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">
                            Selamat Datang di E-Voting
                        </h1>
                        <p class="text-md sm:text-lg text-blue-100 max-w-2xl mx-auto">
                            Gunakan hak suara Anda untuk memilih pemimpin masa depan sekolah!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Voting Status Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-8">
                @foreach (['OSIS', 'MPK'] as $position)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Status Voting {{ $position }}</h3>
                            @php
                                $hasVoted = ($position == 'OSIS') ? $hasVotedOSIS : $hasVotedMPK;
                                $bgColor = $hasVoted ? 'bg-green-100' : 'bg-yellow-100';
                                $textColor = $hasVoted ? 'text-green-800' : 'text-yellow-800';
                                $text = $hasVoted ? 'Sudah Memilih' : 'Belum Memilih';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $bgColor }} {{ $textColor }}">
                                {{ $text }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($hasVotedOSIS && !$hasVotedMPK)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-8" role="alert">
                    <p class="font-bold">Perhatian!</p>
                    <p>Anda sudah memilih kandidat OSIS. Jangan lupa untuk memilih kandidat MPK juga!</p>
                </div>
            @elseif (!$hasVotedOSIS && $hasVotedMPK)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-8" role="alert">
                    <p class="font-bold">Perhatian!</p>
                    <p>Anda sudah memilih kandidat MPK. Jangan lupa untuk memilih kandidat OSIS juga!</p>
                </div>
            @endif

            <!-- Candidates Sections -->
            @foreach (['OSIS', 'MPK'] as $position)
                <div class="mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        @php
                            $candidates = ($position == 'OSIS') ? $osisCandidates : $mpkCandidates;
                            $gradient = ($position == 'OSIS') ? 'from-blue-500 to-purple-600' : 'from-green-500 to-teal-600';
                            $hasVoted = ($position == 'OSIS') ? $hasVotedOSIS : $hasVotedMPK;
                        @endphp
                        <div class="bg-gradient-to-r {{ $gradient }} px-5 py-4">
                            <h2 class="text-xl font-bold text-white">Kandidat {{ $position }}</h2>
                        </div>

                        <div class="p-4 sm:p-6">
                            @if ($candidates->isEmpty())
                                <p class="text-center text-gray-500 py-8">Belum ada kandidat {{ $position }} yang ditambahkan.</p>
                            @else
                                <div class="space-y-4">
                                    @foreach ($candidates as $candidate)
                                        <div x-data="{ open: false }" class="bg-gray-50 dark:bg-gray-700/50 rounded-lg transition-shadow hover:shadow-md">
                                            <div class="p-4">
                                                <div class="flex items-start space-x-4">
                                                    <img src="{{ $candidate->photo_path }}" 
                                                         onerror="this.src='https://placehold.co/300x300/e5e7eb/6b7280?text=No+Photo'" 
                                                         alt="{{ $candidate->name }}" 
                                                         class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg shrink-0">
                                                    <div class="flex-grow">
                                                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">{{ $candidate->name }}</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $candidate->position }}</p>
                                                        <button @click="open = !open" class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                                            <span x-show="!open">Lihat Visi & Misi</span>
                                                            <span x-show="open">Sembunyikan</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div x-show="open" x-collapse.duration.300ms class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                                    <div class="space-y-3">
                                                        <div>
                                                            <h4 class="font-semibold text-sm text-gray-800 dark:text-gray-200">Visi:</h4>
                                                            <p class="text-sm text-gray-700 dark:text-gray-300 prose-sm">{{ $candidate->visi }}</p>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-semibold text-sm text-gray-800 dark:text-gray-200">Misi:</h4>
                                                            <p class="text-sm text-gray-700 dark:text-gray-300 prose-sm whitespace-pre-line">{{ $candidate->misi }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!$hasVoted)
                                                <form method="POST" action="{{ route('voting.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                                    <input type="hidden" name="position" value="{{ $position }}">
                                                    <button type="submit" 
                                                            class="w-full text-center bg-gradient-to-r {{ $gradient }} text-white py-3 px-4 rounded-b-lg hover:opacity-90 transition-opacity font-semibold"
                                                            onclick="return confirm('Apakah Anda yakin ingin memilih {{ $candidate->name }}?')">
                                                        Pilih {{ $candidate->name }}
                                                    </button>
                                                </form>
                                            @else
                                                <div class="w-full text-center bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-3 px-4 rounded-b-lg font-semibold">
                                                    Anda Sudah Memilih
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
