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
        Schema::table('candidates', function (Blueprint $table) {
            // Remove unique constraint from candidate_number
            $table->dropUnique(['candidate_number']);
            
            // Add composite unique constraint for position + candidate_number
            $table->unique(['position', 'candidate_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Remove composite unique constraint
            $table->dropUnique(['position', 'candidate_number']);
            
            // Restore unique constraint on candidate_number
            $table->unique('candidate_number');
        });
    }
};
