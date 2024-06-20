<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jabatans')->insert([
            ['nama_jabatan' => 'Direksi'],
            ['nama_jabatan' => 'Kepala Cabang'],
            ['nama_jabatan' => 'Supervisor'],
            ['nama_jabatan' => 'Admin Kas'],
            ['nama_jabatan' => 'Account Officer'],
        ]);
    }
}
