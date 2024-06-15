<?php
// PegawaiSupervisor.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiSupervisor extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_supervisor';

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
