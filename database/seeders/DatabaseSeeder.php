<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Candidate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Isi database aplikasi.
     */
    public function run(): void
    {
        // Menambahkan kandidat contoh untuk OSIS
        Candidate::factory()->create([
            'name' => 'Alice Smith',
            'nis' => '20220101',
            'position' => 'Ketua OSIS',
            'visi' => 'Membangun OSIS yang inovatif dan berprestasi.',
            'misi' => '1. Mengadakan kegiatan ekstrakurikuler yang beragam. 2. Meningkatkan komunikasi antar siswa dan guru.',
            'photo_path' => 'https://placehold.co/400x400/FF5733/000000?text=Kandidat+1',
        ]);

        Candidate::factory()->create([
            'name' => 'Bob Johnson',
            'nis' => '20220102',
            'position' => 'Ketua OSIS',
            'visi' => 'Menciptakan lingkungan sekolah yang nyaman dan beretika.',
            'misi' => '1. Menegakkan tata tertib sekolah dengan adil. 2. Mengembangkan program kebersihan sekolah.',
            'photo_path' => 'https://placehold.co/400x400/33A4FF/000000?text=Kandidat+2',
        ]);
        
        // Menambahkan kandidat contoh untuk MPK
        Candidate::factory()->create([
            'name' => 'Charlie Brown',
            'nis' => '20220103',
            'position' => 'Ketua MPK',
            'visi' => 'Menjadi suara aspirasi seluruh siswa.',
            'misi' => '1. Mengadakan survei rutin untuk menampung aspirasi siswa. 2. Mengawasi kinerja OSIS secara objektif.',
            'photo_path' => 'https://placehold.co/400x400/A4FF33/000000?text=Kandidat+3',
        ]);
    }
}