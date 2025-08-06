<!-- Halaman untuk memilih kandidat -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Halaman Voting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-3xl font-extrabold mb-8 text-center text-primary-700 dark:text-primary-300">Silakan Berikan Suara Anda</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($candidates as $candidate)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-xl shadow-lg overflow-hidden flex flex-col justify-between transform transition-transform duration-300 hover:scale-105">
                                <div class="p-6">
                                    <img src="{{ $candidate->photo_path }}" onerror="this.src='https://placehold.co/400x400/e5e7eb/000000?text=No+Photo'" alt="Foto {{ $candidate->name }}" class="w-full h-64 object-cover rounded-lg mb-4 shadow-md">
                                    <h4 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-2">{{ $candidate->name }}</h4>
                                    <p class="text-lg text-gray-600 dark:text-gray-300 text-center mb-4">{{ $candidate->position }}</p>

                                    <div class="mt-6 space-y-4">
                                        <div>
                                            <p class="text-lg font-semibold text-primary-600 dark:text-primary-400">Visi:</p>
                                            <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed">{{ $candidate->visi }}</p>
                                        </div>
                                        <div>
                                            <p class="text-lg font-semibold text-primary-600 dark:text-primary-400">Misi:</p>
                                            <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed">{{ $candidate->misi }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6 pt-0">
                                    <form method="POST" action="{{ route('voting.store') }}" onsubmit="return confirm('Apakah Anda yakin ingin memilih kandidat ini? Pilihan Anda tidak bisa diubah!');">
                                        @csrf
                                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                        <x-primary-button class="w-full justify-center py-3 text-lg">
                                            Pilih
                                        </x-primary-button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($candidates->isEmpty())
                        <p class="text-center text-gray-500 text-lg mt-8">Belum ada kandidat yang ditambahkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>