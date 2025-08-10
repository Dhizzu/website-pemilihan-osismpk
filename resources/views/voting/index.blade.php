<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pemilihan OSIS & MPK') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 relative">
        <!-- Enhanced Aesthetic Background Elements - Pinterest Style -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Floating geometric shapes -->
            <div class="absolute top-1/4 left-[10%] w-32 h-32 bg-gradient-to-br from-pink-400/20 to-purple-400/20 rounded-full blur-2xl animate-blob"></div>
            <div class="absolute top-1/3 right-[15%] w-24 h-24 bg-gradient-to-br from-indigo-400/20 to-cyan-400/20 rounded-full blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-1/4 left-[20%] w-20 h-20 bg-gradient-to-br from-orange-400/20 to-pink-400/20 rounded-full blur-lg animate-blob animation-delay-4000"></div>
            
            <!-- Decorative sparkles -->
            <div class="absolute top-[20%] left-[30%] w-2 h-2 bg-pink-300 rounded-full animate-pulse"></div>
            <div class="absolute top-[60%] right-[25%] w-1.5 h-1.5 bg-purple-300 rounded-full animate-pulse delay-500"></div>
            <div class="absolute bottom-[30%] left-[40%] w-1 h-1 bg-indigo-300 rounded-full animate-pulse delay-1000"></div>
            <div class="absolute top-[40%] right-[40%] w-1.5 h-1.5 bg-cyan-300 rounded-full animate-pulse delay-1500"></div>
            
            <!-- Subtle grid pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(168, 85, 247, 0.3) 1px, transparent 0); background-size: 20px 20px;"></div>
            </div>
            
            <!-- Original decorative elements (enhanced) -->
            <div class="absolute top-20 left-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-40 left-10 w-20 h-20 bg-gradient-to-br from-blue-400/20 to-cyan-400/20 rounded-full blur-2xl"></div>
            <div class="absolute top-60 left-5 w-16 h-16 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-xl"></div>

            <!-- Right decorative elements -->
            <div class="absolute top-32 right-0 w-32 h-32 bg-gradient-to-bl from-pink-400/20 to-orange-400/20 rounded-full blur-3xl"></div>
            <div class="absolute top-52 right-10 w-20 h-20 bg-gradient-to-bl from-green-400/20 to-teal-400/20 rounded-full blur-2xl"></div>
            <div class="absolute top-72 right-5 w-16 h-16 bg-gradient-to-bl from-yellow-400/20 to-red-400/20 rounded-full blur-xl"></div>
        </div>

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4 relative z-10">
            <!-- Hero Section -->
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-2xl overflow-hidden">
                    <div class="px-6 py-10 sm:px-10 sm:py-12 text-center">
                        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">
                            Selamat Datang {{ Auth::user()->name }}
                        </h1>
                        <p class="text-md sm:text-lg text-blue-100 max-w-xl mx-auto">
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
                            <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200">Status Voting
                                {{ $position }}</h3>
                            @php
                                $hasVoted = $position == 'OSIS' ? $hasVotedOSIS : $hasVotedMPK;
                                $bgColor = $hasVoted ? 'bg-green-100' : 'bg-yellow-100';
                                $textColor = $hasVoted ? 'text-green-800' : 'text-yellow-800';
                                $text = $hasVoted ? 'Sudah Memilih' : 'Belum Memilih';
                            @endphp
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $bgColor }} {{ $textColor }}">
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
                            $candidates = $position == 'OSIS' ? $osisCandidates : $mpkCandidates;
                            $gradient =
                                $position == 'OSIS' ? 'from-blue-500 to-purple-600' : 'from-green-500 to-teal-600';
                            $hasVoted = $position == 'OSIS' ? $hasVotedOSIS : $hasVotedMPK;
                        @endphp
                        <div class="bg-gradient-to-r {{ $gradient }} px-5 py-4">
                            <h2 class="text-xl font-bold text-white">Kandidat {{ $position }}</h2>
                        </div>

                        <div class="p-4 sm:p-6">
                            @if ($candidates->isEmpty())
                                <p class="text-center text-gray-500 py-8">Belum ada kandidat {{ $position }} yang
                                    ditambahkan.</p>
                            @else
                                <div class="space-y-4">
                                    @foreach ($candidates as $candidate)
                                        <div x-data="{ open: false }"
                                            class="bg-gray-50 dark:bg-gray-700/50 rounded-lg transition-shadow hover:shadow-md">
                                            <div class="p-4">
                                                <div class="flex items-start space-x-4">
                                                    <img src="{{ $candidate->photo_path ? asset('storage/' . $candidate->photo_path) : 'https://placehold.co/300x300/e5e7eb/6b7280?text=No+Photo' }}"
                                                        alt="{{ $candidate->name }}"
                                                        class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-lg shrink-0">
                                                    <div class="flex-grow">
                                                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                                            {{ $candidate->name }}</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                                            {{ $candidate->position }}</p>
                                                        <button @click="open = !open"
                                                            class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                                            <span x-show="!open">Lihat Visi & Misi</span>
                                                            <span x-show="open">Sembunyikan</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div x-show="open" x-collapse.duration.300ms
                                                    class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                                    <div class="space-y-3">
                                                        <div>
                                                            <h4
                                                                class="font-semibold text-sm text-gray-800 dark:text-gray-200">
                                                                Visi:</h4>
                                                            <p
                                                                class="text-sm text-gray-700 dark:text-gray-300 prose-sm">
                                                                {{ $candidate->visi }}</p>
                                                        </div>
                                                        <div>
                                                            <h4
                                                                class="font-semibold text-sm text-gray-800 dark:text-gray-200">
                                                                Misi:</h4>
                                                            <p
                                                                class="text-sm text-gray-700 dark:text-gray-300 prose-sm whitespace-pre-line">
                                                                {{ $candidate->misi }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!$hasVoted)
                                                <form method="POST" action="{{ route('voting.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="candidate_id"
                                                        value="{{ $candidate->id }}">
                                                    <input type="hidden" name="position" value="{{ $position }}">
                                                    <button type="button"
                                                        class="w-full text-center bg-gradient-to-r {{ $gradient }} text-white py-3 px-4 rounded-b-lg hover:opacity-90 transition-opacity font-semibold"
                                                        @click="window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: {{ $candidate->id }}, name: '{{ $candidate->name }}', number: {{ $candidate->candidate_number }} }}))">
                                                        Pilih Nomor {{ $candidate->candidate_number }}
                                                    </button>
                                                </form>
                                            @else
                                                <div
                                                    class="w-full text-center bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-3 px-4 rounded-b-lg font-semibold">
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
        
        <!-- Floating particles -->
        <div class="absolute -top-4 -left-4 w-2 h-2 bg-pink-300 rounded-full animate-pulse delay-1000"></div>
        <div class="absolute -bottom-2 -right-2 w-1.5 h-1.5 bg-purple-300 rounded-full animate-bounce delay-1500"></div>
    </div>

    <!-- Custom Confirmation Modal -->
    <div x-data="{ show: false, candidateName: '', candidateNumber: '', candidateId: '' }" 
         x-show="show"
         x-on:open-modal.window="show = true; candidateName = $event.detail.name; candidateNumber = $event.detail.number; candidateId = $event.detail.id"
         x-on:close-modal.window="show = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="show = false"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-6">
                <!-- Header -->
                <div class="text-center mb-6">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Konfirmasi Pilihan</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Apakah Anda yakin ingin memilih kandidat ini?
                    </p>
                </div>

                <!-- Candidate Info -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                            Nomor <span x-text="candidateNumber"></span>
                        </div>
                        <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-1">
                            <span x-text="candidateName"></span>
                        </div>
                    </div>
                </div>

                <!-- Warning Message -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                <strong>Peringatan:</strong> Pilihan Anda tidak dapat diubah setelah dikonfirmasi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button @click="show = false"
                            class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg font-semibold hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                        Batal
                    </button>
                    <button @click="
                        show = false;
                        $nextTick(() => {
                            const form = document.querySelector(`form input[name='candidate_id'][value='${candidateId}']`).closest('form');
                            if (form) {
                                form.submit();
                            } else {
                                console.error('Could not find form for candidateId:', candidateId);
                                alert('Error: Could not submit vote. Please try again.');
                            }
                        });
                    "
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-colors">
                        Ya, Konfirmasi Pilihan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom animations -->
    <style>
        @keyframes tilt {
            0%, 100% { transform: rotate(-1deg); }
            50% { transform: rotate(1deg); }
        }
        .animate-tilt {
            animation: tilt 3s ease-in-out infinite;
        }
    </style>

    <!-- Update button triggers to pass candidate data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update button triggers to pass candidate data
            document.querySelectorAll('[x-data]').forEach(button => {
                button.addEventListener('click', function() {
                    const candidateCard = this.closest('.bg-gray-50');
                    const candidateName = candidateCard.querySelector('h3').textContent;
                    const candidateNumber = candidateCard.querySelector('.text-3xl').textContent.match(/\d+/)[0];
                    
                    window.dispatchEvent(new CustomEvent('open-modal', {
                        detail: { name: candidateName, number: candidateNumber }
                    }));
                });
            });
        });
    </script>
</x-app-layout>
