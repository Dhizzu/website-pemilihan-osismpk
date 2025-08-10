<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Voting Results') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-200 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation Tabs -->
            <nav class="mb-8 flex space-x-4 border-b border-gray-700 pb-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('admin.results') }}"
                    class="px-3 py-2 rounded-md text-sm font-medium bg-gray-800 hover:bg-gray-700">Voting Results</a>
                <a href="{{ route('admin.users.index') }}"
                    class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Manage Users</a>
                <a href="{{ route('admin.candidates.index') }}"
                    class="px-3 py-2 rounded-md text-sm font-medium hover:bg-gray-700">Manage Candidates</a>
            </nav>

            <!-- Auto-refresh controls -->
            <div class="mb-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="autoRefreshToggle" class="rounded mr-2" checked>
                        <span class="text-sm">Auto-refresh every 30 seconds</span>
                    </label>
                    <span id="lastUpdated" class="text-sm text-gray-400">Last updated:
                        {{ now()->format('H:i:s') }}</span>
                </div>
                <button id="refreshNow" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                    Refresh Now
                </button>
            </div>

            <div class="space-y-6">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-200">Total Votes</h3>
                        <p class="text-3xl font-bold text-white" id="totalVotes">{{ \App\Models\Vote::count() }}</p>
                    </div>
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-200">OSIS Candidates</h3>
                        <p class="text-3xl font-bold text-white">
                            {{ \App\Models\Candidate::where('position', 'like', '%OSIS%')->count() }}</p>
                    </div>
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-200">MPK Candidates</h3>
                        <p class="text-3xl font-bold text-white">
                            {{ \App\Models\Candidate::where('position', 'like', '%MPK%')->count() }}</p>
                    </div>
                </div>

                <!-- OSIS Results -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-medium text-gray-200 mb-4">OSIS Voting Results</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <canvas id="osisChart" width="400" height="400"></canvas>
                        </div>
                        <div class="space-y-4" id="osisResults">
                            @php
                                $osisCandidates = \App\Models\Candidate::where('position', 'like', '%OSIS%')
                                    ->withCount('votes')
                                    ->get();
                                $osisTotalVotes = $osisCandidates->sum('votes_count');
                            @endphp
                            @foreach ($osisCandidates as $candidate)
                                <div class="flex items-center justify-between bg-gray-700 p-4 rounded-lg"
                                    data-candidate-id="{{ $candidate->id }}">
                                    <div class="flex items-center">
                                        @if ($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}"
                                                alt="{{ $candidate->name }}"
                                                class="w-12 h-12 rounded-full object-cover mr-4">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center mr-4">
                                                <span
                                                    class="text-gray-300 text-xl">{{ substr($candidate->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-white font-semibold">{{ $candidate->name }}</p>
                                            <p class="text-gray-400 text-sm">{{ $candidate->position }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-white font-bold text-lg vote-count">
                                            {{ $candidate->votes_count }} votes</p>
                                        <p class="text-gray-400 text-sm percentage">
                                            {{ $osisTotalVotes > 0 ? round(($candidate->votes_count / $osisTotalVotes) * 100, 2) : 0 }}%
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- MPK Results -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-medium text-gray-200 mb-4">MPK Voting Results</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <canvas id="mpkChart" width="400" height="400"></canvas>
                        </div>
                        <div class="space-y-4" id="mpkResults">
                            @php
                                $mpkCandidates = \App\Models\Candidate::where('position', 'like', '%MPK%')
                                    ->withCount('votes')
                                    ->get();
                                $mpkTotalVotes = $mpkCandidates->sum('votes_count');
                            @endphp
                            @foreach ($mpkCandidates as $candidate)
                                <div class="flex items-center justify-between bg-gray-700 p-4 rounded-lg"
                                    data-candidate-id="{{ $candidate->id }}">
                                    <div class="flex items-center">
                                        @if ($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}"
                                                alt="{{ $candidate->name }}"
                                                class="w-12 h-12 rounded-full object-cover mr-4">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-full bg-gray-600 flex items-center justify-center mr-4">
                                                <span
                                                    class="text-gray-300 text-xl">{{ substr($candidate->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-white font-semibold">{{ $candidate->name }}</p>
                                            <p class="text-gray-400 text-sm">{{ $candidate->position }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-white font-bold text-lg vote-count">
                                            {{ $candidate->votes_count }} votes</p>
                                        <p class="text-gray-400 text-sm percentage">
                                            {{ $mpkTotalVotes > 0 ? round(($candidate->votes_count / $mpkTotalVotes) * 100, 2) : 0 }}%
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let osisChart, mpkChart;
        let autoRefreshInterval;
        let isPageVisible = true;
        let refreshInterval = 30000; // 30 seconds

        // Page visibility detection
        document.addEventListener('visibilitychange', () => {
            isPageVisible = !document.hidden;
            if (isPageVisible) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });

        // Auto-refresh controls
        const autoRefreshToggle = document.getElementById('autoRefreshToggle');
        const refreshNowBtn = document.getElementById('refreshNow');
        const lastUpdatedSpan = document.getElementById('lastUpdated');

        autoRefreshToggle.addEventListener('change', (e) => {
            if (e.target.checked) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });

        refreshNowBtn.addEventListener('click', () => {
            refreshData();
        });

        function startAutoRefresh() {
            if (autoRefreshToggle.checked && isPageVisible) {
                autoRefreshInterval = setInterval(refreshData, refreshInterval);
            }
        }

        function stopAutoRefresh() {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
                autoRefreshInterval = null;
            }
        }

        async function refreshData() {
            if (!isPageVisible) return;

            try {
                const response = await fetch('{{ route('admin.results') }}?ajax=1', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                updateResults(data);
                lastUpdatedSpan.textContent = `Last updated: ${data.lastUpdated}`;
            } catch (error) {
                console.error('Error refreshing data:', error);
                // Stop auto-refresh on error to prevent spam
                stopAutoRefresh();
                autoRefreshToggle.checked = false;
            }
        }

        function updateResults(data) {
            // Update total votes
            document.getElementById('totalVotes').textContent = data.totalVotes;

            // Update OSIS results
            updateCandidateResults('osis', data.osis, data.osisTotalVotes);

            // Update MPK results
            updateCandidateResults('mpk', data.mpk, data.mpkTotalVotes);

            // Update charts
            updateCharts(data);
        }

        function updateCandidateResults(type, candidates, totalVotes) {
            const container = document.getElementById(`${type}Results`);

            candidates.forEach(candidate => {
                const candidateDiv = container.querySelector(`[data-candidate-id="${candidate.id}"]`);
                if (candidateDiv) {
                    const voteCountEl = candidateDiv.querySelector('.vote-count');
                    const percentageEl = candidateDiv.querySelector('.percentage');

                    voteCountEl.textContent = `${candidate.votes_count} votes`;
                    percentageEl.textContent = `${candidate.percentage}%`;
                }
            });
        }

        function updateCharts(data) {
            // Update OSIS chart
            if (osisChart) {
                osisChart.data.labels = data.osis.map(c => c.name);
                osisChart.data.datasets[0].data = data.osis.map(c => c.votes_count);
                osisChart.update('none'); // No animation for auto-refresh
            }

            // Update MPK chart
            if (mpkChart) {
                mpkChart.data.labels = data.mpk.map(c => c.name);
                mpkChart.data.datasets[0].data = data.mpk.map(c => c.votes_count);
                mpkChart.update('none'); // No animation for auto-refresh
            }
        }

        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // OSIS Chart
            @php
                $osisCandidates = \App\Models\Candidate::where('position', 'like', '%OSIS%')->withCount('votes')->get();
                $osisLabels = $osisCandidates->pluck('name');
                $osisData = $osisCandidates->pluck('votes_count');
                $osisColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
            @endphp

            const osisCtx = document.getElementById('osisChart').getContext('2d');
            osisChart = new Chart(osisCtx, {
                type: 'pie',
                data: {
                    labels: @json($osisLabels),
                    datasets: [{
                        data: @json($osisData),
                        backgroundColor: @json($osisColors),
                        borderWidth: 2,
                        borderColor: '#374151'
                    }]
                },
                options: {
                    responsive: true,
                    animation: false, // Disable animation for auto-refresh
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#D1D5DB',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

            // MPK Chart
            @php
                $mpkCandidates = \App\Models\Candidate::where('position', 'like', '%MPK%')->withCount('votes')->get();
                $mpkLabels = $mpkCandidates->pluck('name');
                $mpkData = $mpkCandidates->pluck('votes_count');
                $mpkColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
            @endphp

            const mpkCtx = document.getElementById('mpkChart').getContext('2d');
            mpkChart = new Chart(mpkCtx, {
                type: 'pie',
                data: {
                    labels: @json($mpkLabels),
                    datasets: [{
                        data: @json($mpkData),
                        backgroundColor: @json($mpkColors),
                        borderWidth: 2,
                        borderColor: '#374151'
                    }]
                },
                options: {
                    responsive: true,
                    animation: false, // Disable animation for auto-refresh
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#D1D5DB',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });

            // Start auto-refresh
            startAutoRefresh();
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', stopAutoRefresh);
    </script>
</x-app-layout>
