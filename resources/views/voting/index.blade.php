<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Halaman Voting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6 text-center">Silakan Berikan Suara Anda</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($candidates as $candidate)
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
                                </div>
                                <div class="p-6 pt-0">
                                    <form method="POST" action="{{ route('voting.store') }}" onsubmit="return confirm('Apakah Anda yakin ingin memilih kandidat ini? Pilihan Anda tidak bisa diubah!');">
                                        @csrf
                                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-200">
                                            Pilih
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($candidates->isEmpty())
                        <p class="text-center text-gray-500">Belum ada kandidat yang ditambahkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>