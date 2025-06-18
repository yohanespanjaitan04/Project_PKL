<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnals';

    protected $fillable = [
        'tipe_referensi',
        'departemen', 
        'prodi',
        'semester',
        'mata_kuliah',
        'judul',
        'pengarang',
        'tahun_publikasi',
        'issue',
        'banyak_halaman',
        'abstrak',
        'doi',
        'file_path',
        'issn',
        'volume',
        'nomor',
        'tahun_terbit',
        'penerbit',
        'tempat_terbit',
        'url',
        'diakses_tanggal',
        'user_id'
    ];

    protected $casts = [
        'tahun_publikasi' => 'integer',
        'semester' => 'integer', 
        'banyak_halaman' => 'integer',
        'tahun_terbit' => 'integer',
        'diakses_tanggal' => 'date'
    ];
 /**
     * Mendefinisikan relasi bahwa setiap Jurnal dimiliki oleh satu User.
     */
    public function user()
    {
        // Pastikan Anda memiliki model User
        return $this->belongsTo(User::class);
    }
}
