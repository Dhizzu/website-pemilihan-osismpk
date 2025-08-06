<!-- Modern Halaman untuk memilih kandidat -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pemilihan Ketua & Wakil Ketua OSIS') }}
        </h2>
    </x-slot>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-secondary-600 py-20">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 animate-fade-in">
                Pemilihan OSIS 2024
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto">
                Suara Anda Menentukan Masa Depan Sekolah Kita
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                    <span class="text-white font-semibold">{{ $totalVoters }} Total Pemilih</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-6 py-3">
                    <span class="text-white font-semibold">{{ $votedCount }} Sudah Memilih</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Progress Bar -->
    <section class="bg-white dark:bg-gray-800 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress Pemilihan</span>
                <span
                    class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ round(($votedCount / $totalVoters) * 100) }}%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 h-2.5 rounded-full transition-all duration-500"
                    style="width: {{ ($votedCount / $totalVoters) * 100 }}%"></div>
            </div>
        </div>
    </section>

    <!-- Candidates Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Calon Ketua & Wakil Ketua OSIS
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Pilih pemimpin masa depan yang akan membawa perubahan positif untuk sekolah kita
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($candidates as $candidate)
                    <div class="group">
                        <!-- Modern Card Design -->
                        <div class="modern-card h-full flex flex-col">
                            <!-- Image Container with Overlay -->
                            <div class="relative overflow-hidden">
                                <img src="{{ $candidate->photo_path }}"
                                    onerror="this.src='https://placehold.co/400x400/e5e7eb/000000?text={{ urlencode($candidate->name) }}'"
                                    alt="Foto {{ $candidate->name }}"
                                    class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                                    loading="lazy">

                                <!-- Overlay Gradient -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>

                                <!-- Candidate Number Badge -->
                                <div
                                    class="absolute top-4 left-4 bg-primary-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    #{{ $loop->iteration }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $candidate->name }}
                                </h3>
                                <p class="text-primary-600 dark:text-primary-400 font-semibold mb-4">
                                    {{ $candidate->position }}</p>

                                <!-- Vision & Mission -->
                                <div class="space-y-3 mb-6 flex-1">
                                    <div>
                                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">Visi</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-2">
                                            {{ $candidate->visi }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">Misi</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                                            {{ $candidate->misi }}</p>
                                    </div>
                                </div>

                                <!-- Vote Button -->
                                <form method="POST" action="{{ route('voting.store') }}" class="mt-auto"
                                    onsubmit="return confirmVote(this, '{{ $candidate->name }}')">
                                    @csrf
                                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                    <button type="submit" class="w-full btn-primary">
                                        <i class="fas fa-vote-yea mr-2"></i>
                                        Pilih Kandidat
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($candidates->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">Belum Ada Kandidat</h3>
                    <p class="text-gray-500 dark:text-gray-500">Kandidat akan ditampilkan di sini setelah ditambahkan
                        oleh admin.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Voting Instructions -->
    <section class="bg-white dark:bg-gray-800 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">
                Cara Memilih
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass-card p-6">
                    <i class="fas fa-user-check text-4xl text-primary-500 mb-4"></i>
                    <h3 class="font-semibold mb-2">1. Pilih Kandidat</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pelajari visi dan misi setiap kandidat</p>
                </div>
                <div class="glass-card p-6">
                    <i class="fas fa-vote-yea text-4xl text-secondary-500 mb-4"></i>
                    <h3 class="font-semibold mb-2">2. Berikan Suara</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Klik tombol "Pilih Kandidat" untuk memberikan
                        suara</p>
                </div>
                <div class="glass-card p-6">
                    <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                    <h3 class="font-semibold mb-2">3. Selesai</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Suara Anda telah tercatat dan tidak dapat diubah
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom Styles -->
    <style>
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <!-- JavaScript for enhanced interactions -->
    <script>
        function confirmVote(form, candidateName) {
            if (confirm(`Apakah Anda yakin ingin memilih ${candidateName}? Pilihan Anda tidak bisa diubah!`)) {
                // Show loading state
                const button = form.querySelector('button[type="submit"]');
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                button.disabled = true;
                return true;
            }
            return false;
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add loading skeleton for images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
            });
        });
    </script>
</x-app-layout>
