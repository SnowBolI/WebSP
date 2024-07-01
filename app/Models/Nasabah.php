<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'nasabahs';

    protected $fillable = [
        'no',
        'nama',
        'pokok',
        'bunga',
        'denda',
        'total',
        'account_officer',
        'keterangan',
        'ttd',
        'kembali',
        'id_cabang',
        'id_wilayah',
        'id_account_officer',
        'id_admin_kas',
    ];
}
