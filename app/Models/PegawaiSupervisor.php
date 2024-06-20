<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiSupervisor extends Model
{
    protected $table = 'pegawai_supervisors'; // Sesuaikan dengan nama tabel yang sesuai
    protected $primaryKey = 'id_supervisor'; // Atur primary key jika perlu


    public function wilayah()
    {
        return $this->belongsTo(CabangWilayah::class, 'id_cabang', 'id_wilayah');
    }

    protected $fillable = [
        'id_supervisor',
        'nama_supervisor',
        'id_kepala_cabang',
        'id_user',
        'id_jabatan',
        'id_cabang',
        'id_wilayah',
        'email',
        'password',
        // tambahkan atribut tambahan jika diperlukan
    ];

    // Tambahkan relasi atau metode lain jika diperlukan
}
