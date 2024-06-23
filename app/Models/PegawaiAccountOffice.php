<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiAccountOffice extends Model
{
    protected $table = 'pegawai_account_offices'; // Sesuaikan dengan nama tabel yang sesuai
    protected $primaryKey = 'id_account_officer'; // Atur primary key jika perlu

    protected $fillable = [
        'id_account_officer',
        'nama_account_officer',
        'id_user',
        'id_admin_kas',
        'id_jabatan',
        'cabang',
        'id_wilayah',
        'email',
        'password',
        // tambahkan atribut tambahan jika diperlukan
    ];

    // Tambahkan relasi atau metode lain jika diperlukan
}
