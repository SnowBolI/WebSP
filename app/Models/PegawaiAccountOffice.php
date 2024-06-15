<?php
// PegawaiAccountOffice.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiAccountOffice extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_account_office';

    protected $fillable = [
        'user_id',
        // tambahkan kolom lain jika diperlukan
    ];

    // Relasi dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
