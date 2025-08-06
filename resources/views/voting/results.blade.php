<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Voting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-extrabold mb-8 text-center text-primary-700 dark:text-primary-300">Hasil
                        Voting Sementara</h3>

                    <div class="bg-primary-50 dark:bg-primary-950 p-6 rounded-lg mb-8 text-center shadow-md">
                        <span class="text-xl font-semibold text-gray-700 dark:text-gray-300">Total Suara Masuk:</span>
                        <span
                            class="text-4xl font-bold text-primary-600 dark:text-primary-400 ml-2">{{ $totalVotes }}</span>
                    </div>

                    <!-- Pie Chart Section -->
                    <div class="mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                            <h4 class="text-2xl font-bold text-center mb-4 text-gray-800 dark:text-gray-100">Grafik Pie
                                Hasil Voting</h4>
                            <div class="flex justify-center">
                                <canvas id="voteChart" width="200" height="200"></canvas>
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
                                        onerror="this.src='https://placehold.co/400x400/e5e7eb/000000?text=No+Photo'"
                                        alt="Foto {{ $candidate->name }}"
                                        class="w-full h-64 object-cover rounded-lg mb-4 shadow-md">
                                    <h4 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-2">
                                        {{ $candidate->name }}</h4>
                                    <p class="text-lg text-gray-600 dark:text-gray-300 text-center mb-4">
                                        {{ $candidate->position }}</p>

                                    <div class="mt-6 space-y-4">
                                        <div>
                                            <p class="text-lg font-semibold text-primary-600 dark:text-primary-400">
                                                Visi:</p>
                                            <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed">
                                                {{ $candidate->visi }}</p>
                                        </div>
                                        <div>
                                            <p class="text-lg font-semibold text-primary-600 dark:text-primary-400">
                                                Misi:</p>
                                            <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed">
                                                {{ $candidate->misi }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <div class="bg-gray-300 dark:bg-gray-600 rounded-full h-4">
                                            <div class="bg-primary-600 h-4 rounded-full"
                                                style="width: {{ $votePercentage }}%;"></div>
                                        </div>
                                        <p
                                            class="text-center mt-2 text-2xl font-extrabold text-primary-700 dark:text-primary-300">
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
            const ctx = document.getElementById('voteChart').getContext('2d');
            const data = {
                labels: [
                    @foreach ($candidates as $candidate)
                        "{{ $candidate->name }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Suara',
                    data: [
                        @foreach ($candidates as $candidate)
                            {{ $candidate->votes_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        '#3B82F6', // Blue
                        '#EF4444', // Red
                        '#F59E0B', // Yellow
                        '#10B981', // Green
                        '#8B5CF6', // Purple
                        '#EC4899', // Pink
                        '#14B8A6', // Teal
                        '#F97316', // Orange
                        '#6366F1', // Indigo
                        '#22D3EE' // Cyan
                    ],
                    hoverOffset: 30
                }]
            };
            const config = {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            };
            new Chart(ctx, config);
        });
    </script>
</x-app-layout>
