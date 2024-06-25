<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cabangs')->insert([
            ['nama_cabang' => 'ind'],
            ['nama_cabang' => 'vss'],
            ['nama_cabang' => 'jpn'],
            ['nama_cabang' => 'mal'],
            ['nama_cabang' => 'gny'],
            ['nama_cabang' => 'tar'],
        ]);
    }
}
