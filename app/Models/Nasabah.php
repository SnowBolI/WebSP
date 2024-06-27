<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    public function index()
{
    $nasabahs = Nasabah::all(); // Assuming Nasabah is your model name
    return view('dashboard', compact('nasabahs'));
}

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
