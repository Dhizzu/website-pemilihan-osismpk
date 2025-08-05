<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Candidate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menambahkan satu user contoh yang sudah ada di database
        // Gunakan NIS dan password ini untuk login: NIS "8800", Password "8800"
        User::updateOrCreate(
            ['nis' => '8800'],
            [
                'name' => 'Ahmad Viandri Latief',
                'email' => 'ahmad.latief@sekolah.id',
                'password' => Hash::make('8800'), // Hash NIS sebagai password
            ]
        );

        // Menambahkan user dummy lainnya dengan email yang unik
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@sekolah.id',
                'nis' => str_pad($i, 4, '0', STR_PAD_LEFT),
                'password' => Hash::make('password' . $i),
                'remember_token' => Str::random(10),
                'has_voted_osis' => false,
                'has_voted_mpk' => false,
            ]);
        }

        // Menambahkan kandidat contoh untuk OSIS
        Candidate::create([
            'name' => 'Alice Smith',
            'nis' => '20220101',
            'position' => 'Ketua OSIS',
            'visi' => 'Membangun OSIS yang inovatif dan berprestasi.',
            'misi' => '1. Mengadakan kegiatan ekstrakurikuler yang beragam. 2. Meningkatkan komunikasi antar siswa dan guru.',
            'photo_path' => 'https://placehold.co/400x400/FF5733/000000?text=Kandidat+1',
        ]);

        Candidate::create([
            'name' => 'Bob Johnson',
            'nis' => '20220102',
            'position' => 'Ketua OSIS',
            'visi' => 'Menciptakan lingkungan sekolah yang nyaman dan beretika.',
            'misi' => '1. Menegakkan tata tertib sekolah dengan adil. 2. Mengembangkan program kebersihan sekolah.',
            'photo_path' => 'https://placehold.co/400x400/33A4FF/000000?text=Kandidat+2',
        ]);

        // Menambahkan kandidat contoh untuk MPK
        Candidate::create([
            'name' => 'Charlie Brown',
            'nis' => '20220103',
            'position' => 'Ketua MPK',
            'visi' => 'Menjadi suara aspirasi seluruh siswa.',
            'misi' => '1. Mengadakan survei rutin untuk menampung aspirasi siswa. 2. Mengawasi kinerja OSIS secara objektif.',
            'photo_path' => 'https://placehold.co/400x400/A4FF33/000000?text=Kandidat+3',
        ]);
    }
}
