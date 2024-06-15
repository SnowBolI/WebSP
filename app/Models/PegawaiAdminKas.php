<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiAdminKas extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_admin_kas';

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
