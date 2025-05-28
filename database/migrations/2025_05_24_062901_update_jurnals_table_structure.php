<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJurnalsTableStructure extends Migration
{
    public function up()
    {
        Schema::table('jurnals', function (Blueprint $table) {
            // Pastikan kolom-kolom ini ada
            if (!Schema::hasColumn('jurnals', 'banyak_halaman')) {
                $table->integer('banyak_halaman')->nullable();
            }
            if (!Schema::hasColumn('jurnals', 'tahun_publikasi')) {
                $table->integer('tahun_publikasi')->nullable();
            }
            if (!Schema::hasColumn('jurnals', 'doi')) {
                $table->string('doi')->nullable();
            }
            if (!Schema::hasColumn('jurnals', 'file_path')) {
                $table->string('file_path')->nullable();
            }
            
            // Drop kolom lama jika ada dengan nama berbeda
            if (Schema::hasColumn('jurnals', 'tahun') && !Schema::hasColumn('jurnals', 'tahun_publikasi')) {
                $table->dropColumn('tahun');
            }
            if (Schema::hasColumn('jurnals', 'halaman') && !Schema::hasColumn('jurnals', 'banyak_halaman')) {
                $table->dropColumn('halaman');
            }
            if (Schema::hasColumn('jurnals', 'url') && !Schema::hasColumn('jurnals', 'doi')) {
                $table->dropColumn('url');
            }
            if (Schema::hasColumn('jurnals', 'file_pdf') && !Schema::hasColumn('jurnals', 'file_path')) {
                $table->dropColumn('file_pdf');
            }
        });
    }

    public function down()
    {
        Schema::table('jurnals', function (Blueprint $table) {
            $table->dropColumn(['banyak_halaman', 'tahun_publikasi', 'doi', 'file_path']);
        });
    }
}