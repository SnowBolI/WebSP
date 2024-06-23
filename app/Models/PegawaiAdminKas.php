<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiAdminKas extends Model
{
    protected $table = 'pegawai_admin_kas'; // Sesuaikan dengan nama tabel yang sesuai
    protected $primaryKey = 'id_admin_kas'; // Atur primary key jika perlu

    protected $fillable = [
        'id_admin_kas',
        'nama_admin_kas',
        'id_user',
        'id_supervisor',
        'id_jabatan',
        'cabang',
        'id_wilayah',
        'email',
        'password',
        // tambahkan atribut tambahan jika diperlukan
    ];

    // Tambahkan relasi atau metode lain jika diperlukan
}
