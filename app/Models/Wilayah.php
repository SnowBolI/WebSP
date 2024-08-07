<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayahs'; // Sesuaikan dengan nama tabel yang sesuai
    protected $primaryKey = 'id_wilayah'; // Atur primary key jika perlu

    protected $fillable = [
        'nama_wilayah',
        // tambahkan atribut tambahan jika diperlukan
    ];

    public $timestamps = false;

    // Relasi many-to-many dengan model Cabang
    public function cabangs()
    {
        return $this->belongsToMany(Cabang::class, 'cabang_wilayahs', 'id_wilayah', 'id_wilayah');
    }
    public function nasabahs()
    {
    return $this->hasMany(Nasabah::class, 'id_wilayah');
    }
}