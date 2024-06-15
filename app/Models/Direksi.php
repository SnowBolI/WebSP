<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_direksi';

    protected $fillable = [
        'user_id',
    ];

    // Relasi dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
