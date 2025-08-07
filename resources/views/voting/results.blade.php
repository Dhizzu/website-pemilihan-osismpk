<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Voting') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl sm:text-3xl font-extrabold mb-6 sm:mb-8 text-center text-primary-700 dark:text-primary-300">Hasil
                        Voting Sementara</h3>

                    <div class="bg-primary-50 dark:bg-primary-950 p-4 sm:p-6 rounded-lg mb-6 sm:mb-8 text-center shadow-md">
                        <span class="text-lg sm:text-xl font-semibold text-gray-700 dark:text-gray-300">Total Suara Masuk:</span>
                        <span
                            class="text-3xl sm:text-4xl font-bold text-primary-600 dark:text-primary-400 ml-2">{{ $totalVotes }}</span>
                    </div>

                    @if ($hasVotedOSIS && !$hasVotedMPK)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-8" role="alert">
                            <p class="font-bold">Perhatian!</p>
                            <p>Anda sudah memilih kandidat OSIS. Jangan lupa untuk memilih kandidat MPK juga! <a href="{{ route('voting.index') }}" class="font-semibold underline">Kembali ke halaman voting</a></p>
                        </div>
                    @elseif (!$hasVotedOSIS && $hasVotedMPK)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-8" role="alert">
                            <p class="font-bold">Perhatian!</p>
                            <p>Anda sudah memilih kandidat MPK. Jangan lupa untuk memilih kandidat OSIS juga! <a href="{{ route('voting.index') }}" class="font-semibold underline">Kembali ke halaman voting</a></p>
                        </div>
                    @endif

                    <!-- Dual Pie Charts Section -->
                    <div class="mb-8">
                        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Ketuk bagian pie chart untuk melihat detail suara per kandidat.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- OSIS Pie Chart -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                                <h4 class="text-lg sm:text-xl font-bold text-center mb-3 sm:mb-4 text-gray-800 dark:text-gray-100">Hasil
                                    Voting OSIS</h4>
                                <div class="flex justify-center w-full">
                                    <canvas id="osisChart"></canvas>
                                </div>
                            </div>

                            <!-- MPK Pie Chart -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                                <h4 class="text-lg sm:text-xl font-bold text-center mb-3 sm:mb-4 text-gray-800 dark:text-gray-100">Hasil
                                    Voting MPK</h4>
                                <div class="flex justify-center w-full">
                                    <canvas id="mpkChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($candidates as $candidate)
                            @php
                                $votePercentage = $totalVotes > 0 ? ($candidate->votes_count / $totalVotes) * 100 : 0;
                            @endphp
                            <div
                                class="bg-gray-100 dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden flex flex-col justify-between transform transition-transform duration-300 hover:scale-105">
                                <div class="p-6">
                                    <img src="{{ $candidate->photo_path }}"
                                        onerror="this.src='https://placehold.co/300x300/e5e7eb/6b7280?text=No+Photo'"
                                        alt="Foto {{ $candidate->name }}"
                                        class="w-32 h-32 sm:w-48 sm:h-48 object-cover rounded-lg mb-4 shadow-md mx-auto">
                                    <h4 class="text-xl sm:text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-2">
                                        {{ $candidate->name }}</h4>
                                    <p class="text-sm sm:text-lg text-gray-600 dark:text-gray-300 text-center mb-3 sm:mb-4">
                                        {{ $candidate->position }}</p>

                                    <div class="mt-6 space-y-4">
                                        <div>
                                            <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">
                                                Visi:</p>
                                            <p class="text-base text-gray-700 dark:text-gray-300">
                                                {{ $candidate->visi }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm sm:text-lg font-semibold text-primary-600 dark:text-primary-400">
                                                Misi:</p>
                                            <p class="text-base text-gray-700 dark:text-gray-300">
                                                {{ $candidate->misi }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <div class="bg-gray-300 dark:bg-gray-600 rounded-full h-4">
                                            <div class="bg-primary-600 h-4 rounded-full"
                                                style="width: {{ $votePercentage }}%;"></div>
                                        </div>
                                        <p
                                            class="text-center mt-2 text-xl sm:text-2xl font-extrabold text-primary-700 dark:text-primary-300">
                                            {{ number_format($votePercentage, 2) }}%</p>
                                        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                            ({{ $candidate->votes_count }} suara)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Filter candidates by position
            const candidates = @json($candidates);
            const osisCandidates = candidates.filter(candidate => candidate.position.toLowerCase().includes(
            'osis'));
            const mpkCandidates = candidates.filter(candidate => candidate.position.toLowerCase().includes('mpk'));

            // OSIS Chart
            if (osisCandidates.length > 0) {
                const osisCtx = document.getElementById('osisChart').getContext('2d');
                const osisData = {
                    labels: osisCandidates.map(c => c.name),
                    datasets: [{
                        label: 'Suara OSIS',
                        data: osisCandidates.map(c => c.votes_count),
                        backgroundColor: [
                            '#3B82F6', '#EF4444', '#F59E0B', '#10B981', '#8B5CF6',
                            '#EC4899', '#14B8A6', '#F97316', '#6366F1', '#22D3EE'
                        ],
                        hoverOffset: 20
                    }]
                };
                new Chart(osisCtx, {
                    type: 'pie',
                    data: osisData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // MPK Chart
            if (mpkCandidates.length > 0) {
                const mpkCtx = document.getElementById('mpkChart').getContext('2d');
                const mpkData = {
                    labels: mpkCandidates.map(c => c.name),
                    datasets: [{
                        label: 'Suara MPK',
                        data: mpkCandidates.map(c => c.votes_count),
                        backgroundColor: [
                            '#3B82F6', '#EF4444', '#F59E0B', '#10B981', '#8B5CF6',
                            '#EC4899', '#14B8A6', '#F97316', '#6366F1', '#22D3EE'
                        ],
                        hoverOffset: 20
                    }]
                };
                new Chart(mpkCtx, {
                    type: 'pie',
                    data: mpkData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
