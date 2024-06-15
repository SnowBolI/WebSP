<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabangs'; // Sesuaikan dengan nama tabel yang sesuai
    protected $primaryKey = 'id_cabang'; // Atur primary key jika perlu

    protected $fillable = [
        'nama_cabang',
        // tambahkan atribut tambahan jika diperlukan
    ];

    // Tidak ada timestamps di default
    public $timestamps = false;

    // Tambahkan relasi atau metode lain jika diperlukan
}
