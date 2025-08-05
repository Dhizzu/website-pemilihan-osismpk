<?php

namespace Database\Seeders;

use App\Models\Candidate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidate::create([
            'name' => 'Calon Ketua OSIS 1',
            'position' => 'osis',
            'description' => 'Visi Misi Calon 1',
            'photo' => null,
            'class' => 'XI RPL'
        ]);

        Candidate::create([
            'name' => 'Calon Ketua OSIS 2',
            'position' => 'osis',
            'description' => 'Visi Misi Calon 2',
            'photo' => null,
            'class' => 'XI MANLOG'
        ]);
        Candidate::create([
            'name' => 'Calon Ketua MPK 1',
            'position' => 'mpk',
            'description' => 'Visi Misi Calon 1',
            'photo' => null,
            'class' => 'XI AKL'
        ]);
        Candidate::create([
            'name' => 'Calon Ketua MPK 2',
            'position' => 'mpk',
            'description' => 'Visi Misi Calon 2',
            'photo' => null,
            'class' => 'XI TKJ'
        ]);
    }
}
