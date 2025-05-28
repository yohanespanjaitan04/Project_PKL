<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_referensi')->nullable();
            $table->string('departemen')->nullable();
            $table->string('prodi')->nullable();
            $table->string('semester')->nullable();
            $table->string('mata_kuliah')->nullable();
            $table->string('judul')->nullable();
            $table->string('pengarang')->nullable();  // atau penulis
            $table->string('penulis')->nullable();
            $table->integer('tahun_publikasi')->nullable();
            $table->string('issue')->nullable();
            $table->integer('banyak_halaman')->nullable();
            $table->text('abstrak')->nullable();
            $table->string('doi')->nullable();
            $table->string('nama_jurnal')->nullable();
            $table->string('issn')->nullable();
            $table->string('volume')->nullable();
            $table->string('nomor')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('tempat_terbit')->nullable();
            $table->string('url')->nullable();
            $table->date('diakses_tanggal')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jurnals');
    }
}