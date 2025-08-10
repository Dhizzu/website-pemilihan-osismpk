<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GenerateUserTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate-tokens {--all : Generate tokens for all users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate login tokens for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereNull('login_token')->get();
        
        if ($users->isEmpty()) {
            $this->info('No users need token generation.');
            return;
        }

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $token = $this->generateShortToken();
            $user->update([
                'login_token' => $token,
                'login_token_generated_at' => Carbon::now(),
            ]);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Generated login tokens for {$users->count()} users.");
    }

    /**
     * Generate a shorter, more user-friendly token.
     */
    private function generateShortToken()
    {
        return strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8));
    }
}
