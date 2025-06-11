<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User_Manajemen extends Authenticatable // atau extends Model
{
    //
    // Nama tabel yang digunakan oleh model
    protected $table = 'users'; // Sesuaikan dengan nama tabel di database Anda

    // Kolom-kolom yang bisa diisi
    protected $fillable = [
        'name',        // Nama user
        'email',       // Email user
        'role',        // Role user (Dosen, Staff, etc.)
        'department',  // Department tempat user bekerja
        'password',
    ];
    // Menambahkan enkripsi otomatis pada password saat pembuatan atau pembaruan
    protected static function boot()
    {
        parent::boot();

        // Mengenkripsi password sebelum menyimpannya
        static::creating(function ($user) {
            if ($user->password) {
                $user->password = bcrypt($user->password);
            }
        });

        static::updating(function ($user) {
            if ($user->password) {
                $user->password = bcrypt($user->password);
            }
        });
    }
}
