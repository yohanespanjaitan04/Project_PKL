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
        // Perintah untuk mengubah tabel 'jurnals'
        Schema::table('jurnals', function (Blueprint $table) {
            // Menambahkan kolom 'user_id' sebagai foreign key
            // 'after('id')' -> menempatkan kolom ini setelah kolom 'id'
            // 'nullable()' -> mengizinkan kolom ini kosong (penting untuk data yang sudah ada)
            // 'constrained()' -> mengaitkan ke tabel 'users' secara otomatis
            // 'cascadeOnDelete()' -> jika user dihapus, jurnal miliknya juga akan terhapus
            $table->foreignId('user_id')
                  ->after('id')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah ini akan dijalankan jika Anda melakukan rollback migrasi
        Schema::table('jurnals', function (Blueprint $table) {
            // 1. Hapus constraint/kaitan foreign key terlebih dahulu
            $table->dropForeign(['user_id']);
            
            // 2. Hapus kolomnya
            $table->dropColumn('user_id');
        });
    }
};
