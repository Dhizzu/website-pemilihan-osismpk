<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class CandidateAndVoteResetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        try {
            // Reset votes table
            Vote::truncate();
            
            // Reset candidates table
            Candidate::truncate();
            
            // Reset voting flags for all users
            User::where('has_voted_osis', true)->update(['has_voted_osis' => false]);
            User::where('has_voted_mpk', true)->update(['has_voted_mpk' => false]);
            
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            // OSIS Candidates (4 candidates)
            $osisCandidates = [
                [
                    'name' => 'Ahmad Fauzan',
                    'nis' => '001',
                    'position' => 'Ketua OSIS',
                    'visi' => 'Mewujudkan OSIS yang lebih aktif dan inovatif dalam kegiatan sekolah',
                    'misi' => '1. Meningkatkan kegiatan ekstrakurikuler\n2. Mempererat hubungan antar siswa\n3. Menyelenggarakan event sekolah yang lebih berkualitas',
                    'photo_path' => 'https://placehold.co/400x400/3B82F6/FFFFFF?text=Ahmad+F',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Siti Nurhaliza',
                    'nis' => '002',
                    'position' => 'Wakil Ketua OSIS',
                    'visi' => 'Menciptakan lingkungan sekolah yang harmonis dan kreatif',
                    'misi' => '1. Membantu ketua OSIS dalam pelaksanaan program\n2. Mengkoordinir kegiatan kelas\n3. Menjadi penghubung antara siswa dan guru',
                    'photo_path' => 'https://placehold.co/400x400/EF4444/FFFFFF?text=Siti+N',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Budi Santoso',
                    'nis' => '003',
                    'position' => 'Sekretaris OSIS',
                    'visi' => 'Meningkatkan administrasi dan dokumentasi kegiatan OSIS',
                    'misi' => '1. Membuat sistem pencatatan kegiatan yang efisien\n2. Mengelola surat menyurat\n3. Membuat laporan kegiatan berkala',
                    'photo_path' => 'https://placehold.co/400x400/F59E0B/FFFFFF?text=Budi+S',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Anisa Rahma',
                    'nis' => '004',
                    'position' => 'Bendahara OSIS',
                    'visi' => 'Mengelola keuangan OSIS dengan transparan dan efisien',
                    'misi' => '1. Membuat laporan keuangan bulanan\n2. Mengelola dana kegiatan\n3. Mencari sponsor untuk kegiatan OSIS',
                    'photo_path' => 'https://placehold.co/400x400/10B981/FFFFFF?text=Anisa+R',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            // MPK Candidates (4 candidates)
            $mpkCandidates = [
                [
                    'name' => 'Rizky Pratama',
                    'nis' => '005',
                    'position' => 'Ketua MPK',
                    'visi' => 'Mewujudkan MPK yang representatif dan aspiratif',
                    'misi' => '1. Menampung aspirasi siswa\n2. Memperjuangkan hak siswa\n3. Menjadi mitra diskusi untuk guru dan siswa',
                    'photo_path' => 'https://placehold.co/400x400/8B5CF6/FFFFFF?text=Rizky+P',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Dewi Lestari',
                    'nis' => '006',
                    'position' => 'Wakil Ketua MPK',
                    'visi' => 'Menciptakan komunikasi yang efektif antara siswa dan sekolah',
                    'misi' => '1. Membantu ketua MPK dalam tugasnya\n2. Mengkoordinir anggota MPK\n3. Menjadi mediator dalam konflik',
                    'photo_path' => 'https://placehold.co/400x400/EC4899/FFFFFF?text=Dewi+L',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Agus Wijaya',
                    'nis' => '007',
                    'position' => 'Sekretaris MPK',
                    'visi' => 'Meningkatkan dokumentasi dan administrasi MPK',
                    'misi' => '1. Mencatat semua kegiatan MPK\n2. Membuat laporan pertemuan\n3. Mengelola arsip MPK',
                    'photo_path' => 'https://placehold.co/400x400/14B8A6/FFFFFF?text=Agus+W',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Maya Sari',
                    'nis' => '008',
                    'position' => 'Bendahara MPK',
                    'visi' => 'Mengelola keuangan MPK dengan akuntabel dan transparan',
                    'misi' => '1. Membuat laporan keuangan MPK\n2. Mengelola dana operasional\n3. Mencari sumber dana untuk kegiatan MPK',
                    'photo_path' => 'https://placehold.co/400x400/F97316/FFFFFF?text=Maya+S',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            // Insert OSIS candidates
            foreach ($osisCandidates as $candidate) {
                Candidate::create($candidate);
            }

            // Insert MPK candidates
            foreach ($mpkCandidates as $candidate) {
                Candidate::create($candidate);
            }

            $this->command->info('✅ Candidates seeded successfully!');
            $this->command->info('✅ Votes table reset successfully!');
            $this->command->info('✅ User voting flags reset successfully!');
            $this->command->info('📊 Total candidates: ' . Candidate::count());
            $this->command->info('👥 OSIS candidates: ' . Candidate::where('position', 'like', '%OSIS%')->count());
            $this->command->info('👥 MPK candidates: ' . Candidate::where('position', 'like', '%MPK%')->count());
        } finally {
            // Ensure foreign key checks are re-enabled
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
