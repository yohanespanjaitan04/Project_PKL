<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Manajemen extends Model
{
    //
    // Nama tabel yang digunakan oleh model
    protected $table = 'user__manajemens'; // Sesuaikan dengan nama tabel di database Anda

    // Kolom-kolom yang bisa diisi
    protected $fillable = [
        'name',        // Nama user
        'email',       // Email user
        'role',        // Role user (Dosen, Staff, etc.)
        'department',  // Department tempat user bekerja
    ];
}
