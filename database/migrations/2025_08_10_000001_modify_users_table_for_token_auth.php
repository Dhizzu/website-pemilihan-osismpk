<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('users', 'login_token_generated_at')) {
                $table->dropColumn('login_token_generated_at');
            }
            
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }
            
            // Make email nullable since we'll use NIS as primary identifier
            $table->string('email')->nullable()->change();
            
            // Make password nullable since we'll use login_token
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back columns only if they don't exist
            if (!Schema::hasColumn('users', 'login_token_generated_at')) {
                $table->timestamp('login_token_generated_at')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false);
            }
            
            $table->string('email')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
};
