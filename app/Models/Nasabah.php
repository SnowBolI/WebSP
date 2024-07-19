<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model

{

    protected $primaryKey = 'no';  // Set primary key ke kolom 'no'
    public function getRouteKeyName()
    {
        return 'no';
    }
    use HasFactory;
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
    ];

        public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    
}
