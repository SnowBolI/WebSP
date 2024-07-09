<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    // Specify the primary key
    protected $primaryKey = 'no';

    // Disable auto-incrementing
    public $incrementing = false;

    // Specify the data type of the primary key
    protected $keyType = 'integer';  // or 'integer' if the 'no' is integer

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
        'bukti',
        'id_wilayah',
        'id_admin_kas',
    ];
}
