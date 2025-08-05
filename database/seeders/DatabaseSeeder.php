<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\CandidateSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            CandidateSeeder::class
        ]);

        $nisDummy = '1234';

        User::factory()->create([
            'nis' => $nisDummy,
            'password' => Hash::make($nisDummy),
            'name' => 'Admin Testing',
            'has_voted_osis' => false,
            'has_voted_mpk' => false
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
