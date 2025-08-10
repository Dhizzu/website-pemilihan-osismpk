<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@school.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Generate login tokens for all users
        $users = User::whereNull('login_token')->get();
        $generatedCount = 0;

        foreach ($users as $user) {
            $token = $this->generateShortToken();
            $user->update([
                'login_token' => $token,
                'login_token_generated_at' => now(),
            ]);
            $generatedCount++;
        }

        $this->command->info("Generated login tokens for {$generatedCount} users.");
    }

    /**
     * Generate a shorter, more user-friendly token.
     */
    private function generateShortToken()
    {
        return strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8));
    }
}
