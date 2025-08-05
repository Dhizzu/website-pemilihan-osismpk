<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Voting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6 text-center">Hasil Voting Sementara</h3>

                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg mb-6 text-center">
                        <span class="text-lg font-semibold">Total Suara Masuk:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $totalVotes }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($candidates as $candidate)
                            @php
                                $votePercentage = $totalVotes > 0 ? ($candidate->votes_count / $totalVotes) * 100 : 0;
                            @endphp
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden flex flex-col justify-between">
                                <div class="p-6">
                                    <img src="{{ $candidate->photo_path }}" onerror="this.src='https://placehold.co/400x400/cccccc/000000?text=No+Photo'" alt="Foto {{ $candidate->name }}" class="w-full h-auto rounded-lg mb-4 object-cover">
                                    <h4 class="text-xl font-bold text-center">{{ $candidate->name }}</h4>
                                    <p class="text-md text-gray-600 dark:text-gray-400 text-center mb-4">{{ $candidate->position }}</p>
                                    
                                    <div class="mt-4">
                                        <p class="text-lg font-semibold">Visi:</p>
                                        <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $candidate->visi }}</p>
                                        <p class="text-lg font-semibold">Misi:</p>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $candidate->misi }}</p>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <div class="bg-gray-300 dark:bg-gray-600 rounded-full h-4">
                                            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $votePercentage }}%;"></div>
                                        </div>
                                        <p class="text-center mt-2 text-xl font-bold">{{ number_format($votePercentage, 2) }}%</p>
                                        <p class="text-center text-sm text-gray-500">({{ $candidate->votes_count }} suara)</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>