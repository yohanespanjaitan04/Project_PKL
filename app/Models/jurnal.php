<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    
    protected $table = 'jurnals'; // Pastikan nama tabel sesuai
    
    protected $fillable = [
        'judul',
        'penulis',
        'tahun',
        'kategori',
        'isi'
    ];
}