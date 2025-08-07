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
        Schema::table('votes', function (Blueprint $table) {
            // Hapus foreign key constraint pada user_id
            $table->dropForeign(['user_id']);

            // Hapus unique constraint pada user_id
            $table->dropUnique(['user_id']);

            // Tambahkan kembali foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Tambahkan composite unique key untuk user_id dan candidate_id
            $table->unique(['user_id', 'candidate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            // Hapus composite unique key
            $table->dropUnique(['user_id', 'candidate_id']);

            // Hapus foreign key constraint
            $table->dropForeign(['user_id']);

            // Tambahkan kembali unique constraint pada user_id
            $table->unique('user_id');

            // Tambahkan kembali foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
